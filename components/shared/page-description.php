<?php
/**
 * Page Description Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get page description.
 */
if ( is_front_page() && is_home() || is_home() ) {
	$page['description'] = get_bloginfo( 'description' );
} elseif ( is_singular( array( 'post', 'page' ) ) ) {
	// Singular (post|page).
	$page['description'] = apply_filters( 'the_excerpt', get_post_field( 'post_excerpt', $post->ID ) ); // https://core.trac.wordpress.org/ticket/42814
} elseif ( is_archive() ) {
	// Archive.
	$page['description'] = get_the_archive_description();
} else {
	return;
}

/**
 * If don't exists data return.
 */
if ( ! $page['description'] ) {
	return;
} ?>

<p class="odin-page-description"><?php echo wp_strip_all_tags( $page['description'] ); ?></p>
