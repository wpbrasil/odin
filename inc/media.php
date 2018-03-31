<?php
/**
 * Functions for media display.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get a attachment image URL.
 *
 * This funciton required uses class Aq_Resize, to install via composer.
 *
 * @since 3.0.0
 *
 * @param  int|string $attachment  Image ID or Url (must be uploaded using wp media uploade).
 * @param  int        $width       Image width.
 * @param  int        $height      Image height.
 * @param  bool       $crop        Image crop.
 * @param  bool       $single      Returns an array if false.
 * @param  bool       $upscale     Force the resize.
 *
 * @return string|array
 */
function odin_get_attachment_image_src( $attachment = null, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {
	if ( ! class_exists( 'Aq_Resize' ) || ! $attachment ) {
		return false;
	}

	return aq_resize( $attachment, $width, $height, $crop, $single, $upscale );
}
