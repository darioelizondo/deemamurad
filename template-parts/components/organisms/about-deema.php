<?php

    /**
     * Component: Organism: About Deema
     * 
     * @package Darío Elizondo
     * 
     */

    wp_enqueue_script( 'swiper' );
    wp_enqueue_script( 'deemamurad.about-deema' );
    $group= get_sub_field( 'about_deema' );

?>

<!-- About Deema -->
 <section class="about-deema module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="about-deema__inner container">
        <!-- Title -->
         <div class="about-deema__wrapper-title">
            <h2 class="about-deema__title">
                <?php echo esc_html( $group[ 'title' ] ); ?>
            </h2>
         </div>
        <!-- Content -->
        <div class="about-deema__wrapper-content">
            <!-- Text -->
            <div class="about-deema__wrapper-text">
                <?php echo $group[ 'text' ]; ?>
            </div>
            <!-- Swiper -->
            <div class="about-deema__swiper swiper swiper-container">
                <div class="about-deema__swiper-wrapper swiper-wrapper">

                    <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                        <!-- Slides -->
                        <div class="about-deema__swiper-slide swiper-slide">
                            <div class="about-deema__wrapper-image">
                                <img class="about-deema__image image--fluid" src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'image' ][ 'alt' ] ); ?>">
                            </div>
                        </div>  
                    <?php endforeach; ?>

                </div>
            </div>
        </div>
        <!-- Image -->
        <div class="about-deema__wrapper-main-image">
            <img class="about-deema__main-image image--fluid" src="<?php echo esc_attr( $group[ 'main_image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $group[ 'main_image' ][ 'alt' ] ); ?>">
        </div>
    </div>
 </section>
<!-- End about Deema -->