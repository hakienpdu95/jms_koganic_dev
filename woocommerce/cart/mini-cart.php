<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<h3 class="title-mini-cart"><?php esc_html_e( 'My Cart', 'koganic' ); ?></h3>
	<div class="scrollbar_cart <?php if(WC()->cart->cart_contents_count > 2) echo 'perfectScrollbar'; ?>">
	<ul class="cart_list <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php do_action( 'woocommerce_before_mini_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
				<li class="woocommerce-mini-cart-item clearfix <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="preview-image pr">
						<a href="<?php echo esc_url( $product_permalink ); ?>">
							<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
						</a>
						<?php
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove hidden" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-item-key="%s"><i class="pe-7s-close"></i></a>',
							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
							esc_attr__( 'Remove this item', 'koganic' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() ),
							$cart_item_key
						), $cart_item_key );
						?>
					</div>
					<div class="desc">
						<div class="pt-info-mini-cart-item">
							<a href="<?php echo esc_url( $product_permalink ); ?>" class="product_name"><?php echo esc_html($product_name); ?></a>
							<span class="cart-price db"><?php echo apply_filters('woocommerce_widget_cart_item_quantity',  sprintf('%s', $product_price) , $cart_item, $cart_item_key); ?></span>
							<div class="mini-item-remove">
								<?php echo WC()->cart->get_item_data( $cart_item ); ?>
								<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '&times; %s', $cart_item['quantity'] ) . '</span>', $cart_item, $cart_item_key ); ?>								
								
								<div class="quantity-remove">
									<?php
									echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s" data-item-key="%s"><i class="fa fa-trash-o"></i></a>',
										esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
										esc_attr__( 'Remove this item', 'koganic' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() ),
										$cart_item_key
									), $cart_item_key );
									?>
								</div>
							</div>
						</div>
					</div>
				</li>
				<?php
			}
		}
		?>
		<?php do_action( 'woocommerce_mini_cart_contents' ); ?>
	</ul><!-- end product list -->
	</div>
	<div class="cart-bottom-box">
		<p class="total"><?php esc_html_e( 'Subtotal', 'koganic' ); ?>: <?php echo WC()->cart->get_cart_subtotal(); ?></p>

		<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

		<p class="buttons">
			<?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?>
		</p>

	</div>
<?php else : ?>
	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'koganic' ); ?></p>
<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
