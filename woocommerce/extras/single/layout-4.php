<?php 
global $post, $woocommerce, $product;

$tabs_layout = $hide_sticky_addtocart = $share_toolbox = '';

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$tabs_layout = koganic_get_option('product-tab-layout', 'tabs');


$sticky_addtocart = koganic_get_option('wc-product-sticky-addtocart', 0);
if ( isset($sticky_addtocart) && $sticky_addtocart == 0 ) {
	$hide_sticky_addtocart = 'hide-sticky-addtocart-bottom';
}

if ( isset( $_GET['woo-tab'] ) && $_GET['woo-tab'] != '' ) {
	$tabs_layout = $_GET['woo-tab'];
}

if( ( isset($position_accordion) && $position_accordion == 'bottom' ) || ( isset($tabs_layout) && $tabs_layout == 'tabs' ) ){
	$share_toolbox = 'custom-share-toolbox';
}


?>

<div id="jms-column-one" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 column-left smart-sidebar">
	<div class="theiaStickySidebar">
		<div class="summary entry-summary info-summary summary-one">
			<?php
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 15);
				add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 6);
				add_action( 'woocommerce_single_product_summary', 'woocommerce_show_product_sale_flash', 3);

				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
				// remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
				/**
				 * woocommerce_single_product_summary hook.
				 *
				 * @hooked woocommerce_template_single_title - 5
				 * @hooked woocommerce_template_single_rating - 10
				 * @hooked woocommerce_template_single_price - 10
				 * @hooked woocommerce_template_single_excerpt - 20
				 * @hooked woocommerce_template_single_add_to_cart - 30
				 * @hooked woocommerce_template_single_meta - 40
				 * @hooked woocommerce_template_single_sharing - 50
				 * @hooked WC_Structured_Data::generate_product_data() - 60
				 */
				do_action( 'woocommerce_single_product_summary' );
			?>

		</div><!-- .summary -->		
	</div>
</div>

<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 column-center">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook.
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
</div>

<div id="jms-column-two" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 column-right smart-sidebar">
	<div class="theiaStickySidebar">
		<div class="summary entry-summary info-summary summary-two">

			<?php
				woocommerce_template_single_add_to_cart();
			?>
			
		</div><!-- .summary -->
	</div>
</div>