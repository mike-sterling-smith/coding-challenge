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

// Prevent outside access
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access allowed' );
}

// Define plugin filepath
if ( ! defined( 'CODING_CHALLENGE_FILEPATH' ) ) {
	define( 'CODING_CHALLENGE_FILEPATH', plugin_dir_path( __FILE__ ) );
}

// Define plugin URL
if ( ! defined( 'CODING_CHALLENGE_URL' ) ) {
	define( 'CODING_CHALLENGE_URL', plugin_dir_url( __FILE__ ) );
}

// Set plugin version
if ( ! defined( 'CODING_CHALLENGE_VERSION' ) ) {
	define( 'CODING_CHALLENGE_VERSION', '0.1.0' );
}

// Main class location
require CODING_CHALLENGE_FILEPATH . '/includes/class-coding-challenge.php';

// Create main object
$coding_challenge = new Coding_Challenge();

// Starting main loop
$coding_challenge->run();
