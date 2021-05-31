<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div <?php wc_product_cat_class( '', $category ); ?>>
	<div class="category-image-wrapp item-effect">
		<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>" class="category-image">
			<?php
				/**
				 * woocommerce_before_subcategory_title hook
				 *
				 * @hooked mazza_category_thumb_double_size - 10
				 */
				do_action( 'woocommerce_before_subcategory_title', $category );
			?>
		</a>
	</div>
	<div class="hover-mask">
		<a href="<?php echo esc_url( get_term_link( $category->slug, 'product_cat' ) ); ?>">
		<?php
			echo esc_html( $category->name );
		?>
		</a>
		<p class="count"><?php if ( $category->count > 0 ) echo apply_filters( 'woocommerce_subcategory_count_html', ' <span >' . esc_html( $category->count ). ' </span>', $category ); echo esc_html__('Product', 'koganic'); ?></p>
		<?php
			/**
			 * woocommerce_after_subcategory_title hook
			 */
			do_action( 'woocommerce_after_subcategory_title', $category );
		?>
	</div>
</div>
