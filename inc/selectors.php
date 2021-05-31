<?php
/**
 * ------------------------------------------------------------------------------------------------
 * Prepare CSS selectors for theme settions (colors, borders, typography etc.)
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'koganic_custom_inline_css' ) ) {
    function koganic_custom_inline_css( $css = array() ) {
        if ( !class_exists ( 'ReduxFramework' ) ) return;

        // Color scheme
        $primary_color = koganic_get_option('primary-color', '#F86B73');


        if ( isset($_GET['color']) && $_GET['color'] != '' ) {
            $primary_color = '#' . $_GET['color'];
        }

        if ( isset($_GET['skin']) && $_GET['skin'] != '' ) {
            $vc_style = koganic_print_vc_body($_GET['skin']);
            $primary_color = $vc_style[0];
        }

        if(is_page( 'home-1' )) {
            $vc_style = koganic_print_vc_body('home-1');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-2' )) {
            $vc_style = koganic_print_vc_body('home-2');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-3' )) {
            $vc_style = koganic_print_vc_body('home-3');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-4' )) {
            $vc_style = koganic_print_vc_body('home-4');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-5' )) {
            $vc_style = koganic_print_vc_body('home-5');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-6' )) {
            $vc_style = koganic_print_vc_body('home-6');
            $primary_color = $vc_style[0];            
        }

        if(is_page( 'home-7' )) {
            $vc_style = koganic_print_vc_body('home-7');
            $primary_color = $vc_style[0];            
        }

        if ( isset($primary_color) && $primary_color != '' ) {
            $css[] = '
                .color-primary,
                a:hover,
                a:focus,
                a:active,
                tr.order-total strong .amount,
                td.product-name a:hover,
                td.product-subtotal .amount,
                .color,
                .header-action .header-block:hover i,
                .wrap-header .btn-group .dropdown-menu a:hover,
                .result-wrapper .content-price ins,
                .header-account .dropdown-menu ul li a:hover,
                .header-wrapper .single-button > a,
                .topbar .topbar-menu a:hover,
                .topbar.color-scheme-dark .topbar-menu li a:hover,
                .topbar.color-scheme-dark .topbar-menu li a:focus,
                .topbar.color-scheme-dark .dropdown-toggle:hover,
                .topbar a:hover,
                .topbar-right .box-hover:hover .language-dropdown,
                .topbar-right .box-hover:hover .currency-dropdown,
                .topbar-right .box-hover:hover .language-dropdown .pt-icon:before,
                .topbar-right .box-hover:hover .currency-dropdown .pt-icon:before,
                .menu-popup .close-menu-popup:hover:before,
                .popup-menu > li:hover > a,
                .popup-menu ul li:hover > a,
                .koganic-menu .dropdown-menu .column-heading:hover,
                .koganic-menu li a:hover,
                .koganic-menu li.current-menu-item > a,
                .custom-banner h3 span,
                .custom-banner .btn-transparent-color,
                .header-7 .header-menu .header-action i:hover,
                .header-9.header-fullwidth .header-action .account-icon .koganic-login a:hover,
                .header-9.header-fullwidth .header-action .header-cart > a:hover,
                .header-11 .container-fluid.first .header-action .header-11-navigation .koganic-menu .menu-item-link:hover,
                .header-12 > .topbar .header-position.topbar-left .social-list-icons li a:hover,
                .header-12 > .topbar .header-position.topbar-right a:hover,
                .header-12 .container.first .header-menu .header-12-navigation .koganic-menu .menu-item-link:hover,
                .pt-link,
                .pt-link:focus,
                .pt-link:hover,
                .pt-link:focus:hover,
                .not-found .entry-header:before,
                .icon-close:hover,
                .page-heading a:hover,
                .blog-post-loop.blog-design-default .entry-title a:hover,
                .entry-meta-list li.meta-author a:hover,
                .read-more-section a:hover,
                .blog-design-slider .blog-title a:hover,
                .koganic-single-bottom .tags-list a:hover,
                .koganic-single-bottom .tags-list a:focus,
                .comments-area #cancel-comment-reply-link,
                .comments-area .reply a,
                .comment-text .flex a,
                .widget_ranged_price_filter .ranged-price-filter li.current,
                .widget_order_by_filter li.current,
                .widget_ranged_price_filter .ranged-price-filter li.current a,
                .widget_order_by_filter li.current a,
                .widget_products ul.product_list_widget .wc-product .info .product-cat a:hover,
                .widget_products ul.product_list_widget .wc-product .info .product-title:hover,
                .cart_list li .desc .product_name:hover,
                .cart_list li .desc .remove i:hover,
                .product_list_widget > li .woocommerce-Price-amount,
                .widget.widget_koganic_recent_post .post-widget.list ul.posts-list > li .entry-content .media-body .entry-title a:hover,
                .special-filter .product-categories > li > a:hover,
                .special-filter .product-categories > li > a:focus,
                .special-filter .product-categories > li .count,
                .special-filter .product-categories > li.active > a,
                .product-box .product-cat a:hover,
                .product-box .product-info > a:hover,
                .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:hover .yith-wcwl-wishlistaddedbrowse.show a:before,
                .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:focus .yith-wcwl-wishlistaddedbrowse.show a:before,
                .addtocart .button-cart,
                .addtocart .button-cart:hover,
                .addtocart .button-cart:focus,
                .elementor-widget .product-style-list-1 a.woocommerce-loop-product__link:hover,
                .product-style-1 .button-cart,
                .product-style-2 .product-box .price,
                .product-style-2 .product-box .product-btn li .button,
                .product-style-2 .product-box .btn-wishlist .yith-wcwl-add-to-wishlist a,
                .product-style-3 .el--style-3 .btn-quickview,
                .product-style-4 .product-box .price,
                .product-style-5 .product-box .price ins,
                .product-list-info .woocommerce-LoopProduct-link:hover,
                .product-list-info .woocommerce-loop-product__link:hover,
                .list-product .product-info .price,
                .product-style-list-box .addtocart .button-cart:hover,
                .woocommerce-product-rating .woocommerce-review-link:hover,
                .product_meta a:hover,
                .entry-summary .compare.button:hover,
                .wishlist_table.mobile .remove_from_wishlist,
                body.woocommerce-checkout .woocommerce > .woocommerce-info a,
                .cartSidebarWrap .cart-sidebar-header .close-cart i:hover:before,
                .reset_variations:hover,
                .woocommerce div.product form.cart .reset_variations:before,
                .title-color-primary .title,
                .title-color-primary .subtitle,
                .type-title-4 p:hover,
                .banner-box .banner-text.pr-promo-type1 .button-banner:hover,
                .banner-box.box-type-3.banner-vertical-bottom .button-banner:hover,
                .koganic-button-wrapper a:hover,
                .koganic-button-wrapper a:focus,
                .button-color-primary a,
                .button-color-hover-primary a:hover,
                .portfolio-filter > a.selected,
                .portfolio-category .pt-btn-zoom a:hover,
                .portfolio-title a:hover,
                .image-carousel-box .title-image a:hover,
                .product-filter a.active,
                .jmsproduct-tab .nav-tabs > li.active > a,
                .jmsproduct-tab.design-tab-2 .nav-tabs > li.active > a,
                .team-member .member-social .koganic-social-icon a:hover,
                .icon-color-default .koganic-social-icon a:hover,
                .icon-color-black .koganic-social-icon a:hover,
                .icon-color-white .koganic-social-icon a:hover,
                .icon-color-primary .koganic-social-icon a,
                .koganic-price-table.price-style-alt .koganic-price-currency,
                .koganic-price-table.price-style-alt .koganic-price-value,
                .jmsproducttabs-elements .jms-tabs-title .koganic-tabs-header .koganic-tabs-filter a.filter-toggle:hover,
                .jmsproducttabs-elements .jms-tabs-title .koganic-tabs-header .koganic-tabs-filter a.filter-toggle span:after,
                .layout-1 .addon-title.t-flex p a:hover,
                .jms-tabs-title ul li.active,
                .jms-tabs-title ul li:hover,
                .loaderspinner3,
                .site-dark .footer-1 a:hover,
                .toggle-sidebar-widget .toggle-content .widget-social .social-list-icons li a:hover,
                .ui.search > .results .result .title:hover,
                .blog-post-loop .entry-title:hover > a,
                .btn-see-now .koganic-button:hover,
                div.single-product-container .info-summary .woocommerce-variation-price .price,
                .elementor-element.elementor-element-9b90f83 .jms-tabs-title ul li.active,
                .elementor-element.elementor-element-9b90f83 .jms-tabs-title ul li:hover,
                .elementor-element.elementor-element-d49c362 .elementor-accordion .elementor-accordion-icon,
                .elementor-element.elementor-element-d49c362 .elementor-accordion .elementor-accordion-title                                
                {
                    color: ' . esc_attr( $primary_color ) . ';
                }
            ';

            $css[] = '
                .border-color-primary,
                .btn-transparent:hover,
                .owl-theme .owl-dots .owl-dot.active:before,
                .primary-menu > li:hover > a,
                .newsletter-form input[type="email"]:focus,
                #newsletter-bottom .newsletter-form input[type="email"]:focus,
                .custom-banner .btn-transparent-color,
                .comment-form .submit:hover,
                .page-links > span.current:not(.page-links-title),
                .koganic-entry-content .page-links > a:hover,
                .widget_price_filter .price_slider_amount .button:hover,
                .product-style-1 .button-cart,
                .product-style-1 .button-cart:hover,
                .product-style-1 .product-box:hover,
                .product-style-4 .product-box .content-product-imagin,
                .product-style-4 .product-box .addtocart-thumb .button-cart:hover,
                .product-style-5 .product-box .button-cart:hover,
                .product-list-info .product-btn li .button.button-cart:hover,
                .product-list-info .product-btn li .button:hover,
                .product-list-info .product-btn li.addtowishlist:hover,
                .product-list-info .product-btn .button-cart,
                .product-list-info .product-btn .yith-wcwl-add-to-wishlist:hover,
                .product-list-info-box .addtocart .button-cart:hover,
                .koganic-pagination .page-numbers li span:hover,
                .koganic-pagination .page-numbers li a:hover,
                nav.woocommerce-pagination .page-numbers li span:hover,
                nav.woocommerce-pagination .page-numbers li a:hover,
                .koganic-pagination .page-numbers li .current,
                nav.woocommerce-pagination .page-numbers li .current,
                .entry-summary .attribute-wrap .imageswatch-variation.selected,
                .tabs-layout-tabs .wc-tabs > li:hover,
                .tabs-layout-tabs .wc-tabs > li.active,
                table.wishlist_table tr td.product-add-to-cart a.button:hover,
                .variation-attr .variation-attr_color .p-attr-color.active,
                .variation-attr .variation-attr_image .p-attr-image.active,
                .banner-box.box-type-3 .button-banner:hover,
                .border-color-primary a,
                .border-color-hover-primary a:hover,
                .testimonial-box .testimonial-avatar img,
                .testimonials-style-primary .pt-reviewsbox-author,
                .layout-1.jmsproducttabs-elements.search-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.filter-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.search-active.filter-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.search-active .loadmore_product_btn:hover,
                .layout-1.jmsproducttabs-elements.filter-active .loadmore_product_btn:hover,
                .layout-1.jmsproducttabs-elements.search-active.filter-active .loadmore_product_btn:hover,
                .elementor-widget-shortcode .wpcf7 .group-contact input[type="submit"],
                .theme-koganic .wp-block-themepunch-revslider .uranus .tp-bullet.selected .tp-bullet-inner:before,
                .elementor-element.elementor-element-cd29c4f .banner-box .button-banner:hover,
                .elementor-element.elementor-element-a823645 .mc4wp-form-fields button[type="submit"]:hover                               
                {
                    border-color: ' . esc_attr( $primary_color ) . ';
                }
            ';
            
            $css[] = '
                .border-left-color-primary, 
                .loading:before
                {
                    border-left-color: ' . esc_attr( $primary_color ) . ';
                }
            ';

            $css[] = '
                {
                    border-right-color: ' . esc_attr( $primary_color ) . ';
                }
            ';

            $css[] = '
                .background-color-primary,
                .btn.btn-color-primary,
                .button.btn-color-primary,
                button.btn-color-primary,
                .added_to_cart.btn-color-primary,
                input.btn-color-primary[type="submit"],
                input.btn-color-primary[type="button"],
                input.btn-color-primary[type="reset"],
                .btn-transparent:hover,
                .checkout-button,
                .coupon .button,
                .checkout_coupon .button,
                .actions .update-cart,
                #place_order,
                #customer_login .button,
                .btn,
                .owl-theme .owl-dots .owl-dot.active,
                .owl-theme .owl-dots .owl-dot:hover,
                .owl-theme .owl-nav[class*="owl-"]:hover,
                #backtop:hover,
                .header-wishlist a span.yes,
                .header-cart .cart-count,
                .header-wrapper .single-button > a span:before,
                header .pt-box-info ul li a:before,
                .primary-menu > li > a span:before,
                .koganic-mobile-menu .menu-title,
                .koganic-popup-menu .menu-title,
                form.mc4wp-form > .mc4wp-form-fields button[type="submit"]:hover,
                .error404 .page-content .back--homepage a,
                .pt-link:before,
                .pt-link:focus:before,
                .contact-form-default .wpcf7-submit,
                .post-password-form input[type="submit"],
                .comment-form .submit:hover,
                .page-links > span:not(.page-links-title),
                .page-links > span.current:not(.page-links-title),
                .koganic-entry-content .page-links > a:hover,
                .widget_calendar #wp-calendar tbody a,
                .widget_shopping_cart_content .buttons a:hover,
                .widget_shopping_cart_content .buttons a:focus,
                .widget_price_filter .price_slider_amount .button:hover,
                .widget_price_filter .ui-slider .ui-slider-handle,
                .notice-cart .icon-notice,
                .badge,
                .product-style-1 .button-cart:hover,
                .product-style-3 .product-group-button .loop-add-to-cart .button-cart,
                .product-style-4 .product-box .btn-wishlist .yith-wcwl-add-to-wishlist:hover,
                .product-style-4 .product-btn li:hover .button,
                .product-style-5 .product-box .button-cart:hover,
                .product-style-6 .icon-btn li:hover,
                .product-list-info .product-btn li .button:hover,
                .product-list-info .product-btn .button-cart,
                .product-list-info-box .addtocart .button-cart:hover,
                .koganic-pagination .page-numbers li span:hover,
                .koganic-pagination .page-numbers li a:hover,
                nav.woocommerce-pagination .page-numbers li span:hover,
                nav.woocommerce-pagination .page-numbers li a:hover,
                .koganic-pagination .page-numbers li .current,
                nav.woocommerce-pagination .page-numbers li .current,
                .wc-single-video a:before,
                .single_add_to_cart_button:hover,
                table.wishlist_table tr td.product-add-to-cart a.button:hover,
                .woocommerce-MyAccount-content .button.view,
                .woocommerce-cart .wc-proceed-to-checkout > a,
                input.dokan-btn[type="submit"],
                a.dokan-btn,
                .dokan-btn,
                input.dokan-btn[type="submit"]:hover,
                input.dokan-btn[type="submit"]:focus,
                a.dokan-btn:hover,
                a.dokan-btn:focus,
                .dokan-btn:hover,
                .dokan-btn:focus,
                .addon-title.line-bottom-big h3:before,
                .addon-title.line-bottom-small h3:before,
                .addon-title.line-bottom-right h3:before,
                .title-color-primary .title.style-background,
                .title-color-primary .subtitle.style-background,
                .button-type-buton a,
                .button-type-border a,
                .banner-box .banner-text.pr-promo-type1 .button-banner .icon-arrow-right,
                .button-banner:hover:after,
                .banner-box.box-type-2 .banner-text.tc .title > p,
                .banner-box.box-type-3 .button-banner:hover,
                .banner-box.box-type-3.banner-vertical-bottom .button-banner .icon-arrow-right,
                .koganic-button-wrapper a:hover,
                .koganic-button-wrapper a:focus,
                .background-color-primary a,
                .background-color-hover-primary a:hover,
                .jmsproduct-tab .nav-tabs > li > a:after,
                .jmsproduct-tab.design-tab-2 .nav-tabs > li.active > a:after,
                .testimonials-style-primary .pt-reviewsbox-description,
                .megamenu-widget-wrapper h3:before,
                .countdown-style-primary .koganic-countdown > span,
                .koganic-price-table .koganic-plan-footer > a,
                .layout-1.jmsproducttabs-elements.search-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.filter-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.search-active.filter-active.show-loading .jmsproduct-elements.show-loading .loadmore_product_btn,
                .layout-1.jmsproducttabs-elements.search-active .loadmore_product_btn:hover,
                .layout-1.jmsproducttabs-elements.filter-active .loadmore_product_btn:hover,
                .layout-1.jmsproducttabs-elements.search-active.filter-active .loadmore_product_btn:hover,
                .layout-1 .jms-tabs-title ul li > span:after,
                .spinner1 .bounce11,
                .spinner1 .bounce22,
                .spinner4 .bounce11,
                .spinner4 .bounce22,
                .spinner4 .bounce33,
                .spinner5,
                .spinner6 .dot11,
                .spinner6 .dot22,
                .toggle-sidebar-button,
                .elementor-widget-blog .layout-1 .read-more-section a:after,
                .elementor-widget-shortcode .wpcf7 .group-contact input[type="submit"],
                .woocommerce-account .button,
                .elementor-element.elementor-element-8592606 .button-banner:hover,
                .theme-koganic #rev_slider_1_1_wrapper .uranus .tp-bullet.selected .tp-bullet-inner,
                .theme-koganic #rev_slider_1_1_wrapper .uranus .tp-bullet:hover .tp-bullet-inner,
                .elementor-element.elementor-element-cd29c4f .banner-box .button-banner:hover                                 
                {
                    background-color: ' . esc_attr( $primary_color ) .';
                }
            ';
        }

        /* Setting VC Body Default - Theme Settings */
        $default_font = 'Cerebri Sans Pro';
        $default_color = 'rgba(63,40,3,.7)';
        $body_font = koganic_get_option('default-font');
        if ( isset($body_font['font-family']) && $body_font['font-family'] != '' ) {
            $default_font = $body_font['font-family'];
        }
        if ( isset($body_font['color']) && $body_font['color'] != '' ) {
            $default_color = $body_font['color'];
        }
        
        if ( isset($_GET['skin']) && $_GET['skin'] != '' ) {
            $vc_style = koganic_print_vc_body($_GET['skin']);
            $default_color = $vc_style[1];
        }

        if(is_page( 'home-1' )) {
            $vc_style = koganic_print_vc_body('home-1');
            $default_color = $vc_style[1];            
        }

        if(is_page( 'home-2' )) {
            $vc_style = koganic_print_vc_body('home-2');
            $default_color = $vc_style[1];            
        }        

        if(is_page( 'home-3' )) {
            $vc_style = koganic_print_vc_body('home-3');
            $default_color = $vc_style[1];            
        }

        if(is_page( 'home-5' )) {
            $vc_style = koganic_print_vc_body('home-5');
            $default_color = $vc_style[1];            
        }

        if(is_page( 'home-6' )) {
            $vc_style = koganic_print_vc_body('home-6');
            $default_color = $vc_style[1];            
        }

        if(is_page( 'home-7' )) {
            $vc_style = koganic_print_vc_body('home-7');
            $default_color = $vc_style[1];            
        }

        if ( $default_font || $default_color ) {
            $css[] = '
                body {
                    font-family: "'.esc_attr( $default_font ).'", sans-serif;
                    color: '.esc_attr( $default_color ).';
                }
            ';
        }

        $default_mode_color = '';
        $site_mode_color = koganic_get_option('body-background');
        if ( isset($site_mode_color['background-color']) && $site_mode_color['background-color'] != '' ) {
            $default_mode_color = $site_mode_color['background-color'];
        }

        if ( $default_mode_color && !empty($default_mode_color) ) {
            $css[] = '
                html.style-mode {
                    background-color: '.esc_attr( $default_mode_color ).' !important;
                }
            ';
        }

        /* Setting VC Body Default - Theme Settings */

        $max_logo = koganic_get_option('max-width-logo');
        if ( isset($max_logo) && $max_logo != '' ) {
            $css[] = '
                .logo_image img{
                    max-width: '.esc_attr( $max_logo).'px;
                }
            ';
        }      

        return preg_replace( '/\n|\t/i', '', implode( '', $css ) );
    }
}
