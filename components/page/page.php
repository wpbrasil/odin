<?php
/**
 * Page Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'odin-page' ); ?>>

	<div class="odin-page-wrapper">

		<header class="odin-page-header">

			<?php
			if ( is_single() ) :
				the_title( '<h1 class="odin-page-header__title">', '</h1>' );
			else :
				the_title( '<h2 class="odin-page-header__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>

		</header>

		<div class="odin-page-body">

			<?php
			 if ( is_search() || is_archive() ) {
			 	/**
				 * Excerpt post.
				 */
			 	the_excerpt();
			 } else {
				/**
				 * Content post.
				 */
				the_content( '<span class="odin-page-moreLinkText">' . __( 'Continue reading', 'odin' ) . '</span>' );

				/**
				 * Pagination within a post.
				 */
				get_template_part( 'components/pagination/pagination', 'within-post' );
			} ?>

		</div>

		<?php if ( is_single() ) : ?>
			<footer class="odin-page-footer">

				<div class="odin-post-footer__meta">

					<?php get_template_part( 'components/post/parts/meta-date-post' ); ?>

					<?php get_template_part( 'components/post/parts/meta-author-post' ); ?>

					<?php get_template_part( 'components/post/parts/comments-link-post' ); ?>

					<?php get_template_part( 'components/pagination/pagination', 'between-single-posts' ); ?>

				</div>

			</footer>
		<?php endif; ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		} ?>

	</div><!-- .odin-post-wrapper -->

</article><!-- #post-## -->
