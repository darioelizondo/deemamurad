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
    wp_enqueue_script( 'aos' );
    wp_enqueue_script( 'deemamurad.aos-init' );

?>

<!-- Our collections slider -->
<div class="our-collections-slider module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="our-collections-slider__inner container" data-aos="fade-up" data-aos-easing="ease-in-out"  data-aos-delay="100">
        <!-- Swiper -->
        <?php if( count( $group[ 'items' ] ) > 0 ) : ?>
            <div class="our-collections-slider__wrapper-slider">
                <div class="our-collections-slider__content-slider">
                    <!-- Title -->
                    <?php if( $group[ 'title' ] ) : ?>
                        <div class="our-collections-slider__wrapper-title">
                            <h2 class="our-collections-slider__title">
                                <?php echo esc_html( $group[ 'title' ] ); ?>
                            </h2>
                        </div>
                    <?php endif; ?>
                    <div class="our-collections-slider__wrapper-buttons">
                        <!-- Prev button -->
                        <button class="our-collections-slider__nav-button our-collections-slider__prev-button">
                            <svg width="36" height="10" viewBox="0 0 36 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5 1L1 5M1 5L5 9M1 5H35" stroke="#3F3F46" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <!-- Next button -->
                        <button class="our-collections-slider__nav-button our-collections-slider__next-button">
                            <svg width="36" height="10" viewBox="0 0 36 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M31 1L35 5M35 5L31 9M35 5H1" stroke="#3F3F46" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="our-collections-slider__swiper swiper">
                    <div class="our-collections-slider__swiper-wrapper swiper-wrapper">

                        <?php foreach( $group[ 'items' ] as $nitem => $item ) {
                            include TD . '/template-parts/components/molecules/our-collections-slide.php';
                        } ?>
                        
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End Out collectons slider -->