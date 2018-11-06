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

		<div class="odin-post__meta-author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'ID' ), 30 ); ?>
		</div>

		<?php printf( '<div class="odin-post-author-name">%s <a href="%s" rel="author">%s</a></div>', // WPCS: XSS ok.
			__( 'by', 'odin' ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			get_the_author()
		); ?>

	</div>

</div>
