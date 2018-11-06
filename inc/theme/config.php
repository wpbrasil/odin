<?php
/**
 * Theme Setup.
 */

/**
 * Registers theme support.
 *
 * @link https://developer.wordpress.org/reference/functions/add_theme_support
 */
if ( ! function_exists( 'odin_theme_support' ) ) {
	function odin_theme_support() {

		// Add customize selective refresh widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add feed link support.
		add_theme_support( 'automatic-feed-links' );

		// Add support custom background support.
		add_theme_support( 'custom-background', array(
			'default-color' => '',
			'default-image' => '',
		) );

		// Add infinite scroll support.
		// add_theme_support( 'infinite-scroll', array(
		// 	'type'           => 'scroll',
		// 	'footer_widgets' => false,
		// 	'container'      => 'content',
		// 	'wrapper'        => false,
		// 	'render'         => false,
		// 	'posts_per_page' => get_option( 'posts_per_page' ),
		// ) );

		// Add the excerpt on pages.
		// add_post_type_support( 'page', 'excerpt' );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );
	}
}

add_action( 'after_setup_theme', 'odin_theme_support' );

/**
 * Load the theme’s translated strings.
 *
 * @link https://developer.wordpress.org/reference/functions/load_theme_textdomain/
 */
if ( ! function_exists( 'odin_theme_setup_language' ) ) {
	function odin_theme_setup_language() {

		// Add multiple languages support.
		load_theme_textdomain( 'odin', get_template_directory() . '/languages' );
	}
}

add_action( 'after_setup_theme', 'odin_theme_setup_language' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
if ( ! function_exists( 'odin_content_width' ) ) {
	function odin_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'odin_content_width', 730 );
	}
}

add_action( 'after_setup_theme', 'odin_content_width', 0 );

/**
 * Odin custom stylesheet URI.
 *
 * @param string $stylesheet Default URI.
 * @param string $stylesheet_dir Stylesheet directory URI.
 * @return string New URI.
 */
if ( ! function_exists( 'odin_stylesheet_uri' ) ) {
	function odin_stylesheet_uri( $stylesheet, $stylesheet_dir ) {
		// Use minified libraries if SCRIPT_DEBUG is turned off.
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		$stylesheet = $stylesheet_dir . '/dist/css/theme' . $suffix . '.css';
		return $stylesheet;
	}
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Load scripts and styles.
 */
if ( ! function_exists( 'odin_enqueue_scripts' ) ) {
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
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Cleanup wp_head().
 */
function odin_head_cleanup() {
	// Category feeds.
	// remove_action( 'wp_head', 'feed_links_extra', 3 );

	// Post and comment feeds.
	// remove_action( 'wp_head', 'feed_links', 2 );

	// EditURI link.
	remove_action( 'wp_head', 'rsd_link' );

	// Windows live writer.
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Index link.
	remove_action( 'wp_head', 'index_rel_link' );

	// Previous link.
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );

	// Start link.
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );

	// Links for adjacent posts.
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );

	// WP version.
	remove_action( 'wp_head', 'wp_generator' );

	// Emoji's
	// remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	// remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	// remove_action( 'wp_print_styles', 'print_emoji_styles' );
	// remove_action( 'admin_print_styles', 'print_emoji_styles' );
	// remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	// remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	// remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
}

add_action( 'init', 'odin_head_cleanup' );

/**
 * Remove WP version from RSS.
 */
add_filter( 'the_generator', '__return_false' );

/**
 * Remove injected CSS for recent comments widget.
 */
function odin_remove_wp_widget_recent_comments_style() {
	if ( has_filter( 'wp_head', 'wp_widget_recent_comments_style' ) ) {
		remove_filter( 'wp_head', 'wp_widget_recent_comments_style' );
	}
}

add_filter( 'wp_head', 'odin_remove_wp_widget_recent_comments_style', 1);

/**
 * Remove injected CSS from recent comments widget.
 */
function odin_remove_recent_comments_style() {
	global $wp_widget_factory;

	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
}

add_action( 'wp_head', 'odin_remove_recent_comments_style', 1 );

/**
 * Remove injected CSS from gallery.
 */
add_filter( 'use_default_gallery_style', '__return_false' );

/**
 * Add rel="nofollow" and remove rel="category".
 */
function odin_modify_category_rel( $text ) {
	$search = array( 'rel="category"', 'rel="category tag"' );
	$text = str_replace( $search, 'rel="nofollow"', $text );

	return $text;
}

add_filter( 'wp_list_categories', 'odin_modify_category_rel' );
add_filter( 'the_category', 'odin_modify_category_rel' );

/**
 * Add rel="nofollow" and remove rel="tag".
 */
function odin_modify_tag_rel( $taglink ) {
	return str_replace( 'rel="tag">', 'rel="nofollow">', $taglink );
}

add_filter( 'wp_tag_cloud', 'odin_modify_tag_rel' );
add_filter( 'the_tags', 'odin_modify_tag_rel' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param  array $plugins
 *
 * @return array Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
