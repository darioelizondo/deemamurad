<?php

    /**
     * Component: Molecule: Our collections slide
     * 
     * @package Darío Elizondo
     * 
     */

    $group = get_field( 'collection', $item );

?>

<!-- Our collection slide -->
<div class="our-collections-slide swiper-slide item-<?php echo $nkey; ?>">
    <div class="our-collections-slide__wrapper-content">
        <!-- Image -->
        <?php if( isset( $group[ 'image' ] ) && isset( $group[ 'link' ] ) ) : ?>
            <div class="our-collections-slide__wrapper-image">
                <a class="our-collections-slide__link" href="<?php echo esc_url( $group[ 'link' ][ 'url' ] ); ?>">
                    <img class="our-collections-slide__image image--fluid" src="<?php echo $group[ 'image' ][ 'url' ] ?>" alt="<?php echo $group[ 'image' ][ 'alt' ] ?>">
                </a>
            </div>
        <?php endif; ?>
        <!-- Content -->
        <div class="our-collections-slide__content">
            <!-- Title -->
            <?php if( isset( $group[ 'title' ] ) && $group[ 'title' ] ) : ?>
                <h4 class="our-collections-slide__title">
                    <?php echo $group[ 'title' ]; ?>
                </h4>
            <?php endif; ?>
       </div>
    </div>
</div>
<!-- End our collection slide -->