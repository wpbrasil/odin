<?php
/**
 * Admin Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 *
 * @since 2.2.0
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );
