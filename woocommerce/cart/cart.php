<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

 defined('ABSPATH') || exit;

 do_action('woocommerce_before_cart'); ?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<?php do_action( 'woocommerce_before_cart_contents' ); ?>
 
		<div class="custom-cart-table">
			<table class="shop_table cart" cellspacing="0">
				<thead>
					<tr>
						<th class="cart-image"><?php esc_html_e('Cart (' . WC()->cart->get_cart_contents_count() . ')', 'woocommerce'); ?></th>
						<th class="cart-product"><?php esc_html_e('Products', 'woocommerce'); ?></th>
						<th class="cart-details"><?php esc_html_e('Details', 'woocommerce'); ?></th>
						<th class="cart-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
						<th class="cart-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
						<th class="cart-subtotal"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
						$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
		
						if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
							?>
							<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
								<!-- Imagen del producto -->
								<td class="cart-image">
									<?php
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
									echo wp_kses_post($thumbnail);
									?>
								</td>
		
								<!-- Nombre del producto -->
								<td class="cart-product">
									<?php
									if (!$product_permalink) {
										echo wp_kses_post($_product->get_name());
									} else {
										echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
									}
									?>
								</td>
		
								<!-- Variaciones del producto -->
								<td class="cart-details">
								<?php
									if (!empty($cart_item['variation'])) {
										foreach ($cart_item['variation'] as $attribute_name => $attribute_value) {
											// Limpia el nombre del atributo eliminando el prefijo 'attribute_pa_'
											$formatted_name = wc_attribute_label(str_replace('attribute_pa_', '', $attribute_name));
											// Obtener el término (term) del atributo
											$taxonomy = str_replace('attribute_', '', $attribute_name);  // Obtiene el nombre del atributo sin el prefijo 'attribute_'
											$term = get_term_by('slug', $attribute_value, $taxonomy); // Busca el término por su valor y la taxonomía correspondiente

											// Muestra el atributo con su slug
											if ($term) {
												echo '<p>' . esc_html(ucfirst($formatted_name)) . ':' . esc_html($term->name) . '</p>';
											} else {
												echo '<p>' . esc_html(ucfirst($formatted_name)) . ':' . esc_html($attribute_value) . '</p>';
											}
										}
									} else {
										echo esc_html__('No variations', 'woocommerce');
									}
									?>
								</td>
		
								<!-- Cantidad + botón de eliminar -->
								<td class="cart-quantity">
									<div class="cart-quantity__inner">
										<?php
										if ($_product->is_sold_individually()) {
											echo '1';
										} else {
											woocommerce_quantity_input([
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $_product->get_max_purchase_quantity(),
												'min_value'    => '1',
												'product_name' => $_product->get_name(),
											], $_product);
										}
										?>
										<a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="remove" aria-label="<?php esc_attr_e('Remove this item', 'woocommerce'); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>">
											<?php esc_html_e('Remove', 'woocommerce'); ?>
										</a>
									</div>
								</td>
		
								<!-- Precio del producto -->
								<td class="cart-price">
									<?php
									echo wp_kses_post(WC()->cart->get_product_price($_product));
									?>
								</td>
		
								<!-- Subtotal -->
								<td class="cart-subtotal">
									<?php
									echo wp_kses_post(WC()->cart->get_product_subtotal($_product, $cart_item['quantity']));
									?>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>

		<?php do_action( 'woocommerce_cart_contents' ); ?>

		<!-- Botón de actualizar carrito -->
		<div class="cart-update-btn">
			<button type="submit" name="update_cart" value="Actualizar carrito" class="button-update-cart" >Actualizar carrito</button>
		</div>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		
		<!-- Cart Totals Wrapper -->
		<div class="cart-totals-wrapper">
			<?php woocommerce_cart_totals(); ?>
		</div>
</form>
 
 <?php do_action('woocommerce_after_cart'); ?>
