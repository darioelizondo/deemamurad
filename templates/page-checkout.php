<?php

    /**
     * Template Name: Checkout page
     *
     * @package Darío Elizondo
     */

    get_header();

    if( have_posts() ) : while( have_posts() ) : the_post();

    ?>

        <div class="checkout-page">
            <div class="checkout-page__inner container">
                <?php echo do_shortcode( '[woocommerce_checkout]' ); ?>
            </div>
        </div>

    <?php

    endwhile;
    endif;

    get_footer();
