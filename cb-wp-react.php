<?php 
/*
Plugin Name: CB WP React
Plugin URI: https://github.com/hmbashar/WP-RestAPI-with-React
Description: CB WP React
Version: 1.0.0
Author: Md Abul Bashar
Author URI: https://hmbashar.com
License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) exit;

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

        add_action('wp_dashboard_setup', array($this, 'register_dashbord_widget'));

        register_activation_hook( __FILE__, array( $this, 'cb_wp_react_activation_table' ) );

    }

    public function create_admin_page() {
        add_menu_page( 'CB WP React', 'CB WP React', 'manage_options', 'cb-wp-react', array( $this, 'menu_page_template' ), 'dashicons-buddicons-replies' );        
    }

    public function menu_page_template() {
        echo '<div class="cb-wp-react-wrap"><div id="cb-wp-admin-app"></div></div>';
    }


    public function register_dashbord_widget() {
        wp_add_dashboard_widget(
            'cb_wp_react_widget',
            'CB WP React',
            array( $this, 'cb_wp_react_widget' )
        );
    }

    public function cb_wp_react_widget() {
        echo '<div class="cb-wp-react-dash-wrap"><div id="cb-wp-admin-dash-app"></div></div>';
    }

    public function cb_wp_react_activation_table() {
        global $wpdb;
        $table_name = $wpdb->prefix . "chartTable";
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE $table_name (
            id INT NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            uv INT,
            pv INT,
            amt INT,
            dateT DATE,
            PRIMARY KEY  (id)
        ) $charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        $insert_query = "INSERT INTO $table_name (name, uv, pv, amt, dateT) VALUES 
        ('Page A', 4000, 2400, 10000, '2022-09-01'), 
        ('Page B', 3000, 1398, 2000, '2022-09-01'), 
        ('Page C', 100, 100, 100, '2022-09-01'), 
        ('Page D', 200, 200, 200, '2022-09-01'), 
        ('Page E', 300, 300, 300, '2022-09-01')";
        $wpdb->query($insert_query);
    }

}

new CB_WP_Create_Admin_Page();


require_once CB_WP_REACT_PATH . 'classes/rest-api-create.php';

