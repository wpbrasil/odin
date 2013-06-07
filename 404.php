<?php get_header(); ?>
<div id="primary" class="span12">
    <div id="content" role="main">
        <article class="post error404 not-found">
                <h1 class="entry-title"><?php _e( 'This is embarrassing, no?', 'odin' ); ?></h1>
            <header class="entry-header">
            </header>
            <div class="entry-content">
                <p><?php _e( 'It seems we can not find what you were looking for. Maybe a search or the links below can help.', 'odin' ); ?></p>
                <?php get_search_form(); ?>
                <div class="span3 no-margin-left">
                    <?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ), array( 'widget_id' => '404' ) ); ?>
                </div>
                <div class="widget span3">
                    <h2 class="widgettitle"><?php _e( 'Most Used Categories', 'odin' ); ?></h2>
                    <ul>
                        <?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10 ) ); ?>
                    </ul>
                </div>
                <div class="span3">
                    <?php the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) ); ?>
                </div>
                <div class="span3">
                    <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
                </div>
            </div><!-- .entry-content -->
        </article><!-- .error404 -->
    </div><!-- #content -->
</div><!-- #primary -->
<?php get_footer(); ?>
