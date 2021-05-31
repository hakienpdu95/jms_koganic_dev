<?php
if ( ! defined('ELEMENTOR_PATH') && ! class_exists('Elementor\Widget_Base') ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Function to get HTML block content
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'koganic_get_html_block' ) ) {
    function koganic_get_html_block($id) {
        if(\Elementor\Plugin::instance()->preview->is_preview_mode() && get_the_ID() === (int) $id ){
            $content = get_post_field('post_content', $id);
            $content = do_shortcode($content);
        }else{
            $content = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id, false );
        }
        
        return $content;
    }    
}

/**
 * ------------------------------------------------------------------------------------------------
 * Function to get HTML block content
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'koganic_get_footer_layout' ) ) {
    function koganic_get_footer_layout($id) {
        $content = get_post_field('post_content', $id);

        $content = do_shortcode($content);

        $shortcodes_custom_css = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
        if ( ! empty( $shortcodes_custom_css ) ) {
            $content .= '<style type="text/css" data-type="vc_shortcodes-custom-css">';
            $content .= $shortcodes_custom_css;
            $content .= '</style>';
        }

        return $content;
    }
}
