<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version     3.3.0
 */

global $woocommerce_loop;

$classes = array('wc-product-pagination_type');

$product_columns = koganic_get_option( 'wc-product-column', 4 );
$product_view    = koganic_get_option( 'wc-product-view', 'grid' );
$product_spacing = koganic_get_option( 'wc-gutter-space', 40 );
$pagination_type = koganic_get_option( 'wc-pagination-type', 'number' );

// DEMO
if ( isset($_GET['layout']) && $_GET['layout'] != '' ) {
	$product_design = $_GET['layout'];
}
if ( isset( $_GET['product_view'] ) && $_GET['product_view'] != '' ) {
	$product_view = $_GET['product_view'];
}

if ( isset($_GET['gutter']) && $_GET['gutter'] != '' ) {
	$product_spacing = $_GET['gutter'];
}

if ( isset($_GET['per_row']) && $_GET['per_row'] != '' ) {
	$product_columns = $_GET['per_row'];
}


if ( isset($woocommerce_loop['items_spacing']) && !empty( $woocommerce_loop['items_spacing'] ) ) {
    $classes[] = 'layout-spacing-' . $woocommerce_loop['items_spacing'];
} else {
    $classes[] = 'layout-spacing-' . $product_spacing;
}

	$classes[] = 'layout-columns-' . $product_columns;


?>
<div class="product-layout-wrapper <?php echo esc_attr($product_view.'-view') ?>">
	<div class="wc-loading w-30"></div>
	<div class="products product-layout clearfix <?php echo implode(' ', $classes); ?>" >
