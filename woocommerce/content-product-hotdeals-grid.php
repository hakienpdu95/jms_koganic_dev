<?php
global $product, $woocommerce_loop;


$product_hover_preset = koganic_get_option('wc-product-hover-presets', '2e2e2e');

if ( isset($_GET['hover_preset']) && $_GET['hover_preset'] != '' ) {
    $product_hover_preset = $_GET['hover_preset'];
}

?>

<div class="product-box<?php echo ' product-preset-' . esc_attr( $product_hover_preset ); ?>">
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

        <ul class="product-btn in-thumb flex">

            <?php
                koganic_product_wishlist();
                koganic_product_compare();
                koganic_product_quickview();
            ?>
        </ul>
        <?php if(class_exists('TA_WC_Variation_Swatches' )) { ?>
            <div class="variation-attr">
                <div class="variation-attr_color">
                    <?php koganic_swatches_list_color();/*swatches color*/ ?>
                </div>
                <div class="variation-attr_image">
                    <?php koganic_swatches_list_image();/*swatches color*/ ?>
                </div>
            </div>
        <?php } ?>
        <?php
        if ( isset($woocommerce_loop['countdown']) && $woocommerce_loop['countdown'] == 'yes' ) {
            koganic_product_countdown_timer();
        }
        ?>
    </div>

    <div class="product-info">

        <?php 
        do_action( 'woocommerce_shop_loop_item_title' ); 
        koganic_product_categories();
        ?>

        <?php
        /**
         * woocommerce_after_shop_loop_item_title hook.
         *
         * @hooked woocommerce_template_loop_price - 10
         */
        do_action( 'woocommerce_after_shop_loop_item_title' );
        ?>
        <?php
            $catalog_mode = koganic_get_option( 'catalog-mode', 0 );

            if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
                $catalog_mode = 1;
            }

        if ( !$catalog_mode ) : ?>
            <div class="addtocart"><?php woocommerce_template_loop_add_to_cart(); ?></div>
        <?php endif; ?>
    </div>
</div>
