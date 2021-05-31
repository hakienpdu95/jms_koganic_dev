<?php
    global $product, $woocommerce_loop;

    $catalog_mode = koganic_get_option( 'catalog-mode', 0 );

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = $_GET['catalog-mode'];
    }
?>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 hotdeal-label"><?php esc_html_e('Deal of the day', 'koganic'); ?></div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-center">
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
<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 hotdeal-info">
    <?php

    /**
	 * woocommerce_shop_loop_item_title hook
	 *
	 * @hooked koganic_template_loop_product_title - 10
	 */

	do_action( 'woocommerce_shop_loop_item_title' );

    /**
     * woocommerce_after_shop_loop_item_title hook
     *
     * @hooked woocommerce_template_loop_price - 10
     */
    do_action( 'woocommerce_after_shop_loop_item_title' );

    woocommerce_template_single_excerpt();

    koganic_product_countdown_timer();

    if ( isset( $catalog_mode ) && $catalog_mode != 1 ) {
        woocommerce_template_loop_add_to_cart();
    }
    ?>
</div>