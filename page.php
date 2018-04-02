<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
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
 * Main Page Component.
 */
get_template_part( 'components/main/main', 'page' );

/**
 * Footer Component.
 */
get_footer();
