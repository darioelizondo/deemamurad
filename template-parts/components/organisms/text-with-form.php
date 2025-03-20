<?php

    /**
     * Component: Organism: Text with form
     * 
     * @package Darío Elizondo
     * 
     */

    // wp_enqueue_script( 'deemamurad.category-with-image' );
    $group= get_sub_field( 'text_with_form' );

?>

<!-- Text with form -->
 <section class="text-with-form module-<?php echo $module_count; ?>" style="padding-top: <?php echo $group[ 'padding_top' ]; ?>; padding-bottom: <?php echo $group[ 'padding_bottom' ]; ?>;">
    <div class="text-with-form__inner container">
        <!-- Content -->
        <div class="text-with-form__wrapper-content">
            <!-- Title -->
            <div class="text-with-form__wrapper-title">
                <h2 class="text-with-form__title">
                    <?php echo esc_html( $group[ 'title' ] ); ?>
                </h2>
            </div>
            <!-- Text -->
            <div class="text-with-form__wrapper-text">
                <?php echo $group[ 'text' ]; ?>
            </div>
        </div>
        <!-- Form -->
        <div class="text-with-form__wrapper-form">
            <?php echo do_shortcode( $group[ 'form' ] ); ?>
        </div>
    </div>
 </section>
<!-- End text with form -->
