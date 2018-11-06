<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Odin
 * @subpackage Custom_Theme
 */
/**
 * Header Component.
 */
get_header();

/**
 * Content Component.
 */
get_template_part( 'components/main/main', '404' );

/**
 * Footer Component.
 */
get_footer();
