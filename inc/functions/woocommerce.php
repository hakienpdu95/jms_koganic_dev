<?php
if ( !class_exists( 'WooCommerce' ) ) return;

/**
 * ------------------------------------------------------------------------------------------------
 * Unhook the WooCommerce wrappers
 * ------------------------------------------------------------------------------------------------
 */
 /**/

remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );

// Cart page move totals
	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cart_totals', 10 );

if( !function_exists( 'koganic_primary_navigation_wrapper' ) ) {
	/**
	 * The primary navigation wrapper
	 */
	function koganic_primary_navigation_wrapper() {
		$content_class = '';
		echo '<div class="page-content">';
	}
}

if( !function_exists( 'koganic_primary_navigation_wrapper_close' ) ) {
	/**
	 * The primary navigation wrapper close
	 */
	function koganic_primary_navigation_wrapper_close() {
		echo '</div>';
	}
}
add_action('woocommerce_before_main_content', 'koganic_primary_navigation_wrapper', 10);
add_action('woocommerce_after_main_content', 'koganic_primary_navigation_wrapper_close', 10);


// Wrapp cart totals
add_action( 'woocommerce_before_cart_totals', function() {
	echo '<div class="cart-totals-inner">';
}, 1);
add_action( 'woocommerce_after_cart_totals', function() {
	echo '</div><!--.cart-totals-inner-->';
}, 200);

remove_action( 'woocommerce_before_single_product', 'wc_print_notices', 10 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );

if ( ! function_exists('koganic_add_to_cart_message') ) {
	function koganic_add_to_cart_message() {
		if( ! (isset( $_REQUEST['product_id'] ) && (int) $_REQUEST['product_id'] > 0 ) )
			return;

		$titles 	= array();
		$product_id = (int) $_REQUEST['product_id'];

		if ( is_array( $product_id ) ) {
			foreach ( $product_id as $id ) {
				$titles[] = get_the_title( $id );
			}
		} else {
			$titles[] = get_the_title( $product_id );
		}

		$titles     = array_filter( $titles );
		$added_text = sprintf( _n( '<div class="text-inner"><b>%s</b> has been added to your cart.</div>', '%s have been added to your cart.', sizeof( $titles ), 'koganic' ), '"' . wc_format_list_of_items( $titles ) . '"' );
		$message    = sprintf( '%s <a href="%s" class="wc-forward db">%s</a>', wp_kses( $added_text , 'allowed-html' ), esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View Cart', 'koganic' ) );
		$data       =  array( 'message' => apply_filters( 'wc_add_to_cart_message', $message, $product_id ) );

		wp_send_json( $data );

		exit();
	}
	add_action( 'wp_ajax_add_to_cart_message', 'koganic_add_to_cart_message' );
	add_action( 'wp_ajax_nopriv_add_to_cart_message', 'koganic_add_to_cart_message' );
}

if ( !function_exists('koganic_product_get_sale_percent') ) {
	/*
	 *	Single product: Get sale percentage
	 */

	function koganic_product_get_sale_percent( $product ) {
		if ( $product->get_type() === 'variable' ) {
			// Get product variation prices (regular and sale)
			$product_variation_prices = $product->get_variation_prices();

			$highest_sale_percent = 0;

			foreach( $product_variation_prices['regular_price'] as $key => $regular_price ) {
				// Get sale price for current variation
				$sale_price = $product_variation_prices['sale_price'][$key];

				// Is product variation on sale?
				if ( $sale_price < $regular_price ) {
					$sale_percent = round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );

					// Is current sale percent highest?
					if ( $sale_percent > $highest_sale_percent ) {
						$highest_sale_percent = $sale_percent;
					}
				}
			}

			// Return the highest product variation sale percent
			return $highest_sale_percent;
		} else {
			$regular_price = $product->get_regular_price();
			$sale_percent = 0;

			// Make sure the percentage value can be calculated
			if ( intval( $regular_price ) > 0 ) {
				$sale_percent = round( ( ( $regular_price - $product->get_sale_price() ) / $regular_price ) * 100 );
			}

			return $sale_percent;
		}
	}

}

/* New label in product
/* --------------------------------------------------------------------- */
if ( ! function_exists('koganic_add_new_label_product') ) {
	function koganic_add_new_label_product() {
		global $post;

		$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );

		$output = '';

		if ( is_array($options) && isset($options['wc-new-label']) && $options['wc-new-label'] !== '' ) : ?>
			<span class="badge new pa tc dib"><span class="new"><?php echo esc_html($options['wc-new-label']); ?></span></span>
		<?php endif;
	}
	add_action('woocommerce_before_shop_loop_item_title', 'koganic_add_new_label_product', 5);
}

if ( ! function_exists('koganic_label_single_product') ) {
	function koganic_label_single_product() {
		$options = get_post_meta( get_the_ID(), '_custom_single_product_options', true );
		$output = '';
		if ( is_array($options) && isset($options['wc-new-label']) && $options['wc-new-label'] !== '' ) : ?>
			<span class="badge new pa tc dib"><span class="new"><?php echo esc_html($options['wc-new-label']); ?></span></span>
		<?php endif;
	}
}

if ( !function_exists('koganic_wc_quickview') ) {
	/**
	 * Customize product quick view.
	 */
	function koganic_wc_quickview() {
		// Get product from request.
		if ( isset( $_POST['product'] ) && (int) $_POST['product'] ) {
			global $post, $product, $woocommerce;

			$id      = ( int ) $_POST['product'];
			$post    = get_post( $id );
			$product = get_product( $id );

			if ( $product ) {
				// Get quickview template.
				include KOGANIC_PATH . '/woocommerce/content-quickview-product.php';
			}
		}

		exit;
	}
	add_action( 'wp_ajax_koganic_quickview', 'koganic_wc_quickview' );
	add_action( 'wp_ajax_nopriv_koganic_quickview', 'koganic_wc_quickview' );
}

