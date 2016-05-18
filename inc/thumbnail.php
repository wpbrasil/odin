<?php
/**
 * Custom post thumbnail.
 *
 * @since  2.2.0
 *
 * @param  int     $width   Width of the image.
 * @param  int     $height  Height of the image.
 * @param  string  $class   Class attribute of the image.
 * @param  string  $alt     Alt attribute of the image.
 * @param  boolean $crop    Image crop.
 * @param  string  $class   Custom HTML classes.
 * @param  boolean $upscale Force the resize.
 *
 * @return string         Return the post thumbnail.
 */
function odin_thumbnail( $width, $height, $alt, $crop = true, $class = '', $upscale = false ) {
	if ( ! class_exists( 'Odin_Thumbnail_Resizer' ) ) {
		return;
	}

	$thumb = get_post_thumbnail_id();

	if ( $thumb ) {
		$image = odin_get_image_url( $thumb, $width, $height, $crop, $upscale );
		$html  = '<img class="wp-image-thumb img-responsive ' . esc_attr( $class ) . '" src="' . esc_url( $image ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="' . esc_attr( $alt ) . '" />';

		return apply_filters( 'odin_thumbnail_html', $html );
	}
}
