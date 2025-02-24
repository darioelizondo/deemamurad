<?php

    /**
     * Component: Molecule: Size guide
     * 
     * @package Darío Elizondo
     * 
     */

     wp_enqueue_script( 'deemamurad.size-guide-modal' );

?>

<!-- Size guide modal -->
<div id="sizeGuideModal" class="size-guide-modal">
    <div class="size-guide-modal__inner">
        <!-- Close -->
        <div id="sizeGuideClose" class="size-guide-modal__wrapper-close">
            <a class="size-guide-modal__close" href="#">
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L18 18M1 18L18 1L1 18Z" stroke="#3F3F46" stroke-width="0.971429" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </a>
        </div>
        <!-- Title -->
        <div class="size-guide-modal__wrapper-title">
            <h3 class="size-guide-modal__title">
                <?php echo esc_html( $size_guide[ 'title' ] ); ?>
            </h3>
        </div>
        <!-- Content -->
        <div class="size-guide-modal__wrapper-content">
            <?php echo $size_guide[ 'content' ]; ?>
        </div>
        <!-- Image -->
        <div class="size-guide-modal__wrapper-image">
            <img class="size-guide-modal__image image--fluid" src="<?php echo esc_attr( $size_guide[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $size_guide[ 'image' ][ 'alt' ] ); ?>" >
        </div>
        <!-- Table image -->
        <div class="size-guide-modal__wrapper-table-image">
            <img class="size-guide-modal__image image--fluid" src="<?php echo esc_attr( $size_guide[ 'table_image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $size_guide[ 'table_image' ][ 'alt' ] ); ?>" >
        </div>
        <!-- Caption -->
        <div class="size-guide-modal__wrapper-caption">
            <p class="size-guide-modal__caption">
                <?php echo esc_html( $size_guide[ 'caption' ] ); ?>
            </p>
        </div>
    </div>
</div>	
<!-- End size guide modal -->