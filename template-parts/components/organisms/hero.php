<?php

    /**
     * Component: Organism: Hero
     * 
     * @package Darío Elizondo
     * 
     */

    $group = get_sub_field( 'hero' );

    wp_enqueue_script( 'animejs' );
    wp_enqueue_script( 'deemamurad.hero' );

?>

<!-- Hero -->
<section class="hero module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="hero__inner">
        <!-- Hero left -->
        <div class="hero__left">
            <!-- Hero image left -->
            <div class="hero__wrapper-image">
                <?php if( $group[ 'left_image_l' ] ) : ?>
                    <picture class="hero__picture">
                        <source media="(min-width: 768px)" srcset="<?php echo $group[ 'left_image_l' ][ 'url' ]; ?>">
                        <img class="hero__image" src="<?php echo $group[ 'left_image_s' ][ 'url' ]; ?>" alt="<?php echo $group[ 'left_image_s' ][ 'alt' ]; ?>">
                    </picture>
                <?php endif; ?>
            </div>
        </div>
        <!-- Hero right -->
        <div class="hero__right">
            <!-- Hero image right -->
            <div class="hero__wrapper-image">
                <?php if( $group[ 'right_image_s' ] && $group[ 'right_image_l' ] ) : ?>
                    <picture class="hero__picture">
                        <source media="(min-width: 768px)" srcset="<?php echo $group[ 'right_image_l' ][ 'url' ]; ?>">
                        <img class="hero__image" src="<?php echo $group[ 'right_image_s' ][ 'url' ]; ?>" alt="<?php echo $group[ 'right_image_s' ][ 'alt' ]; ?>">
                    </picture>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
        // Scroll indicator
        if( $group[ 'scroll' ] === true ) {
            include TD . '/template-parts/components/atoms/scroll-indicator.php';
        }
    ?>

</section>
<!-- End hero -->