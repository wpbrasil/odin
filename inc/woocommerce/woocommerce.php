<?php
/**
 * WooCommerce Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Query WooCommerce activation
 *
 * @return boolean
 */
if ( ! function_exists( 'odin_is_woocommerce_activated' ) ) {
	function odin_is_woocommerce_activated() {
		return class_exists( 'woocommerce' ) ? true : false;
	}
}

// /**
//  * WooCommerce compatibility files.
//  */
// if ( odin_is_woocommerce_activated() ) {
// 	add_theme_support( 'woocommerce' );
// 	require get_template_directory() . '/inc/woocommerce/hooks.php';
// 	require get_template_directory() . '/inc/woocommerce/functions.php';
// 	require get_template_directory() . '/inc/woocommerce/template-tags.php';
// }

