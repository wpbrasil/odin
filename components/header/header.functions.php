<?php
/**
 * Header Functions Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Add Custom Header support
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 */
function odin_custom_header_setup() {
    $args = array(
		'width'         => 1400,
		'height'        => 600,
		'flex-width'    => true,
		'flex-height'   => true,
		'header-text'   => false,
		'default-image' => '',
		'uploads'       => true,
    );
    add_theme_support( 'custom-header', $args );
}
add_action( 'after_setup_theme', 'odin_custom_header_setup' );
