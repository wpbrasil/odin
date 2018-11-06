<?php
/**
 * Pagination within a post.
 *
 * @link https://developer.wordpress.org/themes/functionality/pagination/#pagination-within-a-post
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

wp_link_pages( array(
	'before'         => '<nav aria-label="' . __( 'Pages:', 'odin' ) . '"><ul class="odin-pagination-with-post"><li class="odin-pagination-with-post__item">',
	'after'          => '</li></ul></nav>',
	'separator'      => '</li><li class="odin-pagination-with-post__item">',
	'link_before'    => '<span class="odin-pagination-with-post__link">',
	'link_after'     => '</span>',
	'next_or_number' => 'next',
) );
