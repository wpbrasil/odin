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

		<div class="odin-footer__copyright">
			<?php esc_attr_e( 'All rights reserved', 'odin' ); ?><br>&copy; <?php echo esc_attr( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>.
		</div>

	</div>

</footer>
