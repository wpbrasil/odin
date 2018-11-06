<?php
/**
 * Post Gallery Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'odin-post' ); ?>>

	<div class="odin-post-wrapper">

		<?php
		/**
		 * Header Post Component.
		 */
		get_template_part( 'components/post/parts/header-post' ); ?>

		<div class="odin-post-body">

			<?php
			 if ( ! is_single() ) {

				// If not a single post, highlight the gallery.
				if ( get_post_gallery() ) :
					echo get_post_gallery();
				endif;

			 } else {

				/**
				 * Content post.
				 */
				the_content( '<span class="odin-post-moreLinkText">' . __( 'Continue reading', 'odin' ) . '</span>' );

				/**
				 * Pagination within a post.
				 */
				get_template_part( 'components/pagination/pagination', 'within-post' );

			} ?>

		</div>

		<?php
		/**
		 * Footer Post Component.
		 */
		get_template_part( 'components/post/parts/footer-post' ); ?>

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) {
			comments_template();
		} ?>

	</div><!-- .odin-post-wrapper -->

</article><!-- #post-## -->
