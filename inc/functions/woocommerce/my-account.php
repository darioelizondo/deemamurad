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

    /**
     * Términos en el registro (My Account + Checkout Create Account)
     * - Muestra modal y bloquea envío hasta aceptar
     * - Valida server-side
     * - Guarda meta al crear usuario
     */

    // 1) Inyecta modal + JS en páginas relevantes
    add_action( 'wp_footer', function () {

        // Si el usuario ya está logueado no aplica
        if ( is_user_logged_in() ) return;

        // Mostrar solo en Mi cuenta (registro) o en Checkout
        if ( !( is_account_page() || is_checkout() || is_page( 'register' ) ) ) return;

        include TD . '/template-parts/components/molecules/terms-and-conditions-popup-register.php';

        ?>

        <script>
        jQuery(function($) {

            // --- Selectores del popup de REGISTRO ---
            const $popup   = $('#termsConditionsPopupRegister');
            const $btn     = $('#termsAndConditionsPopupButtonRegister');
            const $chkA    = $('#termsAndConditionsCheckboxRegister_understood');
            const $chkB    = $('#termsAndConditionsCheckboxRegister_readTerms');

            // Formularios:
            // My Account -> form.register
            const $formRegister = $('form.register-form__form');
            const $hidAccept = $formRegister.find('input[name="tos_modal_accept"]');

            // Checkout -> si marcan "Crear una cuenta" #createaccount
            const $formCheckout = $('form.checkout');
            const $createAccount = $('#createaccount');

            // Campo oculto para validar server-side
            // Lo creamos y lo inyectamos donde haga falta.
            const hiddenName = 'tos_modal_accept';
            const $hidden = $('<input>', {type: 'hidden', name: hiddenName, value: ''});

            let accepted = false;
            let lastTrigger = null; // 'register' | 'checkout'

            function toggleBtn() {
                const ready = $chkA.prop('checked') && $chkB.prop('checked');
                $btn.toggleClass('disabled', !ready).prop('disabled', !ready);
            }
            $chkA.on('change', toggleBtn);
            $chkB.on('change', toggleBtn);
            toggleBtn();

            function openPopup() {
                $popup.addClass('opened');
                setTimeout(() => { $chkA.trigger('focus'); }, 40);
            }
            function closePopup() {
                $popup.removeClass('opened');
            }

            // --- BLOQUEO EN MI CUENTA (registro clásico) ---
            if ($formRegister.length) {
                // Inyectar el hidden en el form de registro
                if (!$formRegister.find('input[name="'+hiddenName+'"]').length) {
                    $formRegister.append($hidden.clone());
                }

                $formRegister.on('submit', function(e) {
                    if (!accepted) {
                        e.preventDefault();
                        lastTrigger = 'register';
                        openPopup();
                        return false;
                    }
                    return true;
                });
            }

            // --- BLOQUEO EN CHECKOUT SÓLO si van a crear cuenta ---
            if ($formCheckout.length && $createAccount.length) {
                // Inyectar hidden también en checkout por si crean cuenta
                if (!$formCheckout.find('input[name="'+hiddenName+'"]').length) {
                    $formCheckout.append($hidden.clone());
                }

                // Enganchar en el evento canónico antes de enviar Woo
                const events = [
                'checkout_place_order',          // genérico Woo
                'checkout_place_order_stripe',   // si usas Stripe card (por consistencia)
                ];
                $formCheckout.on(events.join(' '), function () {
                    // Mostrar popup SOLAMENTE si van a crear cuenta
                    if (!accepted && $createAccount.is(':checked')) {
                        lastTrigger = 'checkout';
                        openPopup();
                        return false;
                    }
                    return true;
                });
            }

            // --- Confirmación del popup ---
            $btn.on('click', function(e) {
                e.preventDefault();
                if ($btn.hasClass('disabled')) return;

                accepted = true;
                closePopup();

                // Setear hidden para validación server-side
                $('input[name="'+hiddenName+'"]').val('1');

                if (lastTrigger === 'register' && $formRegister.length) {
                    $hidAccept.val('1');
                    $formRegister.trigger('submit');
                } else if (lastTrigger === 'checkout' && $formCheckout.length) {
                    $formCheckout.trigger('submit');
                }
            });

            // Si WooCommerce lanza errores (checkout), volvemos a pedir aceptación
            $(document.body).on('checkout_error', function () {
                accepted = false;
                $('input[name="'+hiddenName+'"]').val('');
            });
        });
        </script>
        <?php
    });

    // 2a) Validación en Mi Cuenta (registro clásico)
    add_filter( 'woocommerce_registration_errors', function( $errors, $username, $email ) {
        if ( is_user_logged_in() ) return $errors;

        // Sólo en el flujo de registro
        if ( isset($_POST['register']) ) {
            $accepted = isset($_POST['tos_modal_accept']) && $_POST['tos_modal_accept'] === '1';
            if ( ! $accepted ) {
                $errors->add( 'tos_modal_missing', __( 'Debes aceptar los Términos y Condiciones para crear tu cuenta.', 'your-textdomain' ) );
            }
        }
        return $errors;
    }, 10, 3 );

    // 2b) Validación en Checkout SÓLO si crearán cuenta
    add_action( 'woocommerce_checkout_process', function () {
        if ( is_user_logged_in() ) return;

        $create_account = ! empty( $_POST['createaccount'] );
        if ( $create_account ) {
            $accepted = isset($_POST['tos_modal_accept']) && $_POST['tos_modal_accept'] === '1';
            if ( ! $accepted ) {
                wc_add_notice( __( 'Debes aceptar los Términos y Condiciones para crear tu cuenta.', 'your-textdomain' ), 'error' );
            }
        }
    });

    // 2c) Guardar meta al crear usuario (marca de aceptación en el alta)
    add_action( 'user_register', function( $user_id ) {
        if ( isset($_POST['tos_modal_accept']) && $_POST['tos_modal_accept'] === '1' ) {
            update_user_meta( $user_id, '_tos_modal_accept', '1' );
            update_user_meta( $user_id, '_tos_modal_accept_date', current_time( 'mysql', true ) ); // opcional: fecha UTC
        }
    });