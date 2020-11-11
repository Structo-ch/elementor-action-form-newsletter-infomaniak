<?php
/**
 * Plugin Name: elementor-action-form-newsletter-infomaniak
 * Description:
 * Plugin URI:
 * Author: Eric Monnier
 * Version: 0.1
 * Author URI:
 *
 * Text Domain: elementor-action-form-newsletter-infomaniak
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_ADD_VIEW__FILE__', __FILE__ );

/**
 * Load Hello World
 *
 * Load the plugin after Elementor (and other plugins) are loaded.
 *
 * @since 1.0.0
 */
function elementor_add_view_load() {
	// Load localization file
	load_plugin_textdomain( 'add-newsletter-infomaniak-elementor' );

	// Notice if the Elementor is not active
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'elementor_add_view_fail_load' );
		return;
	}

	// Check version required
	$elementor_pro_version_required = '1.7.2';
	if ( ! version_compare( ELEMENTOR_PRO_VERSION, $elementor_pro_version_required, '>=' ) ) {
		add_action( 'admin_notices', 'elementor_add_view_fail_load_out_of_date' );
		return;
	}

	// Require the main plugin file
	require( __DIR__ . '/plugin.php' );
}
add_action( 'plugins_loaded', 'elementor_add_view_load' );
