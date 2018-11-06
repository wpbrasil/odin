<?php
/**
 * Banner Component Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get banner title.
 */
if ( ! function_exists( 'odin_get_banner_title' ) ) {
	function odin_get_banner_title() {
		if ( is_front_page() && is_home() || is_home() ) {
			// Front-page || Blog (home).
			return get_bloginfo( 'name' );
		} elseif ( is_singular( array( 'post', 'page' ) ) ) {
			// Singular (post|page).
			return get_the_title();
		} elseif ( is_archive() ) {
			// Archive.
			return get_the_archive_title();
		} elseif ( is_search() ) {
			// Search.
			return sprintf( esc_attr__( 'Search Results for: %s', 'odin' ), get_search_query() );
		} else {
			return;
		}
	}
}

/**
 * Get banner description.
 */
if ( ! function_exists( 'odin_get_banner_description' ) ) {
	function odin_get_banner_description() {
		global $post;

		if ( is_front_page() && is_home() || is_home() ) {
			return get_bloginfo( 'description' );
		} elseif ( is_singular( array( 'post', 'page' ) ) ) {
			// Singular (post|page).
			return apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post->ID ) ); // https://core.trac.wordpress.org/ticket/42814
		} elseif ( is_archive() ) {
			// Archive.
			return get_the_archive_description();
		} else {
			return;
		}
	}
}

/**
 * Get banner image.
 */
if ( ! function_exists( 'odin_get_banner_image' ) ) {
	function odin_get_banner_image() {
		if ( get_header_image() && is_home() ) {
			// Header Image (support custom header support) only if is home.
			return get_header_image();
		} elseif ( has_post_thumbnail() ) {
			// Thumbnail Post (get original size if not exists the correct).
			$image = odin_get_attachment_image_src( get_post_thumbnail_id(), 1400, 600 );
			return ( ! isset( $image ) ) ?: wp_get_attachment_url( get_post_thumbnail_id() );
		} else {
			return;
		}
	}
}
