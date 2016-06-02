<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package odin
 */

?>

<aside id="sidebar" class="<?php echo odin_classes_page_sidebar_aside(); ?>" role="complementary">
	<?php
		if ( ! dynamic_sidebar( 'main-sidebar' ) ) {
			the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) );
			the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) );
			the_widget( 'WP_Widget_Tag_Cloud' );
		}
	?>
</aside><!-- #sidebar -->
