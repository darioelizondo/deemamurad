<?php

    /**
     * Function: Checkout
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Move coupon discount to Order Review
     */

    add_action( 'wp', 'move_coupon_form_to_order_review' );

    function move_coupon_form_to_order_review() {
        // Elimina el formulario de cupón de su ubicación original
        remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
    
        // Agrega el formulario del cupón después de los ítems del pedido, pero antes del subtotal
        add_action( 'woocommerce_review_order_before_order_total', 'custom_checkout_coupon_form', 5 );
    }
    
    function custom_checkout_coupon_form() {
        echo '<tr class="coupon-form-row"><td colspan="2">';
        echo '<div class="woocommerce-coupon-form always-visible">';
        woocommerce_checkout_coupon_form();
        echo '</div>';
        echo '</td></tr>';
    }

    add_action( 'woocommerce_review_order_before_order_total', 'display_applied_coupons_in_order_review', 6 );
    
    function display_applied_coupons_in_order_review() {
        $coupons = WC()->cart->get_coupons();
    
        if ( empty( $coupons ) ) {
            return;
        }
    
        echo '<tr class="cart-discount"><td colspan="2">';
        echo '<h3>' . esc_html__( 'Applied Coupons:', 'woocommerce' ) . '</h3>';
        echo '<ul>';
    
        foreach ( $coupons as $code => $coupon ) {
            echo '<li><strong>' . esc_html( $coupon->get_code() ) . ':</strong> ';
            wc_cart_totals_coupon_html( $coupon );
            echo '</li>';
        }
    
        echo '</ul></td></tr>';
    }

     add_action('wp_footer', 'add_move_coupon_checkout');

     function add_move_coupon_checkout() {
        ?>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    function showCouponForm() {
                        let couponFormWrapper = document.querySelector('.woocommerce-coupon-form');
                        let couponForm = document.querySelector('.woocommerce-form-coupon');
                        if (couponFormWrapper) {
                            couponFormWrapper.style.display = "block";
                            couponFormWrapper.style.opacity = "1";
                            couponFormWrapper.style.visibility = "visible";
                            couponFormWrapper.style.height = "auto";
                            couponForm.style.display = "block";
                        }
                    }

                    // Mostrar el formulario en la carga inicial
                    setTimeout( () => {
                        showCouponForm();
                    }, 1000 )

                    // Detectar cuando WooCommerce actualiza el Order Review y volver a mostrar el formulario
                    jQuery(document.body).on('updated_checkout', function () {
                        setTimeout( () => {
                            showCouponForm();
                        }, 1000 )
                    });
                });
            </script>

        <?php
     }

     /** 
     * Add title to Order review
     */

     add_action('woocommerce_review_order_before_cart_contents', function() {
        if (!did_action('my_custom_order_review_header')) { // Verifica si ya se ejecutó
            do_action('my_custom_order_review_header');
        }
    });
    
    add_action('my_custom_order_review_header', function() {
        ?>
            <div class="order-review-header">
                <div class="order-review-header__wrapper-title">
                    <span class="order-review-header__title">Order summary</span>
                    <a class="order-review-header__edit" href="<?php echo wc_get_cart_url() ?>">
                        Edit cart
                    </a>
                </div>
                <div class="order-review-header__accordion-title">
                    <div id="order-review-toggle" class="order-review-header__inner-accordion-title">
                        <span class="order-review-header__title">Show order summary</span>
                        <span class="order-review-header__plus-minus-toggle collapsed"></span>
                    </div>
                    <div class="order-review-header__right">
                        <span class="order-review-header__total active">
                            <?php echo WC()->cart->get_total(); ?>
                        </span>
                        <a id="orderReviewHeaderEditTwo" class="order-review-header__edit" href="<?php echo wc_get_cart_url() ?>">
                            Edit cart
                        </a>
                    </div>
                </div>
            </div>
        <?php
    }, 10);

     /** 
     * Order review accordion
     */

    add_action('wp_footer', function() {
        if (is_checkout()) {
            ?>
            <script>
            
                 // Accordion
                jQuery(document).ready(function($) {
                    function setupOrderReviewToggle() {

                        const orderReviewToggle = document.querySelectorAll( '.order-review-header' );
                        
                        if ( orderReviewToggle.length > 1) {
                            orderReviewToggle[1].remove(); // Elimina duplicados
                        }

                        if ($(window).width() < 768) {

                            $('.shop_table.woocommerce-checkout-review-order-table').hide(); // Oculta por defecto en mobile

                            $('#order-review-toggle').off('click').on('click', function() {
                                $('.shop_table.woocommerce-checkout-review-order-table').slideToggle(300); // Efecto de slide
                                $( '.order-review-header__plus-minus-toggle' ).toggleClass( 'collapsed' );
                                $( '.order-review-header__total' ).toggleClass( 'active' );
                                $( '#orderReviewHeaderEditTwo' ).toggleClass( 'active' );

                            });
                        }

                    }

                    setupOrderReviewToggle();

                    // Detecta cuando WooCommerce actualiza el checkout y ejecuta la corrección
                    $(document.body).on('updated_checkout', function() {
                        setupOrderReviewToggle();
                    });
                });

                // Update total when updating checkout
                jQuery(function($) {
                    $(document.body).on('updated_checkout', function() {
                        $('.order-review-total').html($('.order-total .woocommerce-Price-amount').html());
                    });
                });

                jQuery(document).ready(function($) {
                    // Ajustes al Payment
                    setTimeout( () => {
                        jQuery( '.CardNumberField-input-wrapper' ).style.left = '0px';
                        jQuery( '.CardBrandIcon-container' ).style.display = 'none';
                        jQuery( '#link-pay' ).style.display = 'none';
                    }, 3000 );
                });

            </script>
            <?php
        }
    });

     /** 
     * Move payment to Customer Details
     */

     add_action('wp_head', function() {
        remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
    });

    add_action('woocommerce_after_order_notes', 'custom_move_payment_section', 5);

    function custom_move_payment_section() {
        if (is_checkout()) {
            echo '<div class="custom-payment-wrapper">';
            woocommerce_checkout_payment();
            echo '</div>';
            echo '<div class="back-to-shop__wrapper">';
            echo    '<svg width="32" height="9" viewBox="0 0 32 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.52941 8L1 4.5M1 4.5L4.52941 1M1 4.5L31 4.5" stroke="#3F3F46" stroke-linecap="square" stroke-linejoin="round"/>
                    </svg>';
            echo    '<a class="back-to-shop__link" href="' . get_site_url() . '/shop">Back to shop</a>';
            echo '</div>';
        }
    }

     /** 
     * Move email to up in billing
     */

    add_filter('woocommerce_billing_fields', 'custom_move_email_field', 10, 1);

    function custom_move_email_field($fields) {
        if (isset($fields['billing_email'])) {
            $fields['billing_email']['priority'] = 1; // Mover email al primer lugar
        }
        return $fields;
    }

     /** 
     * Add news checkbox
     */

    add_filter('woocommerce_billing_fields', 'add_newsletter_checkbox');

    function add_newsletter_checkbox($fields) {
        $fields['billing_newsletter'] = array(
            'type'     => 'checkbox',
            'label'    => 'Sign me up for Deema Murad news and other digital communications.',
            'class'    => array('form-row-wide'),
            'priority' => 5, // Lo colocamos después del email
        );
    
        return $fields;
    }

    add_filter('woocommerce_form_field_checkbox', 'custom_newsletter_checkbox_html', 10, 4);

     function custom_newsletter_checkbox_html($field, $key, $args, $value) {
        if ( $key === 'billing_newsletter') {
            $field = '<p class="form-row woocommerce-form__billing-newsletter ' . esc_attr(implode(' ', $args['class'])) . '" id="' . esc_attr($key) . '_field">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox">
                    <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox" name="' . esc_attr($key) . '" id="' . esc_attr($key) . '" value="1" ' . checked($value, 1, false) . ' />
                    <span class="checkmark"></span>
                </label>
                <span class="woocommerce-form__billing-newsletter-span">' . esc_html($args['label']) . '</span>
            </p>';
        }
        return $field;
    }

    add_action('woocommerce_checkout_update_order_meta', 'save_newsletter_checkbox_to_order');
    
    function save_newsletter_checkbox_to_order($order_id) {
        if (isset($_POST['billing_newsletter'])) {
            update_post_meta($order_id, '_billing_newsletter', 'Sí');
        } else {
            update_post_meta($order_id, '_billing_newsletter', 'No');
        }
    }

    add_action('woocommerce_admin_order_data_after_billing_address', 'display_newsletter_checkbox_in_admin', 10, 1);

    function display_newsletter_checkbox_in_admin($order) {
        $newsletter = get_post_meta($order->get_id(), '_billing_newsletter', true);
        if ($newsletter) {
            echo '<p><strong>Suscripción a noticias:</strong> ' . esc_html($newsletter) . '</p>';
        }
    }

     /** 
     * Add title "Billing information"
     */

    add_filter('woocommerce_billing_fields', 'add_billing_information_title', 10, 1);

    function add_billing_information_title($fields) {
        $fields['billing_billing_info_title'] = [
            'type'     => 'text',
            'label'    => 'Billing Information',
            'class'    => ['form-row-wide'], // Ocupa todo el ancho
            'priority' => 6 // Justo después del checkbox
        ];
        return $fields;
    }

    
     /** 
     * Add user account if is logged or not
     */

    add_action('woocommerce_before_checkout_billing_form', 'add_custom_checkout_account_section', 5);

    function add_custom_checkout_account_section() {
        if (is_user_logged_in()) {
            // Usuario logueado
            $current_user = wp_get_current_user(); 
            echo '<div class="checkout-account-info checkout-account-info--logged-in">';
            echo    '<h4 class="checkout-account-info__title">Account</h4>';
            echo    '<div class="checkout-account-info__details">';
            echo        '<p class="checkout-account-info__email">' . esc_html($current_user->user_email) . '</p>';
            echo        '<a class="checkout-account-info__logout" href="' . wp_logout_url(wc_get_checkout_url()) . '" class="checkout-logout">Logout</a>';
            echo    '</div>';
            echo '</div>';
        } else {
            // Usuario no logueado
            echo '<div class="checkout-account-info">';
            echo    '<div class="checkout-account-info__wrapper-title">';
            echo        '<p class="checkout-account-info__title">Contact</p>';
            echo    '</div>';
            echo    '<div class="checkout-account-info__inner">';
            echo        '<p clas="checkout-account-info__label">Already have an account?</p>';
            echo        '<a class="checkout-account-info__login" href="' . esc_url(wp_login_url(wc_get_checkout_url())) . '" class="checkout-login-link">Login</a>';
            echo    '</div>';
            echo '</div>';
            
        }
    }

    add_filter('woocommerce_billing_fields', 'hide_billing_email_if_logged_in');

    function hide_billing_email_if_logged_in($fields) {
        if (is_user_logged_in()) {
            unset($fields['billing_email']); // Oculta el email si está logueado
            unset($fields['billing_newsletter']); // Oculta el newsletter si está logueado
        }
        return $fields;
    }

    /** 
     * Make phone field required
     */
    
    add_filter('woocommerce_billing_fields', 'make_billing_phone_required');

    function make_billing_phone_required($fields) {
        if (isset($fields['billing_phone'])) {
            $fields['billing_phone']['required'] = true;
        }
        return $fields;
    }

     /** 
     * Add title "Payment method"
     */

     add_filter('woocommerce_before_order_notes', 'add_payment_method_title');

     function add_payment_method_title() {
         echo '<div class="payment-method__wrapper-title">';
         echo   '<p class="payment-method__title">Payment method</p>';
         echo '</div>';
     }

     /** 
     * Change labels in checkout form
     */

    add_filter('woocommerce_checkout_fields', 'custom_override_checkout_fields');

    function custom_override_checkout_fields( $fields ) {

        // Cambiar labels en el formulario de facturación (Billing)
        $fields['billing']['billing_country']['label'] = 'Country';
        $fields['billing']['billing_city']['label'] = 'City';
        $fields['billing']['billing_state']['label'] = 'State';
        $fields['billing']['billing_address_1']['label'] = 'Address';
        $fields['billing']['billing_postcode']['label'] = 'Postcode';
        $fields['billing']['billing_phone']['label'] = 'Phone number';
    
        // Cambiar labels en el formulario de envío (Shipping)
        $fields['shipping']['shipping_country']['label'] = 'Country';
        $fields['shipping']['shipping_city']['label'] = 'City';
        $fields['shipping']['shipping_state']['label'] = 'State';
        $fields['shipping']['shipping_postcode']['label'] = 'Address';
    
        return $fields;
    }

    add_filter( 'woocommerce_default_address_fields' , 'override_default_address_fields' );
    function override_default_address_fields( $address_fields ) {

        $address_fields['country']['label'] = __('Country', 'woocommerce');
        $address_fields['address_1']['label'] = __('Address', 'woocommerce');
        $address_fields['city']['label'] = __('City', 'woocommerce');
        $address_fields['state']['label'] = __('State', 'woocommerce');
        $address_fields['postcode']['label'] = __('Postcode', 'woocommerce');

        return $address_fields;
    }

     /** 
     * Adjust layout in billing form with state and city
     */

    add_action('wp_footer', 'fix_layout_checkout');

     function fix_layout_checkout() {
        ?>

            <script>
                jQuery(document).ready(function($) {

                    // Billing and shipping form
                    const stateInputBilling = document.getElementById( 'billing_state_field' );
                    const stateInputShipping = document.getElementById( 'shipping_state_field' );

                    if ( stateInputBilling && stateInputBilling.style.display === "none" ) {
                        stateInputBilling.nextElementSibling.style.width = '49%';
                        stateInputBilling.nextElementSibling.style.float = 'right';
                        stateInputBilling.nextElementSibling.style.clear = 'none';
                    }

                    if ( stateInputShipping && stateInputShipping.style.display === "none" ) {
                        stateInputShipping.nextElementSibling.style.width = '49%';
                        stateInputShipping.nextElementSibling.style.float = 'right';
                        stateInputShipping.nextElementSibling.style.clear = 'none';
                    }

                    // Ship to a different address
                    const shipToDifferentAddress = document.getElementById( 'ship-to-different-address' );

                    if( shipToDifferentAddress ) {
                        shipToDifferentAddress.querySelector( 'label' ).nextElementSibling.innerHTML = 'Ship to a different address';
                    }

                });
            </script>

        <?php
    }

    /** 
     * Hide tax line in cart totals by default
    */
    add_filter('woocommerce_cart_totals_taxes_total_html', '__return_empty_string');
    add_filter('woocommerce_cart_totals_order_total_html', function($value) {
        return preg_replace('/<small class="includes_tax">.*?<\/small>/', '', $value);
    });