(function( $ ) {
	"use strict";

	var koganicTheme = {
		ajaxLinks: '.widget_product_categories a, .widget_product_tag_cloud a, .widget_layered_nav a, .order-by-filter a, .widget_ranged_price_filter li a',
	};

	//Helper function to get content by url
	var get_woocommerce_content = function (currentUrl) {
		$('body').addClass('shop-loading');

		if (currentUrl) {
			// Make sure the URL has a trailing-slash before query args (fix 301 redirect)
			currentUrl = currentUrl.replace(/\/?(\?|#|$)/, '/$1');
			window.history.pushState({ 'url': currentUrl, 'title': '' }, '', currentUrl);

			$.ajax({
				url: currentUrl,
				dataType: 'html',
				cache: false,
				headers: { 'cache-control': 'no-cache' },
				method: 'POST',
				success: function (response) {

					// Update shop content
					$( '.product-layout-wrapper' ).html($(response).find('.product-layout-wrapper').html());
					$( '.product-layout.products' ).html($(response).find('.product-layout.products').html());
					$( '.woocommerce-result-count' ).html($(response).find('.woocommerce-result-count').html());
					$( '.page-heading' ).html($(response).find('.page-heading').html());
					$( '.shop-filter-toggle' ).html($(response).find('.shop-filter-toggle').html());


					if($(response).find('.woocommerce-pagination').length > 0) {
						$( '.shop-action-bottom .woocommerce-pagination' ).html($(response).find('.woocommerce-pagination').html());
					} else {
						$( '.shop-action-bottom .woocommerce-pagination' ).empty();
					}

					if($(response).find('.koganic-ajax-loadmore').length > 0) {
						$( '.koganic-ajax-loadmore' ).html($(response).find('.koganic-ajax-loadmore').html());
					} else {
						$( '.koganic-ajax-loadmore' ).empty();
					}

					$('.shop-filter').html($(response).find('.shop-filter').html());
				},
				complete: function () {
					$('body').removeClass('shop-loading');
				}
			});
		}
	}

	//Woocommerce categories
	$(document).on('click', koganicTheme.ajaxLinks, function (e) {
		// This will prevent event triggering more then once
		if (e.handled !== true) {
			e.handled = true;
			e.preventDefault();
			$(this).closest('ul').find('.current').removeClass('current');
			$(this).closest('li').addClass('current');

			get_woocommerce_content($(this).attr('href'));
		}

	});

	$(document).on('click', '.woocommerce-pagination a', function (e) {

		$('html, body').animate({
			scrollTop : 0
		}, 500);

		// This will prevent event triggering more then once
		if (e.handled !== true) {
			e.handled = true;
			e.preventDefault();
			$(this).closest('ul').find('.current').removeClass('current');
			$(this).closest('li').addClass('current');

			get_woocommerce_content($(this).attr('href'));
		}

	});

	$(document).on('click', '.price_slider_amount .button', function (e) {

		$('html, body').animate({
			scrollTop : 0
		}, 500);

		if (e.handled !== true) {
			e.handled = true;
			e.preventDefault();
			var min_price = $('.price_slider_amount #min_price').val();
			var max_price = $('.price_slider_amount #max_price').val();
			var l = window.location;
			var shop_uri = l.origin + l.pathname;
			var href = l.href;
			var concat = shop_uri == href  ? '?' : '&';
			href = href + concat + $.param(
					{
						min_price: min_price,
						max_price: max_price
					}
				);
			get_woocommerce_content(href);
		}
	});

	jQuery('.wc-switch').each(function(){
		jQuery(this).find('.grid').on('click', function(event){
			event.preventDefault();
			
			jQuery('.wc-switch').find('.grid').addClass('active');
			jQuery('.wc-switch').find('.list').removeClass('active');

			jQuery('.product-layout-wrapper').removeClass('list-view');
			jQuery('.product-layout-wrapper').addClass('grid-view');
		});
		jQuery(this).find('.list').on('click', function(event){
			event.preventDefault();
		
			jQuery('.wc-switch').find('.list').addClass('active');
			jQuery('.wc-switch').find('.grid').removeClass('active');

			jQuery('.product-layout-wrapper').removeClass('grid-view');
			jQuery('.product-layout-wrapper').addClass('list-view');
		});
	});
})( jQuery );
