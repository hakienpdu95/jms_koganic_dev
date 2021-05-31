<?php
global $product, $woocommerce_loop;


$product_hover_preset = koganic_get_option('wc-product-hover-presets', '2e2e2e');

if ( isset($_GET['hover_preset']) && $_GET['hover_preset'] != '' ) {
	$product_hover_preset = $_GET['hover_preset'];
}

$classes = '';
if ( get_option( 'woocommerce_enable_review_rating' ) == 'yes' && $product->get_rating_count() > 0 ) {
	$classes = 'has-stars';
}

?>

<div class="product-box <?php echo esc_attr( $classes ); ?> <?php echo 'product-preset-' . esc_attr( $product_hover_preset ); ?>">
	<div class="ImageOverlayCa"></div>
	<div class="product-thumb pr oh">
		<?php
		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 5
		 * @hooked woocommerce_show_product_loop_sale_flash - 10
		 * @hooked woocommerce_template_loop_product_thumbnail - 15
		 * @hooked koganic_second_product_thumbnail - 15
		 * @hooked woocommerce_template_loop_product_link_close - 20
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );

		?>
	</div>

	<div class="product-info">
		<?php
			koganic_product_categories();
		?>

		<?php
			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			
			do_action( 'woocommerce_shop_loop_item_title' );
		?>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
		
	</div>
	<?php if (is_shop() || is_archive()){  koganic_product_list_info(); } ?>
</div>
