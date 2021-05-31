<?php
/**
 * Template Name: Demo Home Page
 * Template Post Type: post, page
 * The template for Demo Home page
 */
?>
<?php
get_header();

$options = $content_class = $sidebar_class = $layout_classes = '';

// Get page options
$options = get_post_meta( get_the_ID(), '_custom_page_options', true );

// Get VC setting
$post = get_post();

$post_id = $post->ID;

$elementor_page = get_post_meta( $post_id, '_elementor_edit_mode', true );

?>
<?php if (  $post && $elementor_page  ) { ?>
	<div class="page-content">
		<div class="page-content-inner">

			<div class="<?php echo esc_attr($layout_classes); ?>">

				<div id="main-content">
					<?php
						while ( have_posts() ) : the_post();
							the_content();
							?>
							<div class="clearfix"></div>
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) { ?>
								<div class="container">
									<?php comments_template(); ?>
								</div>
								<?php
							}
						endwhile;

						// Displays page-links
						wp_link_pages();
					?>
				</div>

			</div>

		</div>
	</div><!-- page-content -->
<?php }else{ ?>
	<div class="page-content">
		<div class="page-content-inner mt_100 mb_100">

			<div class="<?php echo esc_attr($layout_classes); ?>">

				<div id="main-content">
					<div class="container">
						<?php
							while ( have_posts() ) : the_post();
								the_content();
								?>
								<div class="clearfix"></div>
								<?php
								// If comments are open or we have at least one comment, load up the comment template.
								if ( comments_open() || get_comments_number() ) {
									comments_template();
								}
							endwhile;

							// Displays page-links
							wp_link_pages();
						?>
					</div>
				</div>

			</div>

		</div>
	</div><!-- page-content -->
<?php } ?>


<?php get_footer();
