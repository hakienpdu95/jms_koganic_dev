<?php $header_menu_align  = koganic_get_option('header-menu-align', 'left'); ?>
<div class="menu-popup">
    <div class="menu-popup-box">
        <div class="menu-title"><?php esc_html_e( 'MENU', 'koganic' ) ?><div class="close-menu-popup"></div></div>
        <?php if ( has_nav_menu('primary-menu') ) : ?>
            <?php
                if ( class_exists('Koganic_Megamenu_Walker') ) {
                    $menu = array(
                        'theme_location'  => 'primary-menu',
                        'container_class' => 'primary-menu-wrapper',
                        'menu_class'      => 'koganic-menu vertical-menu',
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