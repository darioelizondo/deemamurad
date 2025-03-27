<?php

    /**
     * Component: Organism: Contact
     * 
     * @package Darío Elizondo
     * 
     */
    $group= get_sub_field( 'contact' );

?>

<!-- Contact -->
<div class="contact module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="contact__inner container">
        <!-- Title -->
        <div class="contact__wrapper-title">
            <h2 class="contact__title">
                <?php echo esc_html( $group[ 'title' ] ); ?>
            </h2>
            <!-- Text -->
            <div class="contact__wrapper-text">
                <?php echo $group[ 'text' ]; ?>
            </div>
        </div>
        <!-- Content -->
        <div class="contact__wrapper-content">
            <!-- Image -->
             <div class="contact__wrapper-image">
                <picture class="contact_picture">
                    <source srcset="<?php echo esc_attr( $group[ 'image_l' ]['url'] ); ?>" media="(min-width: 768px)" >
                    <img class="contact__image image--fluid" src="<?php echo esc_attr( $group[ 'image_s' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $group[ 'image_s' ][ 'alt' ] ); ?>">
                </picture>
             </div>
        </div>
        <!-- Form -->
        <div class="contact__wrapper-form">
                <?php echo do_shortcode( $group[ 'form' ] ); ?>
        </div>
    </div>
</div>
<!-- End contact -->