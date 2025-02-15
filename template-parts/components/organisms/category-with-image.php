<?php

    /**
     * Component: Organism: Category with image
     * 
     * @package Darío Elizondo
     * 
     */

    wp_enqueue_script( 'deemamurad.category-with-image' );
    $group= get_sub_field( 'category_with_image' );

?>

<!-- Category with image -->
<div class="category-with-image module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="category-with-image__inner container">
        <?php if( $group[ 'items' ] ) : ?>
            <!-- List -->
            <ul class="category-with-image__wrapper-list">
                <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                    <p data-id="<?php echo $nitem; ?>" class="category-with-image__link">
                        <?php echo esc_attr( $item[ 'link' ][ 'title' ] ); ?>
                    </p>
                    <!-- <a data-id="<?php // echo $nitem; ?>" class="category-with-image__link" href="<?php // echo esc_attr( $item[ 'link' ][ 'url' ] ); ?>">
                        <?php // echo esc_attr( $item[ 'link' ][ 'title' ] ); ?>
                    </a> -->
                <?php endforeach; ?>
            </ul>
            <!-- Images -->
            <div class="category-with-image__wrapper-images">
                <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                    <img id="categoryWithImageLink-image-<?php echo $nitem; ?>" class="category-with-image__image image--fluid" src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'image' ][ 'alt' ] ); ?>">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<!-- End category with image -->