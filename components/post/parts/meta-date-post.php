<?php
/**
 * Post Meta Date Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-post__meta-date">

	<div class="odin-post__meta-date-wrapper">

		<?php printf( '%s <time datetime="%s">%s</time>', // WPCS: XSS ok.
			__( 'Posted in', 'odin' ),
			get_the_date( 'c' ),
			get_the_date()
		); ?>

	</div>

</div>
