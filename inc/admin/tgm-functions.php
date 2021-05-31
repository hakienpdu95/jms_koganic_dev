<?php
// Require the TGM_Plugin_Activation class.
include KOGANIC_PATH . '/inc/plugins/class-tgm-plugin-activation.php';

if ( ! function_exists( 'koganic_register_required_plugins' ) ) {
    function koganic_register_required_plugins() {
        $plugins = array(
            array(
                'name'                     => esc_html__( 'Elementor PageBuilder', 'koganic' ),
                'slug'                     => 'elementor',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/elementor.jpg',
                'required'                 => true
            ),
            array(
                'name'               => esc_html__('Revolution Slider', 'koganic'),
                'slug'               => 'revslider',
                'source'             => get_template_directory() . '/inc/plugins/revslider.zip',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/rev_slider.jpg',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_class'          => 'RevSlider',
                'plg_func'           => '',
            ),
            array(
                'name'               => esc_html__('Redux Framework', 'koganic'),
                'slug'               => 'redux-framework',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/reduxframework.jpg',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_class'          => 'ReduxFramework',
                'plg_func'           => '',
            ),
            array(
                'name'           => esc_html__('Woocommerce', 'koganic'),
                'slug'           => 'woocommerce',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/woocommerce.jpg',
                'required'       => true,
                'plg_class'      => 'WooCommerce',
                'plg_func'       => '',
            ),
            array(
                'name'               => esc_html__('Koganic Addons', 'koganic'),
                'slug'               => 'koganic-addons',
                'source'             => get_template_directory() . '/inc/plugins/koganic-addons.zip',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/jms_plugin.jpg',
                'required'           => true,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_func'           => 'koganic_addons_load_textdomain',
                'plg_class'          => '',
            ),
            array(
                'name'               => esc_html__('Ajax Search', 'koganic'),
                'slug'               => 'woosearch',
                'source'             => get_template_directory() . '/inc/plugins/ajaxsearch.zip',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/jms_plugin.jpg',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_func'           => '',
                'plg_class'          => 'WooSearch_Admin',
            ),
            array(
                'name'               => esc_html__('Jms Currency', 'koganic'),
                'slug'               => 'jmscurrency',
                'source'             => get_template_directory() . '/inc/plugins/jmscurrency.zip',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/jms_plugin.jpg',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_func'           => '',
                'plg_class'          => 'Jms_Currency',
            ),
            array(
                'name'               => esc_html__('WooCommerce Recently Bought', 'koganic'),
                'slug'               => 'woorebought',
                'source'             => get_template_directory() . '/inc/plugins/woorebought.zip',
                'image_url'          => get_template_directory_uri() . '/inc/plugins/images/jms_plugin.jpg',
                'required'           => false,
                'force_activation'   => false,
                'force_deactivation' => false,
                'external_url'       => '',
                'plg_func'           => '',
                'plg_class'          => 'WooReBought_Admin',
            ),
            array(
                'name'           => esc_html__('YITH WooCommerce Wishlist', 'koganic'),
                'slug'           => 'yith-woocommerce-wishlist',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/yith_wishlist.jpg',
                'required'       => false,
                'plg_class'      => 'YITH_WCWL',
                'plg_func'       => '',
            ),
            array(
                'name'           => esc_html__('YITH WooCommerce Compare', 'koganic'),
                'slug'           => 'yith-woocommerce-compare',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/yith_compare.jpg',
                'required'       => false,
                'plg_class'      => 'YITH_WOOCOMPARE',
                'plg_func'       => '',
            ),
            array(
                'name'           => esc_html__('YITH WooCommerce Ajax Product Filter', 'koganic'),
                'slug'           => 'yith-woocommerce-ajax-navigation',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/yith-woocommerce-ajax-navigation.jpg',
                'required'       => false,
                'plg_class'      => 'YITH_WCAN',
                'plg_func'       => '',
            ),
            array(
                'name'           => esc_html__('Contact Form 7', 'koganic'),
                'slug'           => 'contact-form-7',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/contact_form_7.jpg',
                'required'       => true,
                'plg_class'       => 'WPCF7',
                'plg_func'       => '',
            ),
            array(
                'name'           => esc_html__('MC4WP: Mailchimp for WordPress', 'koganic'),
                'slug'           => 'mailchimp-for-wp',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/mail-chimp.jpg',
                'required'       => true,
                'plg_class'      => 'MC4WP_Admin',
                'plg_func'       => '',
            ),
            array(
                'name'           => esc_html__('Variation Swatches for WooCommerce', 'koganic'),
                'slug'           => 'woo-variation-swatches',
                'image_url'      => get_template_directory_uri() . '/inc/plugins/images/wooswatches.jpg',
                'required'       => false,
                'plg_class'      => 'TA_WC_Variation_Swatches',
                'plg_func'       => '',
            )
        );

        $config = array(
            'default_path' => '',                      // Default absolute path to pre-packaged plugins.
            'menu'         => 'tgmpa-install-plugins', // Menu slug.
            'has_notices'  => true,                    // Show admin notices or not.
            'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
            'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
            'is_automatic' => true,                   // Automatically activate plugins after installation or not.
            'message'      => '',                      // Message to output right before the plugins table.
            'strings'      => array(
                'page_title'                      => esc_html__( 'Install Required Plugins', 'koganic' ),
                'menu_title'                      => esc_html__( 'Install Plugins', 'koganic' ),
                'installing'                      => 'Installing Plugin: %s', // %s = plugin name.
                'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'koganic' ),
                'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'koganic' ), // %1$s = plugin name(s).
                'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'koganic' ), // %1$s = plugin name(s).
                'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'koganic' ), // %1$s = plugin name(s).
                'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'koganic' ), // %1$s = plugin name(s).
                'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'koganic' ), // %1$s = plugin name(s).
                'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'koganic' ), // %1$s = plugin name(s).
                'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'koganic' ), // %1$s = plugin name(s).
                'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'koganic' ), // %1$s = plugin name(s).
                'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'koganic' ),
                'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'koganic' ),
                'return'                          => esc_html__( 'Return to Required Plugins Installer', 'koganic' ),
                'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'koganic' ),
                'complete'                        => esc_html__( 'All plugins installed and activated successfully.', 'koganic' ),
                'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
            )
        );

        tgmpa( $plugins, $config );

    }
    add_action('tgmpa_register', 'koganic_register_required_plugins');
}
