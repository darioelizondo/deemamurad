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

add_action('wp_footer', 'add_tax_included_text');

     function add_tax_included_text() {
        ?>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const cartTotals = document.querySelector('.cart_totals');
                    const cartSubtotal = cartTotals.querySelector('.cart-subtotal th');
                    const taxIncludedText = document.createElement('p');
                    cartSubtotal.innerHTML = 'Subtotal <br><span class="cart-subtotal__tax-included">Tax included</span>';
                });
            </script>

        <?php
     }