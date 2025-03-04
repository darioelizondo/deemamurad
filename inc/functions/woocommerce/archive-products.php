<?php

    /**
     * Function: Archive products
     * 
     * @package Darío Elizondo
     * 
     */

    /** 
     * Shop filters
     */

    add_action('woocommerce_before_shop_loop', 'deemamurad_shop_filters');

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
                                        echo '<label class="products-filters__custom-checkbox"><input class="products-filters__checkbox" type="checkbox" name="category[]" value="' . esc_attr($category->slug) . '"><span class="checkmark"></span>' . esc_html($category->name) . '</label>';
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
                                    $collections = get_terms(['taxonomy' => 'collections', 'hide_empty' => true]);
                                    foreach ($collections as $collection) {
                                        echo '<label class="products-filters__custom-checkbox"><input class="products-filters__checkbox" type="checkbox" name="collections[]" value="' . esc_attr($collection->slug) . '"><span class="checkmark"></span>' . esc_html($collection->name) . '</label>';
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
                                    $colours = get_terms(['taxonomy' => 'filters', 'hide_empty' => true]);
                                    foreach ( $colours as $colour ) {
                                        echo '<label class="products-filters__custom-checkbox"><input class="products-filters__checkbox" type="checkbox" name="colours[]" value="' . esc_attr($colour->slug) . '"><span class="checkmark"></span>' . esc_html($colour->name) . '</label>';
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

                    // Obtener los valores seleccionados de los checkboxes
                    $("#productsFilters input:checked").each(function () {
                        let name = $(this).attr("name").replace("[]", "");
                        if (!filters[name]) {
                            filters[name] = [];
                        }
                        filters[name].push($(this).val());
                    });

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
                            filters: filters
                        },
                        beforeSend: function () {
                            $(".products").html("<p>Loading products...</p>");
                        },
                        success: function (response) {
                            $(".products").html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("Error on AJAX request:", status, error);
                        }
                    });
                }

                // Detectar cambios en los checkboxes y actualizar la lista de productos en tiempo real
                $("#productsFilters input").on("change", updateFilters);

                // Botón para limpiar filtros
                $("#clear-filters").on("click", function () {
                    const allCounters = document.querySelectorAll('.products-filters__filter-count');
                    allCounters.forEach( counter => counter.textContent = '' );
                    $("#productsFilters input").prop("checked", false);
                    history.pushState(null, null, window.location.pathname);
                    updateFilters();
                });

                // Aplicar filtros al cargar la página desde la URL
                let params = new URLSearchParams(window.location.search);
                params.forEach((value, key) => {
                    $(`input[name='${key}[]'][value='${value}']`).prop("checked", true);
                });

                // Count filters
                function updateFilterCount(filterType) {
                    console.log(filterType);
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

            });
        </script>
        <?php
    }

    add_action('pre_get_posts', 'custom_filter_products_query');
    
    function custom_filter_products_query($query) {

        if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_category())) {

            $tax_query = ['relation' => 'AND'];
    
            if (!empty($_GET['category'])) {
                $tax_query[] = [
                    'taxonomy' => 'product_cat',
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', (array) $_GET['category']),
                    'operator' => 'IN',
                ];
            }
    
            if (!empty($_GET['collections'])) {
                $tax_query[] = [
                    'taxonomy' => 'collections',
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', (array) $_GET['collections']),
                    'operator' => 'IN',
                ];
            }
    
            if (!empty($_GET['colours'])) {
                $tax_query[] = [
                    'taxonomy' => 'filters',
                    'field' => 'slug',
                    'terms' => array_map('sanitize_text_field', (array) $_GET['colours']),
                    'operator' => 'IN',
                ];
            }
    
            if (!empty($tax_query)) {
                $query->set('tax_query', $tax_query);
            }
            
        }
    }
    
    