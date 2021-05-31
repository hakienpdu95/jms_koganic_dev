<?php
defined( 'ABSPATH' ) or die( 'You cannot access this script directly' );

class Koganic_Main_Import {

	private $_koganic_pages = array();

	private $_response;

	private $_page;

	private $_process = array();

	public function __construct() {
		$this->_koganic_pages = koganic_get_config();
		global $ajax_response;
		$this->_response = $ajax_response;
		add_action( 'wp_ajax_jms_import_data', array( $this, 'import_action' ) );
	}

	public function data_import_box( $type = false ) {
		$btn_label = esc_html__( 'Import Home', 'koganic' );
		$activate_label = '';
		$shop_page = get_option( 'woocommerce_shop_page_id' );
		if ( $shop_page ) {
			$this->import_attributes();
		}
		?>
			<div class="wrap metabox-holder koganic-import-page">

				<?php if ( ! function_exists( 'is_shop' ) ): ?>
					<p class="koganic-notice">
						<?php printf(esc_html__('To import data properly we recommend you to install', 'koganic'));?> <strong><?php printf('<a href="%s">WooCommerce</a>', esc_url( add_query_arg( 'page', urlencode( 'tgmpa-install-plugins' ), self_admin_url( 'themes.php' ) ) ));?></strong> <?php  printf(esc_html__('plugin', 'koganic'));?>
					</p>
				<?php endif ?>

				<?php if ( !$shop_page ): ?>
					<p class="koganic-warning">
						<?php
							esc_html_e( 'It seems that you didn\'t run WooCommerce setup wizard or didn\'t create a shop and the import can\'t be run now. You need to run WooCommerce setup wizard or install pages manually via WooCommerce -> System status -> Tools.', 'koganic' );
						?>
					</p>
				<?php endif ?>

				<?php if( $this->_required_plugins() ): ?>
					<p class="koganic-warning">
						<?php printf(esc_html__('You need to install the following plugins to use our import function:','koganic'));?> <strong><?php printf('<a href="%s">%s</a>', esc_url( add_query_arg( 'page', urlencode( 'tgmpa-install-plugins' ), self_admin_url( 'themes.php' ) ) ), implode(', ', $this->_required_plugins()));
						?></strong>
					</p>
				<?php endif; ?>

				<form action="#" method="post" class="koganic-import-form">

					<div class="import-response"></div>
					<div class="koganic-import-progress animated" data-progress="0">
							<div class="width-0"></div>
					</div>
					<?php if ( $type == 'base' ): ?>
						<?php
							$btn_label = esc_html__( 'Import Base Data', 'koganic' );
							$activate_label = esc_html__( 'Activate Base Data', 'koganic' );

							if( $this->is_page_imported('base') ) $btn_label = $activate_label;

							$this->page_preview();

							$list = $this->_koganic_pages;

							$all = 'base';

							foreach ($list as $slug => $page) {
								if( $slug == $all ) continue;
								$all .= ','.$slug;
							}

						?>

						<div class="import-form-fields">

						<input type="hidden" class="page_select" name="page_select" value="base">
						<input type="hidden" class="koganic_pages" name="koganic_pages" value="<?php echo esc_attr( $all ); ?>">
						<?php if( ! $this->is_page_imported('base') ): ?>

							<div class="full-import-box">
								<label for="full_import">
									<input type="checkbox" id="full_import" name="full_import" value="yes" checked="checked">
									<?php esc_html_e('Include all pages', 'koganic'); ?>
								</label>
							</div>

						<?php endif ?>

					<?php else: ?>
						<?php

							if( $type == 'page' ) $btn_label = esc_attr__( 'Import Page', 'koganic' );

							$this->pages_select( $type );
						?>
					<?php endif ?>

					<?php if ( ! $this->_required_plugins() && $shop_page ): ?>
						<p class="submit">
							<input type="submit" name="import-submit" id="import-submit" class="button button-primary" value="<?php echo esc_attr( $btn_label ); ?>" data-activate="<?php echo esc_attr( $btn_label ); ?>">
						</p>
					<?php endif ?>
					</div>

				</form>

			</div>
		<?php
	}

	public function base_import_screen() {
		$this->data_import_box( 'base' );
	}

	public function homes_import_screen() {
		$this->data_import_box( 'home' );
	}

