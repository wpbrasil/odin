<?php
/**
 * The template for displaying image attachments.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @since 1.9.0
 */

get_header(); ?>
<div id="primary" class="col-md-12">
    <div id="content" role="main" itemscope itemtype="http://schema.org/MediaObject">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
                    <div class="entry-meta entry-content" itemscope itemtype="http://schema.org/ImageObject">
                        <?php
                            $metadata = wp_get_attachment_metadata();
                            printf( __( 'Image total size: %s pixels', 'odin' ), sprintf( '<a href="%1$s" title="%2$s" itemprop="image"><span itemprop="width">%3$s</span> &times; <span itemprop="height">%4$s</span></a>', wp_get_attachment_url(), esc_attr( __( 'Full image link', 'odin' ) ), $metadata['width'], $metadata['height'] ) );
                        ?>
                    </div><!-- .entry-meta -->
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <div class="entry-attachment">
                        <p class="attachment"><a href="<?php echo wp_get_attachment_url( $post->ID, 'full' ); ?>" title="<?php the_title_attribute(); ?>" itemprop="image"><?php echo wp_get_attachment_image( $post->ID, 'full' ); ?></a></p>
                        <div class="entry-caption" itemprop="description"><em><?php if ( ! empty( $post->post_excerpt ) ) the_excerpt(); ?></em></div>
                        <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'odin' ) ); ?>
                        <?php wp_link_pages( array( 'before' => '<br class="clear" /><div class="page-link"><span>' . __( 'Pages:', 'odin' ) . '</span>', 'after' => '</div>' ) ); ?>
                        <ul class="pager">
                            <li class="previous"><?php previous_image_link( false, __( '&larr; Previous image', 'odin' ) ); ?></li>
                            <li class="next"><?php next_image_link( false, __( 'Next image &rarr;', 'odin' ) ); ?></li>
                        </ul><!-- .pager -->
                    </div><!-- .entry-attachment -->
                    <?php if ( ! empty( $post->post_parent ) ) : ?>
                        <ul class="pager page-title" itemprop="associatedMedia">
                            <li class="previous"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Back to %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" rel="gallery"><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?></a></li>
                        </ul><!-- .pager -->
                    <?php endif; ?>
                </div><!-- .entry-content -->
            </article>
        <?php endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
