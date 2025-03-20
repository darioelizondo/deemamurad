<?php

    /**
     * Component: Organism: Two images section
     * 
     * @package Darío Elizondo
     * 
     */

    wp_enqueue_script( 'swiper' );
    wp_enqueue_script( 'deemamurad.two-images-section' );
    $group= get_sub_field( 'two_images_section' );

?>

<!-- Two images section -->
 <section class="two-images-section module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="two-images-section__inner container">
        <!-- Swiper -->
        <div class="two-images-section__swiper swiper swiper-container">
            <div class="two-images-section__swiper-wrapper swiper-wrapper">
                <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                    <!-- Swiper slide -->
                    <div class="two-images-section__swiper-slide swiper-slide">
                        <div class="two-images-section__wrapper-image">
                            <img class="two-images-section__image image--fluid" src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'image' ][ 'alt' ] ); ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
 </section>
<!-- End two images section -->