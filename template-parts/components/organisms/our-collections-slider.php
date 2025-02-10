<?php

    /**
     * Component: Organism: Our collections slider
     * 
     * @package Darío Elizondo
     * 
     */

    $group = get_sub_field( 'our_collections_slider' );

    wp_enqueue_script( 'swiper' );
    wp_enqueue_script( 'deemamurad.our-collections-slider' );

?>

<!-- Our collections slider -->
<div class="our-collections-slider module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="our-collections-slider__inner container">
        <!-- Title -->
        <?php if( $group[ 'title' ] ) : ?>
            <div class="our-collections-slider__wrapper-title">
                <h2 class="our-collections-slider__title">
                    <?php echo esc_html( $group[ 'title' ] ); ?>
                </h2>
            </div>
        <?php endif; ?>
        <!-- Swiper -->
        <?php if( count( $group[ 'items' ] ) > 0 ) : ?>
            <div class="our-collections-slider__wrapper-slider">
                <button class="our-collections-slider__nav-button our-collections-slider__prev-button">←</button>
                <div class="our-collections-slider__swiper swiper">
                    <div class="our-collections-slider__swiper-wrapper swiper-wrapper">

                        <?php foreach( $group[ 'items' ] as $nitem => $item ) {
                            include TD . '/template-parts/components/molecules/our-collections-slide.php';
                        } ?>
                        
                    </div>
                </div>
                <button class="our-collections-slider__nav-button our-collections-slider__next-button">→</button>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Out collectons slider -->