	public function pages_import_screen() {
		$this->data_import_box( 'page' );
	}
	public function pages_select( $type = false ) {
		$first_page = 'base';
		$list = $this->_koganic_pages;
		if( $type ) {
			$list = array_filter( $this->_koganic_pages, function( $el ) use($type) {
				return $type == $el['type'];
			});

			$first_page = key($list);
		}

		$this->page_preview( $first_page );
		?>
			<div class="import-form-fields">
			<select name="page_select" class="page_select">
				<option><?php esc_html_e('--Select--', 'koganic'); ?></option>
				<?php foreach ($list as $key => $value): ?>
					<option value="<?php echo esc_attr( $key ); ?>" data-imported="<?php if($this->is_page_imported( $key )){
							echo esc_html__('yes', 'koganic');
						}else{
							echo esc_html__('no', 'koganic');
						} ?>"><?php echo esc_html( $value['title'] ); ?></option>
				<?php endforeach ?>
			</select>
		<?php
	}

	public function page_preview( $page = 'base' ) {
		?>
			<div class="page-preview">
				<img src="<?php echo KOGANIC_URL; ?>/inc/admin/data/<?php echo esc_attr( $page ); ?>/preview.jpg" data-dir="<?php echo KOGANIC_URL; ?>/inc/admin/data" alt="<?php esc_attr_e('Page preview', 'koganic'); ?>" />
			</div>
		<?php
	}

	public function import_action() {
		if( empty( $_GET['import_page'] ) ) $this->_response->send_fail_msg( 'Wrong page name' );

		$pages = explode( ',', sanitize_text_field( $_GET['import_page'] ) );

		$sequence = false;

		if( isset( $_GET['sequence'] ) && $_GET['sequence'] == 'true'  ) {
			$sequence = true;
		}

		foreach ($pages as $page) {
			$this->_page = $page;
			if( empty( $page ) ) continue;

			$this->_process = explode(',', $this->_koganic_pages[$this->_page]['process']);

			$type = $this->_koganic_pages[$this->_page]['type'];

			if( $sequence && $type == 'home') $this->_process = array('xml', 'sliders', 'page_menu');
			if( $sequence && ( $type == 'shop' || $type == 'product' ) ) $this->_process = array();
			if( $sequence && $page == 'base') $this->_process = array('xml', 'home', 'shop', 'menu', 'widgets', 'options', 'sliders');

			if( $this->is_page_imported() ) {

				$this->_response->add_msg( 'Page content was imported previously' );
				foreach (array('xml', 'sliders') as $val) {
					if( ( $key = array_search($val, $this->_process ) ) !== false ) {
						unset( $this->_process[ $key ] );
					}
				}
			}
			// Run import of all elements defined in $_process
			$import = new Koganic_Dummy_Import( $this->_page, $this->_process );
			$import->run_import();


			$this->add_imported_page();
		}

		$this->_response->send_response();

	}

	public function gen_imported_pages_classes() {
		$pages = $this->imported_pages();
		$class = implode( '-imported ', $pages);
		if( ! empty( $class ) ) $class =  $class . '-imported' ;
		return $class;
	}

	public function imported_pages() {
		$data = get_option('koganic_imported_pages');
		if( empty( $data ) ) $data = array();
		return $data;
	}

	public function add_imported_page( $page = false ) {
		if( ! $page ) $page = $this->_page;
		$imported = $this->imported_pages();
		if( $this->is_page_imported() ) return;
		$imported[] = $page;
		return update_option( 'koganic_imported_pages', $imported );
	}

	public function is_page_imported( $page = false ) {
		if( ! $page ) $page = $this->_page;
		$imported = $this->imported_pages();
		return in_array( $page, $imported);
	}

	public function clean_imported_page_data(){
		return delete_option( 'koganic_imported_pages' );
	}

	private function _required_plugins() {
		$plugins = array();

		if ( ! function_exists( 'koganic_addons_load_textdomain' ) ) {
		  	$plugins[] = 'koganic-addons';
		}

		if( ! class_exists('WooCommerce') ) {
			$plugins[] = 'WooCommerce';
		}

		if( ! class_exists('RevSlider') ) {
			$plugins[] = 'Slider Revolution';
		}
		if( ! class_exists('ReduxFramework') ) {
			$plugins[] = 'Redux Framework';
		}
		if( ! class_exists('Vc_Manager') ) {
			$plugins[] = 'WPBakery Page Builder';
		}

		if( ! empty( $plugins ) ) {
			return $plugins;
		}

		return false;
	}

	private function _get_page_folder( $page = false ) {
		if( ! $page ) $page = $this->_page;

		return $this->_file_path . $this->_page . '/';
	}

	public function import_attributes() {
		if ( get_option( 'koganic_import_attributes' ) == true ) return;

		$import_attributes = $this->create_attributes();

		if ( $import_attributes ) {
			update_option( 'koganic_import_attributes', true );
		}
	}

	public function clean_import_attributes_data(){
		return delete_option( 'koganic_import_attributes' );
	}

	public function create_attributes() {
		global $wpdb;

		$attribute_color = $this->get_attribute_to_add( 'Color' );
		$attribute_brand = $this->get_attribute_to_add( 'Brand' );

		$brand = true;
		$color = true;

		if ( wc_get_attribute_taxonomies() ){
			foreach ( wc_get_attribute_taxonomies() as $key => $value ) {
				if ( $value->attribute_name == 'brand' ) $brand = false;
				if ( $value->attribute_name == 'color' ) $color = false;
			}
		}

		if ( $brand ) $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute_brand );
		if ( $color ) $wpdb->insert( $wpdb->prefix . 'woocommerce_attribute_taxonomies', $attribute_color );

		flush_rewrite_rules();
		delete_transient( 'wc_attribute_taxonomies' );

		return true;
	}

	public function get_attribute_to_add( $name = 'Color' ) {
		$attribute = array(
			'attribute_label'   => $name,
			'attribute_type'    => 'select',
			'attribute_orderby' =>  '',
			'attribute_public'  => 0
		);

		if ( empty( $attribute['attribute_name'] ) ) {
			$attribute['attribute_name'] = wc_sanitize_taxonomy_name( $attribute['attribute_label'] );
		}

		return $attribute;
	}

}
