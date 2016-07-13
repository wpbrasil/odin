<?php

/**
 * Load scripts and styles.
 *
 * @since 2.2.0
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// JQuery script.
	wp_enqueue_script( 'jquery' );

	// IE-specific scripts with conditional comments.
	wp_enqueue_script( 'respondjs', 'https://cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js' );
	wp_script_add_data( 'respondjs', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'html5shiv', 'https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js' );
	wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );

	// General scripts.
	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
		// Loads main stylesheet file.
		wp_enqueue_style( 'odin-main-style', $template_url . '/assets/css/main.css' );

		// Loads main script file.
		wp_enqueue_script( 'odin-main-script', $template_url . '/assets/js/main.js', array(), null, true );

	} else {
		// Loads main stylesheet file compressed.
		wp_enqueue_style( 'odin-main-style', get_stylesheet_uri() );

		// Loads main script file compressed.
		wp_enqueue_script( 'odin-main-script', $template_url . '/assets/js/main.min.js', array(), null, true );
	}

	// Load Thread comments WordPress script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/main.min.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );
