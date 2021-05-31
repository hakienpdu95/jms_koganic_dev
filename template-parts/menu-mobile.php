<?php $showAccount = koganic_get_option('show-header-account', 0); ?>
<?php $showLanguage = koganic_get_option('show-language-mobile-box', 0); ?>
<?php $showCurrency = koganic_get_option('show-currency-box', 0); ?>
<div class="koganic-mobile-menu">
    <div class="menu-title flex between-xs"><?php esc_html_e( 'MENU', 'koganic' ) ?><div class="close-menu-mobile"><span></span></div></div>
    <?php
    if ( has_nav_menu('primary-menu') ) {
        $args = array(
            'theme_location'  => 'primary-menu',
            'container_class' => 'mobile-menu-wrapper',
            'menu_class'      => 'mobile-menu',
        );
        wp_nav_menu( $args );
    }
    ?>

    <?php if ( $showLanguage == 1 ): ?>
        <div class="language-mobile">
            <?php echo koganic_language(); ?>
        </div>
    <?php endif; ?>

</div>
