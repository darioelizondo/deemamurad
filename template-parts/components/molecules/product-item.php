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

        <a href="<?php the_permalink( $item_id ); ?>">
            <div class="product-item__product-image">
                <img class="product-item__main-image image--fluid" src="<?php echo esc_url($main_image); ?>" alt="<?php echo esc_attr(get_the_title( $item_id )); ?>">
                <img class="product-item__hover-image image--fluid" src="<?php echo esc_url($second_image); ?>" alt="<?php echo esc_attr(get_the_title( $item_id )); ?>">
                <?php if( is_product() ) : ?>
                    <div class="product-item__wrapper-small-title">
                        <h5 class="product-item__small-title">
                            <?php echo get_the_title( $item_id ); ?>
                        </h5>
                    </div>
                <?php endif; ?>
            </div>
                <?php if( !is_product() ) : ?>
                    <h3><?php echo get_the_title( $item_id ); ?></h3>
                    <span><?php echo wc_price( get_post_meta( $item_id, '_price', true ) ); ?></span>
                    <?php if( isset( $filters_text ) && !empty( $filters_text ) ) : ?>
                        <p class="product-filters"><?php echo esc_html( $filters_text ); ?></p>
                    <?php endif; ?>
                <?php endif; ?>
        </a>

    <?php endif; ?>
</div>
<!-- End product item -->