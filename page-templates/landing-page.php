<?php
/**
 * Template Name: Landing Page
 * Template Post Type: post, page
 * The template for Landing page
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="landing-header" class="page-content landing">
	<?php koganic_preloader(); ?>
	<?php locate_template('template-parts/menu-mobile-intro.php', true);?>
	<div class="page-content-inner">
		<?php
		koganic_header_landingpage();
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			echo do_shortcode( get_the_content() );

		// End the loop.
		endwhile;
		?>
	</div>
</div>
<div id="tooltip" class="hide"></div>
<a id="backtop">
    <span class="pt-icon">
        <svg version="1.1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve"><g><polygon fill="currentColor" points="20.9,17.1 12.5,8.6 4.1,17.1 2.9,15.9 12.5,6.4 22.1,15.9    "></polygon></g></svg>
    </span>
    <span class="pt-text">BACK TO TOP</span>
</a>
<?php wp_footer(); ?>

</body>
</html>

