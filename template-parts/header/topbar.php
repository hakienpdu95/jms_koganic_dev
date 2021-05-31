<?php
    global $post;
    
    $showAccount        = koganic_get_option('show-header-account', 1);
    $topbar_color = koganic_get_option('topbar-text-color', 'light');
    $showLanguage = koganic_get_option('show-language-box', 0);
    $showCurrency = koganic_get_option('show-currency-box', 0);
    $header_design     = koganic_get_option('header-layout');
    $header_text = koganic_get_option('header-text');

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_page_options', true );

if ( (isset( $options['disable-topbar'] ) && $options['disable-topbar'] == 1) || (isset( $options['page-header'] ) && $options['page-header'] == 5) ) $topbar = 0;
?>

<?php if ( koganic_topbar() ) : ?>
    <div class="topbar <?php echo 'color-scheme-' . esc_attr( $topbar_color ); ?>">
        <div class="container">
            <div class="wrap-topbar">
                <div class="header-position">
                    <?php if ( ! empty($header_text) ) : ?>
                        <div class="header-block hidden-md hidden-sm hidden-xs text">
                            <?php echo apply_filters( 'koganic_post_meta', '<p>' . $header_text . '</p>' ); ?>
                        </div>
                    <?php endif; ?>
                </div>   

                <div class="header-position"></div>  

                <div class="header-position header-action">
                    <?php if ( $showLanguage == 1 ): ?>
                        <div class="header-block hidden-md hidden-sm hidden-xs">
                            <?php echo koganic_language(); ?>
                        </div>
                    <?php endif; ?>   

                    <?php if ( koganic_woocommerce_activated() && class_exists('Jms_Currency') && $showCurrency == 1 ) : ?>
                        <div class="header-block hidden-md hidden-sm hidden-xs">
                            <?php echo koganic_currency(); ?>
                        </div>
                    <?php endif; ?> 

                </div>             
            </div>
        </div>
    </div>
    <!-- top-bar -->
<?php endif; ?>
