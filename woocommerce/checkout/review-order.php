<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
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

defined( 'ABSPATH' ) || exit;
?>
<table class="shop_table woocommerce-checkout-review-order-table">
	<tbody>
        <?php

		do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $product = $cart_item['data'];
            $product_id = $cart_item['product_id'];
            $variation_id = !empty($cart_item['variation_id']) ? $cart_item['variation_id'] : null;
            $image_url = get_the_post_thumbnail_url($product_id, 'thumbnail'); // Imagen por defecto

            // Si hay una variación seleccionada, obtenemos la imagen desde ACF
            if ($variation_id) {
                $variation_galleries = get_field('variation_galleries', $product_id);
                if (!empty($variation_galleries)) {
                    foreach ($variation_galleries as $gallery) {
                        if ($gallery['variation_id'] == $variation_id) {
                            $gallery_images = $gallery['gallery'];
                            if (!empty($gallery_images[0]['url'])) {
                                $image_url = $gallery_images[0]['url']; // Primera imagen de la galería
                            }
                            break;
                        }
                    }
                }
            }
            ?>
            <tr class="cart-item">
                <td class="cart-item__image">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>">
                </td>
                <td class="cart-item__details">
                    <p class="cart-item__details-text"><?php echo strstr( $product->get_name(), " -", true ); ?></p>
					<div class="cart-item__details-content">
						<?php
						if (isset($cart_item['variation']) && is_array($cart_item['variation'])) {
							foreach ($cart_item['variation'] as $key => $value) {
								$attribute_slug = str_replace('attribute_', '', $key);
								$attribute_name = wc_attribute_label($attribute_slug);
								$term = get_term_by('slug', $value, $attribute_slug);
								$attribute_value = ($term) ? $term->name : ucfirst($value);
								echo '<p class="cart-item__details-text">' . esc_html($attribute_name) . ': ' . esc_html($attribute_value) . '</p>';
							}
						}
						?>
						<div class="cart-item__wrapper-cart-quantity">
							<span class="cart-item__span-quantity">Quantity:</span>
							<span><?php echo esc_html($cart_item['quantity']); ?></span>
						</div>
					</div>
                </td>
                <td class="cart-item__price">
                    <p><?php echo wc_price($cart_item['line_total']); ?></p>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
	<tfoot>

		<tr class="cart-subtotal">
			<th><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_subtotal_html(); ?></td>
		</tr>

		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

			<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

			<?php wc_cart_totals_shipping_html(); ?>

			<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

		<?php endif; ?>

		<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
			<tr class="fee">
				<th><?php echo esc_html( $fee->name ); ?></th>
				<td><?php wc_cart_totals_fee_html( $fee ); ?></td>
			</tr>
		<?php endforeach; ?>

		<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
			<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
				<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
					<tr class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<th><?php echo esc_html( $tax->label ); ?></th>
						<td><?php echo wp_kses_post( $tax->formatted_amount ); ?></td>
					</tr>
				<?php endforeach; ?>
			<?php else : ?>
				<tr class="tax-total">
					<th><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></th>
					<td><?php wc_cart_totals_taxes_total_html(); ?></td>
				</tr>
			<?php endif; ?>
		<?php endif; ?>

		<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

		<tr class="order-total">
			<th><?php esc_html_e( 'Total', 'woocommerce' ); ?></th>
			<td><?php wc_cart_totals_order_total_html(); ?></td>
		</tr>

		<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>

	</tfoot>
</table>
