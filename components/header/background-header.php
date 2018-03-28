<?php
/**
 * Background Header component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get image to apply background header.
 */
if ( get_header_image() && is_home() ) {
	// Header Image (support custom header support) only if is home.
	$header_image_url = get_header_image();
} elseif ( has_post_thumbnail() ) {
	// Thumbnail Post (get original size if not exists the correct).
	$header_image_url = odin_get_attachment_image_src( get_post_thumbnail_id(), 1400, 600 );
	$header_image_url = ( ! isset( $header_image_url ) ) ?: wp_get_attachment_url( get_post_thumbnail_id() );
} else {
	// Default Image.
	$header_image_url = 'http://placehold.it/1400x600';
} ?>

<?php if ( $header_image_url ) : ?>
	<style>
		.odin-header::after {
			background: linear-gradient(to bottom left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)),
									url(<?php echo esc_url_raw( $header_image_url ); ?>)
									no-repeat center center fixed;
			background-size: cover;
		}
	</style>
<?php endif; ?>
