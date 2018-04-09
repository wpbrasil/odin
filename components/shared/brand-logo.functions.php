<?php
/**
 * Brand Functions Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Add Custom Logo support
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-logo/
 */
function odin_custom_logo_setup() {
    $defaults = array(
        'height'      => 50,
        'width'       => 50,
        'flex-height' => true,
        'flex-width'  => true,
    );
    add_theme_support( 'custom-logo', $defaults );
}

add_action( 'after_setup_theme', 'odin_custom_logo_setup' );
