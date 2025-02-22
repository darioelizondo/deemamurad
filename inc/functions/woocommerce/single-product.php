<?php

    /**
     * Function: Single Product
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Remove breadcrumbs
     */
    add_action( 'init', function() {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    });

    /** 
     * Move description under the title
     */
    add_action( 'init', function() {
        // Remove description
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        // Add description under title and price
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 15);
    });

    /** 
     * Remove woocommerce tabs
     */
    add_filter('woocommerce_product_tabs', function($tabs) {
        unset($tabs['description']); // Remueve la pestaña "Descripción"
        unset($tabs['additional_information']); // Remueve la pestaña "Información adicional"
        unset($tabs['reviews']); // Remueve la pestaña "Reseñas"
        return $tabs;
    }, 98 );

     /** 
     * Remove sidebar
     */
    add_action( 'wp', function() {
        if ( is_product() ) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        }
    });

    /** 
     * Add custom field (features) below description
     */
    add_action( 'woocommerce_single_product_summary', function() {

        global $post;
        $product_features = get_field( 'single_product', $post->ID );
    
        if ( $product_features ) {
            echo '<div class="woocommerce-single__wrapper-features">';

            foreach( $product_features[ 'features' ] as $nfeature => $feature ) {
                echo '<div class="woocommerce-single__feature feature-' . $nfeature . '">';
                echo    '<span class="woocommerce-single__feature-title">' . $feature[ 'title' ] . '</span>';
                echo    '<span class="woocommerce-single__feature-description">' . $feature[ 'description' ] . '</span>';
                echo '</div>';
            }

            echo '</div>';
        }
    }, 25 ); 
    