<?php
/**
 * The template for displaying audio attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="<?php echo odin_sidebar_classes(); ?>">
	<div id="content" role="main" itemscope itemtype="http://schema.org/MediaObject">
		<?php while ( have_posts() ) : the_post(); $metadata = wp_get_attachment_metadata(); ?>
			<article <?php post_class(); ?> itemscope itemtype="http://schema.org/AudioObject">
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
						<div class="entry-meta entry-content">
							<meta itemprop="encodingFormat" content="<?php echo esc_attr( $metadata['dataformat'] ); ?>" />
							<meta itemprop="contentSize" content="<?php echo esc_attr( $metadata['filesize'] ); ?>" />
						</div><!-- .entry-meta -->
				</header><!-- .entry-header -->
				<div class="entry-content">
					<div class="entry-attachment">
						<?php echo esc_attr( wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) ) ); ?>

						<p><strong><?php _e( 'URL:', 'odin' ); ?></strong> <a href="<?php echo esc_url( wp_get_attachment_url() ); ?>" title="<?php the_title_attribute(); ?>" rel="attachment" itemprop="contentURL"><span itemprop="name"><?php echo esc_attr( basename( wp_get_attachment_url() ) ); ?></span></a></p>

						<div itemprop="description">
							<?php the_content(); ?>
						</div>
					</div><!-- .entry-attachment -->

					<?php if ( ! empty( $post->post_parent ) ) : ?>
						<ul class="pager page-title" itemprop="associatedMedia">
							<li class="previous"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Back to %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>"><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?></a></li>
						</ul><!-- .pager -->
					<?php endif; ?>
				</div><!-- .entry-content -->
			</article>
		<?php endwhile; ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
