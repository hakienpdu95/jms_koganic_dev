<?php
/**
 * Enqueue script for child theme
 */
if ( ! function_exists('koganic_child_enqueue_styles') ) {
	function koganic_child_enqueue_styles() {
		wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css');
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css' );
		wp_dequeue_style('child-style');

	}
	add_action( 'wp_enqueue_scripts', 'koganic_child_enqueue_styles', 20);
}
