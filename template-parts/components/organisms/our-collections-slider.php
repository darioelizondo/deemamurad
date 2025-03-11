<?php

    /**
     * Component: Organism: Our collections slider
     * 
     * @package Darío Elizondo
     * 
     */

    $terms = get_terms( array(
        'taxonomy'   => 'collections',
        'orderby' => 'ID',
        'hide_empty' => false
    ));

    wp_enqueue_script( 'swiper' );
    wp_enqueue_script( 'deemamurad.our-collections-slider' );
    // wp_enqueue_script( 'aos' );
    // wp_enqueue_script( 'deemamurad.aos-init' );

?>

<!-- Our collections slider -->
<section class="our-collections-slider module-<?php echo $module_count; ?>" >
    <div class="our-collections-slider__inner <?php if( !is_product() ) echo 'container'; ?>">
        <!-- Swiper -->
        <?php if( $terms ) : ?>
            <div class="our-collections-slider__wrapper-slider">
                <div class="our-collections-slider__content-slider">
                    <!-- Title -->
                    <div class="our-collections-slider__wrapper-title">
                        <h2 class="our-collections-slider__title">
                            Discover our collections
                        </h2>
                    </div>
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

                        <?php foreach( $terms as $nitem => $item ) {
                            include TD . '/template-parts/components/molecules/our-collections-slide.php';
                        } ?>
                        
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- End Out collectons slider -->