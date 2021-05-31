<?php
$theme = wp_get_theme();
if ($theme->parent_theme) {
    $template_dir =  basename(get_template_directory());
    $theme = wp_get_theme($template_dir);
}
$tgmpa             = TGM_Plugin_Activation::$instance;
$plugins           = TGM_Plugin_Activation::$instance->plugins;
$view_totals = array(
    'all'      => array(), // Meaning: all plugins which still have open actions.
    'install'  => array(),
    'update'   => array(),
    'activate' => array(),
);

foreach ( $plugins as $slug => $plugin ) {
    if ( koganic_plugin_active($plugin['plg_class'], $plugin['plg_func']) && false === $tgmpa->does_plugin_have_update( $slug ) ) {
        // No need to display plugins if they are installed, up-to-date and active.
        continue;
    } else {
        $view_totals['all'][ $slug ] = $plugin;

        if ( ! $tgmpa->is_plugin_installed( $slug ) ) {
            $view_totals['install'][ $slug ] = $plugin;
        } else {
            if ( false !== $tgmpa->does_plugin_have_update( $slug ) ) {
                $view_totals['update'][ $slug ] = $plugin;
            }

            if ( $tgmpa->can_plugin_activate( $slug ) ) {
                $view_totals['activate'][ $slug ] = $plugin;
            }
        }
    }
}

$all_index = $install_index = $update_index = $activate_index = 0;

foreach ( $view_totals as $type => $count ) {
    $size = sizeof($count);
    if ( $size < 1 ) {
        continue;
    }
    switch ( $type ) {
        case 'all':
            $all_index = $size;
            break;
        case 'install':
            $install_index = $size;
            break;
        case 'update':
            $update_index = $size;
            break;
        case 'activate':
            $activate_index = $size;
            break;
        default:
            break;
    }
}

$installed_plugins = get_plugins();
?>
<div class="wrap koganic-wrap">
    <h1><?php esc_html_e( 'Welcome to Koganic!', 'koganic' ); ?></h1>
    <div class="about-text"><?php esc_html_e( 'Koganic is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'koganic' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic' ), esc_html__( 'Welcome', 'koganic' ) );
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( 'Plugins', 'koganic' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic-samples' ), esc_html__( 'Install Samples', 'koganic' ) );
        ?>
    </h2>
    <div class="koganic-section">
        <p class="about-description"><?php esc_html_e( 'These are plugins we included inside or recommend for all design features of Koganic. You can install, activate, deactivate or update the plugins from this tab.', 'koganic' ); ?></p>

        <?php if ($install_index > 1 || $update_index > 1 || $activate_index > 1) : ?>
        <p class="about-description">
            <?php
            if ($install_index > 1)
                printf( '<a href="%s" class="button-primary">%s</a>', admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=install' ), esc_html__( 'Click here to install plugins all together.', 'koganic' ) );
            ?>
            <?php
            if ($activate_index > 1)
                printf( '<a href="%s" class="button-primary">%s</a>', admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=activate' ), esc_html__( 'Click here to activate plugins all together.', 'koganic' ) );
            ?>
            <?php
            if ($update_index > 1)
                printf( '<a href="%s" class="button-primary">%s</a>', admin_url( 'themes.php?page=tgmpa-install-plugins&plugin_status=update' ), esc_html__( 'Click here to update plugins all together.', 'koganic' ) );
            ?><br><br>
        </p>
        <?php endif; ?>

        <div class="koganic-install-plugins">
            <div class="feature-section theme-browser rendered">
                <?php
                foreach ( $plugins as $plugin ) : ?>
                    <?php
                    $class = '';
                    $plugin_status = '';
                    $file_path = $plugin['file_path'];
                    $plugin_action = $this->plugin_link( $plugin );
                    if ( koganic_plugin_active($plugin['plg_class'], $plugin['plg_func']) ) {
                        $plugin_status = 'active';
                        $class = 'active';
                    } else {
						            $plugin_status = 'unactive';
					          }
                    ?>
                    <div class="theme">
                        <div class="theme-wrapper">
                            <div class="theme-screenshot">
                                <img src="<?php echo esc_url($plugin['image_url']); ?>" alt="<?php echo esc_attr($plugin['name']); ?>" />
                                <div class="plugin-info">
                                    <?php if ( isset( $installed_plugins[ $plugin['file_path'] ] ) ) : ?>
                                        <?php printf( esc_html__( 'Version: %1s', 'koganic' ), $installed_plugins[ $plugin['file_path'] ]['Version'] ); ?>
                                    <?php elseif ( 'bundled' == $plugin['source_type'] && isset($plugin['version']) && $plugin['version']) : ?>
                                        <?php printf( esc_html__( 'Available Version: %s', 'koganic' ), $plugin['version'] ); ?>
                                    <?php endif; ?>
                                </div>
								                <div class="plugin-status <?php echo esc_attr($class); ?>"><?php printf( esc_html__( 'Status: %s', 'koganic' ), $plugin_status ); ?></div>
                            </div>
                            <h3 class="theme-name">
                                <?php if ( 'active' == $plugin_status ) : ?>
                                    <span><?php printf( esc_html__( '%s', 'koganic' ), $plugin['name'] ); ?></span>
                                <?php else : ?>
                                    <?php echo esc_html($plugin['name']); ?>
                                <?php endif; ?>
                            </h3>
                            <div class="theme-actions">
                                <?php foreach ( $plugin_action as $action ) { echo '' . $action; } ?>
                            </div>
                            <?php if ( isset( $plugin_action['update'] ) && $plugin_action['update'] ) : ?>
                                <div class="theme-update">
                                    <?php printf( esc_html__( 'Update Available: Version %s', 'koganic' ), $plugin['version'] ); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( isset( $plugin['required'] ) && $plugin['required'] ) : ?>
                                <div class="plugin-required">
                                    <?php esc_html_e( 'Required', 'koganic' ); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <div class="koganic-thanks">
        <p class="description"><?php esc_html_e( 'Thank you, we hope you to enjoy using Koganic!', 'koganic' ); ?></p>
    </div>
</div>
