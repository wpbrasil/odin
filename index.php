<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="<?php echo odin_page_sidebar_classes(); ?>">
	<div id="content" role="main">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
			<?php echo odin_pagination(); ?>
		<?php else : ?>
			<?php get_template_part( 'no-results' ); ?>
		<?php endif; ?>
	</div><!-- #content -->
</div><!-- #primary -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
