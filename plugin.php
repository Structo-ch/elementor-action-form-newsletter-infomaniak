<?php
namespace InfomaniakNewsletter;

if (!defined('ABSPATH')) exit;

class Plugin {
    public function __construct() {
        add_action('elementor/widgets/widgets_registered', [$this, 'init']);
    }

    public function init() {
        require_once ELEMENTOR_NEWSLETTER_INFOMANIAK__DIR__ . 'widgets/Newsletter_Action_After_Submit.php';
        $this->register_newsletter_action();
    }

    private function register_newsletter_action() {
        $newsletter_action = new Newsletter_Action_After_Submit();
        \ElementorPro\Plugin::instance()->modules_manager->get_modules('forms')->add_form_action($newsletter_action->get_name(), $newsletter_action);
    }
}

new Plugin();
