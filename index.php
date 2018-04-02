<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
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
