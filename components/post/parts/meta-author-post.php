<?php
/**
 * Post Meta Author Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-post__meta-author">

	<div class="odin-post__meta-author-wrapper">

	<?php printf( '%s <a class="odin-post-author-name" href="%s" rel="author">%s</a>', // WPCS: XSS ok.
		__( 'by', 'odin' ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		get_the_author()
	); ?>

	</div>

</div>
