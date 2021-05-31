<?php
/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */

if ( ! class_exists( 'Redux' ) ) {
    return;
}

/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */
//include KOGANIC_PATH . '/inc/selectors.php';

// This is your option name where all the Redux data is stored.
$opt_name = "koganic_option";

/**
 * ---> SET ARGUMENTS
 * All the possible arguments for Redux.
 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
 * */

$theme = wp_get_theme(); // For use with some settings. Not necessary.

$args = array(
    // TYPICAL -> Change these values as you need/desire
    'opt_name'             => $opt_name,
    // This is where your data is stored in the database and also becomes your global variable name.
    'display_name'         => $theme->get( 'Name' ),
    // Name that appears at the top of your panel
    'display_version'      => $theme->get( 'Version' ),
    // Version that appears at the top of your panel
    'menu_type'            => 'menu',
    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
    'allow_sub_menu'       => false,
    // Show the sections below the admin menu item or not
    'menu_title'           => esc_html__( 'Theme Options', 'koganic' ),
    'page_title'           => esc_html__( 'Theme Options', 'koganic' ),
    // You will need to generate a Google API key to use this feature.
    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
    'google_api_key'       => 'AIzaSyCF5_SS7dQ37SiwEHOcNMA5kvCpFurExk4',
    // Set it you want google fonts to update weekly. A google_api_key value is required.
    'google_update_weekly' => false,
    // Must be defined to add google fonts to the typography module
    'async_typography'     => false,
    // Use a asynchronous font on the front end or font string
    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
    'admin_bar'            => false,
    // Show the panel pages on the admin bar
    'admin_bar_icon'       => 'dashicons-portfolio',
    // Choose an icon for the admin bar menu
    'admin_bar_priority'   => 50,
    // Choose an priority for the admin bar menu
    'global_variable'      => '',
    // Set a different name for your global variable other than the opt_name
    'dev_mode'             => false,
    // Show the time the page took to load, etc
    'update_notice'        => true,
    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
    'customizer'           => true,

    // OPTIONAL -> Give you extra features
    'page_priority'        => null,
    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
    'page_parent'          => 'themes.php',

    'page_permissions'     => 'administrator',
    // Permissions needed to access the options panel.
    'menu_icon'            => 'dashicons-palmtree',
    // Specify a custom URL to an icon
    'last_tab'             => '',
    // Force your panel to always open to a specific tab (by id)
    'page_icon'            => 'icon-themes',
    // Icon displayed in the admin panel next to your menu_title
    'page_slug'            => '_options',
    // Page slug used to denote the panel
    'save_defaults'        => true,
    // On load save the defaults to DB before user clicks save or not
    'default_show'         => false,
    // If true, shows the default value next to each field that is not the default value.
    'default_mark'         => '',
    // What to print by the field's title if the value shown is default. Suggested: *
    'show_import_export'   => true,
    // Shows the Import/Export panel when not used as a field.

    // CAREFUL -> These options are for advanced use only
    'transient_time'       => 60 * MINUTE_IN_SECONDS,
    'output'               => true,
    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
    'output_tag'           => true,
    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head

    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
    'database'             => '',
    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!

    'use_cdn'              => true,
    // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.


    // HINTS
    'hints'                => array(
        'icon'          => 'el el-question-sign',
        'icon_position' => 'right',
        'icon_color'    => 'lightgray',
        'icon_size'     => 'normal',
        'tip_style'     => array(
            'color'   => 'light',
            'shadow'  => true,
            'rounded' => false,
            'style'   => '',
        ),
        'tip_position'  => array(
            'my' => 'top left',
            'at' => 'bottom right',
        ),
        'tip_effect'    => array(
            'show' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'mouseover',
            ),
            'hide' => array(
                'effect'   => 'slide',
                'duration' => '500',
                'event'    => 'click mouseleave',
            ),
        ),
    )
);


// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
$args['share_icons'][] = array(
    'url'   => 'https://facebook.com/joommasters2015',
    'title' => 'Like us on Facebook',
    'icon'  => 'el el-facebook'
);
$args['share_icons'][] = array(
    'url'   => 'https://twitter.com/joommasters',
    'title' => 'Follow us on Twitter',
    'icon'  => 'el el-twitter'
);
$args['share_icons'][] = array(
    'url'   => 'https://www.linkedin.com/company/joommasters',
    'title' => 'Find us on LinkedIn',
    'icon'  => 'el el-linkedin'
);


Redux::setArgs( $opt_name, $args );

/*
 * ---> END ARGUMENTS
 */

/*
 * ---> START HELP TABS
 */

$tabs = array(
    array(
        'id'      => 'redux-help-tab-1',
        'title'   => esc_html__( 'Theme Information 1', 'koganic' ),
        'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'koganic' )
    ),
    array(
        'id'      => 'redux-help-tab-2',
        'title'   => esc_html__( 'Theme Information 2', 'koganic' ),
        'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'koganic' )
    )
);
Redux::setHelpTab( $opt_name, $tabs );

// Set the help sidebar
$content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'koganic' );
Redux::setHelpSidebar( $opt_name, $content );


