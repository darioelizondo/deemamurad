<?php

    /**
     * Function: Cart popup
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Add script to footer
     */

    add_action('wp_footer', 'add_cart_popup_scripts');

    function add_cart_popup_scripts () {
        ?>
            <script>
                jQuery(document).ready(function ($) {
                    function updateCartPopup() {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: { action: 'update_cart_popup' },
                            success: function (response) {
                                if ( response.data.cart_count === 0 ) {
                                    $('#cartPopupItems').html(response.data.html);
                                    $('#cartPopupItems').hide();
                                    $( '#cartNoItems' ).show();
                                    $('#cartCount').text(response.data.cart_count);
                                    $('#cartTotal').hide();
                                    $('#cartTotalPrice').html(response.data.cart_total);
                                    $('#cartCheckoutButton').hide();
                                    $('.cart-popup').addClass('active');
                                    setTimeout( () => {
                                        $('.cart-popup__inner').addClass('active');
                                    }, 300 )
                                }
                                if( response.data.cart_count > 0 ) {
                                    $('#cartPopupItems').html(response.data.html);
                                    $('#cartPopupItems').show();
                                    $( '#cartNoItems' ).hide();
                                    $('#cartCount').text(response.data.cart_count);
                                    $('#cartTotal').show();
                                    $('#cartTotalPrice').html(response.data.cart_total);
                                    $('#cartCheckoutButton').show();
                                    $('.cart-popup').addClass('active');
                                    setTimeout( () => {
                                        $('.cart-popup__inner').addClass('active');
                                    }, 300 )
                                }
                            }
                        });
                    }

                    // Intercepta el botón de agregar al carrito
                    $('body').on('click', '.add_to_cart_button', function (e) {
                        e.preventDefault();
                        var product_id = $(this).data('product_id');

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'custom_add_to_cart',
                                product_id: product_id
                            },
                            success: function () {
                                updateCartPopup();
                            }
                        });
                    });

                    // Cambiar cantidad del producto en el carrito
                    // Disminuir cantidad
                    $(document).on('click', '.quantity-decrease', function() {
                        let input = $(this).siblings('input');
                        let newValue = parseInt(input.val()) - 1;
                        if (newValue >= 1) {
                            input.val(newValue).trigger('change');
                        }
                    });

                    // Aumentar cantidad
                    $(document).on('click', '.quantity-increase', function() {
                        let input = $(this).siblings('input');
                        let newValue = parseInt(input.val()) + 1;
                        input.val(newValue).trigger('change');
                    });

                    // Actualizar carrito al cambiar cantidad
                    $(document).on('change', '.cart-item__cart-quantity input', function() {
                        let cartKey = $(this).data('cart_key');
                        let newQuantity = $(this).val();

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'update_cart_quantity',
                                cart_key: cartKey,
                                quantity: newQuantity
                            },
                            success: function(response) {
                                if (response.success) {
                                    updateCartPopup();
                                }
                            }
                        });
                    });

                    // Cerrar carrito
                    $('#cartPopupClose').on('click', function () {
                        setTimeout( () => {
                            $('.cart-popup').removeClass('active');
                        }, 300 )
                        $('.cart-popup__inner').removeClass('active');
                    });
                    

                    // Abrir carrito con Cart Header
                    $('#headerCartButton').on('click', function () {
                        updateCartPopup();
                    });

                    // **Eliminar producto**
                    $(document).on('click', '.cart-item__remove-item', function () {
                        let cartKey = $(this).data('cart-key');

                        $.ajax({
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'remove_cart_item',
                                cart_key: cartKey,
                            },
                            success: function () {
                                updateCartPopup();
                            },
                        });
                    });

                });
            </script>
        <?php
    }

    /** 
     * Ajax add to cart
     */

    add_action('wp_ajax_custom_add_to_cart', 'custom_ajax_add_to_cart');
    add_action('wp_ajax_nopriv_custom_add_to_cart', 'custom_ajax_add_to_cart');

     function custom_ajax_add_to_cart() {
        $product_id = intval($_POST['product_id']);
        WC()->cart->add_to_cart($product_id);
        wp_send_json_success();
    }

    /** 
     * Update Cart
     */

    add_action('wp_ajax_update_cart_popup', 'update_cart_popup');
    add_action('wp_ajax_nopriv_update_cart_popup', 'update_cart_popup');

    function update_cart_popup() {
        ob_start();
        $cart_count = WC()->cart->get_cart_contents_count();
        $cart_total = WC()->cart->get_total();
    
        if ($cart_count > 0) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $product = wc_get_product($cart_item['product_id']);
                $variations = isset($cart_item['variation']) ? $cart_item['variation'] : [];
                $variation_id = !empty($cart_item['variation_id']) ? $cart_item['variation_id'] : null;
                $image_url = get_the_post_thumbnail_url($cart_item['product_id'], 'thumbnail'); // Imagen por defecto

                // Si hay una variación seleccionada, obtenemos la imagen desde ACF
                if ($variation_id) {
                    $variation_galleries = get_field('variation_galleries', $product->get_id());
                    if (!empty($variation_galleries)) {
                        foreach ($variation_galleries as $gallery) {
                            if ($gallery['variation_id'] == $variation_id) {
                                $gallery_images = $gallery['gallery'];
                                if (!empty($gallery_images[0]['url'])) {
                                    $image_url = $gallery_images[0]['url']; // Primera imagen de la galería
                                }
                                break;
                            }
                        }
                    }
                }
    
                echo '<div class="cart-item">';
                echo    '<img class="cart-item__image image--fluid" src="' . esc_url($image_url) . '" alt="' . esc_attr($product->get_name()) . '" />';
                echo    '<div class="cart-item__details">';
                echo        '<div class="cart-item__content">';
                echo            '<div class="cart-item__inner-content">';
                echo                '<p class="cart-item__details-text">' . $product->get_name() . '</p>';
                foreach ($variations as $key => $value) {
                        // Eliminar el prefijo "attribute_" para obtener el slug real del atributo
                        $attribute_slug = str_replace('attribute_', '', $key);
                        // Obtener el nombre del atributo (ejemplo: "Color" en lugar de "attribute_pa_colour")
                        $attribute_name = wc_attribute_label($attribute_slug);
                        // Obtener el valor del atributo (ejemplo: "Mixed Golds")
                        $term = get_term_by('slug', $value, $attribute_slug);
                        $attribute_value = ($term) ? $term->name : ucfirst($value); // Si no encuentra el término, capitaliza el valor
                        // Imprimir el nombre del atributo con su valor
                        echo        '<p class="cart-item__details-text">' . esc_html($attribute_name) . ': ' . esc_html($attribute_value) . '</p>';
                }
                echo                '<div class="cart-item__wrapper-cart-quantity">';
                echo                    '<span class="cart-item__span-quantity">Quantity:</span>';
                echo                    '<div class="cart-item__cart-quantity">';
                echo                        '<button id="quantityDecrease" class="quantity-decrease" data-cart_key="' . $cart_item_key . '">-</button>';
                echo                        '<input type="number" min="1" value="' . esc_attr($cart_item['quantity']) . '" data-cart_key="' . $cart_item_key . '">';
                echo                        '<button id="quantityIncrease" class="quantity-increase" data-cart_key="' . $cart_item_key . '">+</button>';
                echo                    '</div>';
                echo                '</div>';
                echo            '</div>';
                echo            '<div class="cart-item__details-price">';
                echo                '<p class="cart-item__details-text">' . wc_price($cart_item['line_total']) . '</p>';
                echo                '<p class="cart-item__tax-included">Tax included</p>';
                echo            '</div>';
                echo        '</div>';
                echo        '<div class="cart-item__wrapper-remove">';
                echo            '<button class="cart-item__remove-item" data-cart-key="' . $cart_item_key . '">Remove</button>';
                echo        '</div>';
                echo    '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>Tu carrito está vacío.</p>';
        }
    
        wp_send_json_success([
            'html' => ob_get_clean(),
            'cart_count' => $cart_count,
            'cart_total' => $cart_total
        ]);
    }
    
    /** 
     * Update cart quantity
     */

    add_action('wp_ajax_update_cart_quantity', 'update_cart_quantity');
    add_action('wp_ajax_nopriv_update_cart_quantity', 'update_cart_quantity');

    function update_cart_quantity() {
        if (!isset($_POST['cart_key']) || !isset($_POST['quantity'])) {
            wp_send_json_error(['message' => 'Datos inválidos']);
            return;
        }
    
        $cart_key = sanitize_text_field($_POST['cart_key']);
        $quantity = intval($_POST['quantity']);
    
        if ($quantity <= 0) {
            WC()->cart->remove_cart_item($cart_key);
        } else {
            WC()->cart->set_quantity($cart_key, $quantity);
        }
    
        // Forzar actualización del carrito
        WC()->cart->calculate_totals();
        
        wp_send_json_success();
    }

    /** 
     * Remove item from cart
     */

    add_action('wp_ajax_remove_cart_item', 'remove_cart_item');
    add_action('wp_ajax_nopriv_remove_cart_item', 'remove_cart_item');

    function remove_cart_item() {
        $cart_key = sanitize_text_field($_POST['cart_key']);
        WC()->cart->remove_cart_item($cart_key);
        wp_send_json_success();
    }
    
     /** 
     * Update header cart count
     */
    add_action('wp_ajax_get_cart_count', 'get_cart_count');
    add_action('wp_ajax_nopriv_get_cart_count', 'get_cart_count');

    function get_cart_count() {
        wp_send_json_success([
            'cart_count' => WC()->cart->get_cart_contents_count()
        ]);
    }

     add_action('wp_footer', 'update_header_cart_count');
     
     function update_header_cart_count() {
        ?>
            <script>
                jQuery(document).ready(function($) {

                    function updateHeaderCartCount() {
                        $.ajax({
                            type: 'POST',
                            url: "<?php echo admin_url('admin-ajax.php'); ?>",
                            data: {
                                action: 'get_cart_count'
                            },
                            success: function(response) {
                                if (response.success) {
                                    let cartCount = response.data.cart_count;
                                    
                                    // Actualizar el contador en el header
                                    let cartCountElement = $('.header-cart__count');
                                    
                                    if (cartCount > 0) {
                                        if (cartCountElement.length) {
                                            cartCountElement.text(cartCount);
                                        } else {
                                            $('#headerCartButton').append('<span class="header-cart__count">' + cartCount + '</span>');
                                        }
                                    } else {
                                        cartCountElement.remove();
                                    }
                                }
                            }
                        });
                    }

                    // Llamar a la función en estos eventos:
                    $(document).on('click', '.add-to-cart-button', function() {  setTimeout(updateHeaderCartCount, 1000); }); // Al agregar productos
                    $(document).on('click', '.single_add_to_cart_button', function() {  setTimeout(updateHeaderCartCount, 1000); }); // Al agregar productos en single product
                    $(document).on('click', '.remove-cart-item', function() {  setTimeout(updateHeaderCartCount, 1000); });  // Al eliminar productos
                    $(document).on('click', '.cart-item__remove-item', function() {  setTimeout(updateHeaderCartCount, 1000); });  // Al eliminar productos del carrito
                    $(document).on('change', '.cart-item__cart-quantity input', function() {  setTimeout(updateHeaderCartCount, 1000); }); // Al modificar cantidad
                });

            </script>
        <?php
     }

    /** 
     * Update cart
     */
    add_action( 'template_redirect', 'update_cart_action', 10 );

    function update_cart_action() {
        if ( isset( $_POST['update_cart'] ) ) {
            WC()->cart->calculate_totals();
        }
    }

    /** 
     * Update cart on cart page
     */

     add_action('wp_footer', function() {
        if (is_cart()) { ?>
            <script>
                jQuery(function($) {
                    $('div.woocommerce').on('change', 'input.qty', function() {
                        $('button[name="update_cart"]').trigger('click');
                    });
                });
            </script>
        <?php }
    });