if ( ! function_exists('koganic_after_shop_loop_product') ) {
	function koganic_after_shop_loop_product() {
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'koganic_after_shop_loop_product', 5 );
}

/**
 * Show the product title in the product loop.
 */
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
if ( ! function_exists( 'koganic_woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H2.
	 */
	function koganic_woocommerce_template_loop_product_title() {
		echo get_the_title();
	}
}

add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
add_action( 'woocommerce_shop_loop_item_title', 'koganic_woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );

add_action( 'koganic_woocommerce_breadcrumb', 'woocommerce_breadcrumb', 10 );

// Product Shop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
add_action( 'koganic_woocommerce_result_count', 'woocommerce_result_count', 5 );

if ( ! function_exists( 'koganic_woocommerce_catalog_ordering' ) ) {
	function koganic_woocommerce_catalog_ordering() {
		global $wp_query;

		if ( 1 === (int) $wp_query->found_posts || ! woocommerce_products_will_display() ) {
			return;
		}

		$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );
		$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby', array(
			'menu_order' => esc_html__( 'Default', 'koganic' ),
			'popularity' => esc_html__( 'Popularity', 'koganic' ),
			'rating'     => esc_html__( 'Average rating', 'koganic' ),
			'date'       => esc_html__( 'Sort by newness', 'koganic' ),
			'price'      => esc_html__( 'Price low to high', 'koganic' ),
			'price-desc' => esc_html__( 'Price high to low', 'koganic' ),
		) );

		if ( ! $show_default_orderby ) {
			unset( $catalog_orderby_options['menu_order'] );
		}

		if ( 'no' === get_option( 'woocommerce_enable_review_rating' ) ) {
			unset( $catalog_orderby_options['rating'] );
		}

		wc_get_template( 'loop/orderby.php', array( 'catalog_orderby_options' => $catalog_orderby_options, 'orderby' => $orderby, 'show_default_orderby' => $show_default_orderby ) );
	}
}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

/**
 * ------------------------------------------------------------------------------------------------
 * My account remove logout link
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'koganic_remove_my_account_logout' ) ) {
	function koganic_remove_my_account_logout( $items ) {
		unset( $items['customer-logout'] );
		return $items;
	}
	add_filter( 'woocommerce_account_menu_items', 'koganic_remove_my_account_logout', 10 );
}

// -- MY ACCOUNT
if ( ! function_exists( 'koganic_my_account' ) ) {
	function koganic_my_account() {		
			$wp_registration_url = get_permalink( wc_get_page_id( 'myaccount' ) );		
		?>
		<div class="header-account btn-group box-hover compact-hidden mt-svg">
			<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" class="dropdown-toggle">
				<span><?php echo esc_html__( 'My account', 'koganic' ); ?></span>
			</a>
		    <div class="dropdown-menu">
                <ul>
					<?php if ( !is_user_logged_in() ) : ?>
						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-login">
				        	<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><?php echo esc_html__( 'Login', 'koganic' ); ?></a>
				        </li>

						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-register">
				        	<a href="<?php echo esc_url( $wp_registration_url ); ?>"><?php echo esc_html__( 'Register', 'koganic' ); ?></a>
				        </li>
					<?php endif; ?>

					<?php if ( is_user_logged_in() ) : ?>
						<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
				            <li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
								<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>"><span><?php echo esc_html( $label ); ?></span></a>
							</li>
				        <?php endforeach; ?>

						<?php if ( class_exists( 'WeDevs_Dokan' ) ) : ?>
							<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--dokan">
								<a href="<?php echo dokan_get_navigation_url(); ?>"><?php echo esc_html__( 'Vendor dashboard', 'koganic' ); ?></a>
							</li>
						<?php endif; ?>

						<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-logout">
				        	<a href="<?php echo wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php echo esc_html__( 'Logout', 'koganic' ); ?></a>
				        </li>
					<?php endif; ?>
			    </ul>
		    </div>
		</div>
        <?php
	}
}

if (!function_exists('koganic_header_account')) {
	function koganic_header_account() {
		if (!koganic_get_option('show-header-account', true)) {
			return;
		}

		if (koganic_woocommerce_activated()) {
			$account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
		} else {
			$account_link = wp_login_url();
		}
		?>
		<div class="header-account btn-group box-hover">
			<a href="<?php echo esc_html($account_link); ?>" class="<?php echo (!is_user_logged_in()) ? '' : 'dropdown-toggle'; ?>">
				<span>
					<?php if (!is_user_logged_in()) {
						echo esc_html__( 'Register', 'koganic' );
					} else {
						echo esc_html__( 'My account', 'koganic' );
					}
					?>
				</span>
			</a>
			<div class="dropdown-menu">
				<ul>
					<?php if (!is_user_logged_in()) {
						//koganic_login_dropdown();
					} else {
						koganic_account_dropdown();
					}
					?>
				</ul>
			</div>
		</div>
		<?php		
	}
}

if (!function_exists('koganic_login_dropdown')) {
	function koganic_login_dropdown() 
	{
		if (koganic_woocommerce_activated()) {
            $account_link = get_permalink(get_option('woocommerce_myaccount_page_id'));
        } else {
            $account_link = wp_registration_url();
        }
	?>
		<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-login">
        	<a href="<?php echo get_permalink( wc_get_page_id( 'myaccount' ) ); ?>"><?php echo esc_html__( 'Login', 'koganic' ); ?></a>
        </li>

		<li class="woocommerce-MyAccount-navigation-link woocommerce-MyAccount-navigation-link--customer-register">
        	<a href="<?php echo esc_url( $account_link ); ?>"><?php echo esc_html__( 'Register', 'koganic' ); ?></a>
        </li>
	<?php
	}
}

if (!function_exists('koganic_account_dropdown')) {
	function koganic_account_dropdown() {
	?>
		<?php if (koganic_woocommerce_activated()): ?>
			<li>
				<a href="<?php echo esc_url(wc_get_page_permalink('myaccount')); ?>"
				   title="<?php esc_html_e('Dashboard', 'koganic'); ?>"><?php esc_html_e('Dashboard', 'koganic'); ?></a>
			</li>
			<li>
				<a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"
				   title="<?php esc_html_e('Orders', 'koganic'); ?>"><?php esc_html_e('Orders', 'koganic'); ?></a>
			</li>
			<li>
				<a href="<?php echo esc_url(wc_get_account_endpoint_url('downloads')); ?>"
				   title="<?php esc_html_e('Downloads', 'koganic'); ?>"><?php esc_html_e('Downloads', 'koganic'); ?></a>
			</li>
			<li>
				<a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-address')); ?>"
				   title="<?php esc_html_e('Edit Address', 'koganic'); ?>"><?php esc_html_e('Edit Address', 'koganic'); ?></a>
			</li>
			<li>
				<a href="<?php echo esc_url(wc_get_account_endpoint_url('edit-account')); ?>"
				   title="<?php esc_html_e('Account Details', 'koganic'); ?>"><?php esc_html_e('Account Details', 'koganic'); ?></a>
			</li>
		<?php else: ?>
			<li>
				<a href="<?php echo esc_url(get_dashboard_url(get_current_user_id())); ?>"
				   title="<?php esc_html_e('Dashboard', 'koganic'); ?>"><?php esc_html_e('Dashboard', 'koganic'); ?></a>
			</li>
		<?php endif; ?>
		<li>
			<a title="<?php esc_html_e('Log out', 'koganic'); ?>" class="tips"
			   href="<?php echo esc_url(wp_logout_url(home_url())); ?>"><?php esc_html_e('Logout', 'koganic'); ?></a>
		</li>
	<?php
	}
}

if ( ! function_exists( 'koganic_header9_my_account' ) ) {
	function koganic_header9_my_account() {
	?>
	<div class="koganic-login">
		<a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_html_e('Login / Register','koganic'); ?>"><span><?php esc_html_e('Login / Register', 'koganic'); ?></span></a>  
	</div>
	<?php
	}
}
/**
 * Remove product in wishlist.
 */