/*
 * <--- END HELP TABS
 */

Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'General', 'koganic' ),
    'id'     => 'general',
    'icon'   => 'el el-dashboard',
    'fields' => array(
        array(
            'id'      => 'site_mode',
            'type'    => 'button_set',
            'title'   => esc_html__('Theme Style', 'koganic'),
            'options' => array(
                'light' => esc_html__('Light', 'koganic'),
                'dark'  => esc_html__('Dark', 'koganic'),
            ),
            'default' => 'light'
        ),                
        array(
            'id'       => 'site-width',
            'type'     => 'select',
            'title'    => esc_html__('Site width', 'koganic'),
            'subtitle' => esc_html__('You can make your content wrapper boxed or full width', 'koganic'),
            'options'  => array(
               'fullwidth' => esc_html__('Fullwidth', 'koganic'),
               'boxed'   => esc_html__('Boxed', 'koganic'),
            ),
            'default' => 'fullwidth',
        ),
        array(
            'id'        => 'box_layout_width',
            'type'      => 'slider',
            'title'     => esc_html__('Box layout width', 'koganic'),
            'desc'      => esc_html__('Box layout width in pixels, default value: 1370', 'koganic'),
            "default"   => 1356,
            "min"       => 1200,
            "step"      => 10,
            "max"       => 1920,
            'display_value' => 'text',
            'required' => array( 'site-width', '=', 'boxed' )
        ),
        array(
            'id'                    => 'body-background',
            'type'                  => 'background',
            'title'                 => esc_html__('Body background', 'koganic'),
            'subtitle' => esc_html__('Set background image or color for page.', 'koganic'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'koganic'),
            'output'   => array('html'),
        ),
        array(
            'id'      => 'site-loader',
            'type'    => 'switch',
            'title'   => esc_html__('Site Loader', 'koganic'),
            'on'      => esc_html__('On','koganic'),
            'off'     => esc_html__('Off','koganic'),
            'default' => false,
        ),
        array(
            'id'       => 'site-loader-style',
            'type'     => 'select',
            'title'    => esc_html__( 'Site Loader Style', 'koganic' ),
            'options'  => array(
                '1' => esc_html__( 'Style 1', 'koganic' ),
                '2' => esc_html__( 'Style 2', 'koganic' ),
                '3' => esc_html__( 'Style 3', 'koganic' ),
                '4' => esc_html__( 'Style 4', 'koganic' ),
                '5' => esc_html__( 'Style 5', 'koganic' ),
                '6' => esc_html__( 'Style 6', 'koganic' ),
            ),
            'default'  => '5',
            'required' => array( 'site-loader', '=', 3 )
        ),
        array(
            'id'      => 'smart-sidebar',
            'type'    => 'switch',
            'title'   => esc_html__('Smart sidebar', 'koganic'),
            'subtitle' => esc_html__('The smart sidebar is an affix (sticky) sidebar that has auto resize and it scrolls with the content.', 'koganic'),
            'on'      => esc_html__('On','koganic'),
            'off'     => esc_html__('Off','koganic'),
            'default' => false,
        ),
        array(
            'id'       => 'login-logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Login Logo', 'koganic'),
            'subtitle' => esc_html__('Max width: 302px - Max height: 67px','koganic'),
            'default'  => array(
                'url'  => KOGANIC_URL . '/assets/images/logo.png'
            ),            
        ),
        array(
            'id'       => 'favicon',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Favicon', 'koganic'),
            'subtitle' => esc_html__('Max width: 32px - Max height: 32px','koganic'),
            'default'  => array(
                'url'  => KOGANIC_URL . '/assets/images/favicon.png'
            ),            
        ),
        array(
            'id'       => 'back-to-top',
            'type'     => 'switch',
            'title'    => esc_html__( 'Show Back To Top Button', 'koganic' ),
            'desc'     => esc_html__( 'Show back to top button.', 'koganic' ),
            'on'       => esc_html__( 'On', 'koganic' ),
            'off'      => esc_html__( 'Off', 'koganic' ),
            'default'  => 1,
        ),        
        array(
            'id'       => 'google_map_api_key',
            'type'     => 'text',
            'title'    => esc_html__('Google map API key', 'koganic'),
            'subtitle' => wp_kses( esc_html__('Obtain API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank">here</a> to use our Google Map VC element.', 'koganic'),
            array(
                'a' => array(
                    'href' => array(),
                    'target' => array()
                )
            ) ),
            'default'  => '',
        ),
    )
) );

