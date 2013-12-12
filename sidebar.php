<?php
/**
 * The sidebar containing the secondary widget area, displays on homepage, archives and posts.
 *
 * If no active widgets in this sidebar, it will shows Recent Posts, Archives and Tag Cloud widgets.
 *
 * @package Odin
 * @since 1.9.0
 */
?>
<div id="secondary" class="<?php echo odin_sidebar_classes(); ?>" role="complementary" itemscope="" itemtype="http://schema.org/WPSideBar">
	<?php if ( ! dynamic_sidebar( 'main-sidebar' ) ) : ?>
		<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) ); ?>
		<?php the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) ); ?>
		<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>
	<?php endif; ?>
</div><!-- #secondary -->
