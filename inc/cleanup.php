<?php
/**
 * Odin optimize functions.
 */

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
