<?php

    /**
     * Function: Archive products
     * 
     * @package Darío Elizondo
     * 
     */

     /**
     * Remove default pagination
     */
    remove_action('woocommerce_after_shop_loop', 'woocommerce_pagination', 10);

    /**
     * Remove default WooCommerce sidebar
     */

    add_action( 'template_redirect', 'remove_woocommerce_sidebar' );

    function remove_woocommerce_sidebar() {
         if ( is_woocommerce() ) {
             remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
         }
    }


    add_filter( 'woocommerce_product_get_image_id', 'show_variation_image', 10, 2 );

    function show_variation_image( $image_id, $product ) {
        if ( $product->is_type( 'variation' ) ) {
            return $product->get_image_id();
        }
        return $image_id;
    }

    /** 
     * Product category & Collections list
     */

     add_action( 'woocommerce_before_main_content', 'deemamurad_category_and_collections_list', 5 );

     function deemamurad_category_and_collections_list() {
 
         if( is_product() ) return;
 
         ?>
             <div class="woocommerce-shop__wrapper-lists">
                 <!-- Categories list -->
                 <div class="woocommerce-shop__wrapper-categories">
                     <div class="woocommerce-shop__wrapper-list-title">
                         <h3 class="woocommerce-shop__title">
                             Products
                         </h3>
                     </div>
                     <?php
                         // Categories
                         $product_categories = get_terms( array(
                             'taxonomy' => 'product_cat',
                             'hide_empty' => false,
                         ) );
                     
                         // Get URL params
                         $current_categories = isset( $_GET['category'] ) ? $_GET['category'] : [];
                     
                         if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                             echo '<ul class="woocommerce-shop__categories-list">';
                             foreach ( $product_categories as $category ) {
                                 // Verificar si la categoría actual está en los parámetros de la URL
                                 $is_active = in_array( $category->slug, $current_categories ) ? ' active' : '';
                     
                                 // Crear el link con el parámetro 'category[]' y el slug de la categoría
                                 // $category_link = add_query_arg( 'category[]', $category->slug, get_permalink( woocommerce_get_page_id( 'shop' ) ) );
                                 echo '<li class="woocommerce-shop__list-item ' . esc_attr( $is_active ) . '"><a class="woocommerce-shop__list-link" href="#" data-filter="products" data-slug="' . esc_attr( $category->slug ) . '">' . esc_html( $category->name ) . '</a></li>';
                             }
                             echo '</ul>';
                         }
                     ?>
                 </div>
                 <!-- Collections list -->
                 <div class="woocommerce-shop__wrapper-collections">
                     <div class="woocommerce-shop__wrapper-list-title">
                         <h3 class="woocommerce-shop__title">
                             Collections
                         </h3>
                     </div>
                     <?php
                         // Collections
                         $collections = get_terms( array(
                             'taxonomy' => 'collections',
                             'orderby'  => 'id',
                             'hide_empty' => false,
                         ) );
                     
                         // Get URL params
                         $current_collections = isset( $_GET['collections'] ) ? $_GET['collections'] : [];
                     
                         if ( ! empty( $collections ) && ! is_wp_error( $collections ) ) {
                             echo '<ul class="woocommerce-shop__collections-list">';
                             foreach ( $collections as $collection ) {
                                 // Verificar si la colección actual está en los parámetros de la URL
                                 $is_active = in_array( $collection->slug, $current_collections ) ? ' active' : '';
                     
                                 // Crear el link con el parámetro 'collections[]' y el slug de la colección
                                 // $collection_link = add_query_arg( 'collections[]', $collection->slug, get_permalink( woocommerce_get_page_id( 'shop' ) ) );
                                 echo '<li class="woocommerce-shop__list-item ' . esc_attr( $is_active ) . '"><a class="woocommerce-shop__list-link" href="#" data-filter="collections" data-slug="' . esc_attr( $collection->slug ) . '">' . esc_html( $collection->name ) . '</a></li>';
                             }
                             echo '</ul>';
                         }
                     ?>
                 </div>
             </div>
         <?php
 
     }

    /** 
     * Shop filters
     */

    add_action( 'woocommerce_before_shop_loop', 'deemamurad_shop_filters' );

    function deemamurad_shop_filters() {

        if (!is_shop() && !is_product_category()) return;
    
    ?>
        <!-- Filters -->
        <div class="products-filters">
            <div class="products-filters__inner">
                <form id="productsFilters" class="products-filters__form">
                    <div class="products-filters__wrapper-title">
                        <!-- Title -->
                        <h4 class="products-filters__main-title">
                            Filters
                        </h4>
                        <!-- Close -->
                        <div id="filtersClose" class="products-filters__wrapper-close">
                            <a class="products-filters__close" href="#">
                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 1L18 18M1 18L18 1L1 18Z" stroke="#3F3F46" stroke-width="0.971429" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <!-- Wrapper accordions -->
                    <div class="products-filters__wrapper-accordions">
                        <!-- Accordion -->
                        <div class="products-filters__accordion" data-filter-type="products">
                            <h4 class="products-filters__title">
                                <span class="products-filters__span-title">
                                    Products
                                </span>
                                <div class="products-filters__title-right">
                                    <span class="products-filters__filter-count"></span>
                                    <span class="products-filters__plus-minus-toggle collapsed"></span>
                                </div>
                            </h4>
                            <div class="products-filters__accordion-content">
                                <?php
                                    $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
                                    foreach ($categories as $category) {
                                        echo '<label class="products-filters__custom-checkbox"><input class="products-filters__checkbox" type="checkbox" name="category[]" data-filter="products" value="' . esc_attr($category->slug) . '"><span class="checkmark"></span>' . esc_html($category->name) . '</label>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Accordion -->
                        <div class="products-filters__accordion" data-filter-type="collections">
                            <h4 class="products-filters__title">
                                <span class="products-filters__span-title">
                                    Collections
                                </span>
                                <div class="products-filters__title-right">
                                    <span class="products-filters__filter-count"></span>
                                    <span class="products-filters__plus-minus-toggle collapsed"></span>
                                </div>
                            </h4>
                            <div class="products-filters__accordion-content">
                                <?php
                                    $collections = get_terms(['taxonomy' => 'collections', 'orderby'  => 'id', 'hide_empty' => true]);
                                    foreach ($collections as $collection) {
                                        echo '<label class="products-filters__custom-checkbox"><input class="products-filters__checkbox" type="checkbox" name="collections[]" data-filter="collections" value="' . esc_attr($collection->slug) . '"><span class="checkmark"></span>' . esc_html($collection->name) . '</label>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Accordion -->
                        <div class="products-filters__accordion" data-filter-type="colours">
                            <h4 class="products-filters__title">
                                <span class="products-filters__span-title">
                                    Colours
                                </span>
                                <div class="products-filters__title-right">
                                    <span class="products-filters__filter-count"></span>
                                    <span class="products-filters__plus-minus-toggle collapsed"></span>
                                </div>
                            </h4>
                            <div class="products-filters__accordion-content">
                                <?php
                                    // Obtener todas las variaciones de productos con el atributo 'pa_colour'
                                    $args = [
                                        'post_type'      => 'product_variation',
                                        'posts_per_page' => -1,
                                        'post_status'    => 'publish'
                                    ];

                                    $variations = get_posts($args);
                                    $colours = [];

                                    // Recorrer variaciones y obtener el atributo 'pa_colour'
                                    foreach ($variations as $variation) {
                                        $product_variation = wc_get_product($variation->ID);
                                        $colour = $product_variation->get_attribute('pa_colour');

                                        if ($colour && !in_array($colour, $colours)) {
                                            $colours[] = $colour;
                                        }
                                    }

                                    // Mostrar opciones de colores únicos
                                    foreach ($colours as $colour) {
                                        $term = get_term_by('name', $colour, 'pa_colour');
                                        echo '<label class="products-filters__custom-checkbox">
                                            <input class="products-filters__checkbox" type="checkbox" name="colours[]" value="' . esc_attr($term->slug) . '">
                                            <span class="checkmark"></span>' . esc_html($colour) . '
                                        </label>';
                                    }
                                ?>
                            </div>
                        </div>


                    </div>
                    <!-- Clean filters -->
                    <div class="products-filters__wrapper-clean">
                        <button class="products-filters__clean" type="reset" id="clear-filters">Clear all</button>
                    </div>    
            
                </form>
            </div>
        </div>
        <!-- End filters -->
    
        <script>
            jQuery(document).ready(function ($) {
                
                function updateFilters() {
                    let filters = {};
                    let activeFilters = 0;
                    if( typeof windowSpy !== 'undefined' ) {
                        windowSpy.remove('#products-trigger');
                    }

                    // Obtener los valores seleccionados de los checkboxes
                    $("#productsFilters input:checked").each(function () {
                        let name = $(this).attr("name").replace("[]", "");
                        if (!filters[name]) {
                            filters[name] = [];
                        }
                        filters[name].push($(this).val());
                        activeFilters++;
                    });

                     // Mostrar la cantidad de filtros aplicados en el botón
                    if ( activeFilters > 0 ) {
                        $("#activeFiltersCount").text(`(${activeFilters})`);
                    } else {
                        $("#activeFiltersCount").text("");
                    }

                    // Construimos la URL para actualizar el historial del navegador
                    let queryString = Object.keys(filters)
                        .map(key => filters[key].map(val => `${key}[]=${val}`).join("&"))
                        .join("&");

                    let newUrl = window.location.pathname + "?" + queryString;
                    history.pushState(null, null, newUrl);

                    // Enviar los filtros al backend con AJAX
                    $.ajax({
                        url: "<?php echo admin_url('admin-ajax.php'); ?>",
                        method: "POST",
                        data: {
                            action: "filter_products",
                            filters: filters,
                        },
                        beforeSend: function () {
                            jQuery(".products__loading").show();
                        },
                        success: function (response) {
                            $(".products__loading").hide();
                            if( response.canLoadMore ) {
                                $(".products").html(response.products);
                                // Actualizar contador de resultados
                                $( "#productsResultCount" ).text( response.count + " products" );
                            } else {
                                $(".products").html( '<p style="grid-column: span 4; text-align: center; padding: 35px 0;">No products were found matching your selection<p>' );
                                // Actualizar contador de resultados
                                $( "#productsResultCount" ).text( '' );
                            }

                        },
                        error: function (xhr, status, error) {
                            console.error("Error on AJAX request:", status, error);
                            jQuery(".products__loading").hide();
                            canLoadMore = false;
                        },
                    });

                }

                // Detectar cambios en los checkboxes y actualizar la lista de productos en tiempo real
                $("#productsFilters input").on("change", updateFilters);

                // Botón para limpiar filtros
                $("#clear-filters").on("click", function () {
                    const allCounters = document.querySelectorAll('.products-filters__filter-count');
                    $( '.woocommerce-shop__list-item' ).removeClass('active');
                    allCounters.forEach( counter => counter.textContent = '' );
                    $("#productsFilters input").prop("checked", false);
                    history.pushState(null, null, window.location.pathname);
                    updateFilters();
                });

                // Aplicar filtros al cargar la página desde la URL
                const updateOnLoad = () => {     
                    const params = new URLSearchParams(window.location.search);

                    params.forEach((value, key) => {
                        const urlFilterType = key === 'category[]' ? 'products[]' : key;
                        const cleanUrlFilterType = urlFilterType.replace("[]", "");
    
                        $(`input[name='${key}'][value='${value}']`).prop("checked", true);                        
                        updateFilterCount( cleanUrlFilterType );
                    });

                    if ( params.size > 0 ) {
                        updateFilters();
                    }


                }

                updateOnLoad();

                let activeFiltersOnLoad = 0;

                // Obtener los valores seleccionados de los checkboxes
                $("#productsFilters input:checked").each(function () {
                    activeFiltersOnLoad++;
                });

                // Mostrar la cantidad de filtros aplicados en el botón
                if ( activeFiltersOnLoad > 0 ) {
                    $("#activeFiltersCount").text(`(${activeFiltersOnLoad})`);
                } else {
                    $("#activeFiltersCount").text("");
                }

                // Count filters
                function updateFilterCount(filterType) {
                    let count = $(`.products-filters__accordion[data-filter-type="${filterType}"] .products-filters__checkbox:checked`).length;
                    if( count > 0 ) {
                        $(`.products-filters__accordion[data-filter-type="${filterType}"] .products-filters__filter-count`).text(count);
                    }
                    else {
                        $(`.products-filters__accordion[data-filter-type="${filterType}"] .products-filters__filter-count`).text('');
                    }
                }

                $(".products-filters__checkbox").on("change", function () {
                    let filterGroup = $(this).closest(".products-filters__accordion");
                    let filterType = filterGroup.data("filter-type");
                    updateFilterCount(filterType);
                });

                // Accordion
                const accordions = document.querySelectorAll('.products-filters__accordion');
                const handleToggleAccordion = ( event, link ) => {
                    event.preventDefault();
                    jQuery( link ).next().slideToggle();
                    jQuery( link ).find( '.products-filters__plus-minus-toggle' ).toggleClass( 'collapsed' );
                }

                accordions.forEach( ( accordion ) => {
                    const link = accordion.querySelector( '.products-filters__title' );
                    jQuery( link ).next().slideUp();
                    link.addEventListener( 'click', ( event ) => handleToggleAccordion( event, link ) ); // Comportamiento solo en mobile

                });

                // Show / Hide filters
                $("#toggleFilters").on("click", function () {
                    $(".products-filters").addClass("active");
                    setTimeout( () => {
                        $(".products-filters__inner").addClass("active");
                    }, 300 )
                });

                $("#filtersClose").on("click", function(e) {
                    e.preventDefault();
                    $(".products-filters__inner").removeClass("active");
                    setTimeout( () => {
                        $(".products-filters").removeClass("active");
                    }, 300 )
                });

                $(".woocommerce-shop__list-link").on("click", function (e) {
                    e.preventDefault();

                    let filterType = $(this).data("filter"); // 'products' o 'collections'
                    let slug = $(this).data("slug");
                    let parentItem = $(this).parent();
                    let checkbox = $(`.products-filters__checkbox[data-filter="${filterType}"][value="${slug}"]`);

                    if (parentItem.hasClass("active")) {
                        // Si ya está activo, lo desactiva
                        parentItem.removeClass("active");
                        checkbox.prop("checked", false);
                    } else {
                        // Si no está activo, limpia todos los grupos y se selecciona el nuevo
                        // Categories
                        $(".woocommerce-shop__wrapper-categories .woocommerce-shop__list-item").removeClass("active");
                        $('.products-filters__checkbox[data-filter="products"]').prop("checked", false);
                        // Collections
                        $(".woocommerce-shop__wrapper-collections .woocommerce-shop__list-item").removeClass("active");
                        $('.products-filters__checkbox[data-filter="collections"]').prop("checked", false);
                        // Clear counters
                        $( '.products-filters__filter-count' ).text('');

                        // if (filterType === "products") {
                        //     $(".woocommerce-shop__wrapper-categories .woocommerce-shop__list-item").removeClass("active");
                        //     $('.products-filters__checkbox[data-filter="products"]').prop("checked", false);
                        // } else if (filterType === "collections") {
                        //     $(".woocommerce-shop__wrapper-collections .woocommerce-shop__list-item").removeClass("active");
                        //     $('.products-filters__checkbox[data-filter="collections"]').prop("checked", false);
                        // }

                        parentItem.addClass("active");
                        checkbox.prop("checked", true);
                    }

                    // Disparar la función de filtrado AJAX
                    updateFilters();
                    // Contar los filtros aplicados
                    updateFilterCount(filterType);
                });

                                // Prevent reload the page when clicking on the links in Shop page
                document.querySelectorAll('.menu__link').forEach( link => {

                    link.addEventListener('click', (e) => {
                        
                        const currentPath = window.location.pathname;
                        const productPagePath = '/shop/'; 
                        const productPagePathStaging = '/deema-murad/shop/';
                        const category = link.dataset.slug ? link.dataset.slug : null; // Extraer el slug de la categoría del atributo data-slug

                        if ( currentPath === productPagePath || currentPath === productPagePathStaging && category !== null ) {

                            console.log( category );

                            e.preventDefault(); // Prevenir la recarga

                            const itemList = $(`.woocommerce-shop__list-link[data-slug="${category}"]`);
                            const itemListParent = itemList.parent();
                            const checkbox = $(`.products-filters__checkbox[data-filter="products"][value="${category}"]`);

                            if( itemListParent.hasClass("active") ) {
                                // Si ya está activo, lo desactiva
                                itemListParent.removeClass("active");
                                checkbox.prop("checked", false);
                            } else {
                                // Si no está activo, limpia todos los grupos y se selecciona el nuevo
                                // Categories
                                $(".woocommerce-shop__wrapper-categories .woocommerce-shop__list-item").removeClass("active");
                                $('.products-filters__checkbox[data-filter="products"]').prop("checked", false);
                                // Collections
                                $(".woocommerce-shop__wrapper-collections .woocommerce-shop__list-item").removeClass("active");
                                $('.products-filters__checkbox[data-filter="collections"]').prop("checked", false);
                                // Clear counters
                                $( '.products-filters__filter-count' ).text('');
                                itemListParent.addClass("active");
                                checkbox.prop("checked", true);
                            }

                            // Disparar la función de filtrado AJAX
                            updateFilters();
                            // Contar los filtros aplicados
                            updateFilterCount('products');

                        }
                    });
                
                });

            });
        </script>
        <?php
    }


    add_action('pre_get_posts', 'custom_filter_products_query');
    
    function custom_filter_products_query($query) {
        // Asegurarse de que no estamos en el área de administración ni en la consulta de variaciones
        if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category()) && !isset($_GET['is_variation'])) {

            // Configura la consulta para productos simples y variaciones
            $query->set('post_type', array('product', 'product_variation'));
            $query->set( 'posts_per_page', 12 ); // Show 12 products 
            $tax_query = ['relation' => 'AND'];
            $meta_query = $query->get('meta_query');
        
            // Filtrar por categoría de producto
            if (!empty($_GET['category'])) {
                $tax_query[] = [
                    'taxonomy' => 'product_cat',
                    'field'    => 'slug',
                    'terms'    => array_map('sanitize_text_field', (array) $_GET['category']),
                    'operator' => 'IN',
                ];
            }
        
            // Filtrar por colecciones
            if (!empty($_GET['collections'])) {
                $tax_query[] = [
                    'taxonomy' => 'collections',
                    'field'    => 'slug',
                    'terms'    => array_map('sanitize_text_field', (array) $_GET['collections']),
                    'operator' => 'IN',
                ];
            }

            // Filtrar por color
            if (!empty($_GET['colours'])) {
                $meta_query[] = [
                    'key'     => 'attribute_pa_colour',
                    'value'   => sanitize_text_field($_GET['colours']),
                    'compare' => '=',
                ];
            }
        
            // Aplicar tax_query y meta_query a la consulta
            if (!empty($tax_query)) {
                $query->set('tax_query', $tax_query);
            }

            if (!empty($meta_query)) {
                $query->set('meta_query', $meta_query);
            }
        }
    }
    
    /** 
     * Products counter
     */
    
    remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
    
    add_action( 'woocommerce_before_main_content', 'deemamurad_before_main_content', 10 );

    
    function deemamurad_before_main_content() {

        if( is_product() ) return;

        ?>
            <!-- Shop page before main content -->
            <div class="woocommerce-shop__before-main-content">
                <!-- Products counter -->
                <div class="woocommerce-shop__products-counter">
                    <div class="woocommerce-shop__wrapper-products-counter">
                        <span id="productsResultCount" class="woocommerce-shop__products-count">
                            <?php
                                $args = [
                                    'post_type'      => 'product_variation',  // Solo variaciones
                                    'orderby'        => 'meta_value_num',
                                    'posts_per_page' => 12,
                                    'post_status'    => 'publish',
                                ];
                    
                                $query = new WP_Query($args);
                                echo $query->found_posts;
                            ?> products
                        </span>
                    </div>
                </div>
                <!-- Filters button-->
                <div class="woocommerce-shop__wrapper-filters-button">
                    <button type="button" id="toggleFilters" class="woocommerce-shop__filters-button">
                        <svg width="23" height="15" viewBox="0 0 23 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line y1="1.55" x2="23" y2="1.55" stroke="black" stroke-width="0.9"/>
                            <line y1="7.55" x2="23" y2="7.55" stroke="black" stroke-width="0.9"/>
                            <line y1="13.55" x2="23" y2="13.55" stroke="black" stroke-width="0.9"/>
                            <circle cx="4.5" cy="1.5" r="1.5" fill="black"/>
                            <circle cx="16.5" cy="7.5" r="1.5" fill="black"/>
                            <circle cx="8.5" cy="13.5" r="1.5" fill="black"/>
                        </svg>
                        <span class="woocommerce-shop__filters-button-text">
                            Filters
                        </span>
                        <span class="woocommerce-shop__filters-button-text" id="activeFiltersCount"></span>
                    </button>
                </div>
            </div>
            <!-- End shop page before main content -->
        <?php
    }

    /** 
     * Remove default sorting
     */

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

     /** 
     * Remove header title
     */

    add_filter( 'woocommerce_show_page_title', 'wc_hide_page_title' );

    function wc_hide_page_title() {
        if( !is_shop() ) return true;
    }

    /** 
     * Infinite scroll
     */
    
    add_action('wp_head', 'add_ajax_url');

    function add_ajax_url() {
        echo '<script type="text/javascript">const ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
    }

    add_action( 'wp_ajax_get_more_products', 'get_more_products' );
    add_action( 'wp_ajax_nopriv_get_more_products', 'get_more_products' );

    
    function get_more_products() {
        $filters = isset($_GET['filters']) ? $_GET['filters'] : [];
        $page = sanitize_text_field($_GET['page']);
        
        // Aquí creamos la consulta de productos variaciones
        $args = [
            'post_type'      => 'product_variation',  // Solo variaciones
            'orderby'        => 'meta_value_num',
            'posts_per_page' => 12,
            'paged'          => $page,
            'post_status'    => 'publish',
        ];
    
        // Filtrar por categoría de producto si se aplica
        if (!empty($filters['category'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array_map('sanitize_text_field', (array) $filters['category']),
                'operator' => 'IN',
            ];
        }
    
        // Filtrar por colección si se aplica
        if (!empty($filters['collections'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'collections',
                'field'    => 'slug',
                'terms'    => array_map('sanitize_text_field', (array) $filters['collections']),
                'operator' => 'IN',
            ];
        }
    
        // Filtrar por color si se aplica
        if (!empty($filters['colours'])) {
            $args['meta_query'][] = [
                'key'     => 'attribute_pa_colour',
                'value'   => sanitize_text_field($filters['colours']),
                'compare' => '=',
            ];
        }
    
        // Realizar la consulta de variaciones de producto
        $query = new WP_Query($args);
        $processed_variations = [];
    
        if ($query->have_posts()) {
            ob_start();
            $counter = 0;
    
            while ($query->have_posts()) {
                $query->the_post();
    
                // Obtener la variación
                global $product;
                if ( $product ) {
                    $variation_id = $product->get_id();
                    $parent_product = wc_get_product($product->get_parent_id());  // Obtener el producto padre
        
                    // Si la variación ya fue procesada, continuar con la siguiente
                    if (in_array($variation_id, $processed_variations)) {
                        continue;
                    }
        
                    // Mostrar la variación
                    $colour = $product->get_attribute('pa_colour'); // Atributo de color de la variación
                    $quantity = $product->get_attribute('pa_quantity') ? $product->get_attribute('pa_quantity') : null; // Atributo de cantidad
                    mostrar_imagenes_variacion($parent_product, $variation_id, $colour, $quantity);
                    $counter++;
        
                    // Marcar esta variación como procesada
                    $processed_variations[] = $variation_id;
                }
            }
    
            wp_send_json([
                'count'    => $query->found_posts, 
                'products' => ob_get_clean(),
                'canLoadMore' => true,
            ]);
    
        } else {
            wp_send_json([
                'canLoadMore' => false,
            ]);
        }
    
        wp_reset_postdata();
        die();
    }

    function mostrar_imagenes_variacion( $product, $variation_id, $colour, $quantity ) {
        // Obtener la galería de la variación desde ACF
        $variation_galleries = get_field('variation_galleries', $product->get_id());
        
        $gallery_images = [];
        if (!empty($variation_galleries)) {
            foreach ($variation_galleries as $gallery) {
                if ($gallery['variation_id'] == $variation_id) {
                    $gallery_images = $gallery['gallery'];
                    // Obtener la primera y segunda imagen
                    $item_id = $gallery['variation_id'];
                    $main_image   = !empty($gallery_images[0]) ? $gallery_images[0]['url'] : wc_placeholder_img_src();
                    $second_image = !empty($gallery_images[1]) ? $gallery_images[1]['url'] : $main_image;
                    $filters_text = !empty( $colour ) ? $colour : '';
                    $filters_text_qty = !empty( $quantity ) ? ', ' . $quantity : null;

                    include TD . '/template-parts/components/molecules/product-item.php';

                    unset( $item_id, $main_image, $second_image, $filters_text, $filters_text_qty );
                }
            }
        }
    }

    function mostrar_imagenes_producto_simple( $id ) {
        $item_id = $id;
        $main_image = get_the_post_thumbnail_url($item_id, 'large');
        $gallery_images = get_post_meta($item_id, '_product_image_gallery', true);
        $gallery_images = explode(',', $gallery_images);
        $second_image = !empty($gallery_images[0]) ? wp_get_attachment_url($gallery_images[0]) : $main_image;
        $filters_terms = get_the_terms( $item_id, 'filters' );
        $filters_text = !empty( $filters_terms ) ? implode(', ', wp_list_pluck( $filters_terms, 'name' ) ) : 'Without filters';
    
        // Incluir la plantilla personalizada
        include TD . '/template-parts/components/molecules/product-item.php';

        unset( $item_id, $main_image, $second_image, $filters_text );
    }

    add_action( 'woocommerce_before_shop_loop', 'deemamurad_infinite_scroll' );

    function deemamurad_infinite_scroll() {

        ?>
        <script>
             jQuery(document).ready(function ($) {

                let page = 2;
                let canLoadMore = true;
                let windowSpy = new jQuery.Espy(window, products_trigger_callback);
                windowSpy.add('#products-trigger');

                function products_trigger_callback(entered, state) {
                    if ( entered ) {
                        load_more_products();
                    }
                }

                function getFilters() {
                    let filters = {};
                    $("#productsFilters input:checked").each(function () {
                        let name = $(this).attr("name").replace("[]", "");
                        if (!filters[name]) {
                            filters[name] = [];
                        }
                        filters[name].push($(this).val());
                    });
                    return filters;
                }

                function buildQueryString(filters) {
                    return Object.keys(filters)
                        .map(key => filters[key].map(val => `${key}[]=${val}`).join("&"))
                        .join("&");
                }

                function load_more_products() {
                    if ( canLoadMore ) {

                        let filters = getFilters();
                        let queryString =  filters.length > 0 ? buildQueryString(filters) : '';
                        let ajaxUrl = `${ajaxurl}?page=${page}&${queryString}`;

                        $.ajax({
                            url: ajaxUrl,
                            type: "GET",
                            data: {
                                action: "get_more_products",
                                filters: filters,
                                page: page
                            },
                            beforeSend: function () {
                                jQuery(".products__loading").show();
                            },
                            success: function (response) {
                                if( response.canLoadMore === true ) {
                                    jQuery(".products__loading").hide();
                                    $( ".products" ).append( response.products );
                                    $( "#productsResultCount" ).text( response.count + " products" );
                                    page++;
                                }
                                else {
                                    canLoadMore = false;
                                }
                            },
                            error: function (xhr, status, error) {
                                jQuery(".products__loading").hide();
                                canLoadMore = false;
                                console.error("Infinite Scroll Error:", status, error);
                            },
                            complete: function() {
                                jQuery(".products__loading").hide();
                                windowSpy.add('#products-trigger');
                            }
                        });
                    }
                }

            });
                    
        </script>
        <?php
    }


    /** 
     * Fix product titles (Without variation)
     */
    add_filter('the_title', function ($title, $id) {
        $product = wc_get_product($id);
    
        if ($product && $product->is_type('variation')) {
            $parent_id = wp_get_post_parent_id($id);
            $parent_product = wc_get_product($parent_id);
    
            if ($parent_product) {
                return $parent_product->get_name(); // Devuelve el nombre del producto padre
            }
        }
    
        return $title;
    }, 10, 2);