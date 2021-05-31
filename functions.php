<?php
/**
 * Theme constants definition and functions.
*/

// Constants definition
define( 'KOGANIC_PATH', get_template_directory() );
define( 'KOGANIC_URL',  get_template_directory_uri() );
define( 'KOGANIC_DUMMY',  KOGANIC_PATH . '/inc/admin/data' );
define( 'KOGANIC_VERSION', '1.0.0' );

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue styles
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'koganic_enqueue_styles' ) ) {
    function koganic_enqueue_styles() {
        wp_dequeue_style( 'yith-wcwl-font-awesome' );
        // Add custom fonts, used in the main stylesheet.
        wp_enqueue_style( 'koganic-fonts', koganic_enqueue_google_fonts(), array(), null );
        wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/assets/3rd-party/bootstrap/css/bootstrap.min.css', array(), '3.3.7');
        wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/3rd-party/jquery.waypoints.min.js', array(), '4.0.1', true);
        wp_enqueue_style( 'koganic-font-awesome', get_template_directory_uri() . '/assets/3rd-party/font-awesome/css/font-awesome.min.css', array(), '4.7.0' );
        wp_enqueue_style( 'simple-line-icons', get_template_directory_uri() . '/assets/3rd-party/simple-line-icons/simple-line-icons.css', array(), '' );
        wp_enqueue_style( 'linearicons-icons', get_template_directory_uri() . '/assets/3rd-party/linearicons/style.css', array(), '' );
        wp_enqueue_style( 'font-stroke', get_template_directory_uri() . '/assets/3rd-party/font-stroke/css/pe-icon-7-stroke.css' );
        wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.carousel.min.css', array(), '2.0.0' );
        wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.theme.default.min.css' );
        wp_enqueue_style( 'slick', get_template_directory_uri() . '/assets/3rd-party/slick/slick.css' );
        wp_enqueue_style( 'magnific-popup', get_template_directory_uri() . '/assets/3rd-party/magnific-popup/magnific-popup.css' );
        wp_enqueue_style( 'magnific-popup-effect', get_template_directory_uri() . '/assets/3rd-party/magnific-popup/magnific-popup-effect.css' );
        wp_enqueue_style( 'font-cerebri-sans-pro', get_template_directory_uri() . '/assets/3rd-party/font-cerebri-sans-pro/style.css', array(), '' );
        wp_enqueue_style( 'font-alako', get_template_directory_uri() . '/assets/3rd-party/font-alako/style.css', array(), '' );
        wp_enqueue_style( 'font-svn-wellfont', get_template_directory_uri() . '/assets/3rd-party/font-svn-wellfont/style.css', array(), '' );

        $page_transition = koganic_get_option('page-transition', '');
        if ( isset($page_transition) && $page_transition != '' ) {
            wp_enqueue_style( 'animsition', get_template_directory_uri() . '/assets/3rd-party/animsition/css/animsition.css' );
        }


        // Main stylesheet
        wp_enqueue_style( 'koganic-style', get_template_directory_uri() . '/style.css');
         
    }
    add_action( 'wp_enqueue_scripts', 'koganic_enqueue_styles', 15 );
}

