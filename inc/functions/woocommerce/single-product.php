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
                    let options = select.querySelectorAll("option:not([value=''])"); // Excluye la opción vacía
                    if (options.length === 0) return; // Si no hay opciones, salir
    
                    let wrapper = document.createElement("div");
                    wrapper.classList.add("woocommerce-single__custom-variation-buttons");
    
                    // Obtener parámetros de la URL
                    const urlParams = new URLSearchParams(window.location.search);
                    const attributeName = select.getAttribute("name"); // Ej: "attribute_pa_colour"
                    const selectedAttribute = urlParams.get(attributeName); // Ej: "yellow-gold" o null si no está en la URL

                    // Obtener data del localStorage si existiese
                    const productId = document.querySelector('input[name="product_id"]').value;
                    const storageKey = `product_variation_${productId}`;
                    
                    // 🔹 Recuperar la selección previa desde localStorage
                    let savedVariations = JSON.parse(localStorage.getItem(storageKey)) || {};
                    let localStorageSelectedAttribute = savedVariations[attributeName] || null;
    
                    let selectedOption = null;
    
                    options.forEach((option, index) => {
                        let button = document.createElement("button");
                        button.innerText = option.innerText;
                        button.setAttribute("data-value", option.value);
                        button.classList.add("woocommerce-single__variation-button");
    
                        // Si el valor en la URL coincide con la opción, seleccionarlo
                        if (option.value === selectedAttribute) {
                                // 🔹 Si hay un valor en la URL, eliminar el guardado previo en localStorage
                                if (savedVariations[attributeName]) {
                                    delete savedVariations[attributeName];
                                    localStorage.setItem(storageKey, JSON.stringify(savedVariations));
                                }

                            button.classList.add("active");
                            select.value = option.value;
                            selectedOption = option.value;
                        }

                        if( selectedAttribute == null && option.value === localStorageSelectedAttribute ) {
                            button.classList.add("active");
                            select.value = option.value;
                            selectedOption = option.value;
                        }
    
                        button.addEventListener("click", function(e) {
                            e.preventDefault();
    
                            // Eliminar la clase "active" de todos los botones de este grupo
                            wrapper.querySelectorAll(".woocommerce-single__variation-button").forEach(btn => btn.classList.remove("active"));
    
                            // Activar el botón seleccionado
                            button.classList.add("active");
    
                            // Actualizar el valor en el select y disparar el evento de cambio
                            select.value = option.value;
                            select.dispatchEvent(new Event("change"));
    
                            // Dispara el evento de WooCommerce para que actualice variation_id
                            jQuery('select[name^="attribute_"]').trigger('change');
                        });
    
                        wrapper.appendChild(button);
                        
                    });
    
                    // Si no había atributo en la URL, seleccionar la primera opción por defecto
                    if (!selectedOption) {
                        options[0].selected = true;
                        select.value = options[0].value;
                        options[0].parentNode.dispatchEvent(new Event("change"));
                        wrapper.querySelectorAll(".woocommerce-single__variation-button")[0].classList.add("active");
                    }
    
                    select.style.display = "none"; // Ocultar select
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

                if( !sizeLabel ) {
                    sizeGuideButton.style.display = 'none';
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

    add_action('woocommerce_save_product_variation', 'save_variation_gallery_images_acf_repeater', 10, 2);

    function save_variation_gallery_images_acf_repeater($variation_id, $i) {
        $product_id = wp_get_post_parent_id($variation_id);
        $variation_galleries = get_field('variation_galleries', $product_id);

        if ($variation_galleries) {
            foreach ($variation_galleries as $gallery) {
                if ((int) $gallery['variation_id'] === (int) $variation_id) {
                    update_post_meta($variation_id, '_variation_gallery', $gallery['gallery']);
                    return;
                }
            }
        }
    }

    add_action('woocommerce_before_single_product_summary', function () {
        global $product;
    
        if (!$product) return;
    
        wp_enqueue_script('swiper');
    
        $gallery_images = [];
        $main_image_id = $product->get_image_id();
    
        if ($main_image_id) {
            $gallery_images[] = wp_get_attachment_image_url($main_image_id, 'full');
        }
    
        $attachment_ids = $product->get_gallery_image_ids();
        foreach ($attachment_ids as $attachment_id) {
            $gallery_images[] = wp_get_attachment_image_url($attachment_id, 'full');
        }
    
        if (empty($gallery_images)) return;
    
        // Generar galería por variación
        $variationGalleryData = [];
        if ($product->is_type('variable')) {
            $available_variations = $product->get_available_variations();
            foreach ($available_variations as $variation) {
                $variation_id = $variation['variation_id'];
                $variation_images = [];
    
                // Galería personalizada con ACF (Si usas un campo Repeater en ACF)
                $custom_gallery = get_field('variation_galleries', $product->id);
                if (!empty($custom_gallery)) {
                    foreach ($custom_gallery as $variation_gallery) {
                        $variation_images[] = $variation_gallery;

                        if (!empty($variation_images) && $variation_id == $variation_gallery['variation_id'] ) {
                            $variationGalleryData[$variation_id] = $variation_gallery['gallery'];
                        }

                    }
                }
    
            }
        }
    
        ?>
    
        <div class="woocommerce-single__custom-product-gallery" data-gallery>
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
    
        <script>
            var variationGalleryData = <?php echo json_encode($variationGalleryData); ?>;
        </script>
    
        <?php
    }, 25);

    add_action( 'wp_footer', function () {

        if ( !is_product() ) return;
        wp_enqueue_script( 'zoom' ); // Zoom library
        ?>
        <script>
            document.addEventListener( "DOMContentLoaded", function () {

                if (typeof Swiper === "undefined") {
                    console.error("Swiper no está cargado.");
                    return;
                }

                const swiperSingleProduct = document.querySelector( '.woocommerce-single__swiper' );
                const mainImageContainer = document.querySelector('.woocommerce-single__custom-product-gallery .woocommerce-single__swiper-wrapper');
                let swiperInstance;

                function initializeSwiper() {
                    if (swiperInstance) {
                        swiperInstance.destroy(true, true);
                    }

                    swiperInstance = new Swiper(".woocommerce-single__swiper", {
                        loop: true,
                        pagination: {
                            el: ".woocommerce-single__swiper-pagination",
                            type: "progressbar",
                        },
                        zoom: {
                            maxRatio: 2,
                        },
                        slidesPerView: 1,
                        breakpoints: {
                            1024: {
                                enabled: false, // Disable Swiper on desktop
                            },
                        }
                    });
                }

                initializeSwiper(); // Iniciar Swiper al cargar la página

                jQuery('form.variations_form').on('found_variation', function(event, variation) {
                    var selectedVariation = variation.variation_id;

                    if (selectedVariation && variationGalleryData[selectedVariation]) {
                        var images = variationGalleryData[selectedVariation];

                        const mainImageContainer = document.querySelector('.woocommerce-single__swiper-wrapper');
                        mainImageContainer.innerHTML = ''; // Vaciar galería actual

                        images.forEach(function(image) {
                            var slide = `<div class="woocommerce-single__swiper-slide swiper-slide">
                                            <div class="woocommerce-single__swiper-zoom-container swiper-zoom-container">
                                                <img class="image--fluid" src="${image.url}" alt="Product Image">
                                            </div>
                                        </div>`;
                            mainImageContainer.innerHTML += slide;
                        });

                        initializeSwiper(); // Reiniciar Swiper con nuevas imágenes
                        reinitializeZoom(); // Reiniciar Zoom con nuevas imágenes
                    }
                });
                
                // Zoom in desktop
                const reinitializeZoom = () => {

                    const slides = document.querySelectorAll('.woocommerce-single__swiper-slide');

                    slides.forEach( ( slide ) => {

                        slide.addEventListener( 'mouseenter', () => {
                            if (window.innerWidth >= 1024) { // Use Zoom library on desktop

                                const imageContainer = slide.querySelector('.swiper-zoom-container');

                                jQuery(imageContainer).zoom({
                                    url: imageContainer.querySelector('img').src,
                                    touch: false,
                                    magnify: 0.7,
                                });
                            }
                        });
                    });

                };

                reinitializeZoom(); // Iniciar Zoom al cargar la página
               
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

    /**
     * Wrap product gallery and summary
     */
    add_action( 'woocommerce_before_single_product_summary', 'deemamurad_wrap_product_content_start', 5 );
    add_action( 'woocommerce_after_single_product_summary', 'deemamurad_wrap_product_content_end', 5 );
    
    function deemamurad_wrap_product_content_start() {
        echo '<div class="woocommerce-single__product-main-content">';
    }
    
    function deemamurad_wrap_product_content_end() {
        echo '</div>'; // Cierra el .product-main-content
    }

    
    /**
     * Related products
     */

    add_action( 'wp', 'remove_woocommerce_related_products' );
    add_action( 'woocommerce_after_single_product_summary', 'deemamurad_related_products_section', 20 );

    function remove_woocommerce_related_products() {
        remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    }

    function deemamurad_related_products_section() {
        include TD . '/template-parts/components/organisms/related-products.php';
    }

    /**
     * Collections
     */

    add_action('woocommerce_after_single_product', 'deemamurad_collections_single_product', 20);

    function deemamurad_collections_single_product() {
        include TD . '/template-parts/components/organisms/our-collections-slider.php';
    }

    /**
     * Keep selected the variation onload
     */

    add_action('wp_footer', 'keep_selected_the_variation');

    function keep_selected_the_variation() {
        ?>
            <script>

                document.addEventListener("DOMContentLoaded", function () {
                    const form = document.querySelector("form.variations_form"); // Formulario de variaciones
                    if (!form) return;
                
                    const selects = form.querySelectorAll("select"); // Todos los select de variaciones
                    const productId = form.dataset.product_id || form.querySelector('input[name="product_id"]').value;
                    const storageKey = `product_variation_${productId}`; // Clave única para este producto
                
                    // 🔹 Recuperar la selección previa desde localStorage
                    const savedVariations = JSON.parse(localStorage.getItem(storageKey));
                    if (savedVariations) {
                        selects.forEach(select => {
                            if (savedVariations[select.name]) {
                                select.value = savedVariations[select.name];
                            }
                        });
                
                        // 🔹 Disparar evento 'change' para actualizar la interfaz de WooCommerce
                        setTimeout(() => {
                            selects.forEach(select => {
                                select.dispatchEvent(new Event("change"));
                            });
                        }, 200);
                    }
                
                    // 🔹 Guardar la selección cuando el usuario cambie una variante
                    selects.forEach(select => {
                        select.addEventListener("change", function () {
                            const variations = {};
                            selects.forEach(s => variations[s.name] = s.value);
                            localStorage.setItem(storageKey, JSON.stringify(variations));
                        });
                    });
                
                    // 🔹 Limpiar almacenamiento después de agregar al carrito
                    form.addEventListener("submit", function () {
                        setTimeout(() => {
                            localStorage.removeItem(storageKey);
                        }, 1000);
                    });
                });

            </script>
        <?php
    }

    /**
     * Change view of price (normal price and variations price)
     */


    add_filter('woocommerce_get_price_html', function($price, $product) {
        if ( $product->is_type( 'variable' ) ) {
            $variations = $product->get_available_variations();
            
            if (!empty($variations)) {
                // Obtener todos los precios de las variaciones
                $prices = array_unique(array_map(function($variation) {
                    return floatval($variation['display_price']); // Precio de la variación
                }, $variations));
    
                // Si todas las variaciones tienen el mismo precio, mostrar el precio normal
                if (count($prices) === 1) {
                    return wc_price($prices[0]); // Mostrar un solo precio en vez de un rango
                }
    
                // Si hay variaciones con diferentes precios, ocultar el precio por defecto
                return '';
            }
        }
        return $price;
    }, 10, 2);

    add_action('woocommerce_single_product_summary', function() {
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                function updatePrice() {
                    let priceContainer = document.querySelector(".woocommerce-variation-price .price");
                    let mainPriceContainer = document.querySelector(".summary .price"); // Contenedor principal del precio
                    
                    if (priceContainer && mainPriceContainer) {
                        mainPriceContainer.innerHTML = priceContainer.innerHTML; // Reemplaza el precio original con el de la variación
                    }
                }
    
                // Actualizar cuando cambie la variación
                jQuery(document).on("found_variation", function() {
                    updatePrice();
                });
    
                // Forzar actualización al cargar la página
                updatePrice();
            });
        </script>
        <?php
    }, 25);