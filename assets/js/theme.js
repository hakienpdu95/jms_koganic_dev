(function( $ ) {
	"use strict";

	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Enable masonry grid for gallery
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */
	var galleryMasonry = function() {
		if ( ($('.koganic-gallery').hasClass('gallery-design-masonry')) || ($('.koganic-gallery').hasClass('gallery-design-grid')) ) {
			// initialize Masonry after all images have loaded
			var $container = $('.gallery-wrapper');

			$container.imagesLoaded(function() {
				$container.isotope({
				  	itemSelector: '.gallery-wrapper .product-item',
				  	columnWidth: '.gallery-wrapper .product-item',
				  	percentPosition: true,
					layoutMode: 'masonry'
				})
			});
		}
	}

	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Enable masonry grid for blog
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */
	var blogMasonry = function() {
		if ( ! $('.koganic-loop-blog').hasClass('masonry-container') || $('.koganic-loop-blog').hasClass('blog-type-default') ) return;

		var $container = $('.masonry-container');

		// initialize Masonry after all images have loaded
		$container.imagesLoaded(function() {
			$container.isotope({
			  	itemSelector: '.blog-post-loop',
			  	columnWidth: '.blog-post-loop',
			  	percentPosition: true
			})
		});
	}

	var previewMasonry = function() {
		var $container = $('.preview-layout');
		
		// initialize Masonry after all images have loaded
		$container.imagesLoaded(function() {
			$container.isotope({
			  	itemSelector: '.element-item',
			  	columnWidth: '.element-item',
			  	percentPosition: true,
			  	layoutMode: 'masonry'
			})
		});	

		$container.imagesLoaded().progress(function() {
            $container.isotope("layout").addClass("pt-show");
        });
	}

	// Init openswatch update images
	function initOpenSwatch() {
		$( '.imageswatch-list-variations a' ).on( 'click', function(e) {
			e.preventDefault();

			var src = $( this ).data( 'thumb' );
			if ( src != '' ) {
				$( this ).closest( '.product-item' ).find( 'img.wp-post-image' ).first().attr( 'src', src );
				$( this ).closest( '.product-item' ).find( 'img.wp-post-image' ).first().attr( 'srcset', src );
			}
		});
	}

	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Enable masonry grid for portfolio
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */
	var portfolioMasonry = function() {
		if ( ! $('.portfolio-layout').hasClass('portfolio-masonry') ) return;

		var el = $('.portfolio-masonry');
		// initialize Masonry after all images have loaded
		el.imagesLoaded( function() {
			el.isotope({
			  	itemSelector: '.portfolio',
			  	columnWidth: '.portfolio',
			  	percentPosition: true
			});

			$('.portfolio-filter').on('click', 'a', function(e) {
				e.preventDefault();
				$('.portfolio-filter').find('.selected').removeClass('selected');
				$(this).addClass('selected');

				var filterValue = $(this).attr('data-filter');

				el.isotope({
					filter: filterValue
				});
			});
		});
	}

	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Load more button for blog || product and portfolio
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */

	function ajaxLoadMoreItem() {
		var btn_loadmore = $('.koganic-ajax-loadmore');

		btn_loadmore.each( function( i, val ) {
			var data_option = $(this).data( 'load-more' );

			if ( data_option !== undefined ) {
				var page      = data_option.page,
					container = data_option.container,
					layout    = data_option.layout,
					isLoading = false,
					anchor    = $( val ).find( 'a' ),
					next      = $( anchor ).attr( 'href' ),
					i 		  = 2;

				// Load more
				if ( layout == 'loadmore' ) {
					$( val ).on( 'click', 'a', function( e ) {
						e.preventDefault();
						anchor = $( val ).find( 'a' );
						next   = $( anchor ).attr( 'href' );

						$( anchor ).html( '<i class="fa fa-circle-o-notch fa-spin"></i>' + koganic_settings.loading );

						getData();
					});
				}

				// Infinite Scroll Loading
				if ( layout == 'infinite' ) {
					var animationFrame = function() {
						anchor = $( val ).find( 'a' );
						next   = $( anchor ).attr( 'href' );

						var bottomOffset = $( '.' + container ).offset().top + $( '.' + container ).height() - $( window ).scrollTop();

						if ( bottomOffset < window.innerHeight && bottomOffset > 0 && ! isLoading ) {
							if ( ! next )
								return;
							isLoading = true;
							$( anchor ).html( '<i class="fa fa-circle-o-notch fa-spin"></i>' + koganic_settings.loading );

							getData();
						}
					};

					var scrollHandler = function() {
						requestAnimationFrame( animationFrame );
					};

					$( window ).scroll( scrollHandler );
				}


				var getData = function() {
					$.get( next + '', function( data ) {
						var content    = $( '.' + container, data ).wrapInner( '' ).html(),
							newElement = $( '.' + container, data ).find( '.blog-post-loop, .product, .portfolio' );

						$( content ).imagesLoaded( function() {
							next = $( anchor, data ).attr( 'href' );
							$( '.' + container ).append( newElement ).isotope( 'appended', newElement );
						});

						$( anchor ).text( koganic_settings.load_more );

						if ( page > i ) {
							if ( koganic_settings !== undefined && koganic_settings.permalink == 'plain' ) {
								var link = next.replace( /paged=+[0-9]+/gi, 'paged=' + ( i + 1 ) );
							} else {
								var link = next.replace( /page\/+[0-9]+\//gi, 'page/' + ( i + 1 ) + '/' );
							}

							$( anchor ).attr( 'href', link );
						} else {
							$( anchor ).text( koganic_settings.no_more_item );
							$( anchor ).removeAttr( 'href' ).addClass( 'disabled' );
						}
						isLoading = false;
						i++;
					});
				}
			}

		});

	}


	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Banner hover effect with jquery panr
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */
	function bannerHoverParallax() {
		$('.banner-box.banner-hover-parallax').panr({
			sensitivity: 35,
			scale: false,
			scaleOnHover: true,
			scaleTo: 1.15,
			scaleDuration: .34,
			panY: true,
			panX: true,
			panDuration: 0.3,
			resetPanOnMouseLeave: true
		});
	}

	/*
     * [ Page Loader ] - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
     */
    var initPreLoader = function() {
	    $(window).load(function(){
	        if($('.preloader').length > 0){
	            $('.preloader').delay(300).fadeOut('slow');
	        }
	    });

    }

	// Initialize WC quantity adjust.
	function QuantityAdjust() {
		$( 'body' ).on( 'click', '.quantity .plus', function( e ) {
			var $input    = $( this ).parent().parent().find( 'input.input-text' ),
				$quantity = parseInt( $input.attr( 'max' ) ),
				$step     = parseInt( $input.attr( 'step' ) ),
				$val      = parseInt( $input.val() ),
				$button = $( '.single_add_to_cart_button' );

			if ( ( $quantity !== '' ) && ( $quantity <= $val + $step ) ) {
				$( '.quantity .plus' ).css( 'pointer-events', 'none' );
			}

			$input.val( $val + $step );

			$input.trigger( 'change' );
			$button.attr( 'data-quantity', $val + $step );
		});

		$( 'body' ).on( 'click', '.quantity .minus', function( e ) {
			var $input  = $( this ).parent().parent().find( 'input.input-text' ),
				$step   = parseInt( $input.attr( 'step' ) ),
				$val    = parseInt( $input.val() ) - $step,
				$button = $( '.single_add_to_cart_button' );

			if ( $val < $step ) $val = $step;
			$input.val( $val );

			$( '.quantity .plus' ).removeAttr( 'style' );

			$input.trigger( 'change' );
			$button.attr( 'data-quantity', $val );
		});
	}

	function BackToTop() {
        $(window).scroll(function(){
            if ($(this).scrollTop() >= 500) {
                $('#backtop').addClass('pt-show');
            } else {
                $('#backtop').removeClass('pt-show');
            }
	    });

		$( '#backtop' ).on( 'click', function(e) {
		    $('html, body').animate({
                scrollTop : 0
            }, 800);
		    return false;
	    });
    }

	function initToggleMenuSidebar() {
		$( '.header-action .menu-toggle' ).on( 'click', function (e) {
			e.preventDefault();
			$( 'body' ).toggleClass( 'has-toggle-sidebar' );
			$( '#sidebar-open-overlay' ).on( 'click', function() {
				$( 'body' ).removeClass( 'has-toggle-sidebar' );
			});
		});
	}

	//initNavigationMobile
    function initNavigationMobile(){
        $( window ).scroll(function (event) {
		    var scroll = $(window).scrollTop();
			if (scroll >= 100) {
				$("body .topbar-device-mobile").css({"position": "fixed"});
			}else{
				$("body .topbar-device-mobile").css({"position": "absolute"});
			}
		});
    }

	function initStickyHeader() {
		var header        = $( 'header.header-wrapper' );
		var	headerHeight  = header.outerHeight();

		if( ! $('body').hasClass('has-sticky-header') || header.length == 0 ) return;

		$(window).scroll(function(){
			var scroll = $(window).scrollTop();

			if ( $('body').hasClass('has-sticky-header') && ( scroll >= headerHeight + 200 ) ) {
				$('.header-sticky').addClass('show').fadeIn(200);;
				$('header.header-wrapper').css('opacity','0');
			} else {
				$('.header-sticky').removeClass('show').fadeOut(200);;
				$('header.header-wrapper').css('opacity','1');
				
			}
		});
	}

	function initStickyHeaderIntro() {
		var header        = $( '#landing-header header.header-wrapper' );
		var	headerHeight  = header.outerHeight();

		if( ! $('header.header-wrapper').hasClass('has-sticky-header-intro') || header.length == 0 ) return;

		$(window).scroll(function(){
			var scroll = $(window).scrollTop();

			if ( $('header.header-wrapper').hasClass('has-sticky-header-intro') && ( scroll >= headerHeight + 50 ) ) {
				$('.has-sticky-header-intro').addClass('stuck');
			} else {
				$('.has-sticky-header-intro').removeClass('stuck');
			}
		});
	}

	function initStickyHeaderMobile() {
		var header        = $( 'header.header-wrapper' );
		var	headerHeight  = header.outerHeight();

		if( ! $('body').hasClass('has-sticky-header') || header.length == 0 ) return;

		$(window).scroll(function(){
			var scroll = $(window).scrollTop();

			if ( $('body').hasClass('has-sticky-header') && ( scroll >= headerHeight + 200 ) ) {
				$('.header-sticky-mobile').addClass('show');
			} else {
				$('.header-sticky-mobile').removeClass('show');
			}
		});
	}

	/*
	 * [ Product Quickview ] - - - - - - - - - - - - - - - - - - - - - - - -
	 */
	function ProductQuickView() {
		$( 'body' ).on( 'click', '.btn-quickview', function( e ) {
			var _this = $( this );

			_this.addClass('loading');

			var id = _this.attr( 'data-product' ),
				data = {
					action: 'koganic_quickview',
					product: id
				};

			$.post( koganic_settings.ajaxurl, data, function( response ) {
				if ( typeof $.fn.magnificPopup != 'undefined' ) {
					$.magnificPopup.open( {
						items: {
							src: response
						},
						removalDelay: 500,
						callbacks: {
							beforeOpen: function() {
								this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
								this.st.mainClass = 'mfp-left-horizontal';
							},
							open: function() {
								if (typeof $.fn.tawcvs_variation_swatches_form !== 'undefined') {
								    $( '.variations_form' ).tawcvs_variation_swatches_form();
								}
								$( document.body ).trigger( 'tawcvs_initialized' );
							},
						},
					} );
				}

				setTimeout(function() {
					if ( $( '.product-quickview form' ).hasClass( 'variations_form' ) ) {
						$( '.product-quickview form.variations_form' ).wc_variation_form();
						$( '.product-quickview select' ).trigger( 'change' );
					}
				}, 100);

				_this.removeClass('loading');
				
				SlickSlider();

                jQuery('.product-type-variable .tawcvs-swatches .swatch').bind('click',function(e){
                    var optVal = jQuery(this).data('value'),
                        optValTitle = jQuery(this).attr('title'),
                        optAttr = jQuery(this).closest('.tawcvs-swatches').attr('data-attribute_name');
						
						jQuery('.'+optAttr+'').text(optVal);                        
                });

				$( '.images' ).imagesLoaded( function() {
					var imgHeight = $( '.product-quickview .single-product-thumbnail' ).outerHeight();

					if ( $( window ).width() > 767 ) {
						$( '.product-quickview .wc-single-product > div' ).css({
							'height': imgHeight
						});
					}

				});
			} );

			e.preventDefault();
			e.stopPropagation();
		} );
	}
	
	// slick slider
	var SlickSlider = function() {
		$( '.thumbnail-slider' ).not('.slick-initialized').slick();
	};

	// Carousel Slider
	var initCarousel = function() {
		var el = $( '.owl-carousel' );

		el.each( function( i, val ) {
			var _option = $( this ).data( 'carousel' );

			if ( _option !== undefined ) {
				var _selector   	   = _option.selector,
					_itemDesktop   	   = _option.itemDesktop,
					_itemSmallDesktop  = _option.itemSmallDesktop,
					_itemTablet        = _option.itemTablet,
					_itemMobile        = _option.itemMobile,
					_itemSmallMobile   = _option.itemSmallMobile,
					_margin            = _option.margin,
					_navigation        = _option.navigation,
					_pagination        = _option.pagination,
					_autoplay          = _option.autoplay,
					_loop        	   = _option.loop;

					if ( _margin == '0' ) {
						var marginSmallMobile = 0;
						var marginMobile = 0;
						var marginTablet = 0;
						var marginSmallDesktop = 0;
					}

					if ( _margin == '10' ) {
						var marginSmallMobile = 10;
						var marginMobile = 10;
						var marginTablet = 10;
						var marginSmallDesktop = 10;
					}

					if ( _margin == '20' ) {
						var marginSmallMobile = 10;
						var marginMobile = 10;
						var marginTablet = 20;
						var marginSmallDesktop = 20;
					}

					if ( _margin == '30' || _margin == '40' || _margin == '50' || _margin == '60' ) {
						var marginSmallMobile = 10;
						var marginMobile = 10;
						var marginTablet = 20;
						var marginSmallDesktop = 30;
					}

				var rtl = false;
			    if ($('body').hasClass('rtl')) rtl = true;

				$(_selector).owlCarousel({
			        responsive : {
			        	320 : {
			        		items: _itemSmallMobile,
							margin: marginSmallMobile
			        	},
						445 : {
			        		items: _itemMobile,
							margin: marginMobile
			        	},
						768 : {
			        		items: _itemTablet,
							margin: marginTablet
			        	},
					    991 : {
					        items: _itemSmallDesktop,
							margin: marginSmallDesktop
					    },
					    1199 : {
					        items: _itemDesktop,
					    }
					},
					rtl: rtl,
			        margin: _margin,
			        dots: _pagination,
			        nav: _navigation,
			        autoplay: _autoplay,
			        loop: _loop,
			        smartSpeed: 250,
					navText: ['next','prev']
			    });

			}
		} );

	}

	/*
	 * [ Parse URL to array ] - - - - - - - - - - - - - - - - - - - - - - - - -
	 */
	function Parse_Url_To_Array( url ) {
		if ( url.search( '&' ) == -1 )
			return false;

		var data = {}, queries, temp, i;

		// Split into key/value pairs
		queries = url.split( "&" );

		// Convert the array of strings into an object
		for ( i = 0; i < queries.length; i++ ) {
			temp = queries[ i ].split( '=' );
			data[ temp[ 0 ] ] = temp[ 1 ];
		}
		return data;
	}



	function AddToWishList() {
		$( 'body' ).on( 'click', '.yith-wcwl-add-button .add_to_wishlist', function( e ) {
			e.preventDefault();
		});

        $( document ).ajaxComplete( function( event, xhr, settings ) {
            var url = settings.url;
            var data_request = ( typeof settings.data != 'undefined' ) ? settings.data : '';
            
            if ( settings.data !== undefined ) {
                var data_array_url = Parse_Url_To_Array( settings.data );

                if ( data_array_url.action == 'add_to_wishlist' ) {

                	if($('.wishlist_count_products').is(':empty')) {
                		$('.wishlist_count_products').removeClass('no').addClass('yes');
                		$('.wishlist_count_products').text(1);
                	} else {
                		$('.wishlist_count_products').text( parseInt($('.wishlist_count_products').html()) + 1 );
                		console.log(1);
                		
                	}
                	

                    $( 'body > .notice-cart-wrapper' ).remove();
                    var content_notice = '<div class="notice-cart-wrapper"><div class="notice-cart"><div class="icon-notice"><i class="fa fa-heart-o"></i></div><div class="text-notice"><div> ' + xhr.responseJSON.message + ' </div><a class="db" href="' + xhr.responseJSON.wishlist_url + '">' + koganic_settings.viewall_wishlist + '</a></div></div></div>';
                    $( 'body' ).append( content_notice );

					var close = $( '<span class="close-notice icon-close icons"></span>' );

					$('body').on('click', '.close-notice', function() {
						$( this ).closest( '.notice-cart-wrapper' ).removeClass( 'active' );
					});

					$( 'body .notice-cart' ).prepend( close );

					setTimeout( function() {
						$( 'body > .notice-cart-wrapper' ).addClass( 'active' );
					}, '0' );

					setTimeout( function() {
						$( 'body > .notice-cart-wrapper' ).removeClass( 'active' );
					}, '5000' );

                }

            }
        });

		$( 'body' ).on( 'click', '.yith-wcwl-remove-button a', function( e ) {
			e.preventDefault();

			var _this   = $(this);
			var parent  = _this.closest( '.yith-wcwl-add-to-wishlist' );
			var loading = parent.find( '.yith-wcwl-remove-button .ajax-loading' );
			var add     = parent.find( '.yith-wcwl-add-button .add_to_wishlist' );

			_this.css( 'opacity', '0' );
			loading.css( 'visibility', 'visible' );
			add.css( 'opacity', '1' );

			var data_request = {
				action: 'koganic_remove_product_wishlist',
				_nonce: _nonce_koganic,
				product_id: _this.attr( 'data-product-id' )
			};

			$.ajax( {
				type: 'POST',
				url: koganic_settings.ajaxurl,
				data: data_request,
				success: function( val ) {
					if( val.status == 'true' ) {
						// Remove
						loading.css( 'visibility', 'hidden' );

						// Hide remove
						parent.find( '.yith-wcwl-remove-button' ).removeClass('show').hide();

						// Show add
						parent.find( '.yith-wcwl-add-button' ).removeClass('hide').show();

						// Show remove
						_this.css( 'opacity', '1' );
					}
				}
			} );

		} );
	}


	// Accordion mobile menu
	function ShowMobileMenu() {
		$( 'body' ).on( 'click', '.menu-toggle .menu-button', function (e) {
			e.preventDefault();

			if ( ! $( 'body' ).hasClass( 'menu-mobile-open-menu' ) ) {
				$( 'body' ).addClass( 'menu-mobile-open-menu' );
			}

			$('#sidebar-open-overlay, .koganic-mobile-menu .close-menu-mobile' ).on( 'click', function() {
				$( 'body' ).removeClass( 'menu-mobile-open-menu' );
			});
		});
	}

	function DropdownMenuMobile() {
        if( $( window ).width() < 992 ) {
            $( 'ul.mobile-menu li.menu-item-has-children' ).append( '<span class="holder"></span>' );
    		$( 'body' ).on('click','.holder',function() {
    			var el = $( this ).closest( 'li' );
    			if ( el.hasClass( 'open' ) ) {
    				el.removeClass( 'open' );
    				el.find( 'li' ).removeClass( 'open' );
    				el.find( 'ul' ).slideUp();
    			} else {
    				el.addClass( 'open' );
    				el.children( 'ul' ).slideDown();
    				el.siblings( 'li' ).children( 'ul' ).slideUp();
    				el.siblings( 'li' ).removeClass( 'open' );
    				el.siblings( 'li' ).find( 'li' ).removeClass( 'open' );
    				el.siblings( 'li' ).find( 'ul' ).slideUp();
    			}
    		});
        }
	};

	// Accordion popup menu
	function ShowPopupMenu() {
		$( '.menu-popup-button' ).on( 'click', function (e) {
			e.preventDefault();
			$( 'body' ).toggleClass( 'show-menu-popup' );
			$( '.close-menu-popup' ).on( 'click', function() {
				$( 'body' ).removeClass( 'show-menu-popup' );
			});
		});
	}

	function DropdownMenuPopup() {
        $( 'ul.popup-menu li.menu-item-has-children' ).append( '<span class="holders"></span>' );
		$( 'body' ).on('click','.holders',function() {
			var el = $( this ).closest( 'li' );
			if ( el.hasClass( 'open' ) ) {
				el.removeClass( 'open' );
				el.find( 'li' ).removeClass( 'open' );
				el.find( 'ul' ).slideUp();
			} else {
				el.addClass( 'open' );
				el.children( 'ul' ).slideDown();
				el.siblings( 'li' ).children( 'ul' ).slideUp();
				el.siblings( 'li' ).removeClass( 'open' );
				el.siblings( 'li' ).find( 'li' ).removeClass( 'open' );
				el.siblings( 'li' ).find( 'ul' ).slideUp();
			}
		});
	};

	function ShopFilterToggle() {
		$('.shop-filter-toggle').on('click', function (e) {
			var $this = $(this);
			$this.toggleClass('open');

			$('.shop-filter').slideToggle( '100' );
		});
	}

	// Init Countdown
	function initCountdown() {
		/**
		 *-------------------------------------------------------------------------------------------------------------------------------------------
		 * Sale final date countdown
		 *-------------------------------------------------------------------------------------------------------------------------------------------
		 */
		$( '.koganic-countdown' ).each(function(i, val){
			var time = moment.tz( $(this).data('end-date'), $(this).data('timezone') );
			$( this ).countdown( time.toDate(), function( event ) {
				$( this ).html( event.strftime(''
					+ '<span class="countdown-days">%-D <span>' + koganic_settings.days + '</span></span> '
					+ '<span class="countdown-hours">%H <span>' + koganic_settings.hours + '</span></span> '
					+ '<span class="countdown-min">%M <span>' + koganic_settings.mins + '</span></span> '
					+ '<span class="countdown-sec">%S <span>' + koganic_settings.secs + '</span></span>'));
			});
		});
	}

	// Init elevate zoom
	var initZoom = function() {
		if ( $( '.image-zoom' ).length > 0 ) {
			var img = $( '.image-zoom' ), img_src = $( '.image-zoom' ).data( 'src' );

			img.zoom({
				touch: false,
				url: img_src
			});
		}
	}

	// Init Magnific Popup
	var initMagnificPopup = function() {
		if ( $( '.wc-single-video, .video-link-product' ).length > 0 ) {
			$('.wc-popup-url').magnificPopup({
				type:'iframe',
			});
		}

		$('[data-rel="mfp[gallery]"]').magnificPopup({
			type: 'image',
			removalDelay: 500,
			callbacks: {
				beforeOpen: function() {
					this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
					this.st.mainClass = 'mfp-left-horizontal';
				}
			},
			image: {
				verticalFit: true
			},
			gallery: {
				enabled: true,
				navigateByImgClick: false
			},
		});

		$('.p-thumb').each(function() {
		    $(this).magnificPopup({
		        delegate: '.p-item a',
		        type: 'image',
				removalDelay: 500,
				callbacks: {
					beforeOpen: function() {
						this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
						this.st.mainClass = 'mfp-left-horizontal';
					}
				},
		        gallery: {
		          	enabled: true
		        },
		    });
		});
	}

	// Extra content on single product ( Help & Shipping - Return )
	var wcShippingContent = function() {
		$( 'body' ).on( 'click', '.koganic-wc-help', function(e) {
			$( '.site' ).after( '<div class="loader"><div class="loader-inner"></div></div>' );

			var data = { action: 'koganic_shipping_return' }

			$.post( koganic_settings.ajaxurl, data, function( response ) {
				$.magnificPopup.open({
					items: {
						src: response
					},
				});
				$( '.loader' ).remove();
			});
			e.preventDefault();
			e.stopPropagation();
		});
	}

	// Refesh mini cart on ajax event
	function refreshMiniCart() {
		$.ajax({
			type: 'POST',
			url: koganic_settings.ajaxurl,
			dataType: 'json',
			data: {
				action:'load_mini_cart'
			},
			success:function( response ) {
				
				var cart_list = $( '.widget_shopping_cart_content' );

				if ( response.cart_html.length > 0 ) {
					var checkterm;

					var parsed = $.parseHTML(response.cart_html);
        			
        			var result = $(parsed).find(".cart_list");


        			result.each(function (index, value) {
        				checkterm = $(result).find('li.mini_cart_item');

        				$('.header-cart').find(cart_list).css({
							'min-height': '1px'
					    });

						$('body').on('click', 'li.mini_cart_item a.remove', function (e) {
							$('.header-cart').find(cart_list).stop(); 
						});

        			});

					cart_list.html( response.cart_html );

					if( checkterm ) {
						if ( checkterm.length > 2 ) {
							$('.widget_shopping_cart_content .scrollbar_cart').addClass('perfectScrollbar');
						} else {
							$('.widget_shopping_cart_content .scrollbar_cart').removeClass('perfectScrollbar');
						}						
					}
				}

				$( '.cart-contents .cart-count' ).text( response.cart_total );

				
			}
		});
	}

	// Add to cart alert (in product box)
	var addToCartAlert = function() {
		if ( !$('body').hasClass('add-to-cart-style-alert') ) return;

		$( document ).ajaxComplete( function( event, xhr, settings ) {
            var url = settings.url;
            var data_request = ( typeof settings.data != 'undefined' ) ? settings.data : '';

			if ( url.search( 'wc-ajax=add_to_cart' ) != -1 ) {

				if ( !( settings.data != undefined && xhr.responseJSON != undefined && xhr.responseJSON.cart_hash != undefined ) )
					return false;

				var data_array_url = Parse_Url_To_Array( settings.data );

				$.ajax( {
					type: 'POST',
					url: koganic_settings.ajaxurl,
					data: {
						action: 'add_to_cart_message',
						product_id: data_array_url.product_id
					},
					success: function( val ) {
						showCartAlert(val);
					}
				} );
			}
        });
	}

	// Add to cart alert (in single product)
	var addToCartSingleAlert = function() {
		if ( !$('body').hasClass('add-to-cart-style-alert') ) return;

		var _input = $( '.quantity input' ), _quantity = _input.attr( 'max' );

		if ( _quantity != '' ) {
			_input.on( 'keyup mouseup change click', function () {
				if ( parseInt( $( this ).val() ) > parseInt( _quantity ) ) {
					$( '.single_add_to_cart_button' ).addClass( 'disabled' );
				} else {
					$( '.single_add_to_cart_button' ).removeClass( 'disabled' );
				}
			});
		}

		$( 'body' ).on( 'click', '.single_add_to_cart_button', function(e) {
			e.preventDefault();
			e.stopPropagation();

			var _this = $( this ),
				_form = _this.parents( 'form' );

			if ( _this.hasClass( 'disabled' ) ) return;

			_this.addClass( 'loading' );
			_this.removeClass( 'added' );
			if(koganic_settings.JmsSiteURL.indexOf('index.php') != -1){
				var ajax_url = koganic_settings.JmsSiteURL;
			} else {
				var ajax_url = koganic_settings.JmsSiteURL + '/index.php';
			}
			$.ajax({
				type: 'POST',
				url: ajax_url,
				dataType: 'html',
				data: _form.serialize(),
				cache: false,
				headers: { 'cache-control': 'no-cache' },
				success:function() {
					_this.addClass( 'added' );
					_this.removeClass( 'loading' );

					refreshMiniCart();
					add_to_cart_ajax( _this );
				}
			});
		});
	}

	function add_to_cart_ajax( _this ) {
		var form_cart = _this.closest( 'form' );
		var data_post = form_cart.serialize();
		var productID = _this.attr('data-product_id');

		$.ajax( {
			type: 'POST',
			url: koganic_settings.ajaxurl,
			data: {
				action: 'add_to_cart_message',
				product_id: productID
			},
			success: function( val ) {
				showCartAlert(val);
			}
		} );

	}

	function showCartAlert(val) {
		if ( val.message == undefined )
			return false;

		$( 'body > .notice-cart-wrapper' ).remove();
		var content_notice = '<div class="notice-cart-wrapper"><div class="notice-cart"><div class="icon-notice"><i class="fa fa-shopping-bag"></i></div><div class="text-notice">' + val.message + '</div></div></div>';
		$( 'body' ).append( content_notice );

		var close = $( '<span class="close-notice icon-close icons"></span>' );

		$('body').on('click', '.close-notice', function() {
			$( this ).closest( '.notice-cart-wrapper' ).removeClass( 'active' );
		});

		$( 'body .notice-cart' ).prepend( close );

		setTimeout( function() {
			$( 'body > .notice-cart-wrapper' ).addClass( 'active' );
		}, '0' );

		setTimeout( function() {
			$( 'body > .notice-cart-wrapper' ).removeClass( 'active' );
		}, '5000' );
	}


	// Remove item in shopping cart
	function removeCartItem() {
		$('body').on('click', '.mini_cart_item a.remove', function (e) {
			e.preventDefault();
			var $this = $(this);
			var $productKey = $(this).data('item-key');

			$this.closest('li').addClass('loading');

			// Ajax action
			$.ajax({
				url: koganic_settings.ajaxurl,
				dataType: 'json',
				type: 'POST',
				cache: false,
				headers: { 'cache-control': 'no-cache' },
				data: {
					'action': 'cart_remove_item',
					'item_key': $productKey
				},
				success: function (response) {
					refreshMiniCart();
				}
			});
		});
	}


	function addSliderOpacity(){
		// add class centerActiveItem in owl carousel
		$('.slider-opacity').on('initialized.owl.carousel', function(event) {
		    var total = $(this).find('.owl-stage .owl-item.active').length;
				$(this).find('.owl-stage .owl-item.active').each(function(index){
			        if ((index !== 0) && (index !== total - 1))  {
			            $(this).addClass('centerActiveItem');
			        }
			    });
	    });
	    $('.slider-opacity').on('translate.owl.carousel', function(event) {
	    	$(this).find('.owl-stage .owl-item').removeClass('centerActiveItem');
	    });
	    $('.slider-opacity').on('translated.owl.carousel', function(event) {
	    	var total = $(this).find('.owl-stage .owl-item.active').length;;
			$(this).find('.owl-stage .owl-item.active').each(function(index){
	            if ((index !== 0) && (index !== total - 1))  {
	            $(this).addClass('centerActiveItem');
	        }
	        });
	    });
	}

	 // Arrow product position
    function loadmoreproduct() {
        var intervalID;

        $('.jmsproduct-elements').each(function() {
            var $this = $(this),
                cache = [],
                inner = $this.find('.koganic-products-holder');

            var btnLoadmore     = $this.find('.loadmore_product_btn a');
            
            cache[1] = {
                items: inner.html(),
                status: 'have-posts'
            };

            $this.find('.loadmore_product_btn a').on('click', function(e) {
				// This will prevent event triggering more then once
				e.preventDefault();
                if( $(this).hasClass('disabled') ) return;

                clearInterval(intervalID);

                var atts     = inner.data('atts'),
                    maxPaged = btnLoadmore.attr('data-max-paged'),
                    paged    = inner.attr('data-paged');
                paged++;

                loadProducts( atts, paged, inner, $this, cache, function(data) {
                    if( data.items ) {
                        inner.append(data.items).attr('data-paged', paged);
                    }

                    if ( paged >= maxPaged  ) {
                        btnLoadmore.addClass('disabled');
                    } else {
                        btnLoadmore.removeClass('disabled');
                    }
                });
			});

        });

        var loadProducts = function( atts, paged, inner, $this, cache, callback) {
            if( cache[paged] ) {
                $this.removeClass('show-loading');
                setTimeout(function() {
                    callback(cache[paged]);
                }, 100);
                return;
            } else {
                $this.addClass('show-loading');
            }

            $.ajax({
                url: koganic_settings.ajaxurl,
                data: {
                    atts: atts,
                    paged: paged,
                    action: 'koganic_get_product_shortcode',
                },
                dataType: 'json',
                method: 'POST',
                success: function(data) {
                    cache[paged] = data;
                    callback( data );
                },
                error: function(data) {
                    console.log('ajax error');
                },
                complete: function() {
                    $this.removeClass('show-loading');
                    tooltipProduct();
                },
            });
        };
    }


    // init Product tabs
    function initProductTabs() {
        $('.jmsproducttabs-elements').each(function() {
            var intervalID;

            var $wrap = $(this),
                $inner = $wrap.find('.product-tab-content'),
                cache = [];

            if( $inner.find('.owl-carousel').length < 1 ) {
                cache[0] = {
                    html: $inner.html()
                };
            }

            $wrap.find('.jms-tabs-title li').on('click', function(e) {
                e.preventDefault();

                var $this = $(this),
                    atts = $this.data('atts'),
                    index = $this.index();

                loadTab(atts, index, $inner, $this, $wrap, cache, function(data) {
                    if( data.html ) {
                        $inner.html(data.html);
                    }

                    loadmoreproduct();
                });
            });
        });

        var loadTab = function(atts, index, inner, button, wrap, cache, callback) {
            button.parent().find('.active').removeClass('active');
            button.addClass('active');

            if( cache[index] ) {
                setTimeout(function() {
                    wrap.removeClass('show-loading');
                    callback(cache[index]);
                }, 300);
                return;
            } else {
                wrap.addClass('show-loading');
            }

            $.ajax({
                url: koganic_settings.ajaxurl,
                data: {
                    atts: atts,
                    action: 'koganic_get_products_tab',
                },
                dataType: 'json',
                method: 'POST',
                success: function(data) {
                    cache[index] = data;
                    callback(data);
                },
                error: function(data) {
                    console.log('Ajax error');
                },
                complete: function() {
                    wrap.find('.koganic-products-loader').remove();
                    wrap.removeClass('show-loading');
                },
            });
        };
    }

	/**
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 * Compare button
	 *-------------------------------------------------------------------------------------------------------------------------------------------
	 */
	function compare() {
		var body = $("body"),
			button = $("a.compare");

		body.on("click", "a.compare", function() {
			$(this).addClass("loading");
		});

		body.on("yith_woocompare_open_popup", function() {
			button.removeClass("loading");
			body.addClass("compare-opened");
		});

		body.on('click', '#cboxClose, #cboxOverlay', function() {
			body.removeClass("compare-opened");
		});

	}

	function initAddToCart() {
		$('body').on('submit', 'form.cart', function(e) {
            if( koganic_settings.ajax_add_to_cart == false ) return;

            e.preventDefault();

            var $form = $(this),
                $button = $form.find('.button'),
                data = $form.serialize();

            data += '&action=koganic_ajax_add_to_cart';

            if( $button.val() ) {
                data += '&add-to-cart=' + $button.val();
            }

            $button.removeClass( 'added' );
            $button.addClass( 'loading' );

            // Trigger event
            $( document.body ).trigger( 'adding_to_cart', [ $button, data ] );

            $.ajax({
                url: koganic_settings.ajaxurl,
                data: data,
                method: 'POST',
                success: function(response) {
                    if ( ! response ) {
                        return;
                    }

                    // // Redirect to cart option
                    if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
                        window.location = wc_add_to_cart_params.cart_url;
                        return;
                    } else {
                        $button.removeClass( 'loading' );
                        $button.addClass( 'loaded' );

                        addCartAction();

                        var fragments = response.fragments;
                        var cart_hash = response.cart_hash;

                        // Replace value
                        if ( fragments ) {
                            $.each( fragments, function( key, value ) {
                                $( key ).replaceWith( value );
                            });
                        }

                    }

                    $.magnificPopup.close();
                },
                error: function() {
                    console.log('ajax adding to cart error');
                },
                complete: function() {},
            });

        });

		$('body').bind('added_to_cart', function(event, fragments, cart_hash) {
            addCartAction();
        });

		function toggleCartSidebar() {
			$( '.add-to-cart-style-sidebar' ).addClass( 'has-toggle-cart-sidebar' );

			$( '#sidebar-open-overlay, .close-cart' ).on( 'click', function() {
				$( 'body' ).removeClass( 'has-toggle-cart-sidebar' );
			});
		}

		$( 'body' ).on( 'click', '.toggle-sidebar > .cart-contents', function (e) {
			e.preventDefault();
			toggleCartSidebar();
		});


        function addCartAction() {
            if ( $( 'body' ).hasClass('add-to-cart-style-sidebar') ) {
                toggleCartSidebar();
            }

            if ( $( 'body' ).hasClass('add-to-cart-style-alert') ) {
                $( '.header-cart.btn-group' ).addClass( 'cart-opened' );

                setTimeout(function() {
                    $( '.header-cart.btn-group' ).removeClass( 'cart-opened' );
                }, 3000);
            }
        }
	}

	/*Show swatches attribute product*/

	function swatches_list(){
        $('body').on('click', '.p-attr-swatch', function(){
            var src,
                t = $(this),
                variation_image_src = t.data('src'),
                product = t.closest('.product-item'),
                p_image = product.find('.p-image'),
                view_image = p_image.find('img'),
                default_view_image_src = product.find('.p-image').data('ori_src');

            if(t.hasClass('active')){
                src = default_view_image_src;
                t.removeClass('active');
            }else{
                src = variation_image_src;   
                t.addClass('active').siblings().removeClass('active');
            }


            if( view_image.prop('src') == src ) return;

            p_image.addClass('image-is-loading');

            view_image.prop('src', src).one('load', function(){
                p_image.removeClass('image-is-loading');
            });
        });
    }

    /*product carousel: go to first slide image*/
    function gotofirst(){
        $('.thumbnail-slider.slick-initialized').slick('slickGoTo', 0);
    }

    /*product variation*/
    function product_variation(){
        /*woocommerce: product variation*/
        	var $_product = $(document.body).find('.product, .product-quickview'),
            /*easy zoom attr*/
            /*product image*/
            $_image = $_product.find('.p-item').eq(0),
            $_image_src = $_image.find('img').prop('srcset'),
            $_zoom = $_image.data('zoom'),

            /*product thumbnail*/
            $_thumb = $_product.find('.p-item-thumb:eq(0)'),
            $_thumb_src = $_thumb.find('img').prop('srcset');

        /*event when variation changed=========*/
        $(document).on( 'found_variation', 'form.variations_form', function( event, variation ) {
        	            /*get image url form `variation`*/
            var $_product = $(document.body).find('.product-quickview');
            $_image = $_product.find('.p-item').eq(1);

            var thumb_url = variation.image.thumb_src;
            $_thumb.find('img').prop('srcset', thumb_url);

            var img_url = variation.image.full_src;

            $_image.find('img').attr('srcset', img_url);

            if ( $( '.image-zoom' ).length > 0 ) {
				var img = $( '.image-zoom' ), img_src = $( '.image-zoom' ).data( 'src' );

				img.zoom({
					touch: false,
					url: img_src
				});
			}
            /*go to first slick slide*/
            gotofirst();
        });

        /*reset variation========*/
        $('.reset_variations').on('click', function(e){
        	
            e.preventDefault();

             /*change `src` image*/
            $_thumb.find('img').prop('srcset', $_thumb_src);
            $_image.find('img').prop('srcset', $_image_src);

            /*go to first slick slide*/
            gotofirst();
        });
    }

    /*Search Popup*/

    function searchPopup() {
		$( '.search-icon-popup' ).on( 'click', function (e) {
			e.preventDefault();
			$( 'body' ).toggleClass( 'show-search-popup' );
			$( '.close-search-popup' ).on( 'click', function() {
				$( 'body' ).removeClass( 'show-search-popup' );
			});
		});
	}

	/* Smooth Scroll Landing*/
    function landingscroll() {
        $('a.smooth-scroll').on("click", function (e) {
            var anchor = $(this);
            $('html, body').stop().animate({
                scrollTop: $(anchor.attr('href')).offset().top - 70
            }, 1000);
            e.preventDefault();
        });
    }

    function StickyHeaderLanding() {
        $( window ).scroll( function() {
            if ( $( this ).scrollTop() > 300 ) {
                $('.page-template-landing-page .main-header').addClass('landing-fixed-top');
            } else {
                $('.page-template-landing-page .main-header').removeClass('landing-fixed-top');
            }
        });
    }

    function tooltipProduct() {
    	$('.product-style-1 .quickview a, .product-style-1 .btn-wishlist a').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

    	$('.product-style-2 .quickview a, .product-style-2 .btn-wishlist a').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

    	$('.product-style-3 .quickview a, .product-style-3 .btn-wishlist a, .product-style-3 .addtocart-thumb a').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

    	$('.product-style-4 .btn-wishlist a, .product-style-4 .quickview a').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

    	$('.product-style-5 .btn-wishlist a').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

    	$('.product-style-6 .quickview a, .product-style-6 .btn-wishlist a, .product-style-6 .addtocart-thumb').each(function(){
			var text = $.trim($(this).text());
			var title = $.trim($(this).attr('title'));
			$(this).attr('data-toggle', 'tooltip');
			$(this).attr('data-placement', 'top');
			if(!title){
				$(this).attr('title', text);
			}
		});

		$('[data-toggle="tooltip"]').tooltip({container: 'body', delay: { show: 100, hide: 0 } });
    }

	function iNavPostionTopImageCarousel() {
        var t = $(".image-carousel-box .owl-carousel .item").find("a").innerHeight() / 2 - 10;
        $(".image-carousel-box").find(".owl-nav [class*='owl-']").css({
            top: t + "px"
        })
    }

	function toggle_header_menu() {
	    var delay = 200,
	        hoverTimer = 200,
	        timeout1 = false;

	        $(document).on({
	            mouseenter: function() {
	                var $this = $(this),
	                    that = this;

	                timeout1 = setTimeout(function() {

	                    var $ptDesctopMenu = $this.find('.dropdown-menu');


	                    $this.addClass('active')
	                        .find(".dropdown-menu")
	                        .stop()
	                        .addClass('hover')
	                        .fadeIn(hoverTimer);

	                }, delay);

	            },
	            mouseleave: function(e) {
	                var $this = $(this),
	                    $dropdown = $this.find(".dropdown-menu");


	                if (timeout1 !== false) {
	                    clearTimeout(timeout1);
	                    timeout1 = false;
	                }

	                if ($dropdown.length) {
	                    $dropdown.stop().fadeOut({
	                        duration: 0,
	                        complete: function() {
	                            $this.removeClass('active')
	                                .find(".dropdown-menu")
	                                .removeClass('hover');
	                        }
	                    });
	                } else {
	                    $this.removeClass('active')
	                        .find(".dropdown-menu")
	                        .removeClass('hover');
	                }

	            }
	        }, '.koganic-menu li');
	}

    // Toggle sidebar widget
    function initToggleSidebarWidget() {
		$( 'body .toggle-sidebar-button' ).on( 'click', function (e) {
			e.preventDefault();
			$( 'body' ).toggleClass( 'has-toggle-sidebar' );

			$( '#sidebar-open-overlay, .mask-overlay, .close-toggle-sidebar' ).on( 'click', function() {
				$( 'body' ).removeClass( 'has-toggle-sidebar' );
			});
		});
    }

 	function closePopup(popup) {
        // Close button
        popup.removeClass('open');
        setTimeout(function () {
            popup.css('display', 'none');
            popup.find('.modal-content').empty();
            popup.find('.modal-content').removeClass().addClass('modal-content');
        }, 400);

    }

    function handlePopup() {
        var popup = $('.modal-window');
        // Activate popup
        popup.css('display', 'block');
        popup.find('.btn-loading-disabled').addClass('btn-loading');
        setTimeout(function () {
            popup.addClass('open');
        }, 30);
    }

    function handleVideoPopup() {
        $(document).on('click', '.video-module', function (event) {
            event.preventDefault();
            handlePopup();
            var popupInner = $('.modal-content').addClass('video-popup');
            popupInner.siblings('.btn-loading-disabled').removeClass('btn-loading');
            // Append video
            popupInner.append($(document.createElement("iframe")).attr({
                'src': $(this).attr('data-video-module') + "?autoplay=1",
                'allowfullscreen': 'true',
                'frameborder': '0'
            }));
        });
    }

    $( document ).ready( function() {
		initPreLoader();
		initToggleSidebarWidget();
		initStickyHeader();
		initStickyHeaderMobile();
		initStickyHeaderIntro();
		toggle_header_menu();
		initToggleMenuSidebar();
        BackToTop();
		bannerHoverParallax();
		portfolioMasonry();
		galleryMasonry();
		previewMasonry();
		blogMasonry();
		ajaxLoadMoreItem();
		initCarousel();
		ShowMobileMenu();
		DropdownMenuMobile();
		initCountdown();
		initProductTabs();
		ShowPopupMenu();
		DropdownMenuPopup();
		// addSliderOpacity();
		loadmoreproduct();
		landingscroll();
		StickyHeaderLanding();
		handleVideoPopup();
		
		swatches_list();
		gotofirst();
		product_variation();
		searchPopup();

		//WC
		QuantityAdjust();
		ProductQuickView();
		initOpenSwatch();
		SlickSlider();
		AddToWishList();
		ShopFilterToggle();
		initZoom();
		initMagnificPopup();
		wcShippingContent();
		compare();

		//Add to cart
		initAddToCart();
		removeCartItem();
		
		//Tooltip
		tooltipProduct();

		iNavPostionTopImageCarousel();
		initNavigationMobile();

		$('body').on('click keydown', '.modal-window .close', function (e) {
	        e.preventDefault(e);
	        var popup = $(this).closest('.modal-window');
	        closePopup(popup);
	    });

		$("body").on("click", ".add_to_wishlist", function() {
			$(this).parent().addClass("loading");
		});

		$(".btn-navigation").on("click", function(e) {
			e.stopPropagation();
			$('body').toggleClass("display-menu");
		});

		$(".topbar-device-mobile .search-button").on("click", function(e) {
			e.stopPropagation();
			$('.topbar-device-mobile').toggleClass("active");
		});
		

		$('.koganic-menu li').mouseover(function() {
			if ( $(this).find('.dropdown-menu').hasClass('mega-dropdown-menu') || $(this).find('.dropdown-menu').hasClass('simple-menu') ) {
				$('#page-open-overlay').addClass('active');
				$('.pt-top-panel').addClass('zindex');
				$('header.header-wrapper, .header-sticky.header-wrapper').css({
					'z-index': '9999',
					'background-color': 'white'
				});				
			}		
		});

		$('.koganic-menu li').mouseleave(function() {
			$('#page-open-overlay').removeClass('active');
			$('.pt-top-panel').removeClass('zindex');
		});

		// jQuery('.header-block .header-cart').each(function (index, value) {
		// 	$(this).on('click',function(){
		// 		$(this).find('.widget_shopping_cart_content').slideToggle(200);
		// 	});
		// });
		
		var jsInitParallax = $('.page-content .js-init-parallax');
		if (jsInitParallax.length){
			initParallax();
		};
		$(window).resize(function(e) {
			var ttwindowWidth = window.innerWidth || $window.width();
			if(ttwindowWidth > 790){
				initParallax();
			};
		});

		function initParallax(){
			jsInitParallax.each(function(){
				var obj = $(this),
					orientation = $(this).data('orientation'),
					overflow = $(this).data('overflow'),
					scale = $(this).data('scale');

				new simpleParallax(obj, {
					overflow: overflow || false,
					scale: scale || 1.4,
					breakpoint: 790,
					orientation: orientation,
				});
			});
		};

		var $ptSize = $('.site');
		var objTopPanel = $ptSize.find('.pt-top-panel');
		//close block
		objTopPanel.each(function(){
				$(this).on('click', '.js-removeitem', function(){
						$(this).closest(objTopPanel).slideUp(200);
				});
		});
		

		jQuery(document).on("mouseenter mouseleave mousemove mouseout", ".preview-layout img", function(t) {
	        var z = jQuery;
	        var M = z("#tooltip");
	        var e = window.innerWidth,
	            i = (t.target, z(this).next("figcaption").first().text());
	        "mouseenter" === t.type && 1024 < e ? (M.removeClass("hide"), M.html(i).show()) : "mouseleave" === t.type && t.relatedTarget && 1024 < e && (M.hide(), M.addClass("hide"), M.removeAttr("style")), "mousemove" === t.type && 1024 < e ? M.css({
	            top: t.pageY,
	            left: t.pageX
	        }).show() : "mouseout" === t.type && 1024 < e && (M.hide().css({
	            top: 0,
	            left: 0
	        }), M.removeAttr("style"))
	    });	

		$('body').on('click', '.pt-menu-categories button', function(e){
				e.preventDefault();
				$(this).closest('.pt-menu-categories').toggleClass('opened').find('.pt-dropdown-menu').slideToggle(200);
		});

		$('.koganic-accordion-title').on('click',function(e){
			$(this).toggleClass('ting');
		});

		$('header, .header-sticky').on('click','.header-search', function(e) {
			var $this = $(this),
				target = e.target,
				objSearch = $('.pt-search'),
				objSearchInput = objSearch.find('.search-field');
			// search
			if ($this.hasClass('koganic-box-dropdown') && $('.search-button').is(target)){
				searchPopup();
			};		
			function searchPopup(){
				$(objSearch).addClass('active');
				$('.pt-mobile-parent-search .pt-search-mobile').addClass('active');				
				objSearchInput.focus();
				// jQuery('.header-sticky').css('z-index','1');
				jQuery('.search-block').addClass('ps');
				return false;
			};
			if (objSearch.find('.pt-btn-close').is(target)){
				objSearchClose();
				return false;
			};
			function objSearchClose(){
				$(objSearch).removeClass('active');
				$('.pt-mobile-parent-search .pt-search-mobile').removeClass('active');
				objSearchInput.blur();
				jQuery('.header-sticky').removeAttr('style');
				jQuery('.search-block').removeClass('ps');
				return false;
			};													
		});


		$('.header-sticky-mobile').on('click','.header-search', function(e) {
			var $this = $(this),
				target = e.target,
				objSearchMobile = $('.pt-search-mobile'),
				objSearchInputMobile = objSearchMobile.find('.search-field');	
			// search
			if ($this.hasClass('koganic-box-dropdown') && $('.search-button').is(target)){
				searchPopup();
			};		
			function searchPopup(){
				$(objSearchMobile).addClass('active');
				$('.pt-mobile-parent-search .pt-search').addClass('active');		
				objSearchInputMobile.focus();
				jQuery('.search-block').addClass('ps');
				return false;
			};
			if (objSearchMobile.find('.pt-btn-close').is(target)){
				objSearchClose();
				return false;
			};			
			function objSearchClose(){
				$(objSearchMobile).removeClass('active');
				$('.pt-mobile-parent-search .pt-search').removeClass('active');
				objSearchInputMobile.blur();
				jQuery('.search-block').removeClass('ps');
				return false;
			};													
		});

		$(".koganic-products-style-5 .product-box").hover(function () {
			$('.koganic-products-style-5 .owl-stage-outer').css({
		      "z-index": 7
		    });
        }, function () {
            $('.koganic-products-style-5 .owl-stage-outer').css({
		      "z-index": 0
		    });
        });

		jQuery('.pt-menu-categories.opened.disable').click(function(){return false;});

		var rtl = false;
		if ($('body').hasClass('rtl')) rtl = true;
		var $jsHeaderSlider = $('.pt-box-info .js-header-slider');
		if($jsHeaderSlider.length){
			$jsHeaderSlider.slick({
				rtl: rtl,
				autoplay:true,
				autoplaySpeed: 5500,
				dots: false,
				arrows: false,
				infinite: true,
				speed: 500,
				slidesToShow: 1,
				adaptiveHeight: true
			});
		};


	  	$('.enter-review-link').click(function() {
	  		var jms_scrollTop = $(".tab-reviews").offset().top - 65;
		  	$('html, body').animate({
		    scrollTop: jms_scrollTop
		  	}, 1000)
		});


		//*******************************************************************
		//*Change number of products to be viewed on shop page
		//*******************************************************************/
		$( '.show-products-number' ).change( function() {
			$( this ).closest( 'form' ).submit();
		} );

		if ($('.product-box').hasClass('no-ajax')){
	       	$('.add_to_cart_button').removeClass('ajax_add_to_cart');
	  	}

	  	var rtl = false;
		if ($('body').hasClass('rtl')) rtl = true;
	  	
	  	$('.related-posts-carousel').owlCarousel({
	        responsive : {
				320 : {
	        		items: 1,
	        	},
				445 : {
	        		items: 1,
	        	},
				768 : {
	        		items: 2,
	        	},
			    991 : {
			        items: 3,
			    },
			    1199 : {
			        items: 3,
			    }
			},
			rtl: rtl,
	        margin: 30,
			nav: false,
	        dots: false,
	        autoplay: false,
	        loop: false,
	        smartSpeed: 250,
	        autoHeight : true,
	    });

		$(document).find('iframe[src*="youtube.com"]').each(function() {
            var td_video = $(this);
            td_video.attr('width', '100%');
            var td_video_width = td_video.width();
            td_video.css('height', td_video_width * 0.5625, 'important');
        });

    });

})( jQuery );

//==============Feather Icon
feather.replace();