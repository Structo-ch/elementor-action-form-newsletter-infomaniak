<?php
namespace CS_Posts;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Plugin {

  public function __construct() {
      $this->add_actions();
  }

  private function add_actions() {
    add_action( 'elementor/widgets/widgets_registered', [ $this, 'on_widgets_registered' ] );
  }

  public function on_widgets_registered() {
      $this->includes();
      $this->register_widget();
  }

  /**
   * Includes
   *
   * @since 1.0.0
   *
   * @access private
   */
  private function includes() {
      require __DIR__ . '/widgets/Newsletter_Action_After_Submit.php';
  }

  /**
   * Register Widget
   *
   * @since 1.0.0
   *
   * @access private
   */
  private function register_widget() {
      $newsletter_action = new Newsletter_Action_After_Submit();

      // Register the action with form widget
	    \ElementorPro\Plugin::instance()->modules_manager->get_modules( 'forms' )->add_form_action( $newsletter_action->get_name(), $newsletter_action );
  }
}
new Plugin();
