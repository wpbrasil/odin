<?php
/**
 * Scripts and styles theme.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Odin custom stylesheet URI.
 *
 * @param string $stylesheet Default URI.
 * @param string $stylesheet_dir Stylesheet directory URI.
 * @return string New URI.
 */
function odin_stylesheet_uri( $stylesheet, $stylesheet_dir ) {
	// Use minified libraries if SCRIPT_DEBUG is turned off.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	$stylesheet = $stylesheet_dir . '/dist/css/theme' . $suffix . '.css';
	return $stylesheet;
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Load scripts and styles.
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// Use minified libraries if SCRIPT_DEBUG is turned off.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	// // Deregister core jQuery and register jQuery 3.x.
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-3.2.1' . $suffix . '.js', array(), '3.2.1' );

	// // Deregister core jQuery migrate and register jQuery migrate 3.x.
	wp_deregister_script( 'jquery-migrate' );
	wp_enqueue_script( 'jquery-migrate', '//code.jquery.com/jquery-migrate-3.0.0' . $suffix . '.js', array( 'jquery' ), '3.0.0' );

	// Loads main stylesheet file.
	wp_enqueue_style( 'odin-theme-style', get_stylesheet_uri() );

	// Loads main script file.
	wp_enqueue_script( 'odin-theme-script', $template_url . '/dist/js/theme' . $suffix . '.js', array( 'jquery' ), null, true );

	// Load Thread comments WordPress script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );
