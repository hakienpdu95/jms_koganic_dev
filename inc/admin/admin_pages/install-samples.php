<?php
global $main_import;
?>
<div class="wrap koganic-wrap">
    <h1><?php esc_html_e( 'Welcome to Koganic!', 'koganic' ); ?></h1>
    <div class="about-text"><?php esc_html_e( 'Koganic is now installed and ready to use! Read below for additional information. We hope you enjoy it!', 'koganic' ); ?></div>
    <h2 class="nav-tab-wrapper">
        <?php
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic' ), esc_html__( 'Welcome', 'koganic' ) );
        printf( '<a href="%s" class="nav-tab">%s</a>', admin_url( 'admin.php?page=koganic-plugins' ), esc_html__( 'Plugins', 'koganic' ) );
        printf( '<a href="#" class="nav-tab nav-tab-active">%s</a>', esc_html__( 'Install Samples', 'koganic' ) );
        ?>
    </h2>
    <div class="koganic-section">
		<div class="koganic-import-area koganic-row koganic-three-columns <?php echo esc_attr( $main_import->gen_imported_pages_classes() ); ?>">
	<div class="koganic-column import-base">
		<div class="koganic-column-inner">
			<div class="koganic-box koganic-box-shadow">
				<div class="koganic-box-header">
					<h2><?php esc_html_e('Base Data Import', 'koganic'); ?></h2>
					<span class="koganic-box-label koganic-label-error"><?php esc_html_e('Required', 'koganic'); ?></span>
				</div>
				<div class="koganic-box-info">
					<p>
						<?php esc_html_e( 'It includes Home Default (Home 1) version , blog posts, portfolios, pages, demo products. It is a required data to be able to import additional pages.', 'koganic' ); ?>
					</p>
				</div>
				<div class="koganic-box-content">
					<?php $main_import->imported_pages(); ?>
					<?php $main_import->base_import_screen(); ?>
					<div class="koganic-success base-imported-alert">
						<span class="highlight">
                            <?php esc_html_e( 'Base Data is successfully imported. Now you can choose any pages to apply its settings for your website. You are be able to back to default version by click to "Activate Base Version" Button.', 'koganic' ); ?>
            </span>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="koganic-column import-pages">
		<div class="koganic-column-inner">
			<div class="koganic-box koganic-box-shadow">
				<div class="koganic-box-header">
					<h2><?php esc_html_e('Home Setup', 'koganic'); ?></h2>
					<span class="koganic-box-label koganic-label-recommended"><?php esc_html_e('Recommended', 'koganic'); ?></span>
				</div>
				<div class="koganic-box-info">
					<p>
						<?php esc_html_e( 'Select one Home Page from box then click to "Import Home", It will import Home content, Home sliders, and Home setting and set that Home to Frontpage.', 'koganic' ); ?>
						<br>
					</p>
				</div>
				<div class="koganic-box-content">
					<?php $main_import->homes_import_screen(); ?>
				</div>

			</div>
		</div>
	</div>
	<div class="koganic-column import-pages">
		<div class="koganic-column-inner">
			<div class="koganic-box koganic-box-shadow">
				<div class="koganic-box-header">
					<h2><?php esc_html_e('Pages Import', 'koganic'); ?></h2>
					<span class="koganic-box-label koganic-label-warning"><?php esc_html_e('Optional', 'koganic'); ?></span>
				</div>
				<div class="koganic-box-info">
					<p>
						<?php esc_html_e( 'Select one Page from box then click to "Import Page", It will be import page content, help you easy to create page like on demo.', 'koganic' ); ?>
					</p>
				</div>
				<div class="koganic-box-content">
					<?php $main_import->pages_import_screen(); ?>
				</div>

			</div>
		</div>
	</div>
	<br />
	<p>
		<?php esc_html_e( 'Note : Base Data Import must download all attachment from server so sometime it broken when use internet slow. Dont worry refresh this page again then click to Base Import again, it will be ok.', 'koganic' ); ?>
	</p>
</div>
    </div>
</div>
