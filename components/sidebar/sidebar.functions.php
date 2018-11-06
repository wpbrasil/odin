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

if ( ! function_exists( 'odin_widgets_sidebar_init' ) ) {

	function odin_widgets_sidebar_init() {

		register_sidebar(
			array(
				'id' => 'odin-widgets-sidebar',
				'name' => __( 'Sidebar', 'odin' ),
				'description' => __( 'Widgets in Sidebar', 'odin' ),
				'before_widget' => '<aside id="%1$s" class="odin-widget widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="odin-widget-title">',
				'after_title' => '</h3>',
			)
		);

	}

	add_action( 'widgets_init', 'odin_widgets_sidebar_init' );

}
