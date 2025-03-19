<?php

    /**
     * Function: Login
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Add input forgor password
     */
     add_action( 'login_form_middle', 'add_lost_password_link' );

     function add_lost_password_link() {
         return '<p class="login-form__forgot-password"><a href="' . esc_url( wp_lostpassword_url() ) . '">Forgot your password?</a></p>';
     }

     /** 
     * Add placeholder to the inputs
     */

     add_action('wp_footer', 'add_placeholder_to_inputs');

    function add_placeholder_to_inputs () {
        if( is_page_template( 'templates/page-login.php' ) ) {
            ?>
                <script>
                    jQuery(document).ready(function(){
                    jQuery('#user_login').attr('placeholder', 'User Name or Email*');
                    // jQuery('#user_email').attr('placeholder', 'User Email');
                    jQuery('#user_pass').attr('placeholder', 'Password*');
                });
                </script>
            <?php
        }

    }

    /** 
     * User Custom registration
     */

    add_action( 'template_redirect', 'custom_registration_handler' );

    function custom_registration_handler() {
        if ( isset( $_POST['register'] ) && isset( $_POST['custom_register_nonce'] ) && wp_verify_nonce( $_POST['custom_register_nonce'], 'custom_register_action' ) ) {
            $first_name = sanitize_text_field( $_POST['first_name'] );
            $last_name = sanitize_text_field( $_POST['last_name'] );
            $email = sanitize_email( $_POST['email'] );
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];
    
            // Validar si las contraseñas coinciden
            if ( $password !== $password_confirm ) {
                wc_add_notice( 'Passwords do not match', 'error' );
                return;
            }
    
            // Validar si el email ya existe
            if ( email_exists( $email ) ) {
                wc_add_notice( 'This email is already registered.', 'error' );
                return;
            }
    
            // Crear el usuario
            $user_id = wp_create_user( $email, $password, $email );
    
            if ( is_wp_error( $user_id ) ) {
                wc_add_notice( 'Error creating account. Please try again.', 'error' );
                return;
            }
    
            // Agregar nombre y apellido al perfil
            update_user_meta( $user_id, 'first_name', $first_name );
            update_user_meta( $user_id, 'last_name', $last_name );
    
            // Asignar rol de "Customer" de WooCommerce
            wp_update_user( array( 'ID' => $user_id, 'role' => 'customer' ) );
    
            // Autologin después del registro
            wc_set_customer_auth_cookie( $user_id );
    
            // Redirigir a la página de cuenta
            wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }
    }