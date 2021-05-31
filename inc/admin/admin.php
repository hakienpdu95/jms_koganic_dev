<?php

class Koganic_Theme_Admin {

    public function __construct() {
        add_action( 'admin_init', array( $this, 'admin_init' ) );
		global $pagenow;
		if ( $pagenow == 'admin.php' ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts'), 11 );
		}
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'after_switch_theme', array( $this, 'activation_redirect' ) );

    }

	function koganic_admin_script_local() {
		$localize_data = array(
			'ajax' => admin_url( 'admin-ajax.php' ),
		);

		// If we are on edit product attribute page
		if( ! empty( $_GET['page'] ) && $_GET['page'] == 'product_attributes' && ! empty( $_GET['edit'] ) && function_exists('wc_attribute_taxonomy_name_by_id')) {
			$attribute_id = absint( $_GET['edit'] );
			$attribute_name = wc_attribute_taxonomy_name_by_id( $attribute_id );
			$localize_data['attributeSwatchSize'] = woodmart_wc_get_attribute_term( $attribute_name, 'swatch_size' );
			$localize_data['attributeShowOnProduct'] = woodmart_wc_get_attribute_term( $attribute_name, 'show_on_product' );
		}

		if( class_exists('Redux') ) {
			$redux_options = array();
			$options_key = 'moros_options';
			$redux_sections = Redux::getSections($options_key);

			foreach ($redux_sections as $id => $section) {
				if( ! isset( $section['subsection'] ) ) {
					$parent_name = $section['title'];
					$parent_icon = $section['icon'];
				} else {
					$redux_sections[$id]['parent_name'] = $parent_name;
					$redux_sections[$id]['icon'] = $parent_icon;
				}
			}
			$options = Redux::$fields[$options_key];
			foreach ($options as $id => $option) {
				if( ! isset( $option['title'] ) ) continue;
				$text = $option['title'];
				if( isset($option['desc']) ) $text .= ' ' . $option['desc'];
				if( isset($option['subtitle']) ) $text .= ' ' . $option['subtitle'];
				if( isset($option['tags']) ) $text .= ' ' . $option['tags'];
				if( isset( $redux_sections[$option['section_id']]['subsection'] ) ) {
					 $path = $redux_sections[$option['section_id']]['parent_name'] . ' -> ' . $redux_sections[$option['section_id']]['title'];
				} else {
					$path = $redux_sections[$option['section_id']]['title'];
				}
				$redux_options[] = array(
					'id' => $id,
					'title' => $option['title'],
					'text' => $text,
					'section_id' => $redux_sections[$option['section_id']]['priority'],
					'icon' => $redux_sections[$option['section_id']]['icon'],
					'path' => $path,
				);
			}

			$localize_data['reduxOptions'] = $redux_options;
		}
		$localize_data['searchOptionsPlaceholder'] = esc_js(esc_html__('Search for options', 'koganic'));
		return apply_filters( 'moros_admin_script_local', $localize_data );
	}

	public function moros_admin_scripts_localize() {
		wp_localize_script( 'koganic-admin-js', 'koganicConfig', $this->koganic_admin_script_local() );
	}

	public function admin_enqueue_scripts( $hook ) {
		wp_enqueue_script( 'koganic-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array(), false, true );
		$this->moros_admin_scripts_localize();
    }

    public function add_wp_toolbar_menu_item( $title, $parent = false, $href = '', $custom_meta = array(), $custom_id = '' ) {

        global $wp_admin_bar;

        if ( current_user_can( 'edit_theme_options' ) ) {
            if ( ! is_super_admin() || ! is_admin_bar_showing() ) {
                return;
            }

            // Set custom ID
            if ( $custom_id ) {
                $id = $custom_id;
            } else { // Generate ID based on $title
                $id = strtolower( str_replace( ' ', '-', $title ) );
            }

            // links from the current host will open in the current window
            $meta = strpos( $href, site_url() ) !== false ? array() : array( 'target' => '_blank' ); // external links open in new tab/window
            $meta = array_merge( $meta, $custom_meta );

            $wp_admin_bar->add_node( array(
                'parent' => $parent,
                'id'     => $id,
                'title'  => $title,
                'href'   => $href,
                'meta'   => $meta,
            ) );
        }

    }

    public function activation_redirect() {
        if ( current_user_can( 'edit_theme_options' ) ) {
            header( 'Location:' . admin_url() . 'admin.php?page=koganic' );
        }
    }

    public function admin_init() {

        if ( current_user_can( 'edit_theme_options' ) ) {
            if ( isset( $_GET['koganic-deactivate'] ) && 'deactivate-plugin' == $_GET['koganic-deactivate'] ) {
                check_admin_referer( 'koganic-deactivate', 'koganic-deactivate-nonce' );

                $plugins = TGM_Plugin_Activation::$instance->plugins;

                foreach ( $plugins as $plugin ) {
                    if ( $plugin['slug'] == $_GET['plugin'] ) {
                        deactivate_plugins( $plugin['file_path'] );
                    }
                }
            } if ( isset( $_GET['koganic-activate'] ) && 'activate-plugin' == $_GET['koganic-activate'] ) {
                check_admin_referer( 'koganic-activate', 'koganic-activate-nonce' );

                $plugins = TGM_Plugin_Activation::$instance->plugins;

                foreach ( $plugins as $plugin ) {
                    if ( isset( $_GET['plugin'] ) && $plugin['slug'] == $_GET['plugin'] ) {
                        activate_plugin( $plugin['file_path'] );

                        wp_redirect( admin_url( 'admin.php?page=koganic-plugins' ) );
                        exit;
                    }
                }
            }
        }
    }

    public function admin_menu(){
        if ( current_user_can( 'edit_theme_options' ) ) {
            $add_menu = 'add_menu_' . 'page';
            $welcome_screen = $add_menu( 'Koganic', 'Koganic', 'administrator', 'koganic', array( $this, 'welcome_screen' ), 'dashicons-image-filter', 59 );

            $sub_menu = 'add_submenu_' . 'page';
            $welcome       = $sub_menu( 'koganic', esc_html__( 'Welcome', 'koganic' ), esc_html__( 'Welcome', 'koganic' ), 'administrator', 'koganic', array( $this, 'welcome_screen' ) );
            $plugins       = $sub_menu( 'koganic', esc_html__( 'Plugins', 'koganic' ), esc_html__( 'Plugins', 'koganic' ), 'administrator', 'koganic-plugins', array( $this, 'plugins_tab' ) );
            $samples       = $sub_menu( 'koganic', esc_html__( 'Install Samples', 'koganic' ), esc_html__( 'Install Samples', 'koganic' ), 'administrator', 'koganic-samples', array( $this, 'samples_tab' ) );
        }
    }

    public function welcome_screen() {
        require_once( get_template_directory() . '/inc/admin/admin_pages/welcome.php' );
    }

    public function samples_tab() {
        require_once( get_template_directory() . '/inc/admin/admin_pages/install-samples.php' );
    }

    public function plugins_tab() {
        require_once( get_template_directory() . '/inc/admin/admin_pages/koganic-plugins.php' );
    }

    public function plugin_link( $item ) {
        $installed_plugins = get_plugins();

        $item['sanitized_plugin'] = $item['name'];

        $actions = array();

        // We have a repo plugin
        if ( ! $item['version'] ) {
            $item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
        }

        /** We need to display the 'Install' hover link */
        if ( ! isset( $installed_plugins[$item['file_path']] ) ) {
            $actions = array(
                'install' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="'. esc_attr__('Install', 'koganic') .' %2$s">'. esc_html__('Install', 'koganic') .'</a>',
                    esc_url( wp_nonce_url(
                        add_query_arg(
                            array(
                                'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),
                                'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
                                'plugin_source' => urlencode( $item['source'] ),
                                'tgmpa-install' => 'install-plugin',
                                'return_url'    => 'koganic-plugins',
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-install',
                        'tgmpa-nonce'
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }
        /** We need to display the 'Activate' hover link */
        elseif ( !koganic_plugin_active($item['plg_class'], $item['plg_func']) ) {
            $actions = array(
                'activate' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="'. esc_attr__('Activate', 'koganic') .' %2$s">'. esc_html__('Activate', 'koganic') .'</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'               => urlencode( $item['slug'] ),
                            'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
                            'plugin_source'        => urlencode( $item['source'] ),
                            'koganic-activate'       => 'activate-plugin',
                            'koganic-activate-nonce' => wp_create_nonce( 'koganic-activate' ),
                        ),
                        admin_url( 'admin.php?page=koganic-plugins' )
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }
        /** We need to display the 'Update' hover link */
        elseif ( version_compare( $installed_plugins[$item['file_path']]['Version'], $item['version'], '<' ) ) {
            $actions = array(
                'update' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="'. esc_attr__('Update', 'koganic') .' %2$s">'. esc_html__('Update', 'koganic') .'</a>',
                    wp_nonce_url(
                        add_query_arg(
                            array(
                                'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
                                'plugin'        => urlencode( $item['slug'] ),

                                'tgmpa-update'  => 'update-plugin',
                                'plugin_source' => urlencode( $item['source'] ),
                                'version'       => urlencode( $item['version'] ),
                                'return_url'    => 'koganic-plugins',
                            ),
                            TGM_Plugin_Activation::$instance->get_tgmpa_url()
                        ),
                        'tgmpa-update',
                        'tgmpa-nonce'
                    ),
                    $item['sanitized_plugin']
                ),
            );
        } elseif ( koganic_plugin_active($item['plg_class'], $item['plg_func']) ) {
            $actions = array(
                'deactivate' => sprintf(
                    '<a href="%1$s" class="button button-primary" title="'. esc_attr__('Deactivate', 'koganic') .' %2$s">'. esc_html__('Deactivate', 'koganic') .'</a>',
                    esc_url( add_query_arg(
                        array(
                            'plugin'                 => urlencode( $item['slug'] ),
                            'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
                            'plugin_source'          => urlencode( $item['source'] ),
                            'koganic-deactivate'       => 'deactivate-plugin',
                            'koganic-deactivate-nonce' => wp_create_nonce( 'koganic-deactivate' ),
                        ),
                        admin_url( 'admin.php?page=koganic-plugins' )
                    ) ),
                    $item['sanitized_plugin']
                ),
            );
        }

        return $actions;
    }

    public function let_to_num( $size ) {
        $l   = substr( $size, -1 );
        $ret = substr( $size, 0, -1 );
        switch ( strtoupper( $l ) ) {
            case 'P':
                $ret *= 1024;
            case 'T':
                $ret *= 1024;
            case 'G':
                $ret *= 1024;
            case 'M':
                $ret *= 1024;
            case 'K':
                $ret *= 1024;
        }
        return $ret;
    }
}

new Koganic_Theme_Admin();
$ajaxresponse_path = get_template_directory() . '/inc/admin/ajaxresponse.php';
require $ajaxresponse_path;
$ajax_response = new Koganic_Ajax_Response();
$main_import = get_template_directory() . '/inc/admin/import.php';
include $main_import;
$dummy_import = get_template_directory() . '/inc/admin/dummyimport.php';
include $dummy_import;
$main_import = new Koganic_Main_Import();
