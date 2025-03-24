<?php

    /**
     * Component: Molecule: Cart popup
     * 
     * @package Darío Elizondo
     * 
     */

    //  wp_enqueue_script( 'deemamurad.menu-footer' );

?>

<!-- Cart popup -->
<div id="cartPopup" class="cart-popup">
    <div class="cart-popup__inner">
        <div class="cart-popup__wrapper-close">
            <button class="cart-popup__close" id="cartPopupClose">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L18 18M1 18L18 1L1 18Z" stroke="#3F3F46" stroke-width="0.971429" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        <!-- Content -->
        <div class="cart-popup__wrapper-content">
            <h2 class="cart-popup__title">
                Cart (<span id="cartCount">0</span>)
            </h2>
            <div id="cartNoItems" class="cart-popup__wrapper-no-items">
                <p class="cart-popup__no-items">
                    Your cart is empty.<br>
                    Want to add something to it?
                </p>
                <a href="<?php echo get_site_url() . '/shop' ?>" class="cart-popup__link-shop-page">
                    Keep shopping
                </a>
            </div>
            <!-- Dynamically populated -->
            <div id="cartPopupItems" class="cart-popup__wrapper-items"></div>
            <!-- Total -->
            <div id="cartTotal" class="cart-popup__wrapper-total">
                <p class="cart-popup__total-text">
                    Total products
                </p>
                <div id="cartTotalPrice" class="cart-popup__total-amount">
                    $0.00
                </div>
            </div>
        </div>
        <!-- Checkout -->
        <div id="cartCheckoutButton" class="cart-popup__wrapper-checkout">
            <a class="cart-popup__checkout-button" href="<?php echo wc_get_checkout_url(); ?>">Checkout</a>
        </div>
    </div>
</div>
<!-- End cart popup -->