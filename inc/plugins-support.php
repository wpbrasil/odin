<?php
/**
 * Functions to improved plugins support.
 */

/**
 * WooCommerce and Jigoshop content wrapper.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_woocommerce_jigoshop_content_wrapper() {
	echo '<div id="primary" class="' . odin_page_sidebar_classes() . '">';
}

/**
 * WooCommerce and Jigoshop content wrapper end.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_woocommerce_jigoshop_content_wrapper_end() {
	echo '</div>';
}

/**
 * WooCommerce.
 */
// add_theme_support( 'woocommerce' );
// add_action( 'woocommerce_before_main_content', 'odin_woocommerce_jigoshop_content_wrapper', 10 );
// add_action( 'woocommerce_after_main_content', 'odin_woocommerce_jigoshop_content_wrapper_end', 10 );

/**
 * Jigoshop.
 */
// add_action( 'jigoshop_before_main_content', 'odin_jigoshop_output_content_wrapper', 10 );
// add_action( 'jigoshop_after_main_content', 'odin_jigoshop_output_content_wrapper_end', 10 );
