<?php
/**
 * Post Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Post Setup.
 */
add_action( 'after_setup_theme', function() {

	// Add post_thumbnails suport.
	// @link https://developer.wordpress.org/reference/functions/add_theme_support/
	add_theme_support( 'post-thumbnails' );

	// Add support for Post Formats.
	// @link https://developer.wordpress.org/themes/functionality/post-formats/
	add_theme_support( 'post-formats', array(
		'audio',
		'gallery',
		'video',
	) );

} );
