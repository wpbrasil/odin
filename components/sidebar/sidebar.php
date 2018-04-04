<?php
/**
 * Sidebar component.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<aside class="odin-sidebar" id="sidebar" role="complementary">

	<div class="odin-sidebar-wrapper">

		<div class="odin-sidebar__widgets">
			<?php
			if ( ! dynamic_sidebar( 'odin-widgets-sidebar' ) ) {
				the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) );
				the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) );
				the_widget( 'WP_Widget_Tag_Cloud' );
			}
			?>
		</div>

	</div>

</aside><!-- .odin-sidebar -->
