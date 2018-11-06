<?php
/**
 * Taxonomy Category Post Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

if ( ! in_array( 'category', get_object_taxonomies( get_post_type() ), true ) ) {
	return;
} ?>

<div class="odin-taxonomy-category-post">

	<div class="odin-taxonomy-category-post-wrapper">

		<?php echo get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'odin' ) ); // WPCS: XSS ok. ?>

	</div>

</div>
