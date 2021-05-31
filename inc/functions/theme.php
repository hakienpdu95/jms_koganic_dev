<?php

if ( ! function_exists( 'koganic_setup' ) ) {
    function koganic_setup() {
	    load_theme_textdomain( 'koganic', get_template_directory() . '/languages' );

	    // Add default posts and comments RSS feed links to head.
	    add_theme_support( 'automatic-feed-links' );
	    add_theme_support( 'title-tag' );
	    add_theme_support( 'post-thumbnails' );
	    add_theme_support( 'woocommerce' );
        add_theme_support( 'custom-background' );
        add_theme_support( 'custom-header' );
        add_theme_support( 'custom-background' );
        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support( 'woocommerce', array(
            'gallery_thumbnail_image_width' => '600',
        ) );

	    // This theme uses wp_nav_menu() in one location.
	    register_nav_menus( array(
		    'primary-menu'  => esc_html__('Primary Menu', 'koganic'),
            'vertical-menu' => esc_html__('Vertical Menu', 'koganic'),
            'header-11-menu' => esc_html__('Header 11 Menu', 'koganic'),
            'header-12-menu' => esc_html__('Header 12 Menu', 'koganic'),
            'landing-menu'   => esc_html__('Landing Menu', 'koganic'),
	    ) );

	    /*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	    add_theme_support( 'html5', array(
		   'search-form',
		   'comment-form',
		   'comment-list',
		   'gallery',
		   'caption',
	    ) );

        add_image_size( 'koganic-portfolio-square', 450, 450, 1 );

        add_editor_style(); // add the default style

        if ( ! isset( $content_width ) ) $content_width = 900;
   }
}
add_action( 'after_setup_theme', 'koganic_setup' );

/*
* [ Remove all style woocommerce. ] - - - - - - - - - - - - - - - - - - - -
*/
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/*
* [ Check variable Theme option ] - - - - - - - - - - - - - - - - - - - -
*/
if ( ! function_exists( 'koganic_get_option' ) ) {
	function koganic_get_option($name, $default = '') {
		global $koganic_option;
		if ( isset($koganic_option[$name]) ) {
			return $koganic_option[$name];
		}
		return $default;
	}
}

/* get page config for install sample
/* --------------------------------------------------------------------- */
if( ! function_exists( 'koganic_get_config' ) ) {
    function koganic_get_config() {
        $path = KOGANIC_PATH . '/inc/admin/configs/pages.php';
        if( file_exists( $path ) ) {
            return include $path;
        } else {
            return array();
        }
    }
}

/* 	Check WooCommerce is activated
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'koganic_woocommerce_activated' ) ) {
	function koganic_woocommerce_activated() {
		return class_exists( 'WooCommerce' ) ? true : false;
	}
}

/*
* [ Register Widget Area. ] - - - - - - - - - - - - - - - - - - - -
*/
if ( ! function_exists( 'koganic_register_sidebars' ) ) {
	function koganic_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'koganic' ),
				'id'            => 'primary-sidebar',
				'description'   => esc_html__( 'The Primary Sidebar', 'koganic' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			)
		);

        if ( koganic_woocommerce_activated() ) {
            register_sidebar( array(
        		'name'          => esc_html__( 'WooCommerce Sidebar', 'koganic' ),
        		'id'            => 'shop-page',
        		'description'   => esc_html__( 'Add widgets here to appear in shop page sidebar.', 'koganic' ),
        		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        		'after_widget'  => '</aside>',
        		'before_title'  => '<h3 class="widgettitle">',
        		'after_title'   => '</h3>',
        	) );
            
            register_sidebar( array(
                'name'          => esc_html__( 'Koganic Product Filter', 'koganic' ),
                'id'            => 'koganic-product-filter',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widgettitle">',
                'after_title'   => '</h3>',
            ) );

            register_sidebar( array(
        		'name'          => esc_html__( 'WooCommerce Single Product Sidebar', 'koganic' ),
        		'id'            => 'woocommerce-single-product-sidebar',
        		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        		'after_widget'  => '</aside>',
        		'before_title'  => '<h3 class="widgettitle">',
        		'after_title'   => '</h3>',
        	) );
        }

        if ( function_exists('icl_object_id') ) {
            register_sidebar( array(
                'name'          => esc_html__( 'Language', 'koganic' ),
                'id'            => 'language-sidebar',
                'description'   => esc_html__( 'Add widgets wpml to appear languages table.', 'koganic' ),
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget'  => '</aside>',
                'before_title'  => '<h3 class="widgettitle">',
                'after_title'   => '</h3>',
            ) );
        }
        
	}
}
add_action( 'widgets_init', 'koganic_register_sidebars' );

