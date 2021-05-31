<?php
    $showAccount        = koganic_get_option('show-header-account', 1);
    $showCartButton     = koganic_get_option('show-cart-button', 1);
    $catalog_mode       = koganic_get_option('catalog-mode', 0);

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>
<div class="header-sticky-mobile header-wrapper">
    <div class="container">
        <div class="wrap-header">
            <div class="header-position menu-toggle">
                <div class="header-block">
                    <div class="menu-button">
                        <i class="icon-menu icons"></i>
                    </div>
                </div>
            </div>
            <!-- menu-toggle -->
            <div class="header-position header-left header-logo">
                <div class="header-block">
                    <?php koganic_logo(); ?>
                </div>
            </div>
            <!-- main-navigation -->
            <div class="header-position header-right header-action">          
                <?php if ( koganic_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                    <div class="header-block">
                        <?php koganic_header_cart(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- header-action -->
        </div>
    </div>
</div>