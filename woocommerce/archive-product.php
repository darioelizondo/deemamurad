<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
wp_enqueue_script( 'jquery.espy' );
wp_enqueue_script( 'deemamurad.shop-filters' );

?>

<div class="woocommerce-shop container">

	<?php

	/**
	 * Hook: woocommerce_before_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 * @hooked WC_Structured_Data::generate_website_data() - 30
	 */
	do_action( 'woocommerce_before_main_content' );

	/**
	 * Hook: woocommerce_shop_loop_header.
	 *
	 * @since 8.6.0
	 *
	 * @hooked woocommerce_product_taxonomy_archive_header - 10
	 */
	do_action( 'woocommerce_shop_loop_header' );

	if ( woocommerce_product_loop() ) {

		/**
		 * Hook: woocommerce_before_shop_loop.
		 *
		 * @hooked woocommerce_output_all_notices - 10
		 * @hooked woocommerce_result_count - 20
		 * @hooked woocommerce_catalog_ordering - 30
		 */
		do_action( 'woocommerce_before_shop_loop' );

		woocommerce_product_loop_start();

		if ( wc_get_loop_prop( 'total' ) ) {

			$args = [
				'post_type'      => 'product_variation',  // Solo variaciones
				'orderby'        => 'meta_value_num',
				'posts_per_page' => 12,
				'post_status'    => 'publish',
			];

			$query = new WP_Query($args);
			$processed_variations = [];

			// echo $query->found_posts;
		
			if ( $query->have_posts() ) {
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
						mostrar_imagenes_variacion($parent_product, $variation_id, $colour , $quantity);
						$counter++;
			
						// Marcar esta variación como procesada
						$processed_variations[] = $variation_id;
					}
				}
		
		
			} else {
				echo 'No products were found matching your selection';
			}
		
			wp_reset_postdata();
		}

		woocommerce_product_loop_end();

		?>

		<!-- Loading -->
		<div class="products__loading container" style="display: none">
			<img class="products__image-loading" src="<?php echo TDU . '/assets/images/loading/loading-deemamurad.gif' ?>" alt="Loading">
		</div>
		<!-- Trigger -->
		<div class="products__trigger container" id="products-trigger"></div>

		<?php

		/**
		 * Hook: woocommerce_after_shop_loop.
		 *
		 * @hooked woocommerce_pagination - 10
		 */
		do_action( 'woocommerce_after_shop_loop' );
	} else {
		/**
		 * Hook: woocommerce_no_products_found.
		 *
		 * @hooked wc_no_products_found - 10
		 */
		do_action( 'woocommerce_no_products_found' );
	}

	/**
	 * Hook: woocommerce_after_main_content.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );

	/**
	 * Hook: woocommerce_sidebar.
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );

	?>

</div>

<?php

get_footer( 'shop' );
