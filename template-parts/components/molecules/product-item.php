<?php

    /**
     * Component: Molecule: Product item
     * 
     * @package Darío Elizondo
     * 
     */

     wp_enqueue_script( 'deemamurad.menu' );

?>

<!-- Product item -->
<div class="product-item swiper-slide <?php if( $nitem ) echo 'item-' . $nitem; ?>">
    <?php if( isset( $item_id ) && !empty( $item_id ) ) : ?>   
    <?php $product = wc_get_product($item_id);  ?>

        <a href="<?php the_permalink( $item_id ); ?>">
            <div class="product-item__product-image">
                <img class="product-item__main-image image--fluid" src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr(get_the_title( $item_id )); ?>">
                <img class="product-item__hover-image image--fluid" src="<?php echo esc_url($second_image); ?>" alt="<?php echo esc_attr(get_the_title( $item_id )); ?>">
                <?php // if( is_product() ) : ?>
                    <!-- <div class="product-item__wrapper-small-title">
                        <h5 class="product-item__small-title">
                            <?php // echo get_the_title( $item_id ); ?>
                        </h5>
                    </div> -->
                <?php // endif; ?>
            </div>
            <h3 class="product-item__title"><?php echo get_the_title( $item_id ); ?></h3>
                <?php  if( !is_product() ) : ?>
                    <?php if( isset( $filters_text ) && !empty( $filters_text ) ) : ?>
                        <p class="product-filters">
                            <?php
                                 if( isset( $filters_text_qty ) && !empty( $filters_text_qty ) ) {
                                    echo esc_html( $filters_text . $filters_text_qty );
                                } else {
                                    echo esc_html( $filters_text );
                                }
                            ?>
                        </p>
                    <?php endif; ?>
                    <span><?php echo wc_price(wc_get_price_to_display($product)); ?></span>
                <?php endif; ?>
        </a>

    <?php endif; ?>
</div>
<!-- End product item -->