// **********************************************************************//
// ! Text to one-line string
// **********************************************************************//
if( ! function_exists( 'koganic_format_css')) {
	function koganic_format_css( $str ) {
		return trim(preg_replace("/('|\"|\r?\n)/", '', $str));
	}
}

/*
* [ Add a pingback url auto-discovery header for singularly identifiable articles. ] - - - - - - - - - - - - - - - - - - - -
*/
function koganic_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'koganic_pingback_header' );

/*
* [ Adds custom classes to the array of body classes. ] - - - - - - - - - - - - - - - - - - - -
*/

if ( !function_exists('koganic_body_class') ) {
    function koganic_body_class( $classes ) {
        global $post;

        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );
        
        // Get Extra Class in Page
        $classes[] = koganic_page_extra_class();

        if ( koganic_plugin_active( '', 'koganic_addons_load_textdomain' ) ) {
            $classes[] = 'koganic-theme-active';
        } else {
            $classes[] = 'koganic-theme-unit-test';
        }

    	// Adds a class of group-blog to blogs with more than 1 published author.
    	if ( is_multi_author() ) {
    		$classes[] = 'group-blog';
    	}

    	// Adds a class of hfeed to non-singular pages.
    	if ( ! is_singular() ) {
    		$classes[] = 'hfeed';
    	}

        if( !koganic_enable_page_title() ) {
            $classes[] = 'no-breadcrumbs';
        }

        if(is_page( 'home-1' ) || is_page( 'home-2' ) || is_page( 'home-3' ) || is_page( 'home-4' ) || is_page( 'home-5' ) || is_page( 'home-6' )) {
            $classes[] = 'home';          
        }

        $footer_layout = koganic_get_option( 'footer-layout');
        if ( isset( $options['page-footer'] ) && $options['page-footer'] != '' ) {
            $classes[] = 'has-' . str_replace(' ', '-', strtolower($options['page-footer']));
        } else {
            $classes[] = 'has-' . str_replace(' ', '-', strtolower($footer_layout));
        }

        $header_design     = koganic_get_option('header-layout');
        if ( isset($header_design) && empty($options['page-header']) ) {
            $classes[] = 'page-header-' . $header_design;
        } elseif ( isset($header_design) && isset($options['page-header']) ) {
            $classes[] = 'page-header-' . $options['page-header'];
        }

        if ( (isset($header_design) && $header_design == 10) || (isset( $options['page-header'] ) && $options['page-header'] == 10) ) {
            $classes[] = 'home-logo-centered';
        }

        $stickyHeader = koganic_get_option('sticky-header', 0);
        if ( isset($stickyHeader) && $stickyHeader == 1 ) {
    		$classes[] = 'has-sticky-header';
    	}

        $cart_style = koganic_get_option('wc-add-to-cart-style', 'alert');

        if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
            $cart_style = $_GET['cart_design'];
        }

        if ( isset($cart_style) && $cart_style != 'alert' ) {
    		$classes[] = 'add-to-cart-style-sidebar';
    	} else {
            $classes[] = 'add-to-cart-style-alert';
        }

        $layout = koganic_get_option( 'header-layout');

        if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
            $layout = $options['page-header'];
        }

        if ( isset( $layout ) && $layout == '8' ) {
            $classes[] = 'menu-fix-left';
        }

        $site_width = koganic_get_option('site-width', 'fullwidth');


        if ( isset( $options['page-width'] ) && $options['page-width'] != 'inherit' ){
            $site_width = $options['page-width'];
        }

        if ( $layout !== '8' ) {
            $classes[] = 'wrapper-' . $site_width;
        }

        // Check if under construction page is enabled
        $maintenance_mode = koganic_get_option('maintenance-mode', 0);

        if ( isset($_GET['maintenance']) && $_GET['maintenance'] != '' ) {
            $maintenance_mode = $_GET['maintenance'];
        }

        if ( isset($maintenance_mode) && $maintenance_mode == 1 ) {
            if ( ! is_user_logged_in() ) {
                $classes[] = 'offline';
            }
    	}

    	return $classes;
    }
    add_filter( 'body_class', 'koganic_body_class' );
}

if ( !function_exists('koganic_page_extra_class') ) {
    function koganic_page_extra_class() {
        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        $extra_class = '';

        if ( isset( $options['page_extra_class'] ) && $options['page_extra_class'] != '' ) {
            $extra_class = $options['page_extra_class'];
        }

        return $extra_class;
    }
}

