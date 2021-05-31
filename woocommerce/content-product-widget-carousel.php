<div class="list-product">
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
