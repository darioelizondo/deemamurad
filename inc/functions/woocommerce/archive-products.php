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
        <form id="productsFilters">
            <h4 class="products-filters__title">
                Products
            </h4>
            <?php
            $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => true]);
            foreach ($categories as $category) {
                echo '<label><input type="checkbox" name="category[]" value="' . esc_attr($category->slug) . '"> ' . esc_html($category->name) . '</label><br>';
            }
            ?>
    
            <h4 class="products-filters__title">
                Collections
            </h4>
            <?php
            $collections = get_terms(['taxonomy' => 'collections', 'hide_empty' => true]);
            foreach ($collections as $collection) {
                echo '<label><input type="checkbox" name="collections[]" value="' . esc_attr($collection->slug) . '"> ' . esc_html($collection->name) . '</label><br>';
            }
            ?>
    
            <h4 class="products-filters__title">
                Colours
            </h4>
            <?php
            $colours = get_terms(['taxonomy' => 'filters', 'hide_empty' => true]);
            foreach ( $colours as $colour ) {
                echo '<label><input type="checkbox" name="colours[]" value="' . esc_attr($colour->slug) . '"> ' . esc_html($colour->name) . '</label><br>';
            }
            ?>
    
            <button type="reset" id="clear-filters">Limpiar Filtros</button>
        </form>
    
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
                    $("#productsFilters input").prop("checked", false);
                    history.pushState(null, null, window.location.pathname);
                    updateFilters();
                });

                // Aplicar filtros al cargar la página desde la URL
                let params = new URLSearchParams(window.location.search);
                params.forEach((value, key) => {
                    $(`input[name='${key}[]'][value='${value}']`).prop("checked", true);
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
    
    