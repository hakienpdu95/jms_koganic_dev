<?php
$theme = wp_get_theme();
if ($theme->parent_theme) {
    $template_dir =  basename(get_template_directory());
    $theme = wp_get_theme($template_dir);
}
?>
<div class="wrap koganic-wrap">
    <h1><?php esc_html_e( 'Welcome to Koganic!', 'koganic' ); ?></h1>
    <div class="about-text"><?php esc_html_e( 'Koganic is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'koganic' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( 'Welcome', 'koganic' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic-plugins' ), esc_html__( 'Plugins', 'koganic' ) );
		printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic-samples' ), esc_html__( 'Install Samples', 'koganic' ) );
        ?>
    </h2>
    <div class="koganic-section">
        <p class="about-description">
            <?php printf( esc_html__( 'Before you get started, please be sure to always check out', 'koganic')); ?> <a href="<?php printf(esc_url('//wp-docs.jmsthemes.com/koganic/'));?>" target="_blank"><?php printf(esc_html__('this documentation','koganic'));?></a>. <?php printf( esc_html__( 'We outline all kinds of good information, and provide you with all the details you need to use Shopp.', 'koganic')); ?>
        </p>
        <p class="about-description">
            <?php printf( esc_html__( 'If you are unable to find your answer in our documentation, we encourage you to contact us through','koganic'));?> <a href="<?php printf(esc_url('//joommasters.ticksy.com/'));?>" target="_blank"><?php printf(esc_html__('support page','koganic'));?></a> <?php printf( esc_html__( 'with your site CPanel (or FTP) and WordPress admin details. We are very happy to help you and you will get reply from us more faster than you expected.', 'koganic')); ?>
        </p>

    </div>
    <div class="koganic-thanks">
        <p class="description"><?php esc_html_e( 'Thank you, we hope you to enjoy using Koganic!', 'koganic' ); ?></p>
    </div>
</div>
