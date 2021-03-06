<?php
/**
 * RockPress Admin Scripts
 *
 * @package RockPress
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * RockPress_Admin_Scripts class
 */
class RockPress_Admin_Scripts {

	/**
	 * Class construct
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Enqueue admin scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function admin_enqueue_scripts() {
		$this->enqueue();
		$this->register();
		$this->localize();
	}

	/**
	 * Enqueue scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function enqueue() {

		wp_enqueue_script( 'rockpress-admin', ROCKPRESS_PLUGIN_URL . 'assets/js/admin/admin.js' );

		if ( ! isset( $_GET['page'] ) ) {
			return;
		}
		if ( ! isset( $_GET['tab'] ) ) {
			return;
		}
		if ( 'rockpress-settings' !== $_GET['page'] ) {
			return;
		}
		if ( 'import' !== $_GET['tab'] ) {
			return;
		}
		wp_enqueue_script( 'rockpress-import', ROCKPRESS_PLUGIN_URL . 'assets/js/admin/import.js' );

	}

	/**
	 * Register scripts
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function register() {
		wp_register_script( 'rockpress-beacon', ROCKPRESS_PLUGIN_URL . 'assets/js/help.js', array(), '1.0.0', true );
	}

	/**
	 * Localize the script
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	private function localize() {

		wp_localize_script( 'rockpress-admin', 'rockpress_vars', array(
			'nonce' => wp_create_nonce( 'rockpress-nonce' ),
			'messages' => array(
				'done' => __( 'Done', 'ft-rockpress' ),
				'running' => __( 'Running...', 'ft-rockpress' ),
				'manual_import_button' => __( 'Import Now', 'ft-rockpress' ),
				'reset_import_button' => __( 'Reset', 'ft-rockpress' ),
				'connection_test_button' => __( 'Run Test Now', 'ft-rockpress' ),
				'process_running' => __( 'Process is running...', 'ft-rockpress' ),
				'reset_import_confirmation' => __( 'Are you sure that you want to reset the last import time?', 'ft-rockpress' ),
			),
		) );

		$current_user = wp_get_current_user();
		wp_localize_script( 'rockpress-beacon', 'rockpress_beacon_vars', array(
			'customer_name'		=> $current_user->display_name,
			'customer_email'	=> $current_user->user_email,
			'rockpress_ver'		=> RockPress()->version,
			'wp_ver'			=> get_bloginfo( 'version' ),
			'php_ver'			=> phpversion(),
		) );
	}

}
new RockPress_Admin_Scripts();
