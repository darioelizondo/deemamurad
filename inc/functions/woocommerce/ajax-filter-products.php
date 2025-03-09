<?php

    /**
     * Function: Ajax filter products
     * 
     * @package Darío Elizondo
     * 
     */

add_action( 'wp_ajax_filter_products', 'filter_products_ajax' );
add_action( 'wp_ajax_nopriv_filter_products', 'filter_products_ajax' );

// function filter_products_ajax() {


//     // Si hay algun tipo de filtro usamos una $query
//     if( !empty($_POST['filters']['category']) || !empty($_POST['filters']['collections']) || !empty($_POST['filters']['colours']) ) {

//         $args = [
//             'post_type'      => [ 'product', 'product_variation' ],
//             'posts_per_page' => -1,
//             'post_status'    => 'publish',
//             'tax_query'      => [ 'relation' => 'OR' ], 
//             'meta_query'     => [ 'relation' => 'OR' ], 

//         ];
        
//         // Filtro por categoría
//         if (!empty($_POST['filters']['category'])) {
//             $args['tax_query'][] = [
//                 'taxonomy' => 'product_cat',
//                 'field'    => 'slug',
//                 'terms'    => array_map('sanitize_text_field', (array) $_POST['filters']['category']),
//                 'operator' => 'IN',
//             ];
//         }

//         // Filtro por colecciones
//         if (!empty($_POST['filters']['collections'])) {
//             $args['tax_query'][] = [
//                 'taxonomy' => 'collections',
//                 'field'    => 'slug',
//                 'terms'    => array_map('sanitize_text_field', (array) $_POST['filters']['collections']),
//                 'operator' => 'IN',
//             ];
//         }

//         // Filtro por color (atributo)
//         if (!empty($_POST['filters']['colours'])) {
//             $args['meta_query'][] = [
//                 'key'     => 'attribute_pa_colour',
//                 'value'   => $_POST['filters']['colours'],
//                 'compare' => '=',
//             ];
//         } 

//         $query = new WP_Query($args);
//         $processed_products = [];
//         $counter = 0;

//         if ( $query->have_posts() ) {

//             print_r($query);

//             ob_start();
//             while ( $query->have_posts() ) {
//                 $query->the_post();
                
//                 global $product;
//                 $product_id = $product->get_id();
                
//                 if ( $product->is_type('variable') ) {

//                     // Evitar que se procese el mismo producto más de una vez
//                     if ( in_array( $product_id, $processed_products ) ) {
//                         continue;
//                     }

//                     $available_variations = $product->get_available_variations();
//                     $mostrar_producto = false;
                    
//                     foreach ( $available_variations as $variation ) {
//                         $variation_id = $variation['variation_id'];
//                         $variation_obj = wc_get_product($variation_id);

//                         // Obtener el color de la variación
//                         $colour = $variation_obj->get_attribute('pa_colour');

//                         // Si hay filtro de colour marcamos el producto como válido
//                         if ( !empty($_POST['filters']['colours']) && $colour === $_POST['filters']['colours'] ) {
//                             $mostrar_producto = true;
//                         }
                        
//                         // Llamamos al product item
//                         mostrar_imagenes_variacion( $product, $variation_id, $colour );
//                         $counter++;
//                     }

//                     if ( $mostrar_producto ) {
//                         $processed_products[] = $product_id; // 🔹 Marcar como procesado
//                     }

//                 }

//                 // Si ya es una variacion
//                 if( $product->parent_id ) {

//                     $processed_variations = [];
//                     $variation_id = $product->get_id();
//                     $parent_product = wc_get_product($product->get_parent_id());  // Obtener el producto padre
			
//                     // Si la variación ya fue procesada, continuar con la siguiente
//                     if (in_array($variation_id, $processed_variations)) {
//                         continue;
//                     }
        
//                     // Mostrar la variación
//                     $colour = $product->get_attribute('pa_colour'); // Atributo de color de la variación

