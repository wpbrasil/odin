<?php
/**
 * Sample single for Custom Post Type.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="col-md-8">
	<div id="content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?>>
				<header class="entry-header">
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<div class="entry-meta">
						<span class="sep"><?php _e( 'By', 'odin' ); ?> </span>
						<span class="author vcard">
							<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( __( 'All posts by', 'odin' ) . ' ' . get_the_author() ); ?>" rel="author"><?php echo get_the_author(); ?></a>
						</span>
						<span class="sep"> <?php _e( '| Posted in', 'odin' ); ?> </span>
						<time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->
				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'odin' ) . '</span>', 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
				<footer class="entry-meta">
					<span><?php _e( 'Posted in', 'odin' ); ?> <?php the_category( ', ' ); ?></span>
					<?php the_tags( '<span> ' . __( 'and tagged as', 'odin' ) . ' ', ', ', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article>
			<?php comments_template( '', true ); ?>
		<?php endwhile; ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
