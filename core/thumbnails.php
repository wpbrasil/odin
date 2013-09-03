<?php
/**
 * Odin thumbnail functions.
 */

/*
 * Add post_thumbnails suport.
 */
add_theme_support( 'post-thumbnails' );

/**
 * Title: Aqua Resizer
 * Description: Resizes WordPress images on the fly
 * Version: 1.1.7
 * Author: Syamil MJ
 * Author URI: http://aquagraphite.com
 * License: WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation: https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param    string $url - (required) must be uploaded using wp media uploader
 * @param    int $width - (required)
 * @param    int $height - (optional)
 * @param    bool $crop - (optional) default to soft crop
 * @param    bool $single - (optional) returns an array if false
 *
 * @uses     wp_upload_dir()
 * @uses     image_resize_dimensions() | image_resize()
 * @uses     wp_get_image_editor()
 *
 * @return str|array
 */

if ( ! function_exists( 'aq_resize' ) ) {

    function aq_resize( $url, $width = null, $height = null, $crop = null, $single = true, $upscale = false ) {

        // Validate inputs.
        if ( ! $url || ( ! $width && ! $height ) ) return false;

        // Caipt'n, ready to hook.
        if ( true === $upscale ) add_filter( 'image_resize_dimensions', 'aq_upscale', 10, 6 );

        // Define upload path & dir.
        $upload_info = wp_upload_dir();
        $upload_dir = $upload_info['basedir'];
        $upload_url = $upload_info['baseurl'];

        $http_prefix = "http://";
        $https_prefix = "https://";

        // if the $url scheme differs from $upload_url scheme, make them match.
        // if the schemes differe, images don't show up.
        if ( ! strncmp( $url, $https_prefix, strlen( $https_prefix ) ) )
            $upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
        elseif ( ! strncmp( $url, $http_prefix, strlen( $http_prefix ) ) )
            $upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );

        // Check if $img_url is local.
        if ( false === strpos( $url, $upload_url ) ) return false;

        // Define path of image.
        $rel_path = str_replace( $upload_url, '', $url );
        $img_path = $upload_dir . $rel_path;

        // Check if img path exists, and is an image indeed.
        if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

        // Get image info.
        $info = pathinfo( $img_path );
        $ext = $info['extension'];
        list( $orig_w, $orig_h ) = getimagesize( $img_path );

        // Get image size after cropping.
        $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
        $dst_w = $dims[4];
        $dst_h = $dims[5];

        // Return the original image only if it exactly fits the needed measures.
        if ( ! $dims && ( ( ( null === $height && $orig_w == $width ) xor ( null === $width && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
            $img_url = $url;
            $dst_w = $orig_w;
            $dst_h = $orig_h;
        } else {
            // Use this to check if cropped image already exists, so we can return that instead.
            $suffix = "{$dst_w}x{$dst_h}";
            $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
            $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

            if ( ! $dims || ( true == $crop && false == $upscale && ( $dst_w < $width || $dst_h < $height ) ) ) {
                // Can't resize, so return false saying that the action to do could not be processed as planned.
                return false;
            }
            // Else check if cache exists.
            elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
            }
            // Else, we resize the image and return the new resized image url.
            else {

                // Note: This pre-3.5 fallback check will edited out in subsequent version.
                if ( function_exists( 'wp_get_image_editor' ) ) {

                    $editor = wp_get_image_editor( $img_path );

                    if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
                        return false;

                    $resized_file = $editor->save();

                    if ( ! is_wp_error( $resized_file ) ) {
                        $resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
                        $img_url = $upload_url . $resized_rel_path;
                    } else {
                        return false;
                    }

                } else {

                    $resized_img_path = image_resize( $img_path, $width, $height, $crop ); // Fallback foo.
                    if ( ! is_wp_error( $resized_img_path ) ) {
                        $resized_rel_path = str_replace( $upload_dir, '', $resized_img_path );
                        $img_url = $upload_url . $resized_rel_path;
                    } else {
                        return false;
                    }

                }

            }
        }

        // Okay, leave the ship.
        if ( true === $upscale ) remove_filter( 'image_resize_dimensions', 'aq_upscale' );

        // Return the output.
        if ( $single ) {
            // str return.
            $image = $img_url;
        } else {
            // array return.
            $image = array (
                0 => $img_url,
                1 => $dst_w,
                2 => $dst_h
            );
        }

        return $image;
    }


    function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
        if ( ! $crop ) return null; // Let the wordpress default function handle this.

        // Here is the point we allow to use larger image size than the original one.
        $aspect_ratio = $orig_w / $orig_h;
        $new_w = $dest_w;
        $new_h = $dest_h;

        if ( ! $new_w )
            $new_w = intval( $new_h * $aspect_ratio );

        if ( ! $new_h )
            $new_h = intval( $new_w / $aspect_ratio );

        $size_ratio = max( $new_w / $orig_w, $new_h / $orig_h );

        $crop_w = round( $new_w / $size_ratio );
        $crop_h = round( $new_h / $size_ratio );

        $s_x = floor( ( $orig_w - $crop_w ) / 2 );
        $s_y = floor( ( $orig_h - $crop_h ) / 2 );

        return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
    }

}

/**
 * Custom post thumbnail.
 *
 * @param int     $width  Width of the image.
 * @param int     $height Height of the image.
 * @param string  $alt    Alt attribute of the image.
 * @param bool    $crop   Image crop.
 *
 * @return string         Return the post thumbnail.
 */
function odin_thumbnail( $width, $height, $alt, $crop = true ) {
    $thumb = get_post_thumbnail_id();

    if ( $thumb ) {
        $url = wp_get_attachment_url( $thumb, 'full' );
        $image = aq_resize( $url, $width, $height, $crop, true, true );

        $html = '<img class="wp-image-thumb img-responsive" src="' . $image . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="' . esc_attr( $alt ) . '" />';

        return apply_filters( 'odin_thumbnail_html', $html );
    }
}
