<?php get_header(); ?>
<div id="primary" class="col-md-8">
    <section id="content" role="main">
        <?php if ( have_posts() ) : ?>
            <header class="page-header">
                <h1 class="page-title" itemprop="name headline"><?php echo __( 'Tag Archives:', 'odin' ) . ' <span>' . single_tag_title( '', false ) . '</span>'; ?></h1>
                <?php
                    $tag_description = tag_description();
                    if ( ! empty( $tag_description ) ) {
                        echo '<div class="tag-archive-meta" itemprop="description">' . $tag_description . '</div>';
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
