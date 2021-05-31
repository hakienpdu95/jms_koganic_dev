<?php
get_header();
// Get VC setting
$vc = get_post_meta( get_the_ID(), '_wpb_vc_js_status', true );

?>
<div class="page-footer">
	<div class="container">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
	    <?php endwhile; ?>
	</div>
</div><!-- page-content -->
<?php get_footer();