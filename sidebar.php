<div id="secondary" class="widget-area" role="complementary">
    <?php if ( ! dynamic_sidebar( 'main-sidebar' ) ) : ?>
        <?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) ); ?>
        <?php the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) ); ?>
        <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
    <?php endif; ?>
</div><!-- #secondary -->
