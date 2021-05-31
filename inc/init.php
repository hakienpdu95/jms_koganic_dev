<?php
/*
* [ Theme Functions. ] - - - - - - - - - - - - - - - - - - - -
*/
require KOGANIC_PATH . '/inc/functions/theme.php';
require KOGANIC_PATH . '/inc/functions/helpers.php';
require KOGANIC_PATH . '/inc/functions/vc_functions.php';

/*
* [ Widgets. ] - - - - - - - - - - - - - - - - - - - -
*/
require KOGANIC_PATH . '/inc/widgets/recent_post.php';

/*
* [ WooCommerce Customizer. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( koganic_woocommerce_activated() ) require KOGANIC_PATH . '/inc/functions/woocommerce.php';

/*
* [ Theme Options. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( class_exists ( 'ReduxFramework' ) ) {
    require KOGANIC_PATH . '/inc/admin/theme-options.php';
}
require KOGANIC_PATH . '/inc/admin/tgm-functions.php';
require KOGANIC_PATH . '/inc/selectors.php';
