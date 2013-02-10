<?php
/**
 * Lazyload functions.
 *
 * @package    Odin
 * @subpackage Snippets
 * @since      1.0
 */

/**
 * Load lazyload script.
 */
function odin_lazyload_scripts() {
    wp_register_script( 'lazyload', get_template_directory_uri() . '/core/lazyload/js/jquery.lazyload.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'lazyload' );
}

add_action( 'wp_enqueue_scripts', 'odin_lazyload_scripts' );

/**
 * LazyLoad Placeholder.
 *
 * Inspired by http://wordpress.org/extend/plugins/lazy-load/
 *
 * @param  string $content Default content.
 *
 * @return string          Content with placeholder images.
 */
function odin_lazyload_placeholder( $content ) {
    // Removes behavior in feeds, previews, mobile.
    if ( is_feed() || is_preview() || wp_is_mobile() ) {
        return $content;
    }

    // Don't lazy-load if the content has already been run through previously.
    if ( false !== strpos( $content, 'data-original' ) ) {
        return $content;
    }

    // Placeholder image.
    $placeholder = apply_filters( 'odin_lazyload_placeholder', get_template_directory_uri() . '/core/images/lazyload.gif' );

    // This is a pretty simple regex, but it works.
    $content = preg_replace( '#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf( '<img${1}src="%s" data-original="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder ), $content );

    return $content;
}

add_filter( 'the_content', 'odin_lazyload_placeholder', 99 );
add_filter( 'post_thumbnail_html', 'odin_lazyload_placeholder', 11 );
add_filter( 'get_avatar', 'odin_lazyload_placeholder', 11 );