// START Typography
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Typography', 'koganic' ),
    'id'     => 'theme-typography',
    'subsection' => true,
    'fields' => array(
        array(
            'id'              => 'primary-color',
            'type'            => 'color',
            'title'           => esc_html__('Primary Color', 'koganic'),
            'default'         => '#ffba00'
        ),
        array(
            'id'          => 'default-font',
            'type'        => 'typography',
            'title'       => esc_html__('Text font', 'koganic'),
            'subtitle'    => esc_html__('Set you typography options for body, paragraphs.', 'koganic'),
            'line-height' => false,
            'text-align' => false,
            'font-style' => false,
            'font-weight' => false,
            'all_styles'=> true,
            'font-size' => false,
            'color' => false,
            'default'     => array(
                'font-family' => '',
                'subsets' => '',
            ),
        ),
        array(
            'id'          => 'second-font',
            'type'        => 'typography',
            'title'       => esc_html__('Font Family', 'koganic'),
            'google'      => true,
            'color'       => false,
            'text-align'  => false,
            'font-weight' => false,
            'font-size'   => false,
            'line-height' => false,
            'font-style'  => false,
            'all_styles'  => true,
            'subtitle'    => esc_html__('Set you typography options for text with second font. Example: title, description.', 'koganic'),
            'default'     => array(
                'font-family'    => '',
                'subsets' => '',
            ),            
        ),
        array(
            'id'             => 'heading-font',
            'type'           => 'color',
            'title'          => esc_html__('Heading font', 'koganic'),
            'default'        => '#333333',
            'subtitle'       => esc_html__('Set you typography options for heading.', 'koganic'),
            'output'   => array('h1,h2,h3,h4,h5,h6'),
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title' => esc_html__('Page heading', 'koganic'),
    'id' => 'page_titles',
    'subsection' => true,
    'fields' => array(
        array(
            'id'       => 'page-title-design',
            'type'     => 'button_set',
            'title'    => esc_html__('Page title design', 'koganic'),
            'options'  => array(
                'left'     => esc_html__('Left', 'koganic'),
                'centered' => esc_html__('Centered', 'koganic'),
                'right'    => esc_html__('Right', 'koganic'),
                'vertical'    => esc_html__('Line', 'koganic'),
                'disable'  => esc_html__('Disable', 'koganic'),
            ),
            'default' => 'centered',
        ),
        array(
            'id'       => 'page-title-size',
            'type'     => 'button_set',
            'title'    => esc_html__('Page title size', 'koganic'),
            'options'  => array(
                'default' => esc_html__('Default', 'koganic'),
                'small'  => esc_html__('Small', 'koganic'),
                'medium' => esc_html__('Medium', 'koganic'),
                'large'  => esc_html__('Large', 'koganic'),
            ),
            'default' => 'default',
        ),
        array(
            'id'       => 'breadcrumbs',
            'type'     => 'switch',
            'title'    => esc_html__('Show breadcrumbs', 'koganic'),
            'subtitle' => esc_html__('Displays a full chain of links to the current page.', 'koganic'),
            'default' => true
        ),
        array(
            'id'       => 'title-background',
            'type'     => 'background',
            'title'    => esc_html__('Page title background', 'koganic'),
            'subtitle' => esc_html__('Set background image or color, that will be used as a default for all page titles, shop page and blog.', 'koganic'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'koganic'),
            'output'   => array('.page-heading:not(.title-other)'),
            'default'  => array(
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'             => 'page-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Page Heading color', 'koganic'),
            'default'        => '#333',
            'output'           => array('.page-heading:not(.title-other) .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'koganic'),
        ),
    ),
) );

Redux::setSection( $opt_name, array(
    'title' => esc_html__('Toggle Sidebar', 'koganic'),
    'id' => 'toggle_sidebar',
    'subsection' => true,
    'fields' => array(         
        array(
            'id'       => 'toggle-desc',
            'type'     => 'text',
            'title'    => esc_html__('Content', 'koganic'),
            'default'  => 'Modern furniture online shopping destination furniture getting the right furniture for home.',
        ), 
        array(
            'id'       => 'toggle-image',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Image', 'koganic'),
            'default'  => array(
                'url'  => KOGANIC_URL . '/assets/images/demo/toggle-banner.jpg'
            ),            
        ),
        array(
            'id'    => 'toggle-contact',
            'type'  => 'editor',
            'title' => esc_html__( 'Contact', 'koganic' ),
            'desc'  => esc_html__( 'HTML is allowed', 'koganic' ),
        ),                                  
    ),
) );

// Header
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Header', 'koganic' ),
    'id'     => 'header',
    'icon'   => 'el el-circle-arrow-up',
    'fields'     => array(
        array(
            'id'       => 'header-layout',
            'type'     => 'select',
            'title'    => esc_html__( 'Header Layout', 'koganic' ),
            'subtitle' => esc_html__( 'Set the header layout', 'koganic' ),
            'options'  => array(
                '1'    => esc_html__( 'Header 1', 'koganic' ),
                '2'    => esc_html__( 'Header 2', 'koganic' ),
                '3'    => esc_html__( 'Header 3', 'koganic' ),
                '4'    => esc_html__( 'Header 4', 'koganic' ),
                '5'    => esc_html__( 'Header 5', 'koganic' ),
                '7'    => esc_html__( 'Header 7', 'koganic' ),
                '9'    => esc_html__( 'Header 9', 'koganic' ),
                '10'   => esc_html__( 'Header 10', 'koganic' ),
                '11'   => esc_html__( 'Header 11', 'koganic' ),
                '12'   => esc_html__( 'Header 12', 'koganic' ),
            ),
            'default'  => '1',
        ),
        array(
            'id'       => 'header-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Header fullwidth', 'koganic'),
            'subtitle' => esc_html__('Make header full width', 'koganic'),
            'default'  => false,
        ),
        array(
            'id'       => 'header-logo',
            'type'     => 'media',
            'url'      => true,
            'title'    => esc_html__('Logo', 'koganic'),
            'default'  => array(
                'url'  => KOGANIC_URL . '/assets/images/logo.png'
            ),            
        ),

        array(
            'id'       => 'max-width-logo',
            'type'     => 'text',
            'title'    => esc_html__('Logo Max Width', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'          => 'position-header',
            'type'        => 'switch',
            'title'       => esc_html__('Header Position', 'koganic'),
            'subtitle'    => esc_html__('Make header position absolute (only home page)', 'koganic'),
            'default'     => false,
        ),
        array(
            'id'          => 'sticky-header',
            'type'        => 'switch',
            'title'       => esc_html__('Sticky Header', 'koganic'),
            'subtitle'    => esc_html__('How to display the header menu on scroll.', 'koganic'),
            'default'     => false,
        ),
        array(
            'id'                    => 'header-background-color',
            'type'                  => 'background',
            'title'                 => esc_html__('Header background', 'koganic'),
            'subtitle' => esc_html__('Set background image or color for header.', 'koganic'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'koganic'),
            'output'   => array('.header-wrapper'),
            'default'  => array(
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'          => 'show-topbar',
            'type'        => 'switch',
            'title'       => esc_html__('Show topbar', 'koganic'),
            'default'     => false,
        ),        
        array(
            'id'       => 'header-text',
            'type'     => 'text',
            'title'    => esc_html__('Header Text', 'koganic'),
            'default'  => 'Welcome to Koganic food market! ',
        ),
        array(
            'id'          => 'show-callphone',
            'type'        => 'switch',
            'title'       => esc_html__('Show Call Phone', 'koganic'),
            'default'     => false,
        ),        
        array(
            'id'       => 'header-callphone',
            'type'     => 'text',
            'title'    => esc_html__('Header Call Phone', 'koganic'),
            'subtitle'    => esc_html__('Show on Header layout 1,5', 'koganic'),
            'default'  => '(01) 028-6677-1223',
            'required'    => array( 'show-callphone', '=', 1 )
        ),        
        array(
            'id'          => 'show-header-account',
            'type'        => 'switch',
            'title'       => esc_html__('Show Header Account', 'koganic'),
            'default'     => true,
        ),
        array(
            'id'          => 'show-language-mobile-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Language On Mobile', 'koganic'),
            'default'     => false,
        ),                                                   
        array(
            'id'          => 'show-language-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Language', 'koganic'),
            'default'     => true,
        ),
        array(
            'id'          => 'language-name-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Language Name', 'koganic'),
            'default'     => 'English',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-1',
            'type'        => 'text',
            'title'       => esc_html__('1st Language URL', 'koganic'),
            'default'     => '#',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-name-2',
            'type'        => 'text',
            'title'       => esc_html__('2nd Language Name', 'koganic'),
            'default'     => 'Italiano',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-2',
            'type'        => 'text',
            'title'       => esc_html__('2nd Language URL', 'koganic'),
            'default'     => '#',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-name-3',
            'type'        => 'text',
            'title'       => esc_html__('3rd Language Name', 'koganic'),
            'default'     => '',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'language-link-3',
            'type'        => 'text',
            'title'       => esc_html__('3rd Language URL', 'koganic'),
            'default'     => '',
            'required'    => array( 'show-language-box', '=', 1 )
        ),
        array(
            'id'          => 'show-currency-box',
            'type'        => 'switch',
            'title'       => esc_html__('Show Currency', 'koganic'),
            'default'     => true,
        ),
        array(
            'id'          => 'show-search-form',
            'type'        => 'switch',
            'title'       => esc_html__('Show Search Form', 'koganic'),
            'default'     => true
        ),
        array(
            'id'          => 'show-cart-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Cart Button', 'koganic'),
            'default'     => true
        ),
        array(
            'id'       => 'wc-add-to-cart-style',
            'type'     => 'button_set',
            'title'    => esc_html__( 'Add To Cart Design', 'koganic' ),
            'options'  => array(
                'alert'          => esc_html__('Default', 'koganic'),
                'toggle-sidebar' => esc_html__('Toggle Sidebar', 'koganic'),
            ),
            'default'  => 'alert'
        ),
        array(
            'id'          => 'show-wishlist-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Wishlist Button', 'koganic'),
            'default'     => true
        ),
        array(
            'id'          => 'show-compare-button',
            'type'        => 'switch',
            'title'       => esc_html__('Show Compare Button', 'koganic'),
            'default'     => true
        ),                    
        array(
            'id'       => 'header-menu-align',
            'type'     => 'button_set',
            'title'    => esc_html__('Menu Align', 'koganic'),
            'options'  => array(
                'left'   => esc_html__('Left', 'koganic'),
                'center' => esc_html__('Center', 'koganic'),
                'right'  => esc_html__('Right', 'koganic'),
            ),
            'default' => 'center',
        ),
    ),
) );


