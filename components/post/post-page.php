<?php
/**
 * Post Page Component.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'odin-post-page' ); ?>>

	<div class="odin-post-wrapper">

		<header class="odin-post-header">

			<?php
			if ( is_single() ) :
				the_title( '<h1 class="odin-post-title">', '</h1>' );
			else :
				the_title( '<h2 class="odin-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>

		</header>

		<?php if ( is_search() || is_archive() ) : ?>
			<div class="odin-post-excerpt">
				<?php the_excerpt(); ?>
			</div>
		<?php else : ?>
			<div class="odin-post-content">
				<?php
					/**
					 * Content post.
					 */
					the_content( '<span class="odin-post-moreLinkText">' . __( 'Continue reading', 'odin' ) . '</span>' );

					/**
					 * Pagination within a post.
					 */
					get_template_part( 'components/pagination/pagination', 'within-post' );
				?>
			</div>
		<?php endif; ?>

	</div><!-- .odin-post-wrapper -->

</article><!-- #post-## -->
