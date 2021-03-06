<?php
/**
 * File: class-coding-challenge.php
 *
 * @package Coding_Challenge
 * @subpackage Coding_Challenge_main_class
 * @since 0.1.0 ( plugin creation)
 * @author mikesm1118
 */

/**
 * Class: Coding_Challenge
 *
 * Main class and activation hooks.
 *
 * @link https://wordpress.org/plugins/coding-challenge
 *
 * @package Coding_Challenge
 * @subpackage Coding_Challenge_main_class
 * @since 0.1.0 ( plugin creation)
 */
class Coding_Challenge {

	/**
	 * Admin.
	 *
	 * @since 0.1.0
	 *
	 * @var Coding_Challenge_Admin
	 */
	public $admin;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 */
	public function __construct() {
		$this->load_plugin_files();
		$this->admin = new Coding_Challenge_Admin( $this );
	}

	/**
	 * Load_Plugin_Files.
	 *
	 * Location for main class.
	 *
	 * @since 0.1.0
	 */
	public function load_plugin_files() {
		require_once( CODING_CHALLENGE_FILEPATH . 'includes/class-coding-challenge-admin.php' );
	}

	/**
	 * Register_Hooks.
	 *
	 * Register all hooks.
	 *
	 * @since 0.1.0
	 * @access private
	 */
	private function register_hooks() {
		// Initialize.
		add_action(
			'admin_init',
			array( $this->admin, 'register_admin_settings' )
		);

		// Add the menu.
		add_action(
			'admin_menu',
			array( $this->admin, 'register_admin_menu' )
		);

		// Add the color picker.
		add_action(
			'admin_enqueue_scripts',
			array( $this, 'enqueue_color_picker' )
		);

		// Push the change.
		add_action(
			'wp_enqueue_scripts',
			array( $this, 'enqueue_frontend_script' )
		);

		// Save the color selection.
		add_action(
			'update_option_background_setting',
			array( $this->admin, 'set_background_color' )
		);
	}

	/**
	 * Enqueue_Frontend_Script.
	 *
	 * Sends the color selection to the frontend JS script.
	 *
	 * @since 0.1.0
	 *
	 * @param string $hook_suffix script name.
	 */
	public function enqueue_frontend_script( $hook_suffix ) {
		// Initializing js script.
		wp_register_script(
			'cc-frontend',
			plugins_url( 'cc-frontend.js', __FILE__ ),
			array( 'jquery' ),
			false,
			true
		);

		$option        = get_option( 'background_setting', array() );
		$setting_field = isset( $option['color_selection'] ) ? $option['color_selection'] : '';

		// Passing value to js script.
		wp_localize_script(
			'cc-frontend',
			'ccBG',
			array( $setting_field )
		);

		// Running js script.
		wp_enqueue_script(
			'cc-frontend'
		);
	}

	/**
	 * Enqueue_Color_Picker.
	 *
	 * Script for handling the WordPress color picker.
	 *
	 * @since 0.1.0
	 *
	 * @param string $hook_suffix script name.
	 */
	public function enqueue_color_picker( $hook_suffix ) {

		// First check that $hook_suffix is appropriate for your admin page.
		wp_enqueue_style( 'wp-color-picker' );

		// Adding the js script to the site's header.
		wp_enqueue_script(
			'my-script-handle',
			plugins_url( 'cc-picker.js', __FILE__ ),
			array( 'wp-color-picker', 'jquery' ),
			false,
			true
		);
	}

	/**
	 * Run.
	 *
	 * Start registering plugin hooks.
	 *
	 * @since 0.1.0
	 */
	public function run() {
		$this->register_hooks();
	}
}