// -> START Footer Fields

$footer_layouts = array();
$footer_default = '';

$jscomposer_templates_args = array(
    'orderby'          => 'title',
    'order'            => 'ASC',
    'post_type'        => 'footerlayout',
    'post_status'      => 'publish',
    'posts_per_page'   => 30,
);
$jscomposer_templates = get_posts( $jscomposer_templates_args );

if(count($jscomposer_templates) > 0) {
    foreach($jscomposer_templates as $jscomposer_template){
        $footer_layouts[$jscomposer_template->post_title] = $jscomposer_template->post_title;
    }
    $footer_default = $jscomposer_templates[0]->post_title;
}

Redux::setSection( $opt_name, array(
    'title'  => esc_html__('Footer', 'koganic' ),
    'id'     => 'footer',
    'icon'   => 'el el-circle-arrow-down',
    'fields' => array(
        array(
            'id'       => 'footer-layout',
            'type'     => 'select',
            'title'    => esc_html__('Footer Layout', 'koganic' ),
            'subtitle' => esc_html__('Choose footer you want to show - All Page', 'koganic' ),
            'desc'      => esc_html__('Go to Footer Layout (admin table) to create/edit layout', 'koganic'),
            'options'   => $footer_layouts,
            'default'   => $footer_default
        ),
    )
) );

/*
 * <--- END FOOTER
 */

