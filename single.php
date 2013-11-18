<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="col-md-8">
	<div id="content" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> itemscope="" itemtype="http://schema.org/Article">
				<header class="entry-header">
					<h1 class="entry-title" itemprop="name headline"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
					<div class="entry-meta">
						<span class="sep"><?php _e( 'By', 'odin' ); ?> </span>
						<span class="author vcard">
							<a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( __( 'All posts by', 'odin' ) . ' ' . get_the_author() ); ?>" rel="author" itemprop="author"><?php echo get_the_author(); ?></a>
						</span>
						<span class="sep"> <?php _e( '| Posted in', 'odin' ); ?> </span>
						<time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>" itemprop="datePublished"><?php echo get_the_date(); ?></time>
					</div><!-- .entry-meta -->
				</header><!-- .entry-header -->
				<div class="entry-content" itemprop="articleBody">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'odin' ) . '</span>', 'after' => '</div>' ) ); ?>
					<?php echo odin_related_posts(); ?>
				</div><!-- .entry-content -->
				<footer class="entry-meta">
					<span><?php _e( 'Posted in', 'odin' ); ?> <?php the_category( ', ' ); ?></span>
					<?php the_tags( '<span itemprop="keywords"> ' . __( 'and tagged as', 'odin' ) . ' ', ', ', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</article>
			<?php comments_template( '', true ); ?>
		<?php endwhile; ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
