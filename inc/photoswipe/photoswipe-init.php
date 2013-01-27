<?php
/**
 * PhotoSwipe functions.
 */

/**
 * Load photoswipe script.
 */
function odin_photoswipe_scripts() {
    wp_enqueue_script( 'jquery');
    wp_register_script( 'klass', get_template_directory_uri() . '/inc/photoswipe/js/klass.min.js', null, null, true );
    wp_enqueue_script( 'klass' );
	
	wp_enqueue_script( 'jquery');
    wp_register_script( 'photoswipe', get_template_directory_uri() . '/inc/photoswipe/js/code.photoswipe-3.0.5.min.js', null, null, true );
    wp_enqueue_script( 'photoswipe' );
	
	wp_register_style( 'photoswipe', get_template_directory_uri() . '/inc/photoswipe/css/photoswipe.css', array(), null, 'all' );
    wp_enqueue_style( 'photoswipe' );
	
}

add_action( 'wp_enqueue_scripts', 'odin_photoswipe_scripts' );

?>