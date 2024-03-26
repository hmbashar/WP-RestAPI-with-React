<?php 
/*
Plugin Name: CB WP React
Plugin URI: https://github.com/hmbashar/cb-wp-react
Description: CB WP React
Version: 1.0.0
Author: Md Abul Bashar
Author URI: https://hmbashar.com
License: GPLv2 or later
*/


define ( 'CB_WP_REACT_VERSION', '1.0.0' );
define ( 'CB_WP_REACT_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define ( 'CB_WP_REACT_URL', trailingslashit( plugins_url('/', __FILE__ ) ) );

add_action( 'admin_enqueue_scripts', 'load_admin_scripts');

function load_admin_scripts() {
    wp_enqueue_script( 'cb-wp-react', plugin_dir_url( __FILE__ ) . 'build/index.js', array( 'jquery', 'wp-element' ), wp_rand(), true );

    wp_localize_script( 'cb-wp-react', 'appLocalizer', array(
        'apiURL' => home_url( '/wp-json'),
        'nonce' => wp_create_nonce( 'wp_rest' )
    ) );
}

class CB_WP_Create_Admin_Page {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'create_admin_page' ) );
    }

    public function create_admin_page() {
        add_menu_page( 'CB WP React', 'CB WP React', 'manage_options', 'cb-wp-react', array( $this, 'menu_page_template' ), 'dashicons-buddicons-replies' );        
    }

    public function menu_page_template() {
        echo '<div class="cb-wp-react-wrap"><div id="cb-wp-admin-app"></div></div>';
    }

}

new CB_WP_Create_Admin_Page();


require_once CB_WP_REACT_PATH . 'classes/rest-api-create.php';