// BLOG
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Blog', 'koganic' ),
    'id'     => 'blog',
    'icon'   => 'el el-pencil',
    'fields' => array(
        array(
            'id'             => 'Blog-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Blog heading color', 'koganic'),
            'default'        => '#000',
            'output'           => array('.title-blog.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'koganic'),
        ),
        array(
            'id'       => 'blog-title-background',
            'type'     => 'background',
            'title'    => esc_html__('Blog heading background', 'koganic'),
            'subtitle' => esc_html__('Set background image or color for blog.', 'koganic'),
            'desc'     => esc_html__('You can also specify other image for particular page', 'koganic'),
            'output'   => array('.title-blog.page-heading'),
            'default'  => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'       => 'blog-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Full Width', 'koganic'),
            'subtitle' => esc_html__('Makes container 100% width of the page', 'koganic'),
            'on'       => esc_html__('On', 'koganic'),
			'off'      => esc_html__('Off', 'koganic'),
			'default'  => 0,
        ),
        array(
            'id'       => 'blog-design',
            'type'     => 'select',
            'title'    => esc_html__( 'Blog Design', 'koganic' ),
            'subtitle' => esc_html__( 'You can use different design for your blog styled for the theme.', 'koganic' ),
            'options'  => array(
                'default'      => esc_html__('Default', 'koganic'),
                'small-images' => esc_html__('Small images', 'koganic'),
                'chess'        => esc_html__('Chess', 'koganic'),
                'masonry'      => esc_html__('Masonry grid', 'koganic')
            ),
            'default' => 'default'
        ),
        array(
            'id'       => 'blog-style',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog Style', 'koganic'),
            'options'  => array(
                'flat'   => esc_html__('Flat', 'koganic'),
                'shadow' => esc_html__('With Shadow', 'koganic')
            ),
            'default' => 'flat'
        ),
        array(
            'id'       => 'blog-columns',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog items columns', 'koganic'),
            'subtitle' => esc_html__('For masonry grid design', 'koganic'),
            'options'  => array(
                2 => '2',
                3 => '3',
                4 => '4',
            ),
            'default' => 3,
            'required' => array(
                array('blog-design','equals','masonry'),
            )
        ),
        array(
            'id'       => 'blog-image-size',
            'type'     => 'text',
            'title'    => esc_html__( 'Blog image size', 'koganic' ),
            'desc'     => esc_html__( 'Enter image size. Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme. Alternatively enter image size in pixels: 500x300 (Width x Height). Leave empty to use "1540x1082" size.', 'koganic' ),
            'default'  => '1540x1082'
        ),
        array(
            'id'       => 'show-date-image',
            'type'     => 'switch',
            'title'    => esc_html__('Show date in images', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-date',
            'type'     => 'switch',
            'title'    => esc_html__('Show date', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-post-view',
            'type'     => 'switch',
            'title'    => esc_html__('Show post view', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
            'off'      => esc_html__('Hide', 'koganic'),
            'default'  => 1,
        ),        
        array(
            'id'       => 'show-author',
            'type'     => 'switch',
            'title'    => esc_html__('Show author', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-category',
            'type'     => 'switch',
            'title'    => esc_html__('Show category', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-comment',
            'type'     => 'switch',
            'title'    => esc_html__('Show comment', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'blog-words-or-letters',
            'type'     => 'button_set',
            'title'    => esc_html__('Excerpt length by words or letters', 'koganic'),
            'options'  => array(
                'word'   => esc_html__('Words', 'koganic'),
                'letter' => esc_html__('Letters', 'koganic'),
            ),
            'default' => 'letter',
        ),
        array(
            'id'       => 'blog-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Blog Pagination', 'koganic'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'koganic'),
                'loadmore' => esc_html__('Load more button', 'koganic'),
                'infinite' => esc_html__('Infinit scrolling', 'koganic'),
            ),
            'default' => 'number'
        ),
        array(
            'id'       => 'blog-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Blog Layout', 'koganic' ),
            'subtitle' => esc_html__( 'Select blog layout with sidebar postion.', 'koganic' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_attr__('Left Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_attr__('No Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_attr__('Right Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );

// Blog single
Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Blog Single', 'koganic' ),
    'id'         => 'blog-single',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'show-feature-image',
            'type'     => 'switch',
            'title'    => esc_html__('Featured Image', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-author-bio',
            'type'     => 'switch',
            'title'    => esc_html__('Author bio', 'koganic'),
            'subtitle' => esc_html__('Display information about the post author', 'koganic'),
            'default' => true
        ),
        array(
            'id'       => 'show-related-posts',
            'type'     => 'switch',
            'title'    => esc_html__('Show Related Posts', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'show-post-navigation',
            'type'     => 'switch',
            'title'    => esc_html__('Show Post Navigation', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'blog-single-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Blog Single Layout', 'koganic' ),
            'subtitle' => esc_html__( 'Select blog single layout with sidebar postion.', 'koganic' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_attr__('Left Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_attr__('No Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_attr__('Right Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );



// Woocommerce
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Shop', 'koganic' ),
    'id'     => 'shop',
    'icon'   => 'el el-shopping-cart',
    'fields' => array(
        array(
            'id'       => 'wc-shop-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Fullwidth', 'koganic'),
            'on'       => esc_html__('Enable', 'koganic'),
			'off'      => esc_html__('Disable', 'koganic'),
			'default'  => 0,
        ),
        array(
            'id'       => 'wc-product-style',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Product Hover Box Style', 'koganic' ),
            'options'  => array(
                '1' => array(
                    'alt' => esc_attr__('style 1', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/product-style/style1.jpg'
                ),
            ),
            'default'  => '1',
        ),
        array(
            'id'       => 'wc-product-image-hover',
            'type'     => 'switch',
            'title'    => esc_html__('Hover Thumb Image', 'koganic'),
            'options' => array(
                'on'    => esc_html__( 'Show', 'koganic' ),
                'off' => esc_html__( 'Hide', 'koganic' ),
            ),
            'default'  => 1,
        ),
        array(
            'id'       => 'wc-product-style-thumb',
            'type'     => 'select',
            'title'    => esc_html__( 'Hover Thumb Image Effect', 'koganic' ),
            'options'  => array(
                '1'      => esc_html__( 'Zoom', 'koganic' ),
                '2'      => esc_html__( 'Move top to bottom', 'koganic' ),
                '3'      => esc_html__( 'Move bottom to top', 'koganic' ),
                '4'      => esc_html__( 'Move right to left', 'koganic' ),
                '5'      => esc_html__( 'Move left to right', 'koganic' ),
                '6'      => esc_html__( 'Move top left to right bottom', 'koganic' ),
                '7'      => esc_html__( 'Move top right to bottom left', 'koganic' ),
                '8'      => esc_html__( 'Move right bottom to top right', 'koganic' ),
                '9'      => esc_html__( 'Move left bottom to top right', 'koganic' ),
                '10'     => esc_html__( 'Scale', 'koganic' ),
                '11'     => esc_html__( 'Scale rotate', 'koganic' ),
                '12'     => esc_html__( 'Skew Y rotate', 'koganic' ),
                '13'     => esc_html__( 'Skew X rotate', 'koganic' ),
                '14'     => esc_html__( 'Skew', 'koganic' ),
            ),
            'default'  => '1',
            'required' => array( 'wc-product-image-hover', '=', 1 ),
        ),
        array(
            'id'       => 'wc-product-hover-presets',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Opacity color on product image', 'koganic' ),
            'options'  => array(
                '2e2e2e' => array(
                    'alt' => esc_attr__('2e2e2e', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/2e2e2e.png',
                ),
                'ffffff' => array(
                    'alt' => esc_attr__('ffffff', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/ecf0f1.png',
                ),
                '01558f' => array(
                    'alt' => esc_attr__('01558f', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/01558f.png',
                ),
                '3498db' => array(
                    'alt' => esc_attr__('3498db', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/3498db.png',
                ),
                '1abc9c' => array(
                    'alt' => esc_attr__('1abc9c', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/1abc9c.png',
                ),
                '2ecc71' => array(
                    'alt' => esc_attr__('2ecc71', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/2ecc71.png',
                ),
                '9b59b6' => array(
                    'alt' => esc_attr__('9b59b6', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/9b59b6.png',
                ),
                'f1c40f' => array(
                    'alt' => esc_attr__('f1c40f', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/f1c40f.png',
                ),
                'd35400' => array(
                    'alt' => esc_attr__('d35400', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/d35400.png',
                ),
                'e74c3c' => array(
                    'alt' => esc_attr__('e74c3c', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/e74c3c.png',
                ),
                'c0392b' => array(
                    'alt' => esc_attr__('c0392b', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/c0392b.png',
                ),
                'none' => array(
                    'alt' => esc_attr__('none', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/color-icons/none.png',
                ),
            ),
            'default'  => 'none',
        ),                    
        array(
			'id'		=> 'wc-product-onsale',
			'type'		=> 'button_set',
			'title'		=> esc_html__( 'Product Sale Flash', 'koganic' ),
			'subtitle'	=> esc_html__( 'Product sale flash badges.', 'koganic' ),
			'options'	=> array(
                'txt' => esc_html__('Display sale Text', 'koganic'),
                'pct' => esc_html__('Display sale Percentage', 'koganic')
            ),
			'default'	=> 'pct'
		),
        array(
            'id'       => 'wc-quick-view',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Quickview Button', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-wishlist',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Wishlist', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-compare',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Compare', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
            'off'      => esc_html__('Hide', 'koganic'),
            'default'  => 1,
        ),
        array(
            'id'       => 'wc-category-name',
            'type'     => 'switch',
            'title'    => esc_html__('Show/Hide Category Name', 'koganic'),
            'on'       => esc_html__('Show', 'koganic'),
			'off'      => esc_html__('Hide', 'koganic'),
			'default'  => 1
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Page Title', 'koganic' ),
    'id'         => 'wc_shop_page_title',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'             => 'shop-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Shop heading color', 'koganic'),
            'default'        => '#333',
            'output'           => array('.title-shop.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'koganic'),
        ),
        array(
            'id'       => 'shop-title-background',
            'type'     => 'background',
            'title'    => esc_html__('Shop heading background', 'koganic'),
            'subtitle' => esc_html__('Set background image or color for shop.', 'koganic'),
            'output'   => array('.title-shop.page-heading'),
            'default'  => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Shop action', 'koganic' ),
    'id'         => 'wc_shop_action',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'wc-product-view',
            'type'     => 'button_set',
            'title'    => esc_html__('Shop products view', 'koganic'),
            'subtitle' => esc_html__('You can set different view mode for the shop page', 'koganic'),
            'options'  => array(
                'grid' => esc_html__('Grid', 'koganic'),
                'list' => esc_html__('List', 'koganic'),
            ),
            'default'  => 'grid'
        ),
        array(
            'id'       => 'wc-product-style-load',
            'type'     => 'select',
            'title'    => esc_html__( 'Load Product Effect', 'koganic' ),
            'options'  => array(
                ''                      => esc_html__( 'None', 'koganic' ),
                'bounceIn'              => esc_html__( 'bounceIn', 'koganic' ),
                'bounceInDown'          => esc_html__( 'bounceInDown', 'koganic' ),
                'bounceInLeft'          => esc_html__( 'bounceInLeft', 'koganic' ),
                'bounceInRight'         => esc_html__( 'bounceInRight', 'koganic' ),
                'bounceInUp'            => esc_html__( 'bounceInUp', 'koganic' ),
                'fadeIn'                => esc_html__( 'fadeIn', 'koganic' ),
                'fadeInDown'            => esc_html__( 'fadeInDown', 'koganic' ),
                'fadeInDownBig'         => esc_html__( 'fadeInDownBig', 'koganic' ),
                'fadeInLeft'            => esc_html__( 'fadeInLeft', 'koganic' ),
                'fadeInLeftBig'         => esc_html__( 'fadeInLeftBig', 'koganic' ),
                'fadeInRight'           => esc_html__( 'fadeInRight', 'koganic' ),
                'fadeInRightBig'        => esc_html__( 'fadeInRightBig', 'koganic' ),
                'fadeInUp'              => esc_html__( 'fadeInUp', 'koganic' ),
                'fadeInUpBig'           => esc_html__( 'fadeInUpBig', 'koganic' ),
                'flipInX'               => esc_html__( 'flipInX', 'koganic' ),
                'flipInY'               => esc_html__( 'flipInY', 'koganic' ),
                'lightSpeedIn'          => esc_html__( 'lightSpeedIn', 'koganic' ),
                'rotateIn'              => esc_html__( 'rotateIn', 'koganic' ),
                'rotateInDownLeft'      => esc_html__( 'rotateInDownLeft', 'koganic' ),
                'rotateInDownRight'     => esc_html__( 'rotateInDownRight', 'koganic' ),
                'rotateInUpLeft'        => esc_html__( 'rotateInUpLeft', 'koganic' ),
                'rotateInUpRight'       => esc_html__( 'rotateInUpRight', 'koganic' ),
                'rollIn'                => esc_html__( 'rollIn', 'koganic' ),
                'zoomIn'                => esc_html__( 'zoomIn', 'koganic' ),
                'zoomInDown'            => esc_html__( 'zoomInDown', 'koganic' ),
                'zoomInLeft'            => esc_html__( 'zoomInLeft', 'koganic' ),
                'zoomInRight'           => esc_html__( 'zoomInRight', 'koganic' ),
                'zoomInUp'              => esc_html__( 'zoomInUp', 'koganic' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'koganic' ),
                'slideInLeft'           => esc_html__( 'slideInLeft', 'koganic' ),
                'slideInRight'          => esc_html__( 'slideInRight', 'koganic' ),
                'slideInUp'             => esc_html__( 'slideInUp', 'koganic' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'koganic' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'koganic' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'koganic' ),
                'slideInDown'           => esc_html__( 'slideInDown', 'koganic' ),
            ),
            'default'  => '',
        ),
        array(
            'id'       => 'wc-shop-ordering',
            'type'     => 'switch',
            'title'    => esc_html__('Products ordering', 'koganic'),
            'on'       => esc_html__('Enable', 'koganic'),
			'off'      => esc_html__('Disable', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'wc-products-per-page',
            'type'     => 'switch',
            'title'    => esc_html__('Products per page', 'koganic'),
            'on'       => esc_html__('Enable', 'koganic'),
			'off'      => esc_html__('Disable', 'koganic'),
			'default'  => 1,
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Product List Setting', 'koganic' ),
    'id'         => 'wc_product_list_setting',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'wc-number-per-page',
            'type'     => 'text',
            'title'    => esc_html__( 'Per page', 'koganic' ),
            'subtitle' => esc_html__( 'How much items per page to show.', 'koganic' ),
            'validate' => 'numeric',
            'default'  => '12'
        ),
        array(
            'id'       => 'wc-product-column',
            'type'     => 'button_set',
            'title'    => esc_html__('Columns', 'koganic'),
            'options'  => array(
                '2' => '2',
                '3' => '3',
                '4' => '4',
                '5' => '5',
                '6' => '6',
            ),
            'default'  => '3'
        ),
        array(
            'id'       => 'wc-gutter-space',
            'type'     => 'select',
            'title'    => esc_html__('Gutter Space', 'koganic'),
            'options'  => array(
                '0'  => '0',
                '10' => '10',
                '20' => '20',
                '30' => '30',
                '40' => '40',
                '50' => '50',
                '60' => '60'
            ),
            'default' => '30'
        ),
        array(
            'id'       => 'wc-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Shop Pagination', 'koganic'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'koganic'),
                'loadmore' => esc_html__('Load more button', 'koganic'),
                'infinite' => esc_html__('Infinit scrolling', 'koganic'),
            ),
            'default' => 'loadmore'
        ),
        array(
            'id'       => 'wc-shop-layout',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Product List Layout', 'koganic' ),
            'subtitle' => esc_html__( 'Select shop page layout with sidebar postion.', 'koganic' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_attr__('Left Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_attr__('No Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_attr__('Right Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'left'
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__( 'Single Product Setting', 'koganic' ),
    'id'         => 'wc_product_page',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'single-product-sidebar',
            'type'     => 'image_select',
            'title'    => esc_html__( 'Single Product Layout', 'koganic' ),
            'subtitle' => esc_html__( 'Select single product page layout with sidebar postion.', 'koganic' ),
            'options'  => array(
                'left' => array(
                    'alt' => esc_attr__('Left Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/left-sidebar.jpg'
                ),
                'no' => array(
                    'alt' => esc_attr__('No Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/no-sidebar.jpg'
                ),
                'right' => array(
                    'alt' => esc_attr__('Right Sidebar', 'koganic'),
                    'img' => KOGANIC_URL . '/assets/images/layout/right-sidebar.jpg'
                ),
            ),
            'default'  => 'no'
        ),
        array(
            'id' => 'show_product_social_share',
            'type' => 'switch',
            'title' => esc_html__('Show Social Share', 'koganic'),
            'default' => 1
        ),              
        array(
            'id'       => 'wc-product-zoom-image',
            'type'     => 'switch',
            'title'    => esc_html__('Zoom image?', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'product-tab-layout',
            'type'     => 'button_set',
            'title'    => esc_html__('Tabs layout', 'koganic'),
            'options'  => array(
                'tabs'      => esc_html__('Tabs Container', 'koganic'),
                'accordion' => esc_html__('Accordion Container', 'koganic'),
            ),
            'default' => 'accordion'
        ),                                   
        array(
            'id'       => 'wc-single-nagivation',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Navigation?', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'section-upsell-product-start',
            'type'     => 'section',
            'title'    => esc_html__( 'You may also like..', 'koganic' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'upsell-product-title',
            'type'     => 'text',
            'title'    => esc_html__('Title', 'koganic'),
            'default'  => 'You May Also Like..',
        ),
        array(
            'id'       => 'upsell-product-desc',
            'type'     => 'text',
            'title'    => esc_html__('Description', 'koganic'),
            'default'  => 'Includes products updated are similar or are same of quality',
        ),
        array(
            'id'       => 'section-upsell-product-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'section-related-product-start',
            'type'     => 'section',
            'title'    => esc_html__( 'Related Products', 'koganic' ),
            'indent'   => true,
        ),
        array(
            'id'       => 'related-product-title',
            'type'     => 'text',
            'title'    => esc_html__('Title', 'koganic'),
            'default'  => 'Related Products',
        ),
        array(
            'id'       => 'related-product-desc',
            'type'     => 'text',
            'title'    => esc_html__('Description', 'koganic'),
            'default'  => 'Our collection hover on a look you like to shop the items related!',
        ),
        array(
            'id'       => 'section-related-product-end',
            'type'     => 'section',
            'indent'   => true,
        ),
    )
) );

Redux::setSection( $opt_name, array(
    'title'      => esc_html__('Catalog mode', 'koganic'),
    'id'         => 'shop-catalog',
    'subsection' => true,
    'fields'     => array(
        array(
            'id'       => 'catalog-mode',
            'type'     => 'switch',
            'title'    => esc_html__('Enable catalog mode', 'koganic'),
            'subtitle' => esc_html__('You can hide all "Add to cart" buttons, cart widget, cart and checkout pages. This will allow you to showcase your products as an online catalog without ability to make a purchase.', 'koganic'),
            'default'  => false
        ),        
    ),
) );

// Portfolio
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Portfolio', 'koganic' ),
    'id'     => 'portfolio',
    'icon'   => 'el el-filter',
    'fields' => array(
        array(
            'id'       => 'portfolio-title',
            'type'     => 'text',
            'title'    => esc_html__('Portfolio Title', 'koganic'),
            'default'  => esc_html__('Portfolio', 'koganic')
        ),
        array(
            'id'             => 'portfolio-title-color',
            'type'           => 'color',
            'title'          => esc_html__('Page heading color', 'koganic'),
            'default'        => '#000',
            'output'           => array('.title-portfolio.page-heading .entry-title'),
            'subtitle'       => esc_html__('Set your color options for heading.', 'koganic'),
        ),
        array(
            'id'               => 'portfolio-title-background',
            'type'             => 'background',
            'title'            => esc_html__('Portfolio heading background', 'koganic'),
            'subtitle'         => esc_html__('Set background image or color for portfolio.', 'koganic'),
            'output'           => array('.page-heading.title-portfolio'),
            'default'          => array(
                'background-color'    => '',
                'background-position' => 'center center',
                'background-size'     => 'cover'
            ),
        ),
        array(
            'id'       => 'portfolio-fullwidth',
            'type'     => 'switch',
            'title'    => esc_html__('Full Width portfolio', 'koganic'),
            'subtitle' => esc_html__('Makes container 100% width of the page', 'koganic'),
            'on'       => esc_html__('On', 'koganic'),
			'off'      => esc_html__('Off', 'koganic'),
			'default'  => 0,
        ),
        array(
            'id'       => 'portfolio-cat-filter',
            'type'     => 'switch',
            'title'    => esc_html__('Show categories filters', 'koganic'),
            'on'       => esc_html__('On', 'koganic'),
			'off'      => esc_html__('Off', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'portfolio-style',
            'type'     => 'select',
            'title'    => esc_html__( 'Portfolio Style', 'koganic' ),
            'subtitle' => esc_html__('You can use different styles for your projects.', 'koganic'),
            'options'  => array(
                'default'                 => esc_html__('Show text on mouse over', 'koganic'),
                'hover-inverse'           => esc_html__('Alternative', 'koganic'),
                'text-under-image'        => esc_html__('Text under image', 'koganic'),
                'text-under-image-shadow' => esc_html__('Text under image with shadow', 'koganic'),
            ),
            'default'  => 'default'
        ),
        array(
            'id'       => 'portfolio-columns',
            'type'     => 'button_set',
            'title'    => esc_html__('Portfolio columns', 'koganic'),
            'subtitle' => esc_html__('How many projects you want to show per row', 'koganic'),
            'options'  => array(
                2 => '2',
                3 => '3',
                4 => '4',
                5 => '5',
                6 => '6'
            ),
            'default' => 2
        ),
        array(
            'id'       => 'portfolio-spacing',
            'type'     => 'button_set',
            'title'    => esc_html__('Space between projects', 'koganic'),
            'subtitle' => esc_html__('You can set different spacing between blocks on portfolio page', 'koganic'),
            'options'  => array(
                0  => '0',
                10 => '10',
                20 => '20',
                30 => '30',
                40 => '40',
            ),
            'default' => 10
        ),
        array(
            'id'       => 'portfolio-number-per-page',
            'type'     => 'text',
            'title'    => esc_html__( 'Items per page', 'koganic' ),
            'subtitle' => esc_html__( 'How much items per page to show.', 'koganic' ),
            'validate' => 'numeric',
            'default'  => '11'
        ),
        array(
            'id'       => 'portfolio-pagination-type',
            'type'     => 'button_set',
            'title'    => esc_html__('Portfolio pagination', 'koganic'),
            'options'  => array(
                'number'   => esc_html__('Pagination links', 'koganic'),
                'loadmore' => esc_html__('Load more button', 'koganic'),
                'infinite' => esc_html__('Infinit scrolling', 'koganic'),
            ),
            'default' => 'number'
        ),
        array(
            'id'       => 'portfolio-navigation',
            'type'     => 'switch',
            'title'    => esc_html__('Portfolio navigation', 'koganic'),
            'on'       => esc_html__('On', 'koganic'),
			'off'      => esc_html__('Off', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'portfolio-related',
            'type'     => 'switch',
            'title'    => esc_html__('Related Portfolio', 'koganic'),
            'subtitle' => esc_html__('Show related portfolio carousel.', 'koganic'),
            'default' => true
        ),
    )
) );


// START Social Network
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Social Network', 'koganic' ),
    'id'     => 'social',
    'icon'   => 'el el-dribbble',
    'fields' => array(
        array(
            'id'       => 'facebook',
            'type'     => 'text',
            'title'    => esc_html__('Facebook', 'koganic'),
            'default'  => '#'
        ),
        array(
            'id'       => 'twitter',
            'type'     => 'text',
            'title'    => esc_html__('Twitter', 'koganic'),
            'default'  => '#'
        ),
        array(
            'id'       => 'behance',
            'type'     => 'text',
            'title'    => esc_html__('Behance', 'koganic'),
            'default'  => '#'
        ), 
        array(
            'id'       => 'instagram',
            'type'     => 'text',
            'title'    => esc_html__('Instagram', 'koganic'),
            'default'  => '#'
        ),               
        array(
            'id'       => 'google-plus',
            'type'     => 'text',
            'title'    => esc_html__('Google Plus', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'pinterest',
            'type'     => 'text',
            'title'    => esc_html__('Pinterest', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'vimeo',
            'type'     => 'text',
            'title'    => esc_html__('Vimeo', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'youtube',
            'type'     => 'text',
            'title'    => esc_html__('YouTube', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'dribbble',
            'type'     => 'text',
            'title'    => esc_html__('Dribbble', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'tumblr',
            'type'     => 'text',
            'title'    => esc_html__('Tumblr', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'linkedin',
            'type'     => 'text',
            'title'    => esc_html__('LinkedIn', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'flickr',
            'type'     => 'text',
            'title'    => esc_html__('Flickr', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'github',
            'type'     => 'text',
            'title'    => esc_html__('GitHub', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'lastfm',
            'type'     => 'text',
            'title'    => esc_html__('Last.fm', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'paypal',
            'type'     => 'text',
            'title'    => esc_html__('PayPal', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'wordpress',
            'type'     => 'text',
            'title'    => esc_html__('WordPress', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'skype',
            'type'     => 'text',
            'title'    => esc_html__('Skype', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'yahoo',
            'type'     => 'text',
            'title'    => esc_html__('Yahoo', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'reddit',
            'type'     => 'text',
            'title'    => esc_html__('Reddit', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'deviantart',
            'type'     => 'text',
            'title'    => esc_html__('DeviantART', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'steam',
            'type'     => 'text',
            'title'    => esc_html__('Steam', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'foursquare',
            'type'     => 'text',
            'title'    => esc_html__('Foursquare', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'xing',
            'type'     => 'text',
            'title'    => esc_html__('Xing', 'koganic'),
            'default'  => ''
        ),
        array(
            'id'       => 'stumbleupon',
            'type'     => 'text',
            'title'    => esc_html__('StumbleUpon', 'koganic'),
            'default'  => ''
        ),
    )
) );

// Social Media - Woo
Redux::setSection( $opt_name, array(
    'title'  => esc_html__( 'Social Share - Woo', 'koganic' ),
    'id'     => 'social-woo',
    'icon'   => 'el el-share',
    'fields' => array(
        array(
            'id' => 'enable_code_share',
            'type' => 'switch',
            'title' => esc_html__('Enable Code Share', 'koganic'),
            'default' => true
        ),
        array(
            'id'        =>'code_share',
            'type'      => 'textarea',
            'required'  => array('enable_code_share','=',true),
            'title'     => esc_html__('Addthis your code', 'koganic'), 
            'desc'      => esc_html__('You get your code share in https://www.addthis.com', 'koganic'),
            'validate'  => 'html_custom',
            'default'   => '<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-59f2a47d2f1aaba2"></script>'
        ),
    )
) );

// Maintenance
Redux::setSection( $opt_name, array(
    'title' => esc_html__( 'Maintenance Mode', 'koganic' ),
    'id'     => 'maintenance',
    'icon'   => 'el el-time',
    'fields' => array(
        array(
            'id'       => 'maintenance-mode',
            'type'     => 'switch',
            'title'    => esc_html__('Maintenance Mode', 'koganic'),
            'on'       => esc_html__('Enable', 'koganic'),
			'off'      => esc_html__('Disable', 'koganic'),
			'default'  => 0,
        ),
        array(
            'id'       => 'section-maintenance-background-start',
            'title'    => esc_html__('Maintenance Background', 'koganic'),
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'      => 'maintenance-background',
            'type'    => 'background',
            'title'   => esc_html__( 'Background', 'koganic' ),
            'background-color'      => false,
            'default' => array(
                'background-image'      => '',
                'background-color'      => ''
            ),
            'output' => 'body.offline'
        ),
        array(
            'id'       => 'section-maintenance-background-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'section-maintenance-text-start',
            'title'    => esc_html__('Maintenance Text', 'koganic'),
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'    => 'maintenance-title',
            'type'  => 'text',
            'title' => esc_html__( 'Title', 'koganic' ),
            'default' => 'COMING SOON'
        ),
        array(
            'id'    => 'maintenance-message',
            'type'  => 'textarea',
            'title' => esc_html__( 'Message', 'koganic' ),
            'default' => 'We are working very hard to give you the best experience with this one. You will love Jms Koganic as much as we do. It will morph perfectly on your needs!'
        ),
        array(
            'id'       => 'section-maintenance-text-end',
            'type'     => 'section',
            'indent'   => true,
        ),
        array(
            'id'       => 'maintenance-countdown',
            'type'     => 'switch',
            'title'    => esc_html__('Enable Countdown', 'koganic'),
            'on'       => esc_html__('Enable', 'koganic'),
			'off'      => esc_html__('Disable', 'koganic'),
			'default'  => 1,
        ),
        array(
            'id'       => 'maintenance-date',
            'type'     => 'select',
            'title'    => esc_html__('Date', 'koganic'),
            'options'  => array(
                '01' => '01',
				'02' => '02',
				'03' => '03',
				'04' => '04',
				'05' => '05',
				'06' => '06',
				'07' => '07',
				'08' => '08',
				'09' => '09',
				'10' => '10',
				'11' => '11',
				'12' => '12',
				'13' => '13',
				'14' => '14',
				'15' => '15',
				'16' => '16',
				'17' => '17',
				'18' => '18',
				'19' => '19',
				'20' => '20',
				'21' => '21',
				'22' => '22',
				'23' => '23',
				'24' => '24',
				'25' => '25',
				'26' => '26',
				'27' => '27',
				'28' => '28',
				'29' => '29',
				'30' => '30',
				'31' => '31'
            ),
            'default'  => '15',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
        array(
            'id'       => 'maintenance-month',
            'type'     => 'select',
            'title'    => esc_html__('Month', 'koganic'),
            'options'  => array(
                '01' => esc_html__('January', 'koganic'),
			    '02'  => esc_html__('Febuary', 'koganic'),
			    '03'  => esc_html__('March', 'koganic'),
			    '04'  => esc_html__('April', 'koganic'),
			    '05'  => esc_html__('May', 'koganic'),
			    '06'  => esc_html__('June', 'koganic'),
			    '07'  => esc_html__('July', 'koganic'),
			    '08'  => esc_html__('August', 'koganic'),
			    '09'  => esc_html__('September', 'koganic'),
			    '10' => esc_html__('October', 'koganic'),
			    '11' => esc_html__('November', 'koganic'),
			    '12' => esc_html__('December', 'koganic'),
            ),
            'default'  => '03',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
        array(
            'id'       => 'maintenance-year',
            'type'     => 'select',
            'title'    => esc_html__('Year', 'koganic'),
            'options'  => array(
				'2018' => '2018',
				'2019' => '2019',
				'2020' => '2020'
            ),
            'default'  => '2018',
            'required' => array( 'maintenance-countdown', '=', 1 )
        ),
    ),
) );