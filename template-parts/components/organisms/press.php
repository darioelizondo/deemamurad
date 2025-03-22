<?php

    /**
     * Component: Organism: Press
     * 
     * @package Darío Elizondo
     * 
     */

    // wp_enqueue_script( 'deemamurad.press' );
    $group= get_sub_field( 'press' );

?>

<style>

    .press__wrapper-items {
        height: <?php echo esc_attr( $group[ 'height_mobile' ] ); ?>px;
    }
    @media only screen and (min-width: 1024px) {
        .press__wrapper-items {
            height: <?php echo esc_attr( $group[ 'height_desktop' ] ); ?>px;
        }
    }

    @media only screen and (min-width: 1600px) {
        .press__wrapper-items {
            height: <?php echo esc_attr( $group[ 'height_desktop_xxl' ] ); ?>px;
        }
    }

</style>

<!-- Press -->
<div class="press module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="press__inner container">
        <!-- Title -->
        <div class="press__wrapper-title">
            <h2 class="press__title">
                <?php echo esc_html( $group[ 'title' ] ); ?>
            </h2>
        </div>
        <!-- Images -->
        <div class="press__wrapper-items">
            <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                <div id="press-image-<?php echo $nitem ?>" class="press__item">
                    <style>
                        #press-image-<?php echo $nitem ?> {
                            top: <?php echo esc_attr( $item[ 'top_mobile' ] ); ?>px;
                            left: <?php echo esc_attr( $item[ 'left_mobile' ] ); ?>px;
                        }
                        @media only screen and (min-width: 1024px) {
                            #press-image-<?php echo $nitem ?> {
                                top: <?php echo esc_attr( $item[ 'top_desktop' ] ); ?>px;
                                left: <?php echo esc_attr( $item[ 'left_desktop' ] ); ?>px;
                            }
                        }
                        @media only screen and (min-width: 1600px) {
                            #press-image-<?php echo $nitem ?> {
                                top: <?php echo esc_attr( $item[ 'top_desktop_xxl' ] ); ?>px;
                                left: <?php echo esc_attr( $item[ 'left_desktop_xxl' ] ); ?>px;
                            }
                        }
                    </style>
                    <div class="press__wrapper-image">
                        <img class="press__main-image image--fluid" src="<?php echo esc_attr( $item[ 'main_image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'main_image' ][ 'alt' ] ); ?>">
                        <img class="press__second-image image--fluid" src="<?php echo esc_attr( $item[ 'second_image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'second_image' ][ 'alt' ] ); ?>">
                    </div>
                    <div class="press__item-wrapper-title">
                        <h5 class="press__item-title">
                            <?php echo esc_html( $item[ 'title' ] ); ?>
                        </h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- End press -->
