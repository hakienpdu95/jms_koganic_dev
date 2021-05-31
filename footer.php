    <div class="clearfix"></div>
    <?php

        global $post;
        $footer_class = '';
        
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );
        if ( isset( $options['disable-footer'] ) && $options['disable-footer'] == 1 ) {
            $show_footer = 0;
        }else{
            $show_footer = 1;
        }

        $footer_layout = koganic_get_option( 'footer-layout');
        if ( isset( $options['page-footer'] ) && $options['page-footer'] != '' ) {
            $footer_layout = $options['page-footer'];
        }

        
        
        if(isset($footer_layout) && $footer_layout !=''){
            $footer_class = str_replace(' ', '-', strtolower($footer_layout));
        } else {
            $footer_class = '';
        }
    ?>

<?php if ($show_footer) { ?>
    <footer id="footer-wrapper" class="footer <?php echo esc_attr($footer_class);?>">
        <?php
            if ( isset($footer_layout) && $footer_layout !='' ) {
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
                        if($jscomposer_template->post_title == $footer_layout){
                            $content = '';
                            $content .= \Elementor\Plugin::$instance->frontend->get_builder_content( $jscomposer_template->ID, false );
                            echo do_shortcode($content);
                        }
                    }
                }
            } else { ?>
                <div class="footer-block tc copyright_footer pb_60">
                    <p>
                        <?php
                            echo esc_html_e('Koganic store | © 2021 All rights reserved! Designed by Joommasters.','koganic');
                        ?>                        
                    </p>
                </div>
            <?php } ?>
    </footer>
<?php } ?>
<!-- <div style="background-color: red; height: 500px;"></div> -->
    <?php
    $cart_style = koganic_get_option('wc-add-to-cart-style', 'alert');

    if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
        $cart_style = $_GET['cart_design'];
    }

    if ( class_exists( 'WooCommerce' ) && isset($cart_style) && $cart_style != '' ) : ?>
        <div class="cartSidebarWrap">
            <div class="cart_wrap_content">
                <div class="cart-sidebar-header flex between-xs">
                    <div class="cart-sidebar-title">
                        <?php esc_html_e( 'Shopping cart', 'koganic' ); ?>
                    </div>
                    <div class="close-cart"><i class="sl icon-close"></i></div>
                </div>
                <div class="widget_shopping_cart_content"></div>
            </div>
        </div>
    <?php endif; ?>

</div><!-- #page -->

<?php $back_to_top = koganic_get_option('back-to-top', 1); if( !empty($back_to_top) && $back_to_top == 1 ) : ?>
    <a id="backtop">
        <span class="pt-icon">
            <svg version="1.1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><g><polygon fill="currentColor" points="20.9,17.1 12.5,8.6 4.1,17.1 2.9,15.9 12.5,6.4 22.1,15.9"></polygon></g></svg>
        </span>
        <span class="pt-text"><?php esc_html_e( 'BACK TO TOP', 'koganic' ); ?></span>
    </a>
<?php endif; ?>

<div class="modal-window container-loading">
    <div class="close btn-round round-animation">
        <i class="icon-close icons"></i>
    </div>
    <div class="btn-loading-disabled"></div>
    <div class="modal-content container-loading"></div>
</div>
    
<div data-theiastickysidebar-sidebarselector="&quot;#jms-column-one, #jms-column-two, .blog-container #main-sidebar, .shop-container #main-sidebar&quot;" data-theiastickysidebar-options="{&quot;containerSelector&quot;:&quot;&quot;,&quot;additionalMarginTop&quot;:45,&quot;additionalMarginBottom&quot;:0,&quot;updateSidebarHeight&quot;:false,&quot;minWidth&quot;:0,&quot;sidebarBehavior&quot;:&quot;modern&quot;,&quot;disableOnResponsiveLayouts&quot;:true}"></div>

<!-- W3TC-include-css -->
<?php wp_footer(); ?>
<!-- W3TC-include-js-head -->
</body>
</html>