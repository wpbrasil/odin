<?php get_header(); ?>
<div id="primary" class="no-sidebar">
    <div id="content" role="main">
        <article class="post error404 not-found">
            <header class="entry-header">
                <h1 class="entry-title"><?php _e( 'Isso &eacute; embara&ccedil;oso, n&atilde;o?', 'odin' ); ?></h1>
            </header>
            <div class="entry-content">
                <p><?php _e( 'Parece que n&atilde;o encontramos o que voc&ecirc; est&aacute; procurando. Talvez a busca, ou um dos links abaixo, possa ajudar.', 'odin' ); ?></p>
                <?php get_search_form(); ?>
                <?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => '404' ) ); ?>
                <div class="widget">
                    <h2 class="widgettitle"><?php _e( 'Categorias mais usadas', 'odin' ); ?></h2>
                    <ul>
                        <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
                    </ul>
                </div>
                <?php the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) ); ?>
                <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
            </div><!-- .entry-content -->
        </article><!-- .error404 -->
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