if( ! function_exists( 'koganic_inline_enqueue_scripts' ) ) {
    function koganic_inline_enqueue_scripts() {
        wp_register_style( 'css-inline', false );
        wp_enqueue_style( 'css-inline' );
        
        global $post;

        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        //add css for footer, header templates
        $jscomposer_templates_args = array(
            'orderby'          => 'title',
            'order'            => 'ASC',
            'post_type'        => 'footerlayout',
            'post_status'      => 'publish',
            'posts_per_page'   => 30,
        );
        $jscomposer_templates = get_posts( $jscomposer_templates_args );
        $footer_layout = koganic_get_option('footer-layout');
        if ( isset( $options['page-footer'] ) && $options['page-footer'] != '' ) {
            $footer_layout = $options['page-footer'];
        }

        if (count($jscomposer_templates) > 0) {
            foreach($jscomposer_templates as $jscomposer_template){
                if( $jscomposer_template->post_title == $footer_layout){
                    $jscomposer_template_css = get_post_meta ( $jscomposer_template->ID, '_wpb_shortcodes_custom_css', false );
                    if ( ! empty( $jscomposer_template_css ) ) {
                        wp_add_inline_style( 'css-inline', $jscomposer_template_css[0] );
                    }
                }
            }
        }

        // background color

        if ( isset( $options['body-bg-color'] ) && $options['body-bg-color'] != '' && ($options['background-body'] == true) ) {
            $custom_css = "
                    body {
                        background-color: {$options['body-bg-color']} !important;
                    }";
            wp_add_inline_style( 'css-inline', $custom_css );
        }

        if ( isset( $options['pagehead-bg-color'] ) && $options['pagehead-bg-color'] != '' ) {
            $custom_css = "
                    .page-heading {
                        background-color: {$options['pagehead-bg-color']} !important;
                    }";
            wp_add_inline_style( 'css-inline', $custom_css );
        }


        //Background Image
        if ( isset( $options['body-bg'] ) && $options['body-bg'] != '' && ($options['background-body'] == true) ) {
            $image_id = $options['body-bg'];
            $bg_image = wp_get_attachment_image_src( $image_id, 'full' );
            if ( isset($bg_image) && $bg_image != '' ) {
                $custom_css = "
                        body {
                            background-image: url({$bg_image[0]}) !important;
                        }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }

        if ( isset( $options['pagehead-bg'] ) && $options['pagehead-bg'] != '' ) {
            $image_id = $options['pagehead-bg'];
            $bg_image = wp_get_attachment_image_src( $image_id, 'full' );

            if ( isset($bg_image) && $bg_image != '' ) {
                $custom_css = "
                        .page-heading {
                            background-image: url({$bg_image[0]}) !important;
                        }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }

        if( koganic_woocommerce_activated() && is_product_category() ) {
            $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
            if ( isset($term->term_id) && $term->term_id != '' ) {
                $term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
            }

            if ( isset( $term_options ) && $term_options && $term_options['product-cat-bg']['color'] != '' ) {
                $custom_css = "
                    .page-heading {
                        background-color: {$term_options['product-cat-bg']['color']};
                    }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }

            if ( isset( $term_options ) && $term_options && $term_options['product-cat-bg']['image'] != '' ) {
                $custom_css = "
                    .page-heading {
                        background-image: url({$term_options['product-cat-bg']['image']}) !important;
                    }";
                wp_add_inline_style( 'css-inline', $custom_css );
            }
        }
        wp_add_inline_style( 'css-inline', koganic_custom_inline_css() );
    }
    add_action( 'wp_enqueue_scripts', 'koganic_inline_enqueue_scripts', 25 );
}

if( ! function_exists( 'koganic_enqueue_scripts' ) ) {
    function koganic_enqueue_scripts() {
        global $post;
        if($post != null) :
            $elementor_page = get_post_meta( $post->ID, '_elementor_edit_mode', true );
        endif;

        // Load required scripts.
        wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/3rd-party/bootstrap/js/bootstrap.min.js', array(), '3.3.7', true);
        wp_enqueue_script( 'isotope-pkgd' , get_template_directory_uri() . '/assets/3rd-party/isotope/isotope.pkgd.min.js', array(), false, true  );
        wp_enqueue_script( 'slick', get_template_directory_uri() . '/assets/3rd-party/slick/slick.js', array(), '1.6.0', true );
        wp_enqueue_script( 'feather-js', get_template_directory_uri() . '/assets/3rd-party/feather/js/feather.min.js', array(), '4.26.0', true );
        wp_enqueue_script( 'theia-sticky-sidebar', get_template_directory_uri() . '/assets/3rd-party/theia-sticky-sidebar/theia-sticky-sidebar.js', array(), false, true );
        wp_enqueue_script( 'main-theia-sticky-sidebar', get_template_directory_uri() . '/assets/3rd-party/theia-sticky-sidebar/main.js', array(), false, true );
        wp_enqueue_script( 'magnific-popup' , get_template_directory_uri() . '/assets/3rd-party/magnific-popup/jquery.magnific-popup.min.js', array(), false, true  );     
        wp_enqueue_script( 'jquery-tweenmax', get_template_directory_uri() . '/assets/3rd-party/panr/TweenMax.js', array(), '', true );
        wp_enqueue_script( 'jquery-panr', get_template_directory_uri() . '/assets/3rd-party/panr/jquery.panr.js', array(), '', true );
        wp_enqueue_script( 'jquery-anime', get_template_directory_uri() . '/assets/3rd-party/organic-shape-animations/anime.min.js', array(), '', true );
        wp_enqueue_script( 'organic-shape-animations', get_template_directory_uri() . '/assets/3rd-party/organic-shape-animations/main.js', array(), '', true );
        
        if($post != null) :
        if (( !!$elementor_page && ( $post && preg_match( '/countdown="yes"/', $post->post_content ) )  ) || ( !!$elementor_page && ( $post && preg_match( '/koganic_countdown/', $post->post_content ) )  ) || ( is_singular( 'product' ) ) || ( is_page() ) ) {
            wp_enqueue_script( 'countdown' , get_template_directory_uri() . '/assets/3rd-party/jquery.countdown.min.js', array(), false, true  );
            wp_enqueue_script( 'moment', get_template_directory_uri() . '/assets/3rd-party/moment.min.js', array( 'jquery' ), '', true );
            wp_enqueue_script( 'moment-timezone', get_template_directory_uri() . '/assets/3rd-party/moment-timezone-with-data.min.js', array( 'jquery' ), '', true );
        }
        endif;
        wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/3rd-party/parallax.js', array( 'jquery' ), '', true );
        wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/assets/3rd-party/owl-carousel/owl.carousel.min.js', array(), '2.2.0', true );
        wp_enqueue_script( 'resize-sensor', get_template_directory_uri() . '/assets/3rd-party/ResizeSensor.js', array(), false, true );
        
        wp_dequeue_script( 'default-js' );

        if ( koganic_woocommerce_activated() ) {
            wp_enqueue_script( 'wc-add-to-cart-variation' );
            wp_enqueue_script( 'jquery-ui-autocomplete' );
            if ( is_shop() ){
                wp_enqueue_script( 'koganic-shop-filter', get_template_directory_uri() . '/assets/js/shop-filter.js', array(), false, true );
            }

            // Zoom image
            if ( is_singular( 'product' ) ) {
                wp_enqueue_script( 'zoom' );
                wp_register_script( 'threesixty', get_template_directory_uri() . '/assets/3rd-party/threesixty/threesixty.min.js', array(), '', true );
            }
        }

        $page_transition = koganic_get_option('page-transition', '');
        if ( isset($page_transition) && $page_transition != '' ) {
            wp_enqueue_script( 'animsition', get_template_directory_uri() . '/assets/3rd-party/animsition/js/animsition.min.js', array(), false, true );
        }

        // Load theme js
        wp_enqueue_script('koganic-theme', get_template_directory_uri() . '/assets/js/theme.js', array( 'jquery', 'imagesloaded' ), false, true);
        wp_add_inline_script('koganic-theme', koganic_settings_js(), 'after' );

        // Custom localize script
        wp_localize_script( 'koganic-theme', 'koganic_settings',
            array(
                'ajaxurl'          => esc_url(admin_url('admin-ajax.php')),
                'ajax_add_to_cart' => apply_filters( 'koganic_ajax_add_to_cart', true ),
                '_nonce_koganic'     => wp_create_nonce('bb_koganic'),
                'JmsSiteURL'       => esc_url(get_option('siteurl')),
                'added_to_cart'    => esc_html__( 'Product was successfully added to your cart.', 'koganic' ),
                'View Wishlist'    => esc_html__( 'View Wishlist', 'koganic' ),
                'viewall_wishlist' => esc_html__( 'View all', 'koganic' ),
                'removed_notice'   => esc_html__( '%s has been removed from your cart.', 'koganic' ),
                'load_more'        => esc_html__( 'Load more', 'koganic' ),
                'loading'          => esc_html__( 'Loading...', 'koganic' ),
                'no_more_item'     => esc_html__( 'All items loaded', 'koganic' ),
                'days'             => esc_html__( 'Days', 'koganic' ),
                'hours'            => esc_html__( 'Hours', 'koganic' ),
                'mins'             => esc_html__( 'Mins', 'koganic' ),
                'secs'             => esc_html__( 'Secs', 'koganic' ),
                'permalink'        => ( get_option( 'permalink_structure' ) == '' ) ? 'plain' : '',
            )
        );

        if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
            wp_enqueue_script( 'comment-reply' );
        }
    }
    add_action( 'wp_enqueue_scripts', 'koganic_enqueue_scripts', 10000 );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Enqueue google fonts
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'koganic_enqueue_google_fonts' ) ) {
    function koganic_enqueue_google_fonts() {
        $fonts_url = '';

        $primary_font = _x( 'on', 'Libre Franklin: on or off', 'koganic' );

        if ( 'off' !== $primary_font ) {
            $font_families = array();
            $font_families[] = 'Libre Franklin:300,400,400i,500,600,700';

            $query_args = array(
                'family' => urlencode( implode( '|', $font_families ) ),
                'subset' => urlencode( 'latin,latin-ext' ),
            );

            $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

        }  

        return esc_url_raw( $fonts_url );
    }
}

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

// Initialize core file
require KOGANIC_PATH . '/inc/init.php';

if( ! function_exists('koganic_script_admin') ) {
    function koganic_script_admin() {
        wp_enqueue_style( 'koganic-custom-wp-admin', get_template_directory_uri() . '/assets/css/admin-style.css', false, '1.0.0' );
    }
    add_action('admin_enqueue_scripts', 'koganic_script_admin');
}



// Require ReduxFramework
function koganic_addons_custom_css_redux() {
    wp_register_style(
        'redux-custom-css',
        KOGANIC_URL . '/assets/css/redux-framework.css',
        array( 'redux-admin-css' ),
        time(),
        'all'
    );
    wp_enqueue_style('redux-custom-css');
}
add_action( 'redux/page/koganic_option/enqueue', 'koganic_addons_custom_css_redux' );

// load admin dashboard
require_once get_template_directory() . '/inc/admin/admin.php';