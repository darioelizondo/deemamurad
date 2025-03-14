<?php

    /**
     * Template Name: Cart page
     *
     * @package Darío Elizondo
     */

    get_header();

    if( have_posts() ) : while( have_posts() ) : the_post();

    ?>

        <div class="cart-page">
            <div class="cart-page__inner container">
                <?php echo do_shortcode( '[woocommerce_cart]' ); ?>
            </div>
        </div>

    <?php

    endwhile;
    endif;

    get_footer();
