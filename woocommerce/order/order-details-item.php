<?php
/**
 * Order Item Details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details-item.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! apply_filters( 'woocommerce_order_item_visible', true, $item ) ) {
	return;
}
?>
<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_order_item_class', 'woocommerce-table__line-item order_item', $item, $order ) ); ?>">

	<td class="woocommerce-table__product-name product-name">
		<?php
		 $product = $item->get_product();
		 $product_id = $product ? $product->get_id() : 0;
		 $variation_id = $item->get_variation_id();
		 $quantity = $item->get_quantity();
		 $item_total = $item->get_total();
		 $image_url = $product_id ? get_the_post_thumbnail_url($product_id, 'thumbnail') : '';

		 // Obtener los metadatos de la variación
		 $variation_data = $item->get_meta_data();

		 // Obtener imagen de variación (si aplica)
		 $variation_id = $item[ 'variation_id' ];
		 if ($variation_id) {
			 $variation_galleries = get_field('variation_galleries', $item->get_product_id());
			 if (!empty($variation_galleries)) {
				 foreach ($variation_galleries as $gallery) {
					 if ($gallery['variation_id'] == $variation_id) {
						 $gallery_images = $gallery['gallery'];
						 if (!empty($gallery_images[0]['url'])) {
							 $image_url = $gallery_images[0]['url'];
						 }
						 break;
					 }
				 }
			 }
		 }

	 ?>
		 <div class="order-item">
			 <div class="order-item__wrapper-image">
				 <img class="order-item__image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
			 </div>
			 <div class="order-item__details">
				 <p class="order-item__details-text"><?php echo esc_html($product->get_name()); ?></p>
				 
				 <?php if (!empty($variation_data)): ?>
					 <div class="order-item__details-content">
						 <?php foreach ($variation_data as $meta): ?>
							 <?php
								 $meta_array = $meta->get_data();
								 $key = $meta_array['key'];
								 $value = $meta_array['value'];

								 if (strpos($key, 'attribute_') !== false):
									 $attribute_slug = str_replace('attribute_', '', $key);
									 $attribute_name = wc_attribute_label($attribute_slug);
							 ?>
									 <p class="order-item__details-text"><?php echo esc_html($attribute_name); ?>: <?php echo esc_html($value); ?></p>
							 <?php endif; ?>
						 <?php endforeach; ?>
					 </div>
				 <?php endif; ?>

				 <div class="order-item__wrapper-order-quantity">
					 <span class="order-item__span-quantity">Cantidad:</span>
					 <span><?php echo esc_html($quantity); ?></span>
				 </div>
			 </div>
		 </div>
	</td>

	<td class="woocommerce-table__product-total product-total">
		<?php echo $order->get_formatted_line_subtotal( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	</td>

</tr>

<?php if ( $show_purchase_note && $purchase_note ) : ?>

<tr class="woocommerce-table__product-purchase-note product-purchase-note">

	<td colspan="2"><?php echo wpautop( do_shortcode( wp_kses_post( $purchase_note ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></td>

</tr>

<?php endif; ?>
