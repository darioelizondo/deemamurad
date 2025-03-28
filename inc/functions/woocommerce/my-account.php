<?php

    /**
     * Function: Login
     * 
     * @package Darío Elizondo
     * 
     */

     /** 
     * Change order and layout of my account
     */

    add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_order' );

    function custom_my_account_menu_order( $menu_links ) {
        // Elimina los items que no quieres mostrar
        unset( $menu_links['dashboard'] );  // Oculta "Dashboard"
        unset( $menu_links['downloads'] );  // Oculta "Downloads"

        // Reordena los elementos en el orden deseado
        return [
            'edit-account' => __( 'Account details', 'woocommerce' ),
            'edit-address' => __( 'Addresses', 'woocommerce' ),
            'orders'       => __( 'Orders', 'woocommerce' ),
            'customer-logout' => __( 'Log out', 'woocommerce' ),
        ];
    }

     /** 
     * Active account details by default
     */

    add_action( 'template_redirect', 'custom_my_account_default_tab' );

    function custom_my_account_default_tab() {
         // Verifica si estamos en la página "My Account"
        if ( is_account_page() ) {
            // Obtiene el endpoint actual
            $current_endpoint = WC()->query->get_current_endpoint();

            // Si no hay endpoint (es decir, estamos en la raíz de "My Account"), redirigir a "edit-account"
            if ( empty( $current_endpoint ) || $current_endpoint === 'dashboard' ) {
                wp_safe_redirect( wc_get_endpoint_url( 'edit-account' ) );
                exit;
            }
        }
    }

    /** 
     * Addd titles in "Account Details" and Orders"
     */
   
    add_action( 'init', 'add_custom_titles_in_my_account' );

    function add_custom_titles_in_my_account() {
        // Agrega título en "Account Details"
        add_action( 'woocommerce_account_edit-account_endpoint', function() {
            echo '<h2 class="custom-account-title">Personal information</h2>';
        });
    
        // Agrega título en "My Orders"
        add_action( 'woocommerce_account_orders_endpoint', function() {
            echo '<h2 class="custom-orders-title">My Orders</h2>';
        });
    }

    /** 
     * Add placeholder to the password inputs
     */

     add_action('wp_footer', 'add_placeholder_to_password_inputs');

    function add_placeholder_to_password_inputs () {
        if( is_page_template( 'templates/page-my-account.php' ) ) {
            ?>
                <script>

                    // Add placeholders
                    jQuery(document).ready(function(){
                        jQuery('#password_current').attr('placeholder', 'Current password*');
                        jQuery('#password_1').attr('placeholder', 'New password');
                        jQuery('#password_2').attr('placeholder', 'Confirm password*');
                    });

                </script>
            <?php
        }
    }

     /** 
     * Adjust content in My address
     */

    add_action('wp_footer', 'adjust_in_edit_address');

    function adjust_in_edit_address () {
        if( is_page_template( 'templates/page-my-account.php' ) ) {

            // Obtener los datos de billing y shipping
            // $user_id = get_current_user_id();
            // $billing_address = get_user_meta($user_id, 'billing_address_1', true);
            // $shipping_address = get_user_meta($user_id, 'shipping_address_1', true);

            // if ( !empty($billing_address ) || !empty( $shipping_address ) ) {
            //     ?>
            //         <script>

            //             // Adjust content
            //             jQuery(document).ready(function(){

            //                 const element = document.querySelector( '.woocommerce-edit-address .woocommerce-notices-wrapper' );

            //                 if( element && element.nextElementSibling && element.nextElementSibling.tagName.toLowerCase() === 'p' ) {
            //                     element.nextElementSibling.classList.add( 'edit-address-title' );
            //                     element.nextElementSibling.innerHTML = 'My address';
            //                 }

            //             });


            //         </script>
            //     <?php
            // } else {
            //     ?>
            //         <script>
            //             // Adjust content
            //             jQuery(document).ready(function(){

            //                 const element = document.querySelector( '.woocommerce-edit-address .woocommerce-notices-wrapper' );

            //                 if( element && element.nextElementSibling && element.nextElementSibling.tagName.toLowerCase() === 'p' ) {
            //                     element.nextElementSibling.remove();
            //                 }
            //             });


            //         </script>
            //     <?php
            // }

            ?>  
                <script>
                    // Adjust content
                    jQuery(document).ready(function(){

                        const element = document.querySelector( '.woocommerce-edit-address .woocommerce-notices-wrapper' );

                        if( element && element.nextElementSibling && element.nextElementSibling.tagName.toLowerCase() === 'p' ) {
                            element.nextElementSibling.remove();
                        }
                    });
                    </script>
            <?php
        }
    }

     /** 
     * Hide "display name" 
     */
    add_action('wp_footer', 'adjust_my_account_fields');

    function adjust_my_account_fields () {
        if( is_page_template( 'templates/page-my-account.php' ) ) {
            ?>
                <script>

                    jQuery(document).ready(function(){
                       jQuery( '#account_display_name' ).parent().hide();
                       jQuery( '#account_display_name' ).attr( "readonly", "readonly" );
                    });


                </script>
            <?php
        }
    }

     /** 
     * Add 'Birthday' field
     */

    // Guardar el campo "Cumpleaños" al actualizar la cuenta
    add_action('woocommerce_save_account_details', function($user_id) {
        if (isset($_POST['billing_birthday'])) {
            update_user_meta($user_id, 'billing_birthday', sanitize_text_field($_POST['billing_birthday']));
        }
    });

    // Agregar columna "Cumpleaños" en la lista de usuarios en WooCommerce
    add_filter('manage_users_columns', function($columns) {
        $columns['billing_birthday'] = __('Birth date', 'woocommerce');
        return $columns;
    });

    // Mostrar la fecha de cumpleaños en la lista de usuarios
    add_filter('manage_users_custom_column', function($value, $column_name, $user_id) {
        if ($column_name == 'billing_birthday') {
            return get_user_meta($user_id, 'billing_birthday', true) ?: '-';
        }
        return $value;
    }, 10, 3);