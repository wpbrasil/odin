<?php
/**
 * Footer component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<footer class="odin-footer" id="footer" role="contentinfo">

	<div class="odin-footer-wrapper">

		<div class="odin-footer__widgets">
			<?php
			if ( ! dynamic_sidebar( 'odin-widgets-footer' ) ) {
				the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 10 ) );
				the_widget( 'WP_Widget_Archives', array( 'count' => 0, 'dropdown' => 1 ) );
				the_widget( 'WP_Widget_Tag_Cloud' );
			}
			?>
		</div>

		<div class="odin-footer__copyright">
			<?php esc_attr_e( 'All rights reserved', 'odin' ); ?><br>&copy; <?php echo esc_attr( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
		</div>

	</div>

</footer>
