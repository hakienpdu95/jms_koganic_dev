<?php
    $showAccount        = koganic_get_option('show-header-account', 1);
    $showWishlistButton = koganic_get_option('show-wishlist-button', 0);
    $showCartButton     = koganic_get_option('show-cart-button', 1);
    $catalog_mode       = koganic_get_option('catalog-mode', 0);
    $header_menu_align  = koganic_get_option('header-menu-align', 'left');
    $header_design = koganic_get_option('header-layout', 1);
    $header_callphone = koganic_get_option( 'header-callphone' );
    $show_callphone = koganic_get_option( 'show-callphone', 0);


    if(is_page( 'home-7' )) {
        $header_menu_align = 'left';
        $showWishlistButton = 1;
        $show_callphone = 1;
    } elseif ( isset($_GET['menu_align']) && $_GET['menu_align'] != '' ) {
        $header_menu_align = $_GET['menu_align'];
    }

    if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
        $catalog_mode = 1;
    }

?>

<div class="container header-first">
    <div class="wrap-header">
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

        <div class="header-position box-search header-center hidden-md hidden-xs hidden-sm">
            <div class="header-block hidden-md hidden-sm hidden-xs">
                <div class="header-search btn-group woo-search">
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
       
        <!-- main-navigation -->
        <div class="header-position header-right text-right header-action">
            <?php if ( koganic_woocommerce_activated() && $showAccount == 1 ) : ?>
                <div class="header-block border-style site-header-account hidden-md hidden-sm hidden-xs">
                    <?php koganic_header_account(); ?>
                </div>
            <?php endif; ?>

            <?php if ( $showWishlistButton && koganic_woocommerce_activated() && class_exists( 'YITH_WCWL' ) ) : ?>
                <div class="header-block border-style hidden-md hidden-sm hidden-xs">
                    <?php koganic_wishlist(); ?>
                </div>
            <?php endif; ?>             

            <?php if ( koganic_woocommerce_activated() && $showCartButton && !$catalog_mode ) : ?>
                <div class="header-block border-style">
                    <?php koganic_header_cart(); ?>
                </div>
            <?php endif; ?>            
        </div>
        <!-- header-action -->
    </div>
</div>

<div class="header-menu hidden-md hidden-sm hidden-xs">
    <div class="container">
        <div class="wrap-header">
            <div class="header-position header-nav">
                <div class="header-block">
                    <div class="pt-menu-categories">
                        <button class="pt-dropdown-toggle">
                            <span class="pt-text"><?php echo esc_html_e('Shop By Categries','koganic'); ?></span>
                        </button>
                        <div class="pt-dropdown-menu">
                            <nav>
                                <?php if ( has_nav_menu('vertical-menu') ) : ?>
                                    <?php
                                        if ( class_exists('Koganic_Megamenu_Walker') ) {
                                            $menu = array(
                                                'theme_location'  => 'vertical-menu',
                                                'container_class' => 'vertical-menu-wrapper',
                                                'menu_class'      => 'koganic-menu vertical-menu',
                                                'walker'          => new Koganic_Megamenu_Walker,
                                            );
                                        } else {
                                            $menu = array(
                                                'theme_location'  => 'vertical-menu',
                                                'container_class' => 'vertical-menu-wrapper',
                                                'menu_class'      => 'koganic-menu vertical-menu',
                                            );
                                        }

                                        wp_nav_menu( $menu );
                                    ?>
                                <?php else : ?>
                                    <div class="vertical-menu-wrapper">
                                        <ul class="koganic-menu vertical-menu">
                                            <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'koganic' ) ?></a></li>
                                        </ul>
                                    </div>
                                <?php endif; ?>                                
                            </nav>
                        </div>            
                    </div>
                </div>  

                <div class="header-block">
                    <?php if ( has_nav_menu('primary-menu') ) : ?>
                        <?php
                            if ( class_exists('Koganic_Megamenu_Walker') ) {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'koganic-menu primary-menu menu-left',
                                    'walker'          => new Koganic_Megamenu_Walker,
                                );
                            } else {
                                $menu = array(
                                    'theme_location'  => 'primary-menu',
                                    'container_class' => 'primary-menu-wrapper',
                                    'menu_class'      => 'koganic-menu primary-menu menu-left',
                                );
                            }

                            wp_nav_menu( $menu );
                        ?>
                    <?php else : ?>
                        <div class="primary-menu-wrapper">
                            <ul class="koganic-menu primary-menu menu-left">
                                <li><a href="<?php echo esc_url(home_url( '/' )) . 'wp-admin/nav-menus.php?action=locations'; ?>"><?php esc_html_e( 'Select or create a menu', 'koganic' ) ?></a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>                              
            </div>

            <div class="header-position header-right header-action">
                <?php if(!empty($show_callphone) && isset($show_callphone) && $show_callphone == 1) : ?>
                    <div class="header-block">
                        <div class="callphone">
                            <span class="material-icons-outlined phone_in_talk"></span>
                            <span><?php echo koganic_header_layout_five_callphone(); ?></span>
                        </div>
                    </div>     
                <?php endif; ?>
            </div>            
        </div>
    </div>
</div>