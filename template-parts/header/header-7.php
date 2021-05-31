<?php
    $showAccount        = koganic_get_option('show-header-account', 1);
    $showSearchForm     = koganic_get_option('show-search-form', 1);
    $showWishlistButton = koganic_get_option('show-wishlist-button', 1);
    $showCartButton     = koganic_get_option('show-cart-button', 1);
    $catalog_mode       = koganic_get_option('catalog-mode', 0);
    $header_menu_align  = koganic_get_option('header-menu-align', 'left');
    $showLanguage = koganic_get_option('show-language-box', 0);
    $showCurrency = koganic_get_option('show-currency-box', 0);
    $header_design = koganic_get_option('header-layout', 1);

    if ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>

<div class="container-fluid first">
    <div class="wrap-header color-black">
        <div class="header-position hidden-lg menu-toggle">
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
        <div class="header-position header-right text-right header-action">
            <div class="header-block box-search hidden-md hidden-sm hidden-xs">
                <div id="header-search-7" class="header-search btn-group mt-svg woo-search">
                    <?php
                    if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                        echo do_shortcode('[woocommerce_ajax_search]');
                    } else {
                        get_search_form();
                    }
                    ?>
                </div>
            </div>            
            <?php if ( koganic_woocommerce_activated() && $showAccount == 1 ) : ?>
                <div class="header-block account-icon hidden-md hidden-sm hidden-xs">
                    <?php echo koganic_my_account(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $showWishlistButton && koganic_woocommerce_activated() && class_exists( 'YITH_WCWL' ) ) : ?>
                <div class="header-block hidden-md hidden-sm hidden-xs">
                    <?php koganic_wishlist(); ?>
                </div>
            <?php endif; ?>            

            <?php if ( koganic_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                <div class="header-block">
                    <?php koganic_header_cart(); ?>
                </div>
            <?php endif; ?>                      
        </div>
        <!-- header-action -->
    </div>
</div>

<div class="container-fluid line"></div>

<div class="header-menu hidden-md hidden-xs hidden-sm second">
    <div class="container-fluid">
        <div class="wrap-header menu-header-7">
            <div class="header-position header-left">
                <div class="header-block">
                    <?php if ( has_nav_menu('primary-menu') ) : ?>
                        <?php
                            if ( class_exists('Koganic_Megamenu_Walker') ) {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'koganic-menu primary-menu menu-center',
                                    'walker'          => new Koganic_Megamenu_Walker,
                                );
                            } else {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'koganic-menu primary-menu menu-center',
                                );
                            }

                            wp_nav_menu( $menu );
                        ?>
                    <?php else : ?>
                        <div class="primary-menu-wrapper">
                            <ul class="koganic-menu primary-menu menu-<?php echo esc_attr($header_menu_align); ?>">
                                <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'koganic' ) ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>                
            </div>

            <div class="header-position header-right header-action">
                <div class="header-block socials">
                    <?php koganic_social_icons(); ?>
                </div>
                <?php if ( $showLanguage == 1 ): ?>
                    <div class="header-block hidden-md hidden-sm hidden-xs language">
                        <?php echo koganic_language(); ?>
                    </div>
                <?php endif; ?>                 
                <?php if ( koganic_woocommerce_activated() && class_exists('Jms_Currency') && $showCurrency == 1 ) : ?>
                    <div class="header-block hidden-md hidden-sm hidden-xs currency">
                        <?php echo koganic_currency(); ?>
                    </div>
                <?php endif; ?>                 
            </div>
        </div>

    </div>
</div>