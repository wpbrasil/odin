<?php
/**
 * The template for displaying audio attachments.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 2.2.0
 */

get_header(); ?>

	<div id="primary" class="<?php echo odin_classes_page_sidebar(); ?>">
		<main id="main-content" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); $metadata = wp_get_attachment_metadata(); ?>
				<article <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content entry-attachment">
						<?php echo wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) ); ?>

						<p><strong><?php _e( 'URL:', 'odin' ); ?></strong> <a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><span><?php echo esc_attr( basename( wp_get_attachment_url() ) ); ?></span></a></p>

						<?php the_content(); ?>

						<?php if ( ! empty( $post->post_parent ) ) : ?>
							<ul class="pager page-title">
								<li class="previous"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Back to %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>"><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?></a></li>
							</ul><!-- .pager -->
						<?php endif; ?>
					</div><!-- .entry-content -->
				</article>
			<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
