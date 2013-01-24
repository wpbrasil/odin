<?php
/**
 * Generates the title of the site optimized for SEO.
 */
function odin_site_title() {
    global $page, $paged;

    wp_title( '|', true, 'right' );

    bloginfo( 'name' );

    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        echo ' | ' . $site_description;
    }

    if ( $paged >= 2 || $page >= 2 ) {
        echo ' | ' . sprintf( __( 'P&aacute;gina %s', 'odin' ), max( $paged, $page ) );
    }
}

/**
 * Cleanup wp_head().
 */
function odin_head_cleanup() {
    // category feeds.
    // remove_action( 'wp_head', 'feed_links_extra', 3 );
    // post and comment feeds.
    // remove_action( 'wp_head', 'feed_links', 2 );
    // EditURI link.
    remove_action( 'wp_head', 'rsd_link' );
    // windows live writer.
    remove_action( 'wp_head', 'wlwmanifest_link' );
    // index link.
    remove_action( 'wp_head', 'index_rel_link' );
    // previous link.
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
    // start link.
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
    // links for adjacent posts.
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
    // WP version.
    remove_action( 'wp_head', 'wp_generator' );
}

add_action( 'init', 'odin_head_cleanup' );

/**
 * Remove WP version from RSS.
 */
function odin_rss_version() {
    return '';
}

add_filter( 'the_generator', 'odin_rss_version' );

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
 * remove injected CSS from gallery
 */
function odin_gallery_style( $css ) {
    return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
}

add_filter( 'gallery_style', 'odin_gallery_style' );

/**
 * Add rel="nofollow" and remove rel="category"
 */
function odin_modify_category_rel( $text ) {
    $search = array( 'rel="category"', 'rel="category tag"' );
    $text = str_replace( $search, 'rel="nofollow"', $text );
    return $text;
}

add_filter( 'wp_list_categories', 'odin_modify_category_rel' );
add_filter( 'the_category', 'odin_modify_category_rel' );

/**
 * Add rel="nofollow" and remove rel="tag"
 */
function odin_modify_tag_rel( $taglink ) {
    return str_replace( 'rel="tag">', 'rel="nofollow">', $taglink );
}

add_filter( 'wp_tag_cloud', 'odin_modify_tag_rel' );
add_filter( 'the_tags', 'odin_modify_tag_rel' );

/**
 * Add feed link
 */
add_theme_support( 'automatic-feed-links' );
