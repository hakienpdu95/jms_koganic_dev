<?php 
    $header_design     = koganic_get_option('header-layout');
    
    // Get page options
    $options = get_post_meta( get_the_ID(), '_custom_page_options', true );

    if ( isset( $options['page-header'] ) && $options['page-header'] != '' ) {
        $header_design = $options['page-header'];
    }
?>

<?php if ( koganic_topbar() ) : ?>
    <?php if( isset( $header_design ) && ($header_design == '12' || is_page( 'home-12' ) ) ) : ?>
        <a class="dropdown-hover search-button"><?php esc_html_e('Search', 'koganic'); ?></a>
    <?php else : ?>
        <a class="dropdown-hover search-button"></a>    
    <?php endif; ?>
<?php else : ?>
    <a class="dropdown-hover search-button"></a>
<?php endif; ?>

<div class="pt-desctop-parent-search pt-parent-box">
    <div class="pt-search pt-dropdown-obj js-dropdown">
        <div class="pt-dropdown-menu">
            <div class="container">
                <div class="pt-info-text">
                    <?php echo esc_html__('What are you Looking for?', 'koganic'); ?>
                    <button class="pt-btn-close"></button>                                        
                </div>
                <div class="search-box">
                    <div class="search-box-content">
                        <?php
                        if ( class_exists('WooSearch_Widget') || class_exists('WooSearch_Front') ) {
                            echo do_shortcode('[woocommerce_ajax_search]');
                        } else {
                            get_search_form();
                        }
                        ?>
                        <div class="close-search-popup"></div>
                    </div>
                </div>                
            </div>
        </div>      
    </div>
</div>