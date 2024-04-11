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
        ('Page A', 4000, 2400, 10000, '2024-04-10'), 
        ('Page B', 3000, 1398, 2000, '2024-03-10'), 
        ('Page C', 10000, 100, 100, '2024-03-15'), 
        ('Page D', 200, 20000, 200, '2024-04-01'), 
        ('Page E', 4300, 3000, 300, '2024-04-05'),
        ('Page F', 3000, 1398, 2000, '2024-03-10')";        
        $wpdb->query($insert_query);
    }

}

new CB_WP_Create_Admin_Page();


//require_once CB_WP_REACT_PATH . 'classes/rest-api-create-route.php';
require_once CB_WP_REACT_PATH . 'classes/rest-api-create.php';


function abcelebiz_custom_fields_to_rest_api() {
    $fields_to_expose = [
        '_abcelebiz_company_name',
        '_abcelebiz_company_logo',
        '_abcelebiz_deadline',
        '_abcelebiz_job_type',
        '_abcelebiz_salary_range',
        '_abcelebiz_experience',
        '_abcelebiz_apply_text',
        '_abcelebiz_apply_link',
        '_abcelebiz_job_time',
        '_abcelebiz_job_location',
        '_abcelebiz_job_level',
        '_abcelebiz_qualification',
        '_abcelebiz_vacancy',
        '_abcelebiz_short_description',
        '_abcelebiz_working_hours',
        '_abcelebiz_working_days',
        '_abcelebiz_career_page_url',
        '_abcelebiz_skills_required',
        '_abcelebiz_founded_in',
        '_abcelebiz_form_shortcode',
    ];

    foreach ($fields_to_expose as $field) {
        register_rest_field('abcelebiz-jobs', $field, array(
            'get_callback'    => 'abcelebiz_get_custom_field',
            'update_callback' => null,
            'schema'          => null,
        ));
    }
}

function abcelebiz_get_custom_field($object, $field_name, $request) {
    return get_post_meta($object['id'], $field_name, true);
}

add_action('rest_api_init', 'abcelebiz_custom_fields_to_rest_api');