if ( ! function_exists('koganic_remove_product_wishlist') ) {
	function koganic_remove_product_wishlist() {
		if ( ! ( isset ( $_POST['product_id'] ) && isset( $_POST['_nonce'] ) && wp_verify_nonce( $_POST['_nonce'], 'bb_koganic' ) ) ) {
			wp_send_json ( array(
				'status' => 'false',
				'notice' => esc_html__( 'Not validate.', 'koganic' )
			));
		}

		$product_id = intval( $_POST['product_id'] );

		$user_id = get_current_user_id();

		if( $user_id ) {
			global $wpdb;
			$sql = "DELETE FROM {$wpdb->yith_wcwl_items} WHERE user_id = %d AND prod_id = %d";
			$sql_args = array(
				$user_id,
				$product_id
			);
			$wpdb->query( $wpdb->prepare( $sql, $sql_args ) );
		} else {
			$wishlist = yith_getcookie( 'yith_wcwl_products' );
			foreach( $wishlist as $key => $item ){
				if( $item['prod_id'] == $product_id ){
					unset( $wishlist[ $key ] );
				}
			}
			yith_setcookie( 'yith_wcwl_products', $wishlist );
		}
		$data = array(
			'status' => 'true',
		);

		wp_send_json( $data );

		die();
	}
	// Delete product in wishlish
	add_action( 'wp_ajax_koganic_remove_product_wishlist', 'koganic_remove_product_wishlist' );
	add_action( 'wp_ajax_nopriv_koganic_remove_product_wishlist', 'koganic_remove_product_wishlist' );
}

if ( !function_exists('koganic_add_title_to_wishlist') ) {
	/**
	 * Add product title to wishlist notice.
	 */
	function koganic_add_title_to_wishlist() {
		$product_id = isset( $_POST['add_to_wishlist'] ) ? intval( $_POST['add_to_wishlist'] ) : 0;

		if( ! $product_id ) return;

		$product_title = get_the_title( $product_id );
		return '<span><b>' . esc_html( $product_title ) ."</b> ". esc_html__('has been added to your Wishlist', 'koganic') . '</span>';
	}
	add_filter( 'yith_wcwl_product_added_to_wishlist_message', 'koganic_add_title_to_wishlist' );
}

/**
 * Currency Dropdown
 */
