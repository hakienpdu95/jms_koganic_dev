<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @since   1.0.0
 * @package Koganic
 */

get_header();
?>
<div class="page-content">
    <div class="error-404 container tc">
		<div class="pt-empty-layout">
		    <h2 class="pt-title-02"><?php esc_html_e( '404', 'koganic' ); ?></h2>
		    <h1 class="pt-title pt-size-large"><?php esc_html_e( 'Oops! This page Could Not Be Found!', 'koganic' ); ?></h1>
		    <p><?php esc_html_e( 'Sorry bit the page you are looking for does not exist, have been removed or name changed', 'koganic' ); ?></p>
            <div class="back--homepage"><a href="<?php echo esc_url( home_url('/') ); ?>"><?php esc_html_e( 'Back to homepage', 'koganic' ); ?></a></div>
		</div>
    </div>
</div><!-- page-content -->

<?php get_footer();