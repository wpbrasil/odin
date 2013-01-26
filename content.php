<article <?php post_class(); ?>>
    <header class="entry-header">
        <h2 class="entry-title">
            <a href="<?php the_permalink(); ?>" title="<?php echo __( 'Link Permanente para ', 'odin' ) . get_the_title(); ?>" rel="bookmark"><?php the_title(); ?></a>
        </h2>
        <div class="entry-meta">
            <span class="sep"><?php _e( 'Por ', 'odin' ); ?></span>
            <span class="author vcard">
                <a class="url fn n" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" title="<?php echo esc_attr( __( 'Ver todos os posts de ', 'odin') . get_the_author() ); ?>" rel="author"><?php echo get_the_author(); ?></a>
            </span>
            <span class="sep"><?php _e( ' | Publicado em ', 'odin' ); ?></span>
            <time class="entry-date" datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->
    <div class="entry-content">
        <?php the_content( __( 'Continue lendo <span class="meta-nav">&rarr;</span>', 'odin' ) ); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'P&aacute;ginas:', 'odin' ) . '</span>', 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->
    <footer class="entry-meta">
        <?php echo odin_socialite_horizontal( get_the_title(), get_permalink(), get_the_post_thumbnail( $post->ID, 'thumbnail' ) ); ?>
        <span><?php _e( 'Publicado em: ', 'odin' ); the_category(', '); ?></span>
        <?php the_tags( '<span>' . __( ' e marcado ', 'odin' ), ', ', '</span>' ); ?>
        <?php if ( comments_open() && ! post_password_required() ) : ?>
            <span class="sep"> | </span>
            <?php comments_popup_link( __( 'Comentar', 'odin' ), __( '1 Coment&aacute;rio', 'odin' ), __( '% Coment&aacute;rios', 'odin' ) ); ?>
        <?php endif; ?>
        <?php get_template_part( 'share' ); ?>
    </footer><!-- #entry-meta -->
</article>