if ( ! function_exists( 'koganic_currency' )  ) {
 	function koganic_currency() {
		if ( ! class_exists( 'Jms_Currency' ) ) return;

		global $post;

        // Get page options
        $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

        $header_design     = koganic_get_option('header-layout', 1);

        if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
            $header_design = $options['page-header'];
        }

		$currencies = Jms_Currency::getCurrencies();

		if ( (!empty($currencies)) && (count( $currencies ) ) ) {
			$woocurrency = Jms_Currency::woo_currency();
			$woocode = $woocurrency['currency'];
			if ( ! isset( $currencies[$woocode] ) ) {
				$currencies[$woocode] = $woocurrency;
			}
			$default = Jms_Currency::woo_currency();
			$current = isset( $_COOKIE['jms_currency'] ) ? $_COOKIE['jms_currency'] : $default['currency'];

			?>

			<div class="btn-group compact-hidden box-hover">
				<a href="javascript:void(0)" class="dropdown-toggle currency-dropdown">
					<?php echo (isset( $header_design ) && $header_design == '7') ? '<span class="bg">' : ''; ?>
						<span class="current"><?php echo esc_html( $current ) ?></span>
					<?php echo (isset( $header_design ) && $header_design == '7') ? '</span>' : ''; ?>
				</a>
				<div class="dropdown-menu currency-box">
					<ul>
						<?php foreach( $currencies as $code => $val ) : ?>
							<li>
								<a class="currency-item" href="javascript:void(0);" data-currency="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $code ); ?></a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<?php

		}
 	}
}

/* 	Koganic Wishlist
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'koganic_wishlist' ) ){
	function koganic_wishlist(){
			$wishlist_url = YITH_WCWL()->get_wishlist_url(); ?>
			<div class="header-wishlist btn-group">
	            <a href="<?php echo esc_url($wishlist_url);?>" class="dropdown-toggle">
					<?php 
					if(YITH_WCWL()->count_products() == 0 && YITH_WCWL()->count_products() === 0) :
						echo '<span class="wishlist_count_products no"></span>';
					else :
						echo '<span class="wishlist_count_products yes">'.YITH_WCWL()->count_products().'</span>';
					endif;
					?>
	            </a>
	        </div>
		<?php
	}
}


/* 	Header cart
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'koganic_header_cart' ) ) {
	function koganic_header_cart(){
		global $woocommerce;
		$cart_style  = koganic_get_option('wc-add-to-cart-style', 'alert');

		if( isset($_GET['cart_design']) && $_GET['cart_design'] != '' ) {
			$cart_style = $_GET['cart_design'];
		}

    	?>
        <div class="header-cart btn-group box-hover <?php echo esc_attr($cart_style); ?>">
            <a href="#" class="dropdown-toggle cart-contents">
                <samp class="cart-count pa"><?php echo esc_html($woocommerce->cart->cart_contents_count);?></samp>
            </a>
			<?php if ( isset($cart_style) && $cart_style != 'toggle-sidebar' ) : ?>
				<div class="widget_shopping_cart_content"></div>
			<?php endif; ?>
        </div>
	<?php
	}
}

if ( ! function_exists( 'koganic_header_9_link_cart' ) ) {
	function koganic_header_9_link_cart(){
		global $woocommerce; 

		?>

		<div class="header-cart">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
				<?php echo sprintf(_n('Cart (%d)', 'Cart (%d)', $woocommerce->cart->cart_contents_count, 'koganic'), $woocommerce->cart->cart_contents_count);?>
			</a>
		</div>

		<?php
	}
}

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 */

if ( !function_exists('koganic_header_cart_fragment') ) {
	function koganic_header_cart_fragment( $fragments ) {
		global $woocommerce;

		ob_start();
		?>
	    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="dropdown-toggle cart-contents" data-toggle="dropdown">
	        <samp class="cart-count pa"><?php echo esc_html($woocommerce->cart->cart_contents_count);?></samp>
	    </a>
		<?php
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;

	}
	add_filter('woocommerce_add_to_cart_fragments', 'koganic_header_cart_fragment');
}

/**
 * Load mini cart on header.
 */

if ( !function_exists('koganic_load_mini_cart') ) {
	function koganic_load_mini_cart() {
	 	$output = '';

	 	ob_start();
	 		$args['list_class'] = '';
	 		wc_get_template( 'cart/mini-cart.php' );

	 	$output = ob_get_clean();

	 	$result = array(
	 		'message'    => WC()->session->get( 'wc_notices' ),
	 		'cart_total' => WC()->cart->cart_contents_count,
	 		'cart_html'  => $output
	 	);
	 	echo json_encode( $result );
	 	exit;
	}
	add_action( 'wp_ajax_load_mini_cart', 'koganic_load_mini_cart' );
	add_action( 'wp_ajax_nopriv_load_mini_cart', 'koganic_load_mini_cart' );
}

if ( ! function_exists( 'koganic_shop_action_switch' ) ) {
	function koganic_shop_action_switch() {
		$product_view             = koganic_get_option( 'wc-product-view', 'grid' );
		$current_per_row          = koganic_get_option( 'wc-product-column', '4' );

		if ( isset($_GET['per_row']) && $_GET['per_row'] != '' ) {
			$current_per_row = $_GET['per_row'];
		}
		?>
		<div class="wc-switch flex">
			<?php if ($current_per_row !== '') { ?>
				<a href="#" class="<?php echo ( 'list' != $product_view ) ? 'active ' : ''; ?> <?php echo 'per-row-'.$current_per_row ?> grid">
					<i class="icon-view"></i>
				</a>
			<?php } ?>
			<a href="#" class="<?php echo ( 'list' == $product_view ) ? 'active ' : ''; ?>per-row-1 list">
				<i class="icon-view"></i>
			</a>
		</div>
		<?php
	}
}


