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
			while ( have_posts() ) {
				the_post();

				/**
				 * Hook: woocommerce_shop_loop.
				 */
				do_action( 'woocommerce_shop_loop' );

				$item_id = get_the_ID();
				$main_image = get_the_post_thumbnail_url($item_id, 'large');

				// Obtener la primera imagen de la galería
				$gallery_images = get_post_meta($item_id, '_product_image_gallery', true);
				$gallery_images = explode(',', $gallery_images);
				$second_image = !empty($gallery_images[0]) ? wp_get_attachment_url($gallery_images[0]) : $main_image;
				$filters_terms = get_the_terms( $item_id, 'filters' );
				$filters_text = !empty( $filters_terms ) ? implode(', ', wp_list_pluck( $filters_terms, 'name' ) ) : 'Without filters';

				// Incluir la plantilla personalizada
				include TD . '/template-parts/components/molecules/product-item.php';

				unset($item_id, $main_image, $second_image, $filters_text);
			}
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