/**
 * Redirect to under construction page
 */
if ( ! function_exists( 'koganic_offline' ) ) {
	function koganic_offline() {
		$maintenance_mode = koganic_get_option('maintenance-mode', 0);

        if ( isset($_GET['maintenance']) && $_GET['maintenance'] != '' ) {
            $maintenance_mode = $_GET['maintenance'];
        }
        
		// Check if under construction page is enabled
		if ( $maintenance_mode) {
			if ( ! is_feed() ) {
				// Check if user is not logged in
				if ( ! is_user_logged_in() ) {
					// Load under construction page
					include get_template_directory() . '/maintenance.php';
					exit;
				}
			}

			// Check if user is logged in
			if ( is_user_logged_in() ) {
				global $current_user;

				// Get user role
				wp_get_current_user();

				$loggedInUserID = $current_user->ID;
				$userData = get_userdata( $loggedInUserID );

				// If user role is not 'administrator' then redirect to under construction page
				if ( 'administrator' != $userData->roles[0] ) {
					if ( ! is_feed() ) {
						include get_template_directory() . '/maintenance.php';
						exit;
					}
				}
			}
		}
	}
}
add_action( 'template_redirect', 'koganic_offline' );

if ( !function_exists('koganic_customize_register') ) {
    function koganic_customize_register() {
        global $wp_customize;
        $wp_customize->remove_section( 'header_image' );  //Modify this line as needed
    }
    add_action( 'customize_register', 'koganic_customize_register', 11 );
}

/*  Custom Javascript
/* --------------------------------------------------------------------- */
if ( ! function_exists('koganic_settings_js') ) {
	function koganic_settings_js() {
        $custom_js       = koganic_get_option( 'custom_js', '' );
        $js_ready        = koganic_get_option( 'js_ready', '' );

		ob_start();

        return ob_get_clean();
	}
}

if ( ! function_exists('koganic_plugin_active') ) {
    function koganic_plugin_active( $plg_class = '', $plg_func = '' ) {
        if($plg_class) return class_exists($plg_class);
        if($plg_func) return function_exists($plg_func);
        return false;
    }
}

if ( !function_exists( 'koganic_print_vc_body' ) ) {
    function koganic_print_vc_body($skin = '') {
        if(empty($skin) && !isset($skin) && $skin = '') return;

        $color_primary = '#70C03E'; /*for primary*/
        $color_body = 'rgba(63,40,3,.7)'; /*for body*/

        $vc_style = array($color_primary,$color_body);
        
        switch ($skin) {
            case 'home-1':                
                $vc_style[0] = '#B8D021'; 
                $vc_style[1] = '#777'; 
                break;
            case 'home-2':
                $vc_style[0] = '#FF3514'; 
                $vc_style[1] = '#06163A'; 
                break;
            case 'home-3':
                $vc_style[0] = '#D3183A'; 
                $vc_style[1] = 'rgba(63, 40, 3, 0.7)'; 
                break; 
            case 'home-4':
                $vc_style[0] = '#70C03F'; 
                break; 
            case 'home-5':
                $vc_style[0] = '#EB3335'; 
                $vc_style[1] = '#FFF'; 
                break;
            case 'home-6':
                $vc_style[0] = '#7AC44B'; 
                $vc_style[1] = '#3F2803'; 
                break;
            case 'home-7':
                $vc_style[0] = '#7AC44B'; 
                $vc_style[1] = '#3F2803'; 
                break;                                                  
            default:
                $vc_style = array($color_primary,$color_body);
        }

        return $vc_style;
    }   
}

if ( !function_exists( 'koganic_site_mode' ) ) {
    function koganic_site_mode() {
        $handle = 'style-mode site-';
        $site_mode = koganic_get_option('site_mode', 'light');

        if ( isset($_GET['site_mode']) && $_GET['site_mode'] != '' ) {
            $handle .= $_GET['site_mode'];
        } elseif (koganic_get_option('site_mode', 'light') === 'dark' || is_page( 'home-1' )) {
            $handle .= 'dark';
        } elseif (koganic_get_option('site_mode', 'light') === 'dark' || is_page( 'home-5' )) {
            $handle .= 'dark home-5-dark';
        } elseif (koganic_get_option('site_mode', 'light') === 'light' && is_page( 'home-6' )) {
            $handle .= 'light home-6-light';
        } elseif (koganic_get_option('site_mode', 'light') === 'light' && is_page( 'home-7' )) {
            $handle .= 'light home-7-light';
        } else {
            $handle .= $site_mode;
        }
        
        return $handle;
    }
}