if ( ! function_exists( 'koganic_woocommerce_shop_action' ) ) {
	function koganic_woocommerce_shop_action() {
		$shop_ordering        = koganic_get_option( 'wc-shop-ordering', 1 );
		$products_per_page	  = koganic_get_option( 'wc-products-per-page', 1 );

		?>
		<div class="shop-action">
			<div class="shop-action-inner flex">
				<?php koganic_shop_action_switch(); ?>				
				<div class="action-right flex middle-xs">
					<?php do_action('koganic_woocommerce_result_count'); ?>
					<?php if( $shop_ordering ) koganic_woocommerce_catalog_ordering(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}

if ( ! function_exists( 'koganic_taxonomy_archive_description' ) ) {
	function koganic_taxonomy_archive_description() {
		if ( is_product_taxonomy() && 0 === absint( get_query_var( 'paged' ) ) ) {
			$description = wc_format_content( term_description() );
			if ( $description ) {
				echo '<div class="term-description">' .$description. '</div>';
			}
		}
	}
	add_action( 'woocommerce_archive_description', 'koganic_taxonomy_archive_description', 10 );
}
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );


if ( ! function_exists('koganic_cart_remove_item') ) {
	function koganic_cart_remove_item() {
	    $item_key = $_POST['item_key'];

        $removed = WC()->cart->remove_cart_item( $item_key ); // Note: WP 2.3 >

        if ( $removed ) {
           $data['status'] = '1';
           $data['cart_count'] = WC()->cart->get_cart_contents_count();
           $data['cart_subtotal'] = WC()->cart->get_cart_subtotal();
        } else {
            $data['status'] = '0';
        }

        echo json_encode( $data );

        exit;
	}
	add_action( 'wp_ajax_cart_remove_item', 'koganic_cart_remove_item' );
	add_action( 'wp_ajax_nopriv_cart_remove_item', 'koganic_cart_remove_item' );
}

/* 	Product show per page
/* --------------------------------------------------------------------- */
if( ! function_exists( 'koganic_product_show_pager' ) ) {
	function koganic_product_show_pager() {
		$numbers = array(6, 8, 10, 12, 15, 16, 18, 20, 24, 27, 28, 30, 32, 33, 36, 40, 48, 60, 72 );

		$options   = array();
		$showproducts = get_query_var( 'posts_per_page' );
		if( ! $showproducts ) {
			$showproducts = koganic_get_option('products-show-per-page','12');
		}
		foreach ( $numbers as $number ):
			$options[] = sprintf(
				'<option value="%s" %s>%s %s</option>',
				esc_attr( $number ),
				selected( $number, $showproducts, false ),
				$number,'','');
		endforeach;
		?>
		<form class="show-products-number hidden-xs" method="get">
			<span><?php esc_html_e( 'Show:', 'koganic' ) ?></span>
			<select name="showproducts">
				<?php echo implode( '', $options ); ?>
			</select>
			<?php
			foreach( $_GET as $name => $value ) {
				if ( 'showproducts' != $name ) {
					printf( '<input type="hidden" name="%s" value="%s">', esc_attr( $name ), esc_attr( $value ) );
				}
			}
			?>
		</form>
		<?php
	}
}

/**
 * Change number of products to be displayed
 */

if ( !function_exists('koganic_change_product_per_page') ) {
	function koganic_change_product_per_page() {
		if ( isset( $_GET['showproducts'] ) ) {
			$number = absint( $_GET['showproducts'] );
		} else {
			$number = koganic_get_option( 'wc-number-per-page', '12' );
		}
		return $number;
	}
	add_filter( 'loop_shop_per_page', 'koganic_change_product_per_page' );
}


/* Product deal countdown
/* --------------------------------------------------------------------- */
if( ! function_exists( 'koganic_product_countdown_timer' ) ) {
	function koganic_product_countdown_timer() {
		global $post;
        $sale_date = get_post_meta( $post->ID, '_sale_price_dates_to', true );
        
        $countdown_title   = koganic_get_option('countdown_title', 'Offer Will End Through');

		if( ! $sale_date ) return;

        $timezone = 'GMT';

        if ( apply_filters( 'koganic_wp_timezone', false ) ) $timezone = wc_timezone_string();

		echo '<div class="koganic-countdown_box"><div class="koganic-countdown_inner"><div class="koganic-countdow-title">'.esc_attr( $countdown_title ).'</div><div class="koganic-product-countdown koganic-countdown" data-end-date="' . esc_attr( date( 'Y-m-d H:i:s', $sale_date ) ) . '" data-timezone="' . $timezone . '"></div></div></div>';
	}
	add_action( 'woocommerce_single_product_summary', 'koganic_product_countdown_timer', 1 );
}

if ( !function_exists('koganic_product_categories') ) {
	function koganic_product_categories() {
		global $product;
		global $post;
		
		$show_cats  = koganic_get_option('wc-category-name', 1);

		if ( $show_cats == 1 ) {
			echo wc_get_product_category_list( $product->get_id(), ', ', '<div class="product-cat"> ', '</div>' );
		} else {
			echo '';
		}
	}
}

if ( !function_exists('koganic_product_quickview') ) {
	function koganic_product_quickview() {
		global $post;

		$show_quickview = koganic_get_option('wc-quick-view', 0);

		if ( $show_quickview ) : ?>
			<div class="quickview hidden-xs"><a href="javascript:void(0)" class="button btn-quickview" data-product="<?php echo esc_attr( $post->ID ); ?>"><?php echo esc_html__('Quick View', 'koganic'); ?></a></div>
		<?php endif;
	}
}


if ( !function_exists('koganic_product_wishlist') ) {
	function koganic_product_wishlist() {
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}
}

if( ! function_exists( 'koganic_shop_page_link' ) ) {
	/**
	 * ------------------------------------------------------------------------------------------------
	 * Get base shop page link
	 * ------------------------------------------------------------------------------------------------
	 */
	function koganic_shop_page_link( $keep_query = false, $taxonomy = '' ) {
		// Base Link decided by current page
		if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
			$link = home_url();
		} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id('shop') ) ) {
			$link = get_post_type_archive_link( 'product' );
		} elseif( is_product_category() ) {
			$link = get_term_link( get_query_var('product_cat'), 'product_cat' );
		} elseif( is_product_tag() ) {
			$link = get_term_link( get_query_var('product_tag'), 'product_tag' );
		} else {
			$link = get_term_link( get_query_var('term'), get_query_var('taxonomy') );
		}

		return $link;
	}
}


