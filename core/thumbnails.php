<?php
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

        //validate inputs
        if ( ! $url || ( ! $width && ! $height ) ) return false;

        // caipt'n, ready to hook
        if ( $upscale === true ) add_filter( 'image_resize_dimensions', 'aq_upscale', 10, 6 );

        //define upload path & dir
        $upload_info = wp_upload_dir();
        $upload_dir = $upload_info['basedir'];
        $upload_url = $upload_info['baseurl'];

        //check if $img_url is local
        if ( strpos( $url, $upload_url ) === false ) return false;

        //define path of image
        $rel_path = str_replace( $upload_url, '', $url );
        $img_path = $upload_dir . $rel_path;

        //check if img path exists, and is an image indeed
        if ( ! file_exists( $img_path ) or ! getimagesize( $img_path ) ) return false;

        //get image info
        $info = pathinfo( $img_path );
        $ext = $info['extension'];
        list( $orig_w, $orig_h ) = getimagesize( $img_path );

        //get image size after cropping
        $dims = image_resize_dimensions( $orig_w, $orig_h, $width, $height, $crop );
        $dst_w = $dims[4];
        $dst_h = $dims[5];

        // return the original image only if it exactly fits the needed measures
        if ( ! $dims && ( ( ( $height === null && $orig_w == $width ) xor ( $width === null && $orig_h == $height ) ) xor ( $height == $orig_h && $width == $orig_w ) ) ) {
            $img_url = $url;
            $dst_w = $orig_w;
            $dst_h = $orig_h;
        } else {
            //use this to check if cropped image already exists, so we can return that instead
            $suffix = "{$dst_w}x{$dst_h}";
            $dst_rel_path = str_replace( '.' . $ext, '', $rel_path );
            $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

            if ( ! $dims || ( $crop == true && $upscale == false && ( $dst_w < $width || $dst_h < $height ) ) ) {
                //can't resize, so return false saying that the action to do could not be processed as planned.
                return false;
            }
            //else check if cache exists
            elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
                $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
            }
            //else, we resize the image and return the new resized image url
            else {

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
            }
        }

        // okay, leave the ship
        if ( $upscale === true ) remove_filter( 'image_resize_dimensions', 'aq_upscale' );

        //return the output
        if ( $single ) {
            //str return
            $image = $img_url;
        } else {
            //array return
            $image = array (
                0 => $img_url,
                1 => $dst_w,
                2 => $dst_h
            );
        }

        return $image;
    }

    function aq_upscale( $default, $orig_w, $orig_h, $dest_w, $dest_h, $crop ) {
        if ( ! $crop ) return null; // let the wordpress default function handle this

        // here is the point we allow to use larger image size than the original one
        $aspect_ratio = $orig_w / $orig_h;
        $new_w = $dest_w;
        $new_h = $dest_h;

        if ( ! $new_w ) {
            $new_w = intval( $new_h * $aspect_ratio );
        }

        if ( ! $new_h ) {
            $new_h = intval( $new_w / $aspect_ratio );
        }

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
 * @return string         Return the post thumbnail
 */
function odin_thumbnail( $width, $height, $alt, $crop = true ) {
    $thumb = get_post_thumbnail_id();

    if ( $thumb ) {
        $url = wp_get_attachment_url( $thumb, 'full' );
        $image = aq_resize( $url, $width, $height, $crop );

        $html = '<img class="wp-image-thumb" src="' . $image . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="' . esc_attr( $alt ) . '" />';

        return apply_filters( 'odin_thumbnail_html', $html );
    }
}

/**
 * Automatically sets the post thumbnail.
 *
 * @global array $post WP post object.
 */
function odin_autoset_featured() {
    global $post;
    if ( isset( $post->ID ) ) {
        $already_has_thumb = has_post_thumbnail( $post->ID );
        if ( ! $already_has_thumb ) {
            $attached_image = get_children( 'post_parent=' . $post->ID . '&post_type=attachment&post_mime_type=image&numberposts=1' );
            if ( $attached_image ) {
                foreach ( $attached_image as $attachment_id => $attachment ) {
                    set_post_thumbnail( $post->ID, $attachment_id );
                }
            }
        }
    }
}

add_action( 'the_post', 'odin_autoset_featured' );
add_action( 'save_post', 'odin_autoset_featured' );
add_action( 'draft_to_publish', 'odin_autoset_featured' );
add_action( 'new_to_publish', 'odin_autoset_featured' );
add_action( 'pending_to_publish', 'odin_autoset_featured' );
add_action( 'future_to_publish', 'odin_autoset_featured' );
