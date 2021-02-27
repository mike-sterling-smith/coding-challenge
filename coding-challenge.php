<?php
/**
 * Plugin Name:       Coding Challenge
 * Plugin URI:        https://michaelsterling.net/
 * Description:       Change background color
 * Version:           0.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Mike Sm
 * Author URI:        https://michaelsterling.net/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       coding-challenge
 * Domain Path:       /languages
 */

// Prevent outside access
if (!defined('ABSPATH')) die('No direct access allowed');

// Define plugin filepath
if ( ! defined( 'CODING_CHALLENGE_FILEPATH' ) ) {
	define( 'CODING_CHALLENGE_FILEPATH', plugin_dir_path(__FILE__) );
}

// Define plugin URL
if ( ! defined( 'CODING_CHALLENGE_URL' ) ) {
	define( 'CODING_CHALLENGE_URL', plugin_dir_url( __FILE__ ) );
}

// Set plugin version
if ( ! defined( 'CODING_CHALLENGE_VERSION' ) ) {
	define( 'CODING_CHALLENGE_VERSION', implode( get_file_data( __FILE__, array( 'Version' ), 'plugin' ) ) );
}

// Main class location
require CODING_CHALLENGE_FILEPATH . '/includes/cc-class.php';

// Create main object
$coding_challenge = new Coding_Challenge();

// Starting main loop
$coding_challenge->run();