if( ! function_exists( 'koganic_get_shop_view' ) ) {
	function koganic_get_shop_view() {
		if( ! class_exists('WC_Session_Handler') ) return;
		$s = WC()->session;
		if ( is_null( $s ) ) return koganic_get_option('wc-product-view', 'grid');

		if ( isset( $_REQUEST['product_view'] ) ) {
			return $_REQUEST['product_view'];
		}elseif ( $s->__isset( 'product_view' ) ) {
			return $s->__get( 'product_view' );
		} else {
			$product_view = koganic_get_option('wc-product-view', 'grid');
			if ( $product_view == 'grid' ) {
				return 'grid';
			} elseif( $product_view == 'list'){
				return 'list';
			}
		}
	}
}

if( ! function_exists( 'koganic_shop_view_action' ) ) {
	function koganic_shop_view_action() {
		if( ! class_exists('WC_Session_Handler')) return;
		$s = WC()->session;
		if ( is_null( $s ) ) return;

		if ( isset( $_REQUEST['product_view'] ) ) {
			$s->set( 'product_view', $_REQUEST['product_view'] );
		}
		if ( isset( $_REQUEST['per_row'] ) ) {
			$s->set( 'shop_per_row', $_REQUEST['per_row'] );
		}
	}
}

if ( ! function_exists( 'koganic_is_woo_ajax' ) ) {
	/**
	 * ------------------------------------------------------------------------------------------------
	 * is ajax request
	 * ------------------------------------------------------------------------------------------------
	 */
	function koganic_is_woo_ajax() {
		$request_headers = getallheaders();

		if( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return 'wp-ajax';
		}
		if( isset( $request_headers['x-pjax'] ) || isset( $request_headers['X-PJAX'] ) || isset( $request_headers['X-Pjax'] ) ) {
			return 'full-page';
		}
		if( isset( $_REQUEST['woo_ajax'] ) ) {
			return 'fragments';
		}
		if( isset( $_REQUEST['_pjax'] ) ) {
			return 'full-page';
		}

		if( isset( $_REQUEST['_pjax'] ) ) {
			return true;
		}
		return false;
	}
}

if( ! function_exists( 'koganic_my_account_wrapper_start' ) ) {
	/**
	 * ------------------
	 * My account wrapper
	 * ------------------
	 */
	function koganic_my_account_wrapper_start(){
		echo '<div class="woocommerce-my-account-wrapper">';
	}
	add_action( 'woocommerce_account_navigation', 'koganic_my_account_wrapper_start', 1 );
}

if( ! function_exists( 'koganic_my_account_wrapper_end' ) ) {
	function koganic_my_account_wrapper_end(){
		echo '</div><!-- .woocommerce-my-account-wrapper -->';
	}
	add_action( 'woocommerce_account_content', 'koganic_my_account_wrapper_end', 10000 );
}

if ( !function_exists('koganic_catalog_mode_init') ) {
	function koganic_catalog_mode_init() {
		/**
		 * WooCommerce catalog mode functions
		 */
		$catalog_mode = koganic_get_option( 'catalog-mode', 0 );

		if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
	        $catalog_mode = 1;
	    }

		if( ! $catalog_mode  ) return false;

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
	}
	add_action( 'wp', 'koganic_catalog_mode_init' );
}

if ( !function_exists('koganic_pages_redirect') ) {
	function koganic_pages_redirect() {
		$catalog_mode = koganic_get_option( 'catalog-mode', 0 );

		if( ! $catalog_mode  ) return false;

		$cart     = is_page( wc_get_page_id( 'cart' ) );
		$checkout = is_page( wc_get_page_id( 'checkout' ) );

		wp_reset_postdata();

		if ( $cart || $checkout ) {
			wp_redirect( home_url() );
			exit;
		}
	}
	add_action( 'wp', 'koganic_pages_redirect' );
}

if ( !function_exists('koganic_related_product_carousel_js') ) {
	function koganic_related_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.product-related-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});

			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: false,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'koganic'); ?>','<?php esc_html_e('Next', 'koganic'); ?>']
			});


		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('koganic_cross_sell_product_carousel_js') ) {
	function koganic_cross_sell_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.cross-sell-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});

			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: true,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'koganic'); ?>','<?php esc_html_e('Next', 'koganic'); ?>']
			});
		});
		<?php
		return ob_get_clean();
	}
}

