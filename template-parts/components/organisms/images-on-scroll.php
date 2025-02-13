<?php

    /**
     * Component: Organism: Images on scroll
     * 
     * @package Darío Elizondo
     * 
     */

    wp_enqueue_script( 'gsap' );
    wp_enqueue_script( 'gsap.scrollTrigger' );
    wp_enqueue_script( 'deemamurad.images-on-scroll' );
    $group= get_sub_field( 'images_on_scroll' );

?>

<!-- Images on scroll -->
<section class="images-on-scroll module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="images-on-scroll__inner">
        <?php
            if( $group[ 'items' ] ) {
                foreach( $group[ 'items' ] as $nitem => $item ) {
        ?>  
                    <!-- Image -->
                    <div class="images-on-scroll__wrapper-image">
                        <img class="images-on-scroll__image image--fluid" src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'image' ][ 'alt' ] ); ?>">
                    </div>
        <?php
                }
            }
        ?>
    </div>
</section>
<!-- End images on scroll -->
