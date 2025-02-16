<?php

    /**
     * Component: Atom: Subscription form
     * 
     * @package Darío Elizondo
     * 
     */

    $suscription_form = get_field( 'subscription_form', 'option' );

?>


<!-- Subscription form -->
 <div class="subscription-form">
    <div class="subscription-form__inner">
        <!-- Title -->
        <div class="subscription-form__wrapper-title">
            <h4 class="subscription-form__title">
                <?php echo esc_html( $suscription_form[ 'title' ] ); ?>
            </h4>
        </div>
        <!-- Form -->
        <div class="subscription-form__wrapper-form">
            <?php echo do_shortcode( $suscription_form[ 'form' ] ); ?>
        </div>
    </div>
 </div>
<!-- End subscription form -->