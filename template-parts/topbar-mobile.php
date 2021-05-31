<?php 
/**
 * ====================================================
 * TopBar - Show On Mobile
 * ====================================================
 */

global $post;
$catalog_mode       = koganic_get_option('catalog-mode', 0);
?>

<?php if(!is_home() && !is_front_page()) : ?>
<div class="topbar-device-mobile hidden-md hidden-lg clearfix">
   	
   	<div class="topbar-left-mobile">
		<div class="topbar-mobile-history"><a href="javascript:history.back()"><span class="lnr lnr-arrow-left"></span></a></div>
		<div class="topbar-mobile-title"><?php koganic_get_title_mobile(); ?></div>		   		
   	</div>

	<div class="top-right-mobile">
		<div class="topbar-icon-home"><a href="<?php echo esc_url(get_home_url()); ?>"><i class="icon-home icons"></i></a></div>

		<div id="header-search" class="header-search btn-group">
            <a href="javascript:void(0)" class="search-button"></a>
            <div class="widget_search_content">
                <?php
                if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                    echo do_shortcode('[woocommerce_ajax_search]');
                } else {
                    get_search_form();
                }
                ?>
            </div>
        </div>
				
		<?php if ( koganic_woocommerce_activated() && isset($catalog_mode) && $catalog_mode != 1 ) : ?>	
		    <div class="top-cart">
		        <div class="tbay-dropdown-cart sidebar-right">
					<?php koganic_header_cart(); ?>
				</div>            
			</div>
	   <?php endif ; ?>        
	</div>
</div>
<?php endif; ?>