<?php

    /**
     * Function: Single Product
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Remove breadcrumbs
     */
    add_action( 'init', function() {
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
    });

    /** 
     * Move description under the title
     */
    add_action( 'init', function() {
        // Remove description
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
        // Add description under title and price
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 15);
    });

    /** 
     * Wrap title and price
     */
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
    remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);

    add_action('woocommerce_single_product_summary', function() {
        echo '<div class="woocommerce-single__wrapper-title-and-price">';
            woocommerce_template_single_title();
            woocommerce_template_single_price();
        echo '</div>';
    }, 5);

    /** 
     * Remove woocommerce tabs
     */
    add_filter('woocommerce_product_tabs', function($tabs) {
        unset($tabs['description']); // Remueve la pestaña "Descripción"
        unset($tabs['additional_information']); // Remueve la pestaña "Información adicional"
        unset($tabs['reviews']); // Remueve la pestaña "Reseñas"
        return $tabs;
    }, 98 );

     /** 
     * Remove sidebar
     */
    add_action( 'wp', function() {
        if ( is_product() ) {
            remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
        }
    });

    /** 
     * Add custom field (features) below description
     */
    add_action( 'woocommerce_single_product_summary', function() {

        global $post;
        $product_features = get_field( 'single_product', $post->ID );
    
        if ( $product_features ) {
            echo '<div class="woocommerce-single__wrapper-features">';

            foreach( $product_features[ 'features' ] as $nfeature => $feature ) {
                echo '<div class="woocommerce-single__feature feature-' . $nfeature . '">';
                echo    '<span class="woocommerce-single__feature-title">' . $feature[ 'title' ] . '</span>';
                echo    '<span class="woocommerce-single__feature-description">' . $feature[ 'description' ] . '</span>';
                echo '</div>';
            }

            echo '</div>';
        }
    }, 25 ); 
    
    /** 
     * Remove SKU, categories and tags
     */
    remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
    
    /** 
     * Change design of attributes
     */
    add_action( 'wp_enqueue_scripts', function() {
        wp_add_inline_style( 'woocommerce-layout', '
            .variations {
                display: flex !important;
                flex-direction: column !important;
                gap: 15px !important;
            }
            .variations tr {
                display: flex !important;
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 5px;
            }
            .variations td {
                display: flex !important;
                flex-direction: column !important;
            }
        ' );
    });

     add_action('woocommerce_before_variations_form', function() {
        ?>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.querySelectorAll('.variations select').forEach(select => {
                        let options = select.querySelectorAll("option:not([value=''])"); // Exclude empty option
                        if (options.length === 0) return; // If there are no options, leave

                        let wrapper = document.createElement("div");
                        wrapper.classList.add("woocommerce-single__custom-variation-buttons");

                        options.forEach((option, index) => {
                            let button = document.createElement("button");
                            button.innerText = option.innerText;
                            button.setAttribute("data-value", option.value);
                            button.classList.add("woocommerce-single__variation-button");

                            // If it is the first option, mark it as active and select its value
                            if (index === 0) {
                                button.classList.add("active");
                                select.value = option.value;
                                select.dispatchEvent(new Event("change"));
                            }

                            button.addEventListener("click", function(e) {
                                e.preventDefault();
                                
                                // Remove the active class from the other buttons
                                wrapper.querySelectorAll(".woocommerce-single__variation-button").forEach(btn => btn.classList.remove("active"));
                                
                                // Activa el botón seleccionado
                                button.classList.add("active");

                                // Activate the selected button
                                select.value = option.value;
                                select.dispatchEvent(new Event("change"));
                            });

                            wrapper.appendChild(button);
                        });

                        select.style.display = "none"; // Hide select
                        select.parentNode.appendChild(wrapper);
                    });
                });
            </script>
        <?php
    });

    /** 
     * Add Size guide, in the end of summary
     */
    add_action( 'woocommerce_single_product_summary', function() {
        global $product;
        
        if ( !$product ) return;
    
        $acf_value = get_field( 'size_guide', 'option' );
        
        if ( $acf_value ) {
            echo '<div id="wrapper_SizeGuideButton" class="woocommerce-single__wrapper-attribute-button"><button type="button" id="sizeGuideOpen">'. $acf_value[ 'button' ][ 'title' ] . '</button></div>';
        }
    
    }, 25); 

    /** 
     * Move Size guide to Size attribute
     */
    add_action('wp_footer', function() {

        if (!is_product()) return;
    ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                const sizeGuideButton = document.getElementById('wrapper_SizeGuideButton');
                const sizeLabel = document.querySelector('label[for="pa_size"]');

                // Move the info right after the label
                if( sizeLabel && sizeGuideButton ) {
                    sizeLabel.after( sizeGuideButton );
                }
    
            });
        </script>
    <?php

    });

    /** 
     * Product images: Add swiper and zoom feature
     */
    remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
    remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);

    add_action( 'woocommerce_before_single_product_summary', function () {

        global $product;

        if ( !$product ) return;

        wp_enqueue_script( 'swiper' );

        $gallery_images = [];
        $main_image_id = $product->get_image_id();
        
        if ( $main_image_id ) {
            $gallery_images[] = wp_get_attachment_image_url( $main_image_id, 'full' );
        }

        $attachment_ids = $product->get_gallery_image_ids();
        foreach ($attachment_ids as $attachment_id) {
            $gallery_images[] = wp_get_attachment_image_url( $attachment_id, 'full' );
        }

        if ( empty( $gallery_images ) ) return;

        ?>
        <div class="woocommerce-single__custom-product-gallery">
            <div class="woocommerce-single__swiper swiper swiper-container">
                <div class="woocommerce-single__swiper-wrapper swiper-wrapper">
                    <?php foreach ($gallery_images as $image_url) : ?>
                        <div class="woocommerce-single__swiper-slide swiper-slide">
                            <div class="woocommerce-single__swiper-zoom-container swiper-zoom-container">
                                <img class="image--fluid" src="<?php echo esc_url($image_url); ?>" alt="Product Image">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="woocommerce-single__swiper-pagination swiper-pagination"></div>
            </div>
        </div>
        <?php

    }, 25);

    add_action( 'wp_footer', function () {

        if ( !is_product() ) return;
        wp_enqueue_script( 'zoom' ); // Zoom library
        ?>
        <script>
            document.addEventListener( "DOMContentLoaded", function () {
                const swiperSingleProduct = document.querySelector( '.woocommerce-single__swiper' );
                const slides = document.querySelectorAll('.woocommerce-single__swiper-slide');

                if( swiperSingleProduct !== undefined ) {
                    swiperGallery = new Swiper( ".woocommerce-single__swiper", {
                        loop: true,
                        pagination: {
                            el: ".woocommerce-single__swiper-pagination",
                            type: "progressbar",
                        },
                        zoom: {
                            panOnMouseMove: true,
                        },
                        slidesPerView: 1,
                        breakpoints: {
                            '1024': {
                                enabled: false, // Disable Swiper on desktop
                            },
                        }
                    });
                }

                slides.forEach( ( slide, index ) => {    
                    slide.addEventListener( 'mouseenter', () => {
                        if ( window.innerWidth >= 1024 ) { // Use Zoom library on desktop
                            
                            const imageContainer = slide.querySelector( '.swiper-zoom-container' );

                            jQuery( imageContainer ).zoom({
                                url: imageContainer.querySelector( 'img' ).src,
                                touch: false,
                            });
                        }
                    }); 
                });
               
            });
        </script>
        <?php
    });

    /**
     * Quantity input
     */

    // Add increment and decrement buttons
    add_action( 'wp_footer', 'custom_quantity_fields_script');

    function custom_quantity_fields_script() {
        if (!is_product() && !is_cart()) return;
        ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.quantity').each(function() {
                    var $this = $(this),
                        $input = $this.find('input[type="number"]'),
                        $dec = $this.find('.minus'),
                        $inc = $this.find('.plus');

                    $dec.on('click', function() {
                        var value = parseInt($input.val()) - 1;
                        value = value < 1 ? 1 : value;
                        $input.val(value);
                        $input.change();
                    });

                    $inc.on('click', function() {
                        var value = parseInt($input.val()) + 1;
                        $input.val(value);
                        $input.change();
                    });
                });
            });
        </script>
        <?php
    }

    