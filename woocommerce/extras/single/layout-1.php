<?php 
global $post, $woocommerce, $product;

$tabs_layout = '';

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$tabs_layout = koganic_get_option('product-tab-layout', 'tabs');


if ( isset( $_GET['woo-tab'] ) && $_GET['woo-tab'] != '' ) {
	$tabs_layout = $_GET['woo-tab'];
}

?>
<div id="jms-column-left" class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-left">
	<?php
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
</div>
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 column-right">
	<div class="summary entry-summary info-summary">
		<?php koganic_label_single_product(); ?>
		<?php
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);

			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 9);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 11);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 12);
			add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 3);

			/**
			 * woocommerce_single_product_summary hook.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_meta - 15
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_price - 25
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div><!-- .summary -->
</div>
