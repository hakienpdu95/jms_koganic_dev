<div class="koganic-mobile-menu">
    <div class="menu-title flex between-xs"><?php esc_html_e( 'MENU', 'koganic' ) ?><div class="close-menu-mobile"><span></span></div></div>
    <?php
    if ( has_nav_menu('landing-menu') ) {
        $args = array(
            'theme_location'  => 'landing-menu',
            'container_class' => 'mobile-menu-wrapper',
            'menu_class'      => 'mobile-menu',
        );
        wp_nav_menu( $args );
    }
    ?>
</div>
