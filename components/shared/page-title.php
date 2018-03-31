<?php
/**
 * Page Title Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get title page current.
 */
if ( is_front_page() && is_home() || is_home() ) {
	// Front-page || Blog (home).
	$page['title'] = get_bloginfo( 'name' );
} elseif ( is_singular( array( 'post', 'page' ) ) ) {
	// Singular (post|page).
	$page['title'] = get_the_title();
} elseif ( is_archive() ) {
	// Archive.
	$page['title'] = get_the_archive_title();
} elseif ( is_search() ) {
	// Search.
	$page['title'] = sprintf( esc_attr__( 'Search Results for: %s', 'odin' ), get_search_query() );
} else {
	return;
}

/**
 * If don't exists data return.
 */
if ( ! $page['title'] ) {
	return;
} ?>

<h1 class="odin-page-title"><?php echo wp_strip_all_tags( $page['title'] ); ?></h1>
