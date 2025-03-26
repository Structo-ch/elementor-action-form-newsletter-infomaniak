<?php

namespace InfomaniakNewsletter;

use ElementorPro\Modules\Forms\Classes\Action_Base;
use WP_Error;

class Newsletter_Action_After_Submit extends Action_Base {
    public function get_name() {
        return 'newsletter';
    }

    public function get_label() {
        return __('Newsletter Infomaniak', 'elementor-newsletter-infomaniak');
    }

    public function run($record, $ajax_handler) {
        $settings = $record->get('form_settings');
        $raw_fields = $record->get('fields');
        $fields = array_map(fn($field) => $field['value'], $raw_fields);

        if (!$this->validate_settings($settings, $fields)) {
            return;
        }

        $this->send_to_infomaniak($settings, $fields);
    }

    private function validate_settings($settings, $fields) {
        $required_keys = ['infomaniak_domain', 'infomaniak_email_field', 'api_token'];
        
        foreach ($required_keys as $key) {
            if (empty($settings[$key])) {
                return false;
            }
        }

        return !empty($fields[$settings['infomaniak_email_field']]);
    }

    private function send_to_infomaniak($settings, $fields) {
        $api_url = "https://api.infomaniak.com/1/newsletters/{$settings['infomaniak_domain']}/subscribers";
        $email = $fields[$settings['infomaniak_email_field']];

        $body = [
            'email' => $email,
            'fields' => [],
            'groups' => isset($settings['infomaniak_groups']) ? explode(',', $settings['infomaniak_groups']) : []
        ];

        if (!empty($settings['infomaniak_firstname_field']) && !empty($fields[$settings['infomaniak_firstname_field']])) {
            $body['fields']['firstname'] = $fields[$settings['infomaniak_firstname_field']];
        }
        
        if (!empty($settings['infomaniak_lastname_field']) && !empty($fields[$settings['infomaniak_lastname_field']])) {
            $body['fields']['lastname'] = $fields[$settings['infomaniak_lastname_field']];
        }

        $response = wp_remote_post($api_url, [
            'body' => json_encode($body),
            'headers' => [
                'Authorization' => 'Bearer ' . $settings['api_token'],
                'Content-Type'  => 'application/json'
            ]
        ]);

        if (is_wp_error($response)) {
            error_log('Erreur API Infomaniak : ' . $response->get_error_message());
        }
    }

    public function register_settings_section($widget) {
        $widget->start_controls_section('section_infomaniak', [
            'label' => __('Infomaniak', 'elementor-newsletter-infomaniak'),
            'condition' => ['submit_actions' => $this->get_name()],
        ]);

        $controls = [
            'infomaniak_domain' => __('ID du Domaine', 'elementor-newsletter-infomaniak'),
            'api_token' => __('Token API', 'elementor-newsletter-infomaniak'),
            'infomaniak_email_field' => __('Champ Email', 'elementor-newsletter-infomaniak'),
            'infomaniak_firstname_field' => __('Champ Prénom', 'elementor-newsletter-infomaniak'),
            'infomaniak_lastname_field' => __('Champ Nom', 'elementor-newsletter-infomaniak'),
            'infomaniak_groups' => __('Groupes (séparés par une virgule)', 'elementor-newsletter-infomaniak'),
        ];

        foreach ($controls as $name => $label) {
            $widget->add_control($name, [
                'label' => $label,
                'type' => \Elementor\Controls_Manager::TEXT,
                'label_block' => true,
            ]);
        }

        $widget->end_controls_section();
    }

    public function on_export($element) {
        unset($element['api_token']);
    }
}