if ( !function_exists('koganic_upsell_product_carousel_js') ) {
	function koganic_upsell_product_carousel_js() {
		ob_start();
		?>
		jQuery(document).ready(function($) {
			var owl_product = $('.upsell-product-carousel');
			var rtl = false;
			if ($('body').hasClass('rtl')) rtl = true;

			owl_product.on('initialized.owl.carousel', function(event) {
			    $(this).trigger('refresh.owl.carousel');
			});
			
			owl_product.owlCarousel({
				responsive : {
					320 : {
						items: 2,
					},
					560 : {
						items: 2,
					},
					767 : {
						items: 2,
					},
					991 : {
						items: 3,
					},
					1199 : {
						items: 4,
					}
				},
				lazyLoad : true,
				rtl: rtl,
				margin: 30,
				dots: true,
				nav: true,
				autoplay: false,
				loop: false,
				autoplayTimeout: 5000,
				smartSpeed: 250,
				autoHeight:true,
				navText: ['<?php esc_html_e('Prev', 'koganic'); ?>','<?php esc_html_e('Next', 'koganic'); ?>']
			});
		});
		<?php
		return ob_get_clean();
	}
}


remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
//remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 4);

/*
 * Add to cart ajax
 */
if( ! function_exists( 'koganic_ajax_add_to_cart' ) ) {
	function koganic_ajax_add_to_cart() {

		// Get messages
		ob_start();

		wc_print_notices();

		$notices = ob_get_clean();


		// Get mini cart
		ob_start();

		woocommerce_mini_cart();

		$mini_cart = ob_get_clean();

		// Fragments and mini cart are returned
		$data = array(
			'notices' => $notices,
			'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
					'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
				)
			),
			'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
		);

		wp_send_json( $data );

		die();
	}
	add_action( 'wp_ajax_koganic_ajax_add_to_cart', 'koganic_ajax_add_to_cart' );
	add_action( 'wp_ajax_nopriv_koganic_ajax_add_to_cart', 'koganic_ajax_add_to_cart' );
}


/* 	Koganic Compare
/* --------------------------------------------------------------------- */
if ( ! function_exists( 'koganic_compare' ) ){
	function koganic_compare(){
			$compare_url = home_url() . '/?action=yith-woocompare-view-table&iframe=yes'; ?>
			<div class="header-compare btn-group compare-button product">
	            <a href="<?php echo esc_url($compare_url);?>" class="compare added">
	                <svg width="24" height="24" viewBox="0 0 24 24">
						<use xlink:href="#icon-compare"></use>
					</svg>	
					<!-- <span></span> -->
	            </a>
	        </div>
		<?php
	}
}

/* Compare button
/* --------------------------------------------------------------------- */

if ( !function_exists('koganic_product_compare') ) {
	function koganic_product_compare() {
		$show_compare = koganic_get_option('wc-compare', 1);
		if( ! class_exists( 'YITH_Woocompare' ) ) return;

		echo '<li class="compare-button">';
            global $product;
            $product_id = $product->get_id();

            // return if product doesn't exist
            if ( empty( $product_id ) || apply_filters( 'yith_woocompare_remove_compare_link_by_cat', false, $product_id ) )
	            return;

            $is_button = ! isset( $button_or_link ) || ! $button_or_link ? get_option( 'yith_woocompare_is_button' ) : $button_or_link;

            if ( ! isset( $button_text ) || $button_text == 'default' ) {
                $button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'koganic' ) );
            }

            printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>', koganic_compare_add_product_url( $product_id ), 'compare' . ( $is_button == 'button' ? ' button' : '' ), $product_id, $button_text );

		echo '</li>';
	}
}

/* koganic_compare_add_product_url
/* --------------------------------------------------------------------- */
if( ! function_exists( 'koganic_compare_add_product_url' ) ) {
    function koganic_compare_add_product_url( $product_id ) {
    	$action_add = 'yith-woocompare-add-product';
        $url_args = array(
            'action' => 'asd',
            'id' => $product_id
        );
        return apply_filters( 'yith_woocompare_add_product_url', esc_url_raw( add_query_arg( $url_args ) ), $action_add );
    }
}


