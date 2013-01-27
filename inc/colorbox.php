<?php
/**
 * Colorbox.
 *
 * Ref: http://www.jacklmoore.com/colorbox
 */

/**
 * Load colorbox script.
 */
function odin_colorbox_scripts() {
    wp_register_script( 'colorbox', get_template_directory_uri() . '/js/jquery.colorbox-min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'colorbox' );
}

add_action( 'wp_enqueue_scripts', 'odin_colorbox_scripts' );
