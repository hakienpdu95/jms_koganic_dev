<?php
/**
 * Product loop sale flash
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/sale-flash.php.
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

global $post, $product;

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

$onsale_style = koganic_get_option('wc-product-onsale', 'txt');

if ( $product->is_on_sale() ) : ?>
		<?php 
		if ( is_array($options) && isset($options['wc-new-label']) && $options['wc-new-label'] !== '' ) { ?>
			<span class="badge new pa tc dib"><span class="new"><?php echo esc_html($options['wc-new-label']); ?></span></span>
		<?php

		} elseif ( isset($onsale_style) && $onsale_style == 'pct' ) {
			$sale_percent = koganic_product_get_sale_percent( $product ); 
			
			
			 if ( $sale_percent > 0 ) { ?>
				<span class="badge pa tc dib">
				<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html( $sale_percent ). '<span class="onsale-after">%</span></span>', $post, $product ); ?>
				</span>
			<?php } ?>
			
		<?php } else { ?>
			<span class="badge pa tc dib">
			<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale">' . esc_html__( 'Sale', 'koganic' ) . '</span>', $post, $product ); ?>
			</span>
		<?php }?>
<?php endif; ?>
