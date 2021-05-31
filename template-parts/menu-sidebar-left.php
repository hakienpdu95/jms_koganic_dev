<?php
$showLanguage = koganic_get_option('show-language-box', 0);
$showCurrency = koganic_get_option('show-currency-box', 0);

global $post;

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_page_options', true );

$layout = koganic_get_option( 'header-layout', 1 );

if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
    $layout = $options['page-header'];
}
?>

<?php if ( isset($layout) && $layout == 3 && has_nav_menu('primary-menu') ): ?>
    <div id="menu-toggle-left">
        <?php if ( $showLanguage == 1 || (koganic_woocommerce_activated() && $showCurrency == 1) ): ?>
            <div class="header-extra">
                <?php if ( $showLanguage == 1 ): ?>
                    <div class="header-block">
                        <?php echo koganic_language(); ?>
                    </div>
                <?php endif; ?>
                <?php if ( koganic_woocommerce_activated() && $showCurrency == 1 ) : ?>
                    <div class="header-block">
                        <?php echo koganic_currency(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- header-extra -->
        <?php endif; ?>
        <?php
            if ( class_exists('Koganic_Megamenu_Walker') ) {
                $menu = array(
                    'theme_location'  => 'primary-menu',
                    'container_class' => 'vertical-menu-wrapper',
                    'menu_class'      => 'koganic-menu vertical-menu',
                    'walker'          => new Koganic_Megamenu_Walker,
                );
            } else {
                $menu = array(
                    'theme_location'  => 'primary-menu',
                    'container_class' => 'vertical-menu-wrapper',
                    'menu_class'      => 'koganic-menu vertical-menu',
                );
            }

            wp_nav_menu( $menu );
        ?>
    </div>
<?php endif; ?>
