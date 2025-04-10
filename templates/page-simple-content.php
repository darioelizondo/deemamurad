<?php

    /**
     * Template Name: Simple content
     *
     * @package Darío Elizondo
     */
    $group = get_field( 'simple_content' ); 

    get_header();
    
    if( have_posts() ) : while( have_posts() ) : the_post();

    ?>

        <div class="simple-content">
            <div class="simple-content__inner container">
                <!-- Title -->
                <div class="simple-content__wrapper-title">
                    <h1 class="simple-content__title">
                        <?php echo esc_html( $group[ 'title' ] ); ?>
                    </h1>
                </div>
                <!-- End title -->
                <!-- Content -->
                <div class="simple-content__wrapper-content">
                    <?php echo $group[ 'content' ]; ?>
                </div>
                <!-- End content -->
            </div>
        </div>

    <?php

    endwhile;
    endif;

    get_footer();
