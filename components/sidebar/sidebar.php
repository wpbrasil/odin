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

<aside class="odin-sidebar" id="secundary" role="complementary">

	<div class="odin-sidebar-wrapper">

		<?php
		if ( ! dynamic_sidebar( 'sidebar-main' ) ) {
			the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) );
			the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) );
			the_widget( 'WP_Widget_Tag_Cloud' );
		}
		?>

	</div>

</aside><!-- .odin-main__sidebar -->
