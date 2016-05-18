<?php
/**
 * Get a image URL.
 *
 * @param  int     $id      Image ID.
 * @param  int     $width   Image width.
 * @param  int     $height  Image height.
 * @param  boolean $crop    Image crop.
 * @param  boolean $upscale Force the resize.
 *
 * @return string
 */
function odin_get_image_url( $id, $width, $height, $crop = true, $upscale = false ) {
	$resizer    = Odin_Thumbnail_Resizer::get_instance();
	$origin_url = wp_get_attachment_url( $id );
	$url        = $resizer->process( $origin_url, $width, $height, $crop, $upscale );

	if ( $url ) {
		return $url;
	} else {
		return $origin_url;
	}
}
