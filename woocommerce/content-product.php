<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product, $woocommerce_loop;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_view        = koganic_get_option('wc-product-view', 'grid');
$product_style       = koganic_get_option('wc-product-style', 1);
$product_style_thumb = koganic_get_option('wc-product-style-thumb', '1');
$product_thumb_hover = koganic_get_option('wc-product-image-hover', 1);
$product_spacing     = koganic_get_option('wc-gutter-space', 40);
$product_load_effect = koganic_get_option('wc-product-style-load', 'rollIn');

// Get product options
$options = get_post_meta( get_the_ID(), '_custom_wc_thumb_options', true );

// Classes array
$classes = array('product-item item');


if ( isset($_GET['gutter']) && $_GET['gutter'] != '' ) {
	$product_spacing = $_GET['gutter'];
}

// Product box style
if (isset($woocommerce_loop['type_product']) && ( $woocommerce_loop['style_product'] == '' ) && ( empty( $woocommerce_loop['style_product_list'] ) )) {
	$woocommerce_loop['type_product'] = $product_style;
}

if ( isset($_GET['style']) && $_GET['style'] != '' ) {
	$product_style = $_GET['style'];
}


if ( isset( $woocommerce_loop['style_product'] ) && ( $woocommerce_loop['style_product'] !== '' ) ) {
	$classes[] = 'product-style-' . $woocommerce_loop['style_product'];
} elseif ( isset( $woocommerce_loop['style_product'] ) && ( $woocommerce_loop['style_product'] == '' ) ) {
	$classes[] = 'product-style-' . $product_style;
} else {
	$classes[] = 'product-style-' . $product_style;
}

if ( isset( $woocommerce_loop['style_product_list'] ) && ( $woocommerce_loop['style_product_list'] !== '' ) ) {
	$classes[] = 'product-style-' . $woocommerce_loop['style_product_list'];
	$classes[] = 'product-style-list-box';
}

// Product box spacing bottom
if ( ! empty($woocommerce_loop['items_spacing']) && $woocommerce_loop['product_style'] != '1' ) {
	$classes[] = 'mb_' . $woocommerce_loop['items_spacing'];
} elseif( $product_style != '1' && $product_spacing ) {
	$classes[] = 'mb_' . $product_spacing;
}

// Product load
if ( isset($product_load_effect) && $product_load_effect !== '' ) {
	$classes[] = 'product-no-wpb_animate_when_almost_visible wpb_'. $product_load_effect .' '. $product_load_effect .' wpb_start_animation animated';
}


// Product thumb hover
if ( $product_thumb_hover == 1 ) {
	if ( ! empty( $woocommerce_loop['style_thumb'] ) ) {
		$classes[] = 'effect-thumb-' . $woocommerce_loop['style_thumb'];
		$style_thumb = $woocommerce_loop['style_thumb'];
	}else {
		$classes[] = 'effect-thumb-' . $product_style_thumb;
	}
}

?>

<div <?php post_class( $classes ); ?>>
	<?php 
	if ( koganic_wc_type_product('grid') && $woocommerce_loop['style_product'] != '' ) {
		wc_get_template_part( 'content-box/content', 'product-' . $woocommerce_loop['style_product'] ); 
	} elseif ( koganic_wc_type_product('list') ) {
		wc_get_template_part( 'content-box/content', 'product-' . $woocommerce_loop['style_product_list']); 
	}else{
		wc_get_template_part( 'content-box/content', 'product-' . $product_style );
	}
	?>
</div>