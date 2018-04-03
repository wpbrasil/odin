<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Header Component.
 */
get_header();

/**
 * Main Component.
 */
get_template_part( 'components/main/main' );

/**
 * Sidebar Component.
 */
get_sidebar();

/**
 * Footer Component.
 */
get_footer();
