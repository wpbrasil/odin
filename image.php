<?php
/**
 * The template for displaying image attachments.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package odin
 */

get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_sidebar(); ?>" tabindex="-1" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					<div class="entry-meta">
						<?php
							$metadata = wp_get_attachment_metadata();
							printf( __( 'Image total size: %s pixels', 'odin' ), sprintf( '<a href="%1$s" title="%2$s"><span>%3$s</span> &times; <span>%4$s</span></a>', wp_get_attachment_url(), esc_attr( __( 'Full image link', 'odin' ) ), $metadata['width'], $metadata['height'] ) );
						?>
					</div>
				</header>

				<div class="entry-content">
					<figure class="entry-attachment entry-attachment--image">
						<a href="<?php echo wp_get_attachment_url( $post->ID, 'full' ); ?>" title="<?php the_title_attribute(); ?>">
							<?php echo wp_get_attachment_image( $post->ID, 'full' ); ?>
						</a>
						<figcaption class="entry-attachment-caption">
							<?php if ( ! empty( $post->post_excerpt ) ) the_excerpt(); ?>
						</figcaption>
					</figure>

					<?php the_content(); ?>
				</div>

				<footer class="entry-footer">
					<nav>
						<ul class="pager">
							<li class="previous"><?php previous_image_link( false, __( '&larr; Previous image', 'odin' ) ); ?></li>
							<li class="next"><?php next_image_link( false, __( 'Next image &rarr;', 'odin' ) ); ?></li>
						</ul>
					</nav>

					<?php if ( ! empty( $post->post_parent ) ) : ?>
					<nav>
						<a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Back to %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" class="link-post-parent" rel="gallery">
							<?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?>
						</a>
					</nav>
					<?php endif; ?>
				</footer>
			</article>
		<?php endwhile; ?>

	</main>

<?php
get_sidebar();
get_footer();
