<?php
/**
 * Taxonomy Tag Post Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-taxonomy-tag-post">

	<div class="odin-taxonomy-tag-post-wrapper">

		<?php the_tags( '<span class="odin-post-tag-links">' . __( 'Tagged as:', 'odin' ) . ' ', ', ', '</span>' ); ?>

	</div>

</div>
