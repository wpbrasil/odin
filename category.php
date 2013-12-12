<?php
/**
 * The template for displaying Category pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 2.1.6
 */

get_header(); ?>
<div id="primary" class="<?php echo odin_page_sidebar_classes(); ?>">
	<section id="content" role="main">
		<?php if ( have_posts() ) : ?>
			<header class="page-header">
				<h1 class="page-title" itemprop="name headline"><?php echo __( 'Category Archives:', 'odin' ) . ' <span>' . single_cat_title( '', false ) . '</span>'; ?></h1>
				<?php
					$category_description = category_description();
					if ( ! empty( $category_description ) ) {
						echo '<div class="category-archive-meta" itemprop="description">' . $category_description . '</div>';
					}
				?>
			</header>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			<?php echo odin_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'no-results' ); ?>
		<?php endif; ?>
	</section><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
