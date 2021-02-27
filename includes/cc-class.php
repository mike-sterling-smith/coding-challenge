<?php
/**
 * Main class for Coding Challange plugin
 */
 
class Coding_Challenge {

    // Initialize object
    public function __construct() {
        $this->load_plugin_files();
        $this->admin = new Coding_Challenge_Admin( $this );
    }

    // Set additional file paths
    public function load_plugin_files() {
        require_once( CODING_CHALLENGE_FILEPATH . 'includes/cc-class-admin.php' );
    }

    // Set hooks
    private function register_hooks() {
        
        // Initialize
        add_action ( 
            'admin_init', 
            array( $this->admin, 'register_admin_settings' ) 
        );
        
        // Add the menu   
        add_action ( 
            'admin_menu', 
            array( $this->admin, 'register_admin_menu' ) 
        );
        
        // Experimenting with color picker, reference site 
        // https://wordpress.stackexchange.com/questions/304285/how-to-implement-color-picker-from-wordpress-in-my-plugin
        add_action( 
            'admin_enqueue_scripts', 
            array( $this,'mw_enqueue_color_picker') 
        );
        
        // Trying to make the color change more theme friendly
        add_action(
            'wp_enqueue_scripts',
            array( $this, 'enqueue_frontend_script')
        );
        
        // Save the color selection
        add_action(
            'update_option_background_setting',
            array( $this->admin, 'set_background_color' )
        );
    }
    
    // Registering the value, getting it ready
    public function enqueue_frontend_script( $hook_suffix ) {
        
        // Initializing js script
        wp_register_script( 
            'cc-frontend', 
            plugins_url('cc-frontend.js', __FILE__ ), 
            array( 'jquery' ), 
            false, 
            true 
        );
        
        $option = get_option( 'background_setting',[] );
        $setting_field = isset ( $option['color_selection']) ? $option['color_selection'] : '';
        
        // Passing value to js script
        wp_localize_script(
            'cc-frontend',
            'ccBG',
            $setting_field
        );
        
        // Running js script
        wp_enqueue_script(
          'cc-frontend'  
        );
    }   
    
    
    public function mw_enqueue_color_picker( $hook_suffix ) {
        
        // first check that $hook_suffix is appropriate for your admin page
        wp_enqueue_style( 'wp-color-picker' );
        
        wp_enqueue_script( 
            'my-script-handle', 
            plugins_url('cc-picker.js', __FILE__ ), 
            array( 'wp-color-picker', 'jquery' ), 
            false, 
            true 
        );
    }

    // Main loop
    public function run() {
        $this->register_hooks();
    }
    
    // Deconstructor to-do
}