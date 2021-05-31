<!doctype html>
<html <?php language_attributes(); ?> class="<?php echo koganic_site_mode(); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php if ( !wp_is_mobile() ){ ?>
		<?php koganic_preloader(); ?>

		<div id="sidebar-open-overlay"></div>
		<?php locate_template('template-parts/toggle-sidebar.php', true); ?>
	    <?php locate_template('template-parts/menu-mobile.php', true);?>
		<?php locate_template('template-parts/menu-popup.php', true);?>

		<div id="page" class="site">
			<div id="page-open-overlay"></div>
			<?php locate_template('template-parts/topbar-mobile.php', true); ?>	 
			<?php koganic_header(); ?>
			<?php koganic_page_title(); ?>			
<?php } else { ?>
		<?php koganic_preloader(); ?>
		<?php locate_template('template-parts/menu-mobile.php', true);?>
		<?php locate_template('template-parts/topbar-mobile.php', true); ?>		
		<div id="page" class="site">
			<?php koganic_header_mobile(); ?>
			<?php koganic_page_title(); ?>
<?php } ?>