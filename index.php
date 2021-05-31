<?php
get_header();

$layout = $pagination_type = $blog_design = $content_class = $sidebar_class = $layout_classes = '';

// Get blog options
$smart_sidebar   = koganic_get_option( 'smart-sidebar', 0 );
$layout          = koganic_get_option( 'blog-layout', 'left' );
$blog_design     = koganic_get_option( 'blog-design', 'default' );
$blog_fullwidth  = koganic_get_option( 'blog-fullwidth', 0 );
$pagination_type = koganic_get_option( 'blog-pagination-type', 'number' );

// DEMO
if ( isset($_GET['design']) && $_GET['design'] != '' ) {
	$blog_design = $_GET['design'];
}

if ( isset($_GET['fullwidth']) && $_GET['fullwidth'] != '' ) {
	$blog_fullwidth = $_GET['fullwidth'];
}

if ( isset($_GET['sidebar']) && $_GET['sidebar'] != '' ) {
	$layout = $_GET['sidebar'];
}

if ( isset($_GET['pagination']) && $_GET['pagination'] != '' ) {
	$pagination_type = $_GET['pagination'];
}

// Fullwidth
if ( $blog_fullwidth == 0 ) {
	$blog_container_class = 'blog-container container';
} else {
	$blog_container_class = 'blog-container fullwidth';
}

if( isset( $blog_design ) && $blog_design != '' && $blog_design == 'default') {
	$content_class = 'col-lg-8';
}

if( isset( $blog_design ) && $blog_design != '' && $blog_design != 'default') {
	$content_class = 'col-lg-12 masonry-blog';
}

// Render columns number
if ( $layout == 'left' && is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	$layout_classes = 'left-sidebar';
} elseif ( $layout == 'right' && is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-lg-8 col-md-8 col-sm-12 col-xs-12';
	$sidebar_class = 'col-lg-4 col-md-4 col-sm-12 col-xs-12';
	$layout_classes = 'right-sidebar';
} elseif ( $layout == 'no' || !is_active_sidebar( 'primary-sidebar' ) ) {
	$content_class .= ' col-md-12 col-sm-12 col-xs-12 no-sidebar unset-float';
	$sidebar_class = '';
}

if ( isset($smart_sidebar) && $smart_sidebar == 1 ) {
	$sidebar_class .= ' smart-sidebar';
}

?>

<div class="page-content">
	<div class="<?php echo esc_attr( $blog_container_class ); ?>">
		<div class="row <?php echo esc_attr($layout_classes); ?>">
			<div id="main-content" class="<?php echo esc_attr( $content_class ); ?>">
				<?php if ( have_posts() ) : ?>
					<div class="koganic-loop-blog masonry-container blog-type-<?php echo esc_attr($blog_design); ?>">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'content', get_post_format() ); ?>
						<?php endwhile; wp_reset_postdata();?>
					</div>
				<?php else : ?>
					<?php get_template_part( 'content', 'none' ); ?>
				<?php endif; ?>

				<?php if ( 'loadmore' == $pagination_type || 'infinite' == $pagination_type ) : ?>
					<div class="koganic-ajax-loadmore tc" data-load-more='{"page":"<?php echo esc_attr( $wp_query->max_num_pages ); ?>","container":"masonry-container","layout":"<?php echo esc_attr( $pagination_type ); ?>"}'>
						<?php echo next_posts_link( esc_html__( 'Load more', 'koganic' ) ); ?>
					</div>
				<?php else : ?>
					<?php koganic_post_pagination(); ?>
				<?php endif; ?>
			</div><!-- #main-content -->

			<?php if ( isset( $layout ) && $layout != 'no' && is_active_sidebar( 'primary-sidebar' ) ) : ?>
				<div id="main-sidebar" class="<?php echo esc_attr( $sidebar_class ); ?>">
					<?php if ( is_active_sidebar( 'primary-sidebar' ) ) dynamic_sidebar( 'primary-sidebar' ); ?>
				</div><!-- #main-sidebar -->
			<?php endif; ?>

		</div>
	</div>
</div><!-- page-content -->

<?php get_footer();