//                     mostrar_imagenes_variacion($parent_product, $variation_id, $colour);
//                     $counter++;
                    
        
//                     // Marcar esta variación como procesada
//                     $processed_variations[] = $variation_id;
//                 }

//                 if( $product->is_type('simple') ) {
//                     if ( in_array( $product_id, $processed_products ) ) {
//                         continue;
//                     }
//                     mostrar_imagenes_producto_simple($product_id);
//                     $processed_products[] = $product_id; // 🔹 Marcar como procesado
//                 }
                
//             }

//             wp_send_json([
//                 'count'    => $counter, 
//                 'products' => ob_get_clean(),
//                 'canLoadMore' => true,
//             ]);

//         } else {
//             wp_send_json([
//                 'canLoadMore' => false,
//             ]);
//         }
        
//         wp_reset_postdata();
//         wp_die();

//     } else { // Sino usamos una $query solo para variaciones

//         $args = [
//             'post_type'      => 'product_variation',  // Solo variaciones
//             'orderby'        => 'meta_value_num',
//             'posts_per_page' => 12,
//             'post_status'    => 'publish',
//         ];

//         $queryVariation = new WP_Query($args);
// 			$processed_variations = [];
		
// 			if ( $queryVariation->have_posts() ) {
// 				ob_start();
// 				$counter = 0;
		
// 				while ($queryVariation->have_posts()) {
// 					$queryVariation->the_post();
		
// 					// Obtener la variación
// 					global $product;
// 					if ( $product ) {
// 						$variation_id = $product->get_id();
// 						$parent_product = wc_get_product($product->get_parent_id());  // Obtener el producto padre
			
// 						// Si la variación ya fue procesada, continuar con la siguiente
// 						if (in_array($variation_id, $processed_variations)) {
// 							continue;
// 						}
			
// 						// Mostrar la variación
// 						$colour = $product->get_attribute('pa_colour'); // Atributo de color de la variación
// 						mostrar_imagenes_variacion($parent_product, $variation_id, $colour);
// 						$counter++;
			
// 						// Marcar esta variación como procesada
// 						$processed_variations[] = $variation_id;
// 					}
// 				}

                
//                 wp_send_json([
//                     'count'    => $queryVariation->found_posts, 
//                     'products' => ob_get_clean(),
//                     'canLoadMore' => true,
//                 ]);
		
		
// 			} else {
//                 wp_send_json([
//                     'canLoadMore' => false,
//                 ]);
// 			}
		
// 			wp_reset_postdata();
//             wp_die();
//     }

// }

