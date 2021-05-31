<?php
    $showSearchForm     = koganic_get_option('show-search-form', 1);
    $showCartButton     = koganic_get_option('show-cart-button', 1);
    $catalog_mode       = koganic_get_option('catalog-mode', 0);
    $header_menu_align  = koganic_get_option('header-menu-align', 'left');
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
        <div class="header-position header-left hidden-md hidden-sm hidden-xs">
            <div class="header-block box-search">
                <div id="header-search-11" class="header-search btn-group mt-svg woo-search">
                    <?php
                    if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                        echo do_shortcode('[woocommerce_ajax_search]');
                    } else {
                        get_search_form();
                    }
                    ?>
                </div>
            </div>              
        </div>

        <div class="header-position header-center header-logo">
            <div class="header-block">
                <?php koganic_logo(); ?>
            </div>            
        </div>
        <!-- main-navigation -->
        <div class="header-position header-right text-right header-action">         
            <div class="header-block hidden-md hidden-sm hidden-xs">
                <nav class="header-11-navigation">
                    <?php if ( has_nav_menu('header-11-menu') ) : ?>
                        <?php
                            if ( class_exists('Koganic_Megamenu_Walker') ) {
                                $menu = array(
                                    'theme_location'  => 'header-11-menu',
                                    'container_class' => 'header-11-menu-wrapper',
                                    'menu_class'      => 'koganic-menu header-11-menu-flex menu-right',
                                    'walker'          => new Koganic_Megamenu_Walker,
                                );
                            } else {
                                $menu = array(
                                    'theme_location'  => 'header-11-menu',
                                    'container_class' => 'header-11-menu-wrapper',
                                    'menu_class'      => 'koganic-menu header-11-menu-flex menu-right',
                                );
                            }

                            wp_nav_menu( $menu );
                        ?>
                    <?php else : ?>
                        <div class="header-11-menu-wrapper">
                            <ul class="koganic-menu header-11-menu-flex menu-right">
                                <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'koganic' ) ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>                                
                </nav>                
            </div>
            <?php if ( koganic_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                <div class="header-block">
                    <?php koganic_header_cart(); ?>
                </div>
            <?php endif; ?>                      
        </div>
        <!-- header-action -->
    </div>
</div>

<div class="container-line"></div>

<div class="header-menu hidden-md hidden-xs hidden-sm second">
    <div class="container-fluid">
        <div class="wrap-header menu-header-11">
            <div class="header-position header-center">
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
        </div>

    </div>
</div>