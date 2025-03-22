<?php

    /**
     * Modules
     * 
     * @package Darío Elizondo
     * 
     */

    $module_count = 1;

    if ( have_rows( 'modules' ) ) : while ( have_rows( 'modules' ) ) : the_row( 'modules' );
     
        if ( get_row_layout() === 'hero' )                      require TD . '/template-parts/components/organisms/hero.php';
        if ( get_row_layout() === 'our_collections_slider' )    require TD . '/template-parts/components/organisms/our-collections-slider.php';
        if ( get_row_layout() === 'full_image_linked' )         require TD . '/template-parts/components/organisms/full-image-linked.php';
        if ( get_row_layout() === 'images_on_scroll' )          require TD . '/template-parts/components/organisms/images-on-scroll.php';
        if ( get_row_layout() === 'category_with_image' )       require TD . '/template-parts/components/organisms/category-with-image.php';
        if ( get_row_layout() === 'two_images_section' )        require TD . '/template-parts/components/organisms/two-images-section.php';
        if ( get_row_layout() === 'text_with_form' )            require TD . '/template-parts/components/organisms/text-with-form.php';
        if ( get_row_layout() === 'about_deema' )               require TD . '/template-parts/components/organisms/about-deema.php';
        if ( get_row_layout() === 'contact' )                   require TD . '/template-parts/components/organisms/contact.php';
        if ( get_row_layout() === 'faq' )                       require TD . '/template-parts/components/organisms/faq.php';
        if ( get_row_layout() === 'events' )                    require TD . '/template-parts/components/organisms/events.php';
        if ( get_row_layout() === 'press' )                     require TD . '/template-parts/components/organisms/press.php';
     
        $module_count++;
     
     endwhile;
     endif;

