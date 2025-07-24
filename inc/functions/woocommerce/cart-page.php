<?php

    /**
     * Function: Cart page
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Add text tax included
     */

    add_action('wp_footer', function() {
        if ( is_cart() ) : ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const subtotalRow = document.querySelector(".cart-subtotal th");
                    if (subtotalRow && !subtotalRow.querySelector(".cart-subtotal__tax-included")) {
                        subtotalRow.innerHTML = '<p>Subtotal (Tax included)</p>';
                        subtotalRow.insertAdjacentHTML(
                            "beforeend",
                            '<p class="cart-subtotal__tax-included">Including: <?php echo wc_price(WC()->cart->get_taxes_total()); ?> VAT</p>'
                        );
                    }
                });
            </script>
        <?php endif;
    });

    /** 
     * Hide tax line in cart totals by default
     */
    add_filter('woocommerce_cart_totals_taxes_total_html', '__return_empty_string');
    add_filter('woocommerce_cart_totals_order_total_html', function($value) {
        // Quita la línea de impuestos si se está mostrando junto al total
        return preg_replace('/<small class="includes_tax">.*?<\/small>/', '', $value);
    });