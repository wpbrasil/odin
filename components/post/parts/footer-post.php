<?php
/**
 * Taxonomy Tag Post Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

if ( ! is_single() ) {
	return;
} ?>

<footer class="odin-post-footer">

	<div class="odin-post-footer__meta">

		<?php get_template_part( 'components/post/parts/meta-author-post' ); ?>

		<?php get_template_part( 'components/post/parts/comments-link-post' ); ?>

		<?php get_template_part( 'components/post/parts/taxonomy-category-post' ); ?>

		<?php get_template_part( 'components/post/parts/taxonomy-tag-post' ); ?>

		<?php get_template_part( 'components/pagination/pagination', 'between-single-posts' ); ?>

	</div>

</footer>
