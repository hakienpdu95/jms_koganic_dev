<?php
global $post, $product, $woocommerce_loop;

$show_quickview = koganic_get_option('wc-quick-view', 0);
$show_wishlist = koganic_get_option('wc-wishlist', 1);

$product_hover_preset = koganic_get_option('wc-product-hover-presets', '2e2e2e');

if ( isset($_GET['hover_preset']) && $_GET['hover_preset'] != '' ) {
	$product_hover_preset = $_GET['hover_preset'];
}

?>

<div class="product-box<?php echo ' product-preset-' . esc_attr( $product_hover_preset ); ?>">
	<div class="content-product-imagin"></div>
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
		do_action( 'woocommerce_shop_loop_item_title' ); 
		?>

		<?php
		/**
		 * woocommerce_after_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_price - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</div>

	<ul class="product-btn flex">
		<?php if ( $show_wishlist || class_exists( 'YITH_WCWL' ) ) { ?>
				<li class="btn-wishlist">
					<?php koganic_product_wishlist(); ?>
				</li>
			<?php }
		?>

		<?php
			$catalog_mode = koganic_get_option( 'catalog-mode', 0 );

			if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
		        $catalog_mode = 1;
		    }

		if ( !$catalog_mode ) : ?>
			<li class="addtocart-thumb"><?php woocommerce_template_loop_add_to_cart(); ?></li>
		<?php endif; ?>

		<?php if ( $show_quickview ) { ?><li class="button-quickview"><?php koganic_product_quickview(); ?></li><?php } ?>
	</ul>
	<?php if (is_shop() || is_archive()){  koganic_product_list_info(); } ?>
</div>
