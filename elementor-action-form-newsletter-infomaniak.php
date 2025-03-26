<?php
/**
 * Plugin Name: Elementor Action Form Newsletter Infomaniak
 * Description: Ajoute une action sur les formulaires Elementor pour s’abonner à une newsletter Infomaniak.
 * Plugin URI:
 * Author: Eric Monnier
 * Version: 0.3
 * Author URI:
 * Text Domain: elementor-action-form-newsletter-infomaniak
 */

if (!defined('ABSPATH')) exit; // Sécurité

define('ELEMENTOR_NEWSLETTER_INFOMANIAK__FILE__', __FILE__);
define('ELEMENTOR_NEWSLETTER_INFOMANIAK__DIR__', plugin_dir_path(__FILE__));

/**
 * Charge le plugin après Elementor
 */
function elementor_newsletter_infomaniak_load() {
    load_plugin_textdomain('elementor-newsletter-infomaniak');

    if (!did_action('elementor/loaded')) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>' . esc_html__('Elementor doit être activé pour utiliser ce plugin.', 'elementor-newsletter-infomaniak') . '</p></div>';
        });
        return;
    }

    if (!defined('ELEMENTOR_PRO_VERSION') || version_compare(ELEMENTOR_PRO_VERSION, '1.7.2', '<')) {
        add_action('admin_notices', function() {
            echo '<div class="error"><p>' . esc_html__('Elementor Pro 1.7.2+ est requis.', 'elementor-newsletter-infomaniak') . '</p></div>';
        });
        return;
    }

    require ELEMENTOR_NEWSLETTER_INFOMANIAK__DIR__ . 'plugin.php';
}
add_action('plugins_loaded', 'elementor_newsletter_infomaniak_load');
