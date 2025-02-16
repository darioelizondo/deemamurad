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
<section class="category-with-image module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="category-with-image__inner container">
        <?php if( $group[ 'items' ] ) : ?>
            <!-- List -->
            <ul class="category-with-image__wrapper-list">
                <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                    <p data-id="<?php echo $nitem; ?>" class="category-with-image__text">
                        <?php echo esc_attr( $item[ 'link' ][ 'title' ] ); ?>
                    </p>
                <?php endforeach; ?>
            </ul>
            <!-- Images -->
            <div class="category-with-image__wrapper-images">
                <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                    <a id="categoryWithImageLink-image-<?php echo $nitem; ?>" class="category-with-image__image-link" href="<?php echo esc_attr( $item[ 'link' ][ 'url' ] ); ?>">
                        <img class="category-with-image__image image--fluid" src="<?php echo esc_attr( $item[ 'image' ][ 'url' ] ); ?>" alt="<?php echo esc_attr( $item[ 'image' ][ 'alt' ] ); ?>">                    
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- End category with image -->