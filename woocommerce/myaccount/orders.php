<?php
/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.5.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_account_orders', $has_orders ); ?>

<?php

	$customer_orders = wc_get_orders([
		'customer' => get_current_user_id(),
		'limit'    => -1, // Obtener todos los pedidos
	]);

	if ( $has_orders ) :

	
		if (empty($customer_orders)) {
			echo '<p>' . esc_html__('No orders found.', 'woocommerce') . '</p>';
			return;
		}
		?>

		<div class="orders-list">
			<?php foreach ($customer_orders as $order): ?>
				<?php
					$order_id = $order->get_id();
					$order_date = wc_format_datetime($order->get_date_created());
					$order_status = wc_get_order_status_name($order->get_status());
					$order_total = $order->get_formatted_order_total();
					$order_items = $order->get_items();
				?>
				
				<div class="order-accordion">
					<button class="accordion-toggle">
						<span class="accordion-toggle__id">Orden #<?php echo esc_html($order_id); ?></span>
						<span class="accordion-toggle__date"><?php echo esc_html($order_date); ?></span>
						<span class="accordion-toggle__status">Status: <?php echo esc_html($order_status); ?></span>
						<?php echo $order_total; ?>
						<span class="accordion-toggle__plus-minus-toggle collapsed"></span>
					</button>
					
					<div class="accordion-content">
						<?php foreach ($order_items as $item_id => $item): ?>
							<?php
							$order_item = new WC_Order_Item_Product( $item[ 'id' ] );

							$product = wc_get_product( $item[ 'product_id' ] );
							$product_id = $item[ 'product_id' ];
							$variation_id = $item[ 'variation_id' ];
							$quantity = $item[ 'qty' ];
							$item_total = $item[ 'total' ];
							$image_url = get_the_post_thumbnail_url($product_id, 'thumbnail');
							$variation_data = $item->get_meta_data();
							
							// Obtener imagen de variación (si aplica)
							$variation_id = $item[ 'variation_id' ];
							if ($variation_id) {
								$variation_galleries = get_field('variation_galleries', $product->get_id());
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
									<div class="order-item__details-content">
										<?php if (!empty($variation_data)): ?>
											<div class="order-item__details-content">
												<?php foreach ($variation_data as $meta): ?>
													<?php
														$meta_array = $meta->get_data(); // Extrae los datos
														$key = $meta_array['key']; // Clave del atributo (ej: "pa_colour")
														$value = $meta_array['value']; // Valor del atributo (ej: "silver")

														// Verificar si el atributo pertenece a una variación
														if (strpos($key, 'pa_') !== false):
															$attribute_slug = str_replace('pa_', '', $key);
															$attribute_name = wc_attribute_label($attribute_slug);
													?>
															<p class="order-item__details-text"><?php echo esc_html(ucfirst( $attribute_name )); ?>: <?php echo esc_html($value); ?></p>
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
								<div class="order-item__wrapper-price">
									<p class="order-item__price"><?php echo wc_price($item_total); ?></p>
								</div>
							</div>

						<?php endforeach; ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<script>
			document.addEventListener("DOMContentLoaded", function () {

				jQuery( '.accordion-content' ).slideUp();

				document.querySelectorAll(".accordion-toggle").forEach(button => {
					button.addEventListener("click", function ( e ) {

						const currentPlusMinus = jQuery( this ).find( '.accordion-toggle__plus-minus-toggle' );
						const content = this.nextElementSibling;
						
						this.classList.toggle("active");
						currentPlusMinus[0].classList.toggle( 'collapsed' );
						jQuery( content ).slideToggle();

					});
				});
			});
		</script>

<?php else : ?>

	<?php wc_print_notice( esc_html__( 'No order has been made yet.', 'woocommerce' ) . ' <a class="woocommerce-Button wc-forward button' . esc_attr( $wp_button_class ) . '" href="' . esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ) . '">' . esc_html__( 'Browse products', 'woocommerce' ) . '</a>', 'notice' ); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment ?>

<?php endif; ?>

<?php do_action( 'woocommerce_after_account_orders', $has_orders ); ?>