if( ! function_exists( 'koganic_product_list_info' ) ) {
    function koganic_product_list_info() {
    	global $product, $woocommerce_loop;
		$show_wishlist = koganic_get_option('wc-wishlist', 1);
    	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
		add_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 4); ?>

		<div class="product-list-info">
			<div class="pt-description">
				<?php koganic_product_categories(); ?>
					<?php do_action( 'woocommerce_shop_loop_item_title' ); ?>			
					<?php
					/**
					 * woocommerce_after_shop_loop_item_title hook.
					 *
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action( 'woocommerce_after_shop_loop_item_title' );
					?>
					<?php woocommerce_template_single_excerpt(); ?>	

				<ul class="product-btn flex">
					<?php
						$catalog_mode = koganic_get_option( 'catalog-mode', 0 );

						if ( isset($_GET['catalog-mode']) && $_GET['catalog-mode'] == 1 ) {
					        $catalog_mode = 1;
					    }

					if ( !$catalog_mode ) : ?>
						<li class="addtocart"><?php woocommerce_template_loop_add_to_cart(); ?></li>
					<?php endif; ?>	

					<?php if(class_exists('YITH_WCWL')) { ?>
						<li class="addtowishlist"><?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?></li>
					<?php } ?>

					<li class="quickview"><?php koganic_product_quickview(); ?></li>
				</ul>
			</div>
		</div>
		<?php
    }
}

// check for empty-cart get param to clear the cart
add_action( 'init', 'koganic_wc_clear_cart_url' );
if ( ! function_exists( 'koganic_wc_clear_cart_url' ) ) {
	function koganic_wc_clear_cart_url() {
	  global $woocommerce;
		
		if ( isset( $_GET['empty-cart'] ) ) {
			$woocommerce->cart->empty_cart(); 
		}
	}
}

// hide coupon field on the cart page
add_filter( 'woocommerce_coupons_enabled', 'koganic_disable_coupon_field_on_cart' );
if ( ! function_exists( 'koganic_disable_coupon_field_on_cart' ) ) {
	function koganic_disable_coupon_field_on_cart( $enabled ) {
		if ( is_cart() ) {
			$enabled = false;
		}
		return $enabled;
	}
}

//Custom Variation product in cart template
add_filter( 'woocommerce_product_variation_title_include_attributes', '__return_false' );
add_filter( 'woocommerce_is_attribute_in_product_name', '__return_false' );

if ( ! function_exists( 'koganic_customizing_variable_short_description_products' ) ) {
	function koganic_customizing_variable_short_description_products() {
		global $product;
		if( ! $product->is_type( 'variable' ) ) return;
		echo '<div class="woocommerce-variable__short-description">';
			echo wpautop($product->get_short_description());
		echo '</div>';
	}
}

if ( !function_exists('koganic_change_cross_sells_columns') ) {
	add_filter( 'woocommerce_cross_sells_columns', 'koganic_change_cross_sells_columns' ); 
	function koganic_change_cross_sells_columns( $columns ) {
		return 4;
	}
}

if ( !function_exists('koganic_change_cross_sells_product_no') ) {
	add_filter( 'woocommerce_cross_sells_total', 'koganic_change_cross_sells_product_no' );  
	function koganic_change_cross_sells_product_no( $columns ) {
		return 10;
	}
}

if ( !function_exists('koganic_wc_style_product_add_to_cart') ) {
    function koganic_wc_style_product_add_to_cart() {
    	global $product, $woocommerce_loop;

    	$_style_product = false;

		$product_style = koganic_get_option('wc-product-style');

		if ( !empty($woocommerce_loop['style_product']) ) {
			$product_style = $woocommerce_loop['style_product'];
		}

		if ( $product_style == 1 || $product_style == 5 || $product_style == 6) {
			$_style_product = true;
		}

        return $_style_product;
    }
}

if ( !function_exists('koganic_wc_type_product') ) {
    function koganic_wc_type_product($type_product) {
    	global $product, $woocommerce_loop;

    	$_support = false;

    	if( !empty($woocommerce_loop['type_product']) && isset($woocommerce_loop['type_product']) && $woocommerce_loop['type_product'] == $type_product ) {
    		$_support = true;
    	}

        return $_support;
    }
}

if ( ! function_exists( 'koganic_woocommerce_product_buttons' ) ) {
    // Change Product Buttons
    function koganic_woocommerce_product_buttons(){
        global $product;
        ?>
        <?php if(class_exists('YITH_WCWL') || class_exists('YITH_Woocompare')){ ?>
            <?php if(class_exists('YITH_WCWL')) { ?> 
                <div class="koganic-wishlist" style="display: flex;">
                   <?php echo do_shortcode( '[yith_wcwl_add_to_wishlist]' ); ?>
                </div>  
            <?php } ?>
            <?php if(class_exists('YITH_Woocompare')){ ?>
                <div class="koganic-compare" style="display: flex;">
                    <?php echo do_shortcode('[yith_compare_button]') ?>
                </div>
            <?php } ?>
        <?php } ?>
        <?php
    }
    add_action('woocommerce_after_add_to_cart_button', 'koganic_woocommerce_product_buttons', 10);
}

// share box
if ( !function_exists('koganic_woocommerce_share_box') ) {
    function koganic_woocommerce_share_box() {
        if ( koganic_get_option('enable_code_share',false)  && koganic_get_option('show_product_social_share', false) ) {
            ?>
              <div class="koganic-woo-share">
                <div class="addthis_inline_share_toolbox"></div>
              </div>
            <?php
        }
    }
    add_filter( 'woocommerce_single_product_summary', 'koganic_woocommerce_share_box', 100 );
}


remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
if ( ! function_exists( 'koganic_widget_shopping_cart_proceed_to_checkout' ) ) {

	/**
	 * Output the proceed to checkout button.
	 */
	function koganic_widget_shopping_cart_proceed_to_checkout() {
		echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward"><span>' . esc_html__( 'Check Out', 'koganic' ) . '</span></a>';
	}
}
add_action( 'woocommerce_widget_shopping_cart_buttons', 'koganic_widget_shopping_cart_proceed_to_checkout', 20 );

// To change add to cart text on single product page
add_filter( 'woocommerce_product_single_add_to_cart_text', 'koganic_woocommerce_custom_single_add_to_cart_text' ); 
function koganic_woocommerce_custom_single_add_to_cart_text() {
	global $product, $woocommerce_loop;

	$product_style = koganic_get_option('wc-product-style');
	if ( !empty($woocommerce_loop['style_product']) ) {
		$product_style = $woocommerce_loop['style_product'];
	}

	if($product_style == 1 || $product_style == 5 || $product_style == 6) {
		return esc_html( 'Buy now', 'koganic' ); 	
	} else {
		return esc_html( 'Add to cart', 'koganic' ); 	
	}	
}

// To change add to cart text on product archives(Collection) page
add_filter( 'woocommerce_product_add_to_cart_text', 'koganic_woocommerce_custom_product_add_to_cart_text' );  
function koganic_woocommerce_custom_product_add_to_cart_text() {
	global $product, $woocommerce_loop;

	$product_style = koganic_get_option('wc-product-style');
	if ( !empty($woocommerce_loop['style_product']) ) {
		$product_style = $woocommerce_loop['style_product'];
	}

	if($product_style == 1 || $product_style == 5 || $product_style == 6) {
		return esc_html( 'Buy now', 'koganic' );	
	} else {
		return esc_html( 'Add to cart', 'koganic' );	
	}	
}