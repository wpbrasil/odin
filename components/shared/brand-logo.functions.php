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
        'height'      => 240,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array( 'site-title', 'site-description' ),
    );
    add_theme_support( 'custom-logo', $defaults );
}

add_action( 'after_setup_theme', 'odin_custom_logo_setup' );
