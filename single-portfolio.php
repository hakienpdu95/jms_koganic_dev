<?php
get_header();
// Get VC setting
$vc = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );
?>
<div class="page-content">
	<div class="container mt_50 mb_50">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="portfolio-<?php the_ID(); ?>" <?php post_class('portfolio-single-content'); ?>>
		        <?php the_content(); ?>
			</article><!-- #post-# -->
	    <?php endwhile; ?>
	</div>
	<div class="container pb_80">
		<?php if ( koganic_get_option( 'portfolio-navigation' ) ) koganic_post_navigation(); ?>
		<?php if ( koganic_get_option( 'portfolio-related' ) ) koganic_related_portfolio(); ?>
	</div>

</div><!-- page-content -->
<?php get_footer();
