<?php
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
	 * Constructor.
	 */
	public function __construct( $coding_challenge ) {
		$this->coding_challenge = $coding_challenge;
	}

	/**
	 * Add admin menu to dashboard.
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
	 * Add options to admin page.
	 */
	public function register_admin_settings() {
		register_setting(
			'background_setting',
			'background_setting',
			''
		);

	/**
	 * Add section to options settings.
	 */
		add_settings_section(
			'setting_section',
			'Background Settings',
			array( $this, 'display_section' ),
			'coding-challenge'
		);

	/**
	 * Add field to section.
	 */
		add_settings_field(
			'color_selection',
			'Select background color',
			array( $this, 'display_field' ),
			'coding-challenge',
			'setting_section'
		);
	}
	
	/**
	 * Applying color selection to theme.
	 */
	public function set_background_color( $new_value ) {

		/**
		 * Grabbing the color value from the returned array.
		 */
		$option			= get_option( 'background_setting',[] );
		$setting_field	= isset ( $option['color_selection']) ? $option['color_selection'] : [];           
		
		/**
		 * There's a bug in the twentytwentyone theme that expects the
		 * background value to be delivered without the '#' value.
		 */
		$color = str_replace(
			'#',
			'',
			$setting_field
		);

		/**
		 * Set background color.
		 */
		set_theme_mod(
			'background_color',
			$color
		);
	}

	/**
	 * Callback for add_settings_section.
	 */
	public function display_section() {
		echo 'Coding Challenge Admin Area';
	}

	/**
	 * Callback for add_settings_field.
	 */
	public function display_field() {
		$option = get_option( 'background_setting',[] );
		$setting_field = isset ( $option['color_selection']) ? $option['color_selection'] : [];
		?>
			<input type="text" name='background_setting[color_selection]' value="<?php echo $setting_field; ?>" class="my-color-field" data-default-color="#effeff" />
		<?php
	}

	/**
	 * Render admin page.
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
