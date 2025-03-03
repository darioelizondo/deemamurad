<?php

    /**
     * Component: Organism: Related products
     * 
     * @package Darío Elizondo
     * 
     */

    $related_products = wc_get_related_products( get_the_ID(), 4 );
    wp_enqueue_script( 'swiper' );
    wp_enqueue_script( 'deemamurad.related-products' );

    if ( !empty( $related_products ) ): ?>
        <!-- Related products -->
        <div class="related-products">
            <h4 class="related-products__title">You may also like</h4>
            <div class="related-products__inner">
                <div class="related-products__swiper swiper swiper-container">
                    <div class="related-products__swiper-wrapper swiper-wrapper">
                        <?php foreach ( $related_products as $nitem => $item_id ): 
                            $post_object = get_post( $item_id );
                            setup_postdata( $post_object );

                            // Get the main product image
                            $main_image = get_the_post_thumbnail_url( $item_id, 'large' );

                            // Get the first image from the product gallery
                            $gallery_images = get_post_meta($item_id, '_product_image_gallery', true);
                            $gallery_images = explode(',', $gallery_images);
                            $second_image = !empty( $gallery_images[0] ) ? wp_get_attachment_url( $gallery_images[0] ) : $main_image;

                            // Get the terms of the "filters" taxonomy
                            $filters_terms = get_the_terms( $item_id, 'filters' );
                            $filters_text = !empty( $filters_terms ) ? implode(', ', wp_list_pluck( $filters_terms, 'name' ) ) : 'Without filters';
                            ?>
                            
                            <?php include TD . '/template-parts/components/molecules/product-item.php'; ?>

                            <?php
                                unset( $item_id );
                                unset( $main_image );
                                unset( $second_image );
                            ?>

                        <?php endforeach; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- End related products -->