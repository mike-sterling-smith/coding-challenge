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
 * Class:  Coding_Challenge_Admin
 *
 * Main class and activation hooks.
 *
 * @link https://wordpress.org/plugins/coding-challenge
 *
 * @package Coding_Challenge
 * @subpackage Coding_Challenge_Admin_menu
 * @since 0.1.0 ( plugin creation)
 */
class Coding_Challenge_Admin {

	/**
	 * Coding_challenge.
	 *
	 * @since 0.1.0
	 *
	 * @var Coding_Challenge
	 */
	public $coding_challenge;

	/**
	 * Constructor.
	 *
	 * @since 0.1.0
	 *
	 * @param Coding_Challenge $coding_challenge coding challenge object.
	 */
	public function __construct( $coding_challenge ) {
		$this->coding_challenge = $coding_challenge;
	}

	/**
	 * Register admin menu.
	 *
	 * Adds the plugin to the admin dashboard.
	 *
	 * @since 0.1.0
	 */
	public function register_admin_menu() {
		add_menu_page(
			'Coding Challenge',
			'Coding Challenge',
			'manage_options',
			'coding-challenge',
			array( $this, 'display_admin_page' ),
			'',
			65
		);
	}

	/**
	 * Register admin settings.
	 *
	 * Adds the plugin features to the admin menu
	 *
	 * @since 0.1.0
	 */
	public function register_admin_settings() {
		register_setting(
			'background_setting',
			'background_setting',
			''
		);

	// Add section to options settings.
		add_settings_section(
			'setting_section',
			'Background Settings',
			array( $this, 'display_section' ),
			'coding-challenge'
		);

	// Add field to section.
		add_settings_field(
			'color_selection',
			'Select background color',
			array( $this, 'display_field' ),
			'coding-challenge',
			'setting_section'
		);
	}

	/**
	 * Set background color.
	 *
	 * Gets the background selection and sets the color value.
	 *
	 * @param string $new_value background color value.
	 *
	 * @since 0.1.0
	 *
	 */
	public function set_background_color( $new_value ) {

		// Grabbing the color value from the returned array.
		$option			= get_option( 'background_setting',[] );
		$setting_field	= isset ( $option['color_selection']) ? $option['color_selection'] : [];

		/*
		 * There's a bug in the twentytwentyone theme that expects the
		 * background value to be delivered without the '#' value.
		 */
		$color = str_replace(
			'#',
			'',
			$setting_field
		);

		// Set background color.
		set_theme_mod(
			'background_color',
			$color
		);
	}

	/**
	 * Display Section.
	 *
	 * Displays the admin menu title
	 *
	 * @since 0.1.0
	 *
	 */
	public function display_section() {
		echo 'Coding Challenge Admin Area';
	}

	/**
	 * Display Field.
	 *
	 * Displays the current background color.
	 *
	 * @since 0.1.0
	 *
	 */
	public function display_field() {
		$option = get_option( 'background_setting',[] );
		$setting_field = isset ( $option['color_selection']) ? $option['color_selection'] : [];
		?>
			<input type="text" name='background_setting[color_selection]' value="<?php echo $setting_field; ?>" class="my-color-field" data-default-color="#effeff" />
		<?php
	}

	/**
	 * Display Admin Page.
	 *
	 * Renders the form in the admin menu.
	 *
	 * @since 0.1.0
	 *
	 */
	public function display_admin_page() {
		?>
			<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
				<form action="options.php" method="post">
					<?php
						settings_fields('background_setting');
						do_settings_sections('coding-challenge');
						submit_button('Save Color');
					?>
				</form>
			</div>
		<?php
	}
}
