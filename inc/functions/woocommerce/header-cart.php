<?php

    /**
     * Function: Header cart
     * 
     * @package Darío Elizondo
     * 
     */

    add_action( 'deemamurad_header_cart', 'add_deemamurad_header_cart' );

    function add_deemamurad_header_cart() {
?>
        <!-- Header cart -->
        <div id="headerCart" class="header-cart">
            <div class="header-cart__inner">
                <!-- Icon -->
                <div class="header-cart__wrapper-icon">
                    <button id="headerCartButton" class="header-cart__button" type="button">
                        <span class="header-cart__text" >
                            Cart
                        </span>
                        <!-- Counter -->
                        <?php if( WC()->cart->get_cart_contents_count() > 0 ) : ?>
                            <span class="header-cart__count">
                                <?php echo WC()->cart->get_cart_contents_count(); ?>
                            </span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>
        </div>
<?php
    }
?>