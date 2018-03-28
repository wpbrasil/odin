<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'odin-post' ); ?>>

	<div class="odin-post-wrapper">

		<header class="odin-post-header">

			<?php
			if ( is_single() ) :
				the_title( '<h1 class="odin-post-title">', '</h1>' );
			else :
				the_title( '<h2 class="odin-post-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
			endif;
			?>

			<div class="odin-post-meta">

				<span class="odin-post-date">
					<?php printf( '%s <time datetime="%s">%s</time>', // WPCS: XSS ok.
						__( 'Posted in', 'odin' ),
						get_the_date( 'c' ),
						get_the_date()
					); ?>
				</span>

				<span class="odin-post-author">
					<?php printf( '%s <a class="odin-post-author-name" href="%s" rel="author">%s</a>', // WPCS: XSS ok.
						__( 'by', 'odin' ),
						esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
						get_the_author()
					); ?>
				</span>

			</div>

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

		<?php if ( is_single() ) : ?>
			<footer class="odin-post-footer">

				<div class="odin-post-meta">

					<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
						<span class="odin-post-comments-link">
							<?php comments_popup_link( __( 'Leave a comment', 'odin' ), __( '1 Comment', 'odin' ), __( '% Comments', 'odin' ) ); ?>
						</span>
					<?php endif; ?>

					<?php if ( in_array( 'category', get_object_taxonomies( get_post_type() ), true ) ) : ?>
						<span class="odin-post-cat-links">
							<?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'odin' ) ); // WPCS: XSS ok. ?>
						</span>
					<?php endif; ?>

					<?php the_tags( '<span class="odin-post-tag-links">' . __( 'Tagged as:', 'odin' ) . ' ', ', ', '</span>' ); ?>

				</div>

			</footer>
		<?php endif; ?>

	</div><!-- .odin-post-wrapper -->

</article><!-- #post-## -->
