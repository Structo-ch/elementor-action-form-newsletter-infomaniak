<?php

namespace CS_Posts;
/**
 * Class Infomaniak_Action_After_Submit
 * @see https://developers.elementor.com/custom-form-action/
 * Custom elementor form action after submit to add a subsciber to
 * Infomaniak list via API
 */
class Newsletter_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {
	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'Newsletter';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Newsletter', 'text-domain' );
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		//  Make sure that there is a Infomaniak installation url
		if ( empty( $settings['infomaniak_url'] ) ) {
			return;
		}

		//  Make sure that there is a Infomaniak list ID
		if ( empty( $settings['infomaniak_list'] ) ) {
			return;
		}

		// Make sure that there is a Infomaniak Email field ID
		// which is required by Infomaniak's API to subsribe a user
		if ( empty( $settings['infomaniak_email_field'] ) ) {
			return;
		}

		// Get sumitetd Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Make sure that the user emtered an email
		// which is required by Infomaniak's API to subsribe a user
		if ( empty( $fields[ $settings['infomaniak_email_field'] ] ) ) {
			return;
		}

    //  Make sure that there is a Infomaniak installation url
    if ( empty( $fields[ $settings['infomaniak_validator_field'] ] ) ) {
      return;
    }

		// If we got this far we can start building our request data
		// Based on the param list at https://newsletter.infomaniak.com/accounts/access-token
		$infomaniak_data = [
			'email' => $fields[ $settings['infomaniak_email_field'] ]
		];

		// Send the request
		$response = wp_remote_post( $settings['infomaniak_url'] . $settings['infomaniak_list'] . '/importcontact', [
			'body' => [
  			'contacts' => $infomaniak_data
      ],
      'headers' => array(
        'Authorization' => 'Basic ' . base64_encode( $settings['username'] . ':' . $settings['secret']  ),
      )
		] );
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_infomaniak',
			[
				'label' => __( 'Infomaniak', 'text-domain' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'infomaniak_url',
			[
				'label' => __( 'Infomaniak URL', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'https://newsletter.infomaniak.com/api/v1/public/mailinglist/',
				'label_block' => true,
				'separator' => 'before',
				'description' => __( 'Enter the URL where you have Infomaniak installed', 'text-domain' ),
			]
		);
		$widget->add_control(
			'username',
			[
				'label' => __( 'Clé API', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'description' => __( 'Enter the key api where you have Infomaniak installed (ex : https://newsletter.infomaniak.com/api/v1/public/mailinglist/)', 'text-domain' ),
			]
		);
		$widget->add_control(
			'secret',
			[
				'label' => __( 'Clé secrète', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '',
				'label_block' => true,
				'separator' => 'after',
				'description' => __( 'Enter the secret api where you have Infomaniak installed', 'text-domain' ),
			]
		);

		$widget->add_control(
			'infomaniak_list',
			[
				'label' => __( 'Infomaniak List ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'separator' => 'before',
				'description' => __( 'the list id you want to subscribe a user to. This encrypted & hashed id can be found under View all lists section named ID.', 'text-domain' ),
			]
		);

		$widget->add_control(
			'infomaniak_email_field',
			[
				'label' => __( 'Email Field ID', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->add_control(
			'infomaniak_validator_field',
			[
				'label' => __( 'Name Field validator', 'text-domain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$widget->end_controls_section();
	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['infomaniak_url'],
			$element['infomaniak_list'],
			$element['infomaniak_email_field']
		);
	}
}
