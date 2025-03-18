<?php

    /**
     * Template Name: My account page
     *
     * @package Darío Elizondo
     */

    if ( !is_user_logged_in() ) {
        wp_redirect( site_url('/login') ); // 🔥 Cambia "/login" por la URL real de tu página de login
        exit; // Importante para detener la ejecución
    }

    get_header();

    if ( have_posts() ) : while ( have_posts() ) : the_post();
    ?>

        <div class="my-account-page">
            <div class="my-account-page__inner container">
                <?php echo do_shortcode( '[woocommerce_my_account]' ); ?>
            </div>
        </div>

    <?php
    endwhile;
    endif;

    get_footer();
