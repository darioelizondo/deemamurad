<?php

    /**
     * Function: Ajax filter products
     * 
     * @package Darío Elizondo
     * 
     */

add_action( 'wp_ajax_filter_products', 'filter_products_ajax' );
add_action( 'wp_ajax_nopriv_filter_products', 'filter_products_ajax' );

function filter_products_ajax() {
    $args = [
        'post_type' => 'product',
        'posts_per_page' => 12,
        'tax_query' => ['relation' => 'AND'],
    ];

    if (!empty($_POST['filters']['category'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => array_map('sanitize_text_field', $_POST['filters']['category']),
            'operator' => 'IN',
        ];
    }

    if (!empty($_POST['filters']['collections'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'collections',
            'field' => 'slug',
            'terms' => array_map('sanitize_text_field', $_POST['filters']['collections']),
            'operator' => 'IN',
        ];
    }

    if (!empty($_POST['filters']['colours'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'filters',
            'field' => 'slug',
            'terms' => array_map('sanitize_text_field', $_POST['filters']['colours']),
            'operator' => 'IN',
        ];
    }

    $query = new WP_Query($args);

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $item_id = get_the_ID();
            // Get the main product image
            $main_image = get_the_post_thumbnail_url( $item_id, 'large' );

            // Get the first image from the product gallery
            $gallery_images = get_post_meta($item_id, '_product_image_gallery', true);
            $gallery_images = explode(',', $gallery_images);
            $second_image = !empty( $gallery_images[0] ) ? wp_get_attachment_url( $gallery_images[0] ) : $main_image;

            include TD . '/template-parts/components/molecules/product-item.php';
            
            unset( $item_id );
            unset( $main_image );
            unset( $second_image );
        }
        wp_reset_postdata();
    } else {
        echo '<p>No products found.</p>';
    }

    wp_die();
}
