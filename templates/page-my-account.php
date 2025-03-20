<?php

    /**
     * Template Name: My account page
     *
     * @package Darío Elizondo
     */

    $current_url = $_SERVER['REQUEST_URI']; // Obtiene la URL actual

    // Verifica si el usuario no está logueado y la URL NO es "/my-account/lost-password"
    if ( !is_user_logged_in() && strpos($current_url, '/my-account/lost-password') === false ) {
        wp_redirect( site_url('/login') ); // 🔥 Cambia "/login" por la URL real de tu página de login
        exit;
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
