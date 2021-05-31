<?php
/**
 * Plugin Name:       Coding Challenge
 * 
 * @package Coding_Challenge
 * @subpackage Coding_Challenge_main_class
 * @since 0.1.0 ( plugin creation)
 * @author mikesm1118
 * 
 * @wordpress-plugin 
 * Plugin Name:       Coding Challenge
 * Plugin URI:        https://wordpress.org/plugins/coding-challenge
 * Description:       This plugin creates an admin menu for changing the website's background color.
 * Version:           0.1.0
 * Requires at least: 5.1
 * Requires PHP:      5.6
 * Author:            mikesm1118
 * Author URI:        https://profiles.wordpress.org/mikesm1118/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       coding-challenge
 * Domain Path:       /languages
 */

/**
 * Class:  Coding_Challenge
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
	 * Constructor.
	 * 
	 * @since 0.1.0
	 * 
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
	 * 
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
	 * 
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

		// Add color picker widget.
		add_action( 
			'admin_enqueue_scripts', 
			array( $this, 'mw_enqueue_color_picker' ) 
		);    

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
		
		$option			= get_option( 'background_setting',[] );
		$setting_field	= isset( $option['color_selection']) ? $option['color_selection'] : '';
		
		// Passing value to js script.
		wp_localize_script(
			'cc-frontend',
			'ccBG',
			$setting_field
		);
		
		// Running js script.
		wp_enqueue_script(
		  'cc-frontend'  
		);
	}   
	
	/** 
	 * Mw_Enqueue_Color_Picker.
	 * 
	 * Script for handling color picker.
	 * 
	 * @since 0.1.0
	 * 
	 * @param string $hook_suffix script name.
	 */
	public function mw_enqueue_color_picker( $hook_suffix ) {
		
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
	 * 
	 */
	public function run() {
		$this->register_hooks();
	}
}
