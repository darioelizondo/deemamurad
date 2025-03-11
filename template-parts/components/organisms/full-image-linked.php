<?php

    /**
     * Component: Organism: Full image linked
     * 
     * @package Darío Elizondo
     * 
     */

    // wp_enqueue_script( 'deemamurad.full-image-linked' );
    $group= get_sub_field( 'full_image_linked' );

?>

<!-- Full image linked -->
<section class="full-image-linked module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <?php if( $group[ 'image_s' ] && $group[ 'link' ] ) : ?>
        <div class="full-image-linked__inner container">
            <!-- Image -->
            <a class="full-image-linked__link" href="<?php echo esc_attr( $group[ 'link' ][ 'url' ] ); ?>">
                <div class="full-image-linked__wrapper-image">
                    <picture class="full-image-linked__picture">
                        <source media="(min-width: 768px)" srcset="<?php echo $group[ 'image_l' ][ 'url' ]; ?>">
                        <img class="full-image-linked__image image--fluid" src="<?php echo $group[ 'image_s' ][ 'url' ]; ?>" alt="<?php echo $group[ 'image_s' ][ 'alt' ]; ?>">
                    </picture>
                </div>
            </a>
            <!-- Content -->
            <div class="full-image-linked__wrapper-content">
                <!-- Title -->
                <?php if( $group[ 'title' ] ) : ?>
                    <div class="full-image-linked__wrapper-title">
                        <h2 class="full-image-linked__title">
                            <?php echo esc_html( $group[ 'title' ] ); ?>
                        </h2>
                    </div>
                <?php endif; ?>
                <!-- Link -->
                <div class="full-image-linked__wrapper-link">
                    <a class="full-image-linked__link-button" href="<?php echo esc_attr( $group[ 'link' ][ 'url' ] ); ?>">
                        <?php echo esc_html( $group[ 'link' ][ 'title' ] ); ?>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
<!-- End full image linked -->