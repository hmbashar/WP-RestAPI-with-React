<?php 

//don't load this file directly
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

class CBWP_REST_API {

    public function __construct() {

        add_action( 'rest_api_init', array( $this, 'create_rest_routes' ) );
    }

    public function create_rest_routes() {

        register_rest_route( 'cbwp/v2', '/settings', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_settings' ),
            'permission_callback' => [$this, 'get_settings_permission'],
        ) );
    }

    public function get_settings(  ) {  
        global $wpdb;
        $table_name = $wpdb->prefix . "chartTable";
        $sql = "SELECT * FROM $table_name";
        $results = $wpdb->get_results(
            $wpdb->prepare( $sql ), ARRAY_A
        );
        return $results;
        
    }

    public function get_settings_permission() {
        return true;
    }


}

new CBWP_REST_API();