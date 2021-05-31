<?php
    $showAccount        = koganic_get_option('show-header-account', 1);
    $showSearchForm     = koganic_get_option('show-search-form', 1);

    $showCartButton     = koganic_get_option('show-cart-button', 1);
    $catalog_mode       = koganic_get_option('catalog-mode', 0);
    $header_menu_align  = koganic_get_option('header-menu-align', 'center');

    $header_design      = koganic_get_option('header-layout', 3);
    

    if(is_page( 'home-3' )) {
        $header_menu_align = 'right';
    } elseif(is_page( 'home-4' )) {
        $header_menu_align = 'center';
    } elseif ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>

<div class="container">
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
        <div class="header-position menu-nav navigation-<?php echo esc_attr($header_menu_align); ?> hidden-md hidden-xs hidden-sm">
            <div class="header-block">
                <?php if ( has_nav_menu('primary-menu') ) : ?>
                    <?php
                        if ( class_exists('Koganic_Megamenu_Walker') ) {
                            $menu = array(
                                'theme_location'  => 'primary-menu',
                                'container_class' => 'primary-menu-wrapper',
                                'menu_class'      => 'koganic-menu primary-menu',
                                'walker'          => new Koganic_Megamenu_Walker,
                            );
                        } else {
                            $menu = array(
                                'theme_location'  => 'primary-menu',
                                'container_class' => 'primary-menu-wrapper',
                                'menu_class'      => 'koganic-menu primary-menu',
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
        <!-- main-navigation -->
        <div class="header-position header-right text-right header-action">
            <div class="header-block search-block desctop hidden-md hidden-sm hidden-xs">
                <div id="header-search-3" class="koganic-box-dropdown header-search btn-group">
                    <?php locate_template('template-parts/search.php', true);?>
                </div>
            </div>

            <?php if ( koganic_woocommerce_activated() && $showAccount == 1 ) : ?>
                <div class="header-block site-header-account hidden-md hidden-sm hidden-xs">
                    <?php echo koganic_header_account(); ?>
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