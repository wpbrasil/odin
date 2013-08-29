<?php
/**
 * Sample archive for Custom Post Type.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="col-md-8">
    <section id="content" role="main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php post_type_archive_title(); ?></h1>
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
