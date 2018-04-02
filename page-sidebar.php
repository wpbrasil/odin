<?php
/**
 * Template Name: Page Sidebar
 *
 * The template for displaying pages with sidebar.
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
 * Content Component.
 */
get_template_part( 'components/main/main', 'page' );

/**
 * Sidebar Component.
 */
get_sidebar();

/**
 * Footer Component.
 */
get_footer();
