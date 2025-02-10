<?php

    /**
     * Component: Molecule: Our collections slide
     * 
     * @package Darío Elizondo
     * 
     */

?>

<!-- Our collection slide -->
<div class="our-collections-slide swiper-slide item-<?php echo $nkey; ?>">
    <div class="our-collections-slide__wrapper-content">
        <!-- Image -->
        <?php if( isset( $item[ 'image' ] ) && isset( $item[ 'link' ] ) ) : ?>
            <div class="our-collections-slide__wrapper-image">
                <a class="our-collections-slide__link" href="<?php echo esc_url( $item[ 'link' ][ 'url' ] ); ?>">
                    <img class="our-collections-slide__image image--fluid" src="<?php echo $item[ 'image' ][ 'url' ] ?>" alt="<?php echo $item[ 'image' ][ 'alt' ] ?>">
                </a>
            </div>
        <?php endif; ?>
        <!-- Content -->
        <div class="our-collections-slide__content">
            <!-- Title -->
            <?php if( isset( $item[ 'title' ] ) && $item[ 'title' ] ) : ?>
                <h4 class="our-collections-slide__title">
                    <?php echo $item[ 'title' ]; ?>
                </h4>
            <?php endif; ?>
       </div>
    </div>
</div>
<!-- End our collection slide -->