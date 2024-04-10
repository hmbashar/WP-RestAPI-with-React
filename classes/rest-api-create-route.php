<?php 

//don't load this file directly
defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

class CBWP_REST_API_Create_Route {

    public function __construct() {

        add_action( 'rest_api_init', array( $this, 'create_rest_routes' ) );
    }

    public function create_rest_routes() {

        register_rest_route( 'wprest/v1', '/settings', [
            'methods' => 'GET',
            'callback' => array( $this, 'get_settings' ),
            'permission_callback' => [$this, 'get_settings_permission']
        ]);

        register_rest_route( 'wprest/v1', '/settings', [
            'methods' => 'POST',
            'callback' => array( $this, 'save_settings' ),
            //'permission_callback' => [$this, 'get_settings_permission']
        ]);
    }

    public function get_settings(  ) {
     
        $firstname = get_option( 'react_firstName' );
        $lastname = get_option( 'react_lastName' );
        $email = get_option( 'react_email' );
        
        $response = array(    
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email
         );

        return rest_ensure_response( $response );

    }

    public function get_settings_permission(  ) {
        return true;
    }

    public function save_settings( $request ) {
     
        $firstname = sanitize_text_field( $request['firstname'] );
        $lastname = sanitize_text_field( $request['lastname'] );
        $email = sanitize_email( $request['email'] );

        update_option( 'react_firstName', $firstname );
        update_option( 'react_lastName', $lastname );
        update_option( 'react_email', $email );

        return rest_ensure_response( 'success' );
    }

}

new CBWP_REST_API_Create_Route();