<?php

    /**
     * Component: Organism: Related products
     * 
     * @package Darío Elizondo
     * 
     */

    // Obtener la colección del producto actual
    $product_id = get_the_ID();
    $collections = wp_get_post_terms( $product_id, 'collections', array( 'fields' => 'ids' ) );

    if ( !empty( $collections ) ) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4, // Número de productos a mostrar
            'post__not_in'   => array( $product_id ), // Excluir el producto actual
            'tax_query'      => array(
                array(
                    'taxonomy' => 'collections',
                    'field'    => 'id',
                    'terms'    => $collections,
                ),
            ),
        );

        $related_products = get_posts( $args );

        wp_enqueue_script( 'swiper' );
        wp_enqueue_script( 'deemamurad.related-products' );

        if ( !empty( $related_products ) ): ?>
            <!-- Related products -->
            <div class="related-products">
                <h4 class="related-products__title">You may also like</h4>
                <div class="related-products__inner">
                    <div class="related-products__swiper swiper swiper-container">
                        <div class="related-products__swiper-wrapper swiper-wrapper">
                            <?php foreach ( $related_products as $item_id ): 
                                setup_postdata( $item_id );

                                // Get the main product image
                                $main_image = get_the_post_thumbnail_url( $item_id->ID, 'large' );

                                // Get the first image from the product gallery
                                $gallery_images = get_post_meta( $item_id->ID, '_product_image_gallery', true );
                                $gallery_images = explode(',', $gallery_images);
                                $second_image = !empty( $gallery_images[0] ) ? wp_get_attachment_url( $gallery_images[0] ) : $main_image;

                                // Get the terms of the "filters" taxonomy
                                $filters_terms = get_the_terms( $item_id->ID, 'filters' );
                                $filters_text = !empty( $filters_terms ) ? implode(', ', wp_list_pluck( $filters_terms, 'name' ) ) : 'Without filters';
                                ?>
                                
                                <?php include TD . '/template-parts/components/molecules/product-item.php'; ?>

                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;
    } ?>
    <!-- End related products -->