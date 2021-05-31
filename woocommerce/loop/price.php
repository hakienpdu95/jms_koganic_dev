<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

$product_style = koganic_get_option('wc-product-style');
if ( !empty($woocommerce_loop['style_product']) ) {
	$product_style = $woocommerce_loop['style_product'];
}

$el_style = array('el-price');

$el_style[] = 'el--style-'.esc_html($product_style).'';

if ( $product->is_on_sale() ) {
	$el_style[] = 'koganic_woocommerce_time_sale';
}
?>

<?php if($product_style == '6') { koganic_product_categories();	} ?>

<div class="<?php echo implode(' ', $el_style); ?>">	
	<?php echo (koganic_wc_style_product_add_to_cart()) ? '<div class="product_after_shop_loop_switcher">' : ''; ?>
		
		<?php if($product_style == '3') { ?>
			<div class="product-group-button">
				<div class="loop-add-to-cart"><?php woocommerce_template_loop_add_to_cart(); ?></div>
		<?php } ?>

	    <span class="price">
			<?php if ( $price_html = $product->get_price_html() ) :
				echo ''. $price_html;
			endif; ?>
		</span>

		<?php if($product_style == '3') { ?>
				<div class="button-in quickshop"><?php koganic_product_quickview(); ?></div>
			</div>			
		<?php } ?>
		
		<?php 
			if(koganic_wc_style_product_add_to_cart()) {
				woocommerce_template_loop_add_to_cart();
			}
		?>	
	<?php echo (koganic_wc_style_product_add_to_cart()) ? '</div>' : ''; ?>
</div>
