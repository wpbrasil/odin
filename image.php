<?php
/**
 * The template for displaying image attachments.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_sidebar(); ?>" tabindex="-1" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<article <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta entry-content">
							<?php
								$metadata = wp_get_attachment_metadata();
								printf( __( 'Image total size: %s pixels', 'odin' ), sprintf( '<a href="%1$s" title="%2$s"><span>%3$s</span> &times; <span>%4$s</span></a>', wp_get_attachment_url(), esc_attr( __( 'Full image link', 'odin' ) ), $metadata['width'], $metadata['height'] ) );
							?>
						</div><!-- .entry-meta -->
					</header><!-- .entry-header -->

					<div class="entry-content entry-attachment">
						<p class="attachment"><a href="<?php echo wp_get_attachment_url( $post->ID, 'full' ); ?>" title="<?php the_title_attribute(); ?>"><?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a></p>
						<div class="entry-caption"><em><?php if ( ! empty( $post->post_excerpt ) ) the_excerpt(); ?></em></div>
						<?php the_content(); ?>

						<ul class="pager">
							<li class="previous"><?php previous_image_link( false, __( '&larr; Previous image', 'odin' ) ); ?></li>
							<li class="next"><?php next_image_link( false, __( 'Next image &rarr;', 'odin' ) ); ?></li>
						</ul><!-- .pager -->

						<?php if ( ! empty( $post->post_parent ) ) : ?>
							<ul class="pager page-title">
								<li class="previous"><a href="<?php echo esc_url( get_permalink( $post->post_parent ) ); ?>" title="<?php echo esc_attr( sprintf( __( 'Back to %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" rel="gallery"><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?></a></li>
							</ul><!-- .pager -->
						<?php endif; ?>
					</div><!-- .entry-content -->
				</article>
			<?php endwhile; ?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();
