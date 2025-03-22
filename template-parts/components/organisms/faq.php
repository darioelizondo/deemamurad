<?php

    /**
     * Component: Organism: FAQ
     * 
     * @package Darío Elizondo
     * 
     */

    wp_enqueue_script( 'deemamurad.faq' );
    $group= get_sub_field( 'faq' );

?>

<!-- FAQ -->
<div class="faq module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="faq__inner container">
        <!-- Title -->
        <div class="faq__wrapper-title">
            <h2 class="faq__title">
                <?php echo esc_html( $group[ 'title' ] ); ?>
            </h2>
        </div>
        <!-- Accordion -->
        <div class="faq__wrapper-accordion">
            <?php foreach( $group[ 'items' ] as $nitem => $item ) : ?>
                <div class="faq__accordion-item">
                    <div id="faq-accordion-<?php echo $nitem ?>" class="faq__accordion-title">
                        <span class="faq__accordion-span-title">
                            <?php echo esc_html( $item[ 'title' ] ); ?>
                        </span>
                        <div class="faq__accordion-title-right">
                            <span class="faq__plus-minus-toggle collapsed"></span>
                        </div>
                    </div>
                    <div class="faq__accordion-content">
                        <?php echo $item[ 'content' ]; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!-- End FAQ -->