function filter_products_ajax() {

    // Verificar si hay filtros aplicados
    if (!empty($_POST['filters']['category']) || !empty($_POST['filters']['collections']) || !empty($_POST['filters']['colours'])) {

        // Paso 1: Filtrar variaciones por color (si hay filtro de colores)
        $color_filter = !empty($_POST['filters']['colours']) ? $_POST['filters']['colours'] : '';
        $color_filter = is_array($color_filter) ? array_map('sanitize_text_field', $color_filter) : sanitize_text_field($color_filter);

        $variation_args = [
            'post_type'      => 'product_variation', // Solo variaciones
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'meta_query'    => [],
        ];

        if (!empty($color_filter)) {
            $variation_args['meta_query'][] = [
                'key'     => 'attribute_pa_colour', // Asegúrate de que este sea el meta_key correcto
                'value'   => $color_filter,
                'compare' => is_array($color_filter) ? 'IN' : '=', // Usar IN si es un array
            ];
        }

        $variation_query = new WP_Query($variation_args);
        $parent_ids = []; // Almacenar IDs de productos padres

        // Obtener los IDs de los productos padres de las variaciones filtradas
        if ($variation_query->have_posts()) {
            while ($variation_query->have_posts()) {
                $variation_query->the_post();
                global $product;
                $parent_ids[] = $product->get_parent_id(); // Guardar el ID del producto padre
            }
            wp_reset_postdata();
        }

        // Paso 2: Filtrar productos padres por categoría y colección
        $parent_args = [
            'post_type'      => 'product', // Solo productos padres
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => ['relation' => 'AND'], // Relación entre taxonomías
        ];

        // Si hay filtro de colores, limitar a los productos padres de las variaciones filtradas
        if ($color_filter && !empty($parent_ids)) {
            $parent_args['post__in'] = array_unique($parent_ids);
        }

        // Filtro por categoría
        if (!empty($_POST['filters']['category'])) {
            $parent_args['tax_query'][] = [
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array_map('sanitize_text_field', (array) $_POST['filters']['category']),
                'operator' => 'IN',
            ];
        }

        // Filtro por colecciones
        if (!empty($_POST['filters']['collections'])) {
            $parent_args['tax_query'][] = [
                'taxonomy' => 'collections',
                'field'    => 'slug',
                'terms'    => array_map('sanitize_text_field', (array) $_POST['filters']['collections']),
                'operator' => 'IN',
            ];
        }

        $parent_query = new WP_Query($parent_args);
        $processed_variations = []; // Para evitar duplicados
        $counter = 0;

        if ($parent_query->have_posts()) {
            ob_start();

            while ($parent_query->have_posts()) {
                $parent_query->the_post();
                global $product;

                // Obtener las variaciones del producto padre
                $variations = $product->get_available_variations();

                foreach ($variations as $variation) {
                    $variation_id = $variation['variation_id'];
                    $variation_obj = wc_get_product($variation_id);

                    // Si hay filtro de color, verificar que la variación coincida
                    if (!empty($color_filter)) {
                        $variation_color = $variation_obj->get_attribute('pa_colour');
                        $variation_term = get_term_by('name', $variation_color, 'pa_colour');

                       // Si el filtro de color es un array, usar in_array; de lo contrario, comparar directamente
                        if ( is_array($color_filter) ) {
                            if (!in_array(strtolower($variation_term->slug), array_map('strtolower', $color_filter))) {
                                continue; // Saltar si no coincide con ningún color del filtro
                            }
                        } else {
                            if (strtolower($variation_term->slug) !== strtolower($color_filter)) {
                                continue; // Saltar si no coincide con el color
                            }
                        }
                    }

                    // Evitar procesar la misma variación más de una vez
                    if (in_array($variation_id, $processed_variations)) {
                        continue;
                    }

                    // Mostrar la variación
                    $colour = $variation_obj->get_attribute('pa_colour');
                    mostrar_imagenes_variacion($product, $variation_id, $colour);
                    $processed_variations[] = $variation_id; // Marcar como procesada
                    $counter++;
                }
            }

            wp_send_json([
                'count'    => $counter,
                'products' => ob_get_clean(),
                'canLoadMore' => true,
            ]);
        } else {
            wp_send_json([
                'canLoadMore' => false,
            ]);
        }

        wp_reset_postdata();
        wp_die();

    }   else { // Sino usamos una $query solo para variaciones

                $page = sanitize_text_field($_POST['page']);

                $args = [
                    'post_type'      => 'product_variation',  // Solo variaciones
                    'orderby'        => 'meta_value_num',
                    'posts_per_page' => -1,
                    'post_status'    => 'publish',
                    'paged'          => $page,
                ];
        
                $queryVariation = new WP_Query($args);
        			$processed_variations = [];
                
        			if ( $queryVariation->have_posts() ) {
        				ob_start();
        				$counter = 0;
                
        				while ($queryVariation->have_posts()) {
        					$queryVariation->the_post();
                
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
        						mostrar_imagenes_variacion($parent_product, $variation_id, $colour);
        						$counter++;
                    
        						// Marcar esta variación como procesada
        						$processed_variations[] = $variation_id;
        					}
        				}
        
                        
                        wp_send_json([
                            'count'    => $queryVariation->found_posts, 
                            'products' => ob_get_clean(),
                            'canLoadMore' => true,
                        ]);
                
                
        			} else {
                        wp_send_json([
                            'canLoadMore' => false,
                        ]);
        			}
                
        			wp_reset_postdata();
                    wp_die();
            }
        

}