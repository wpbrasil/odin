<?php get_header(); ?>
<div id="primary" class="no-sidebar">
    <div id="content" role="main">
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php if ( wp_attachment_is_image() ) : ?>
                        <div class="entry-meta entry-content">
                            <?php
                                $metadata = wp_get_attachment_metadata();
                                printf( __( 'Tamanho total da imagem: %s pixels', 'odin' ), sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>', wp_get_attachment_url(), esc_attr( __( 'Link da imagem completa', 'odin' ) ), $metadata['width'], $metadata['height'] ) );
                            ?>
                        </div><!-- .entry-meta -->
                    <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">
                    <?php if ( ! empty( $post->post_parent ) ) : ?>
                        <p class="page-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php echo esc_attr( sprintf( __( 'Voltar para %s', 'odin' ), strip_tags( get_the_title( $post->post_parent ) ) ) ); ?>" rel="gallery"><?php printf( __( '<span class="meta-nav">&larr;</span> %s', 'odin' ), get_the_title( $post->post_parent ) ); ?></a></p>
                    <?php endif; ?>
                    <div class="entry-attachment">
                        <?php if ( wp_attachment_is_image() ) : ?>
                            <p class="attachment"><a href="<?php echo wp_get_attachment_url( $post->ID, 'full' ); ?>" title="<?php the_title_attribute(); ?>"><?php echo wp_get_attachment_image( $post->ID, array( 900, 900 ) ); ?></a></p>
                            <div class="entry-caption"><em><?php if ( ! empty( $post->post_excerpt ) ) the_excerpt(); ?></em></div>
                            <?php the_content( __( 'Continue lendo <span class="meta-nav">&rarr;</span>', 'odin' ) ); ?>
                            <?php wp_link_pages( array( 'before' => '<br class="clear" /><div class="page-link"><span>' . __( 'P&aacute;ginas:', 'odin' ) . '</span>', 'after' => '</div>' ) ); ?>
                            <div id="nav-below" class="navigationc clearfix">
                                <div class="nav-next"><?php next_image_link( false, __( 'Pr&oacute;xima imagem &rarr;', 'odin' ) ); ?></div>
                                <div class="nav-previous"><?php previous_image_link( false, __( '&larr; Imagem anterior', 'odin' ) ); ?></div>
                            </div><!-- #nav-below -->
                        <?php else : ?>
                            <a href="<?php echo wp_get_attachment_url(); ?>" title="<?php the_title_attribute(); ?>" rel="attachment"><?php echo basename( get_permalink() ); ?></a>
                        <?php endif; ?>
                    </div><!-- .entry-attachment -->
                </div><!-- .entry-content -->
            </article>
        <?php endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
