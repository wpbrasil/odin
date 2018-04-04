<?php
/**
 * Sidebar Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Register widget areas.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 */

if ( ! function_exists( 'odin_sidebar_widgets_init' ) ) {

	function odin_sidebar_widgets_init() {

		register_sidebar(
			array(
				'name' => __( 'Main Sidebar', 'odin' ),
				'id' => 'sidebar-main',
				'description' => __( 'Site Main Sidebar', 'odin' ),
				'before_widget' => '<aside id="%1$s" class="odin-widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="odin-widget-title">',
				'after_title' => '</h3>',
			)
		);

	}

	add_action( 'widgets_init', 'odin_sidebar_widgets_init' );

}
