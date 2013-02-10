<?php
/*
 * Add post_thumbnails suport.
 */
add_theme_support( 'post-thumbnails' );

/**
 * Title: Aqua Resizer
 * Description: Resizes WordPress images on the fly
 * Version: 1.1.6
 * Author: Syamil MJ
 * Author URI: http://aquagraphite.com
 * License: WTFPL - http://sam.zoy.org/wtfpl/
 * Documentation: https://github.com/sy4mil/Aqua-Resizer/
 *
 * @param string  $url    - (required) must be uploaded using wp media uploader
 * @param int     $width  - (required)
 * @param int     $height - (optional)
 * @param bool    $crop   - (optional) default to soft crop
 * @param bool    $single - (optional) returns an array if false
 *
 * @uses     wp_upload_dir()
 * @uses     image_resize_dimensions() | image_resize()
 * @uses     wp_get_image_editor()
 *
 * @return str|array
 */
function aq_resize( $url, $width, $height = null, $crop = null, $single = true ) {

    // Validate inputs.
    if ( ! $url or ! $width ) return false;

    // Define upload path & dir.
    $upload_info = wp_upload_dir();
    $upload_dir = $upload_info['basedir'];
    $upload_url = $upload_info['baseurl'];

    // Check if $img_url is local.
    if ( strpos( $url, $upload_url ) === false ) return false;

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

    // Use this to check if cropped image already exists, so we can return that instead.
    $suffix = "{$dst_w}x{$dst_h}";
    $dst_rel_path = str_replace( '.'.$ext, '', $rel_path );
    $destfilename = "{$upload_dir}{$dst_rel_path}-{$suffix}.{$ext}";

    if ( ! $dst_h ) {
        // Can't resize, so return original url.
        $img_url = $url;
        $dst_w = $orig_w;
        $dst_h = $orig_h;
    }
    // Else check if cache exists.
    elseif ( file_exists( $destfilename ) && getimagesize( $destfilename ) ) {
        $img_url = "{$upload_url}{$dst_rel_path}-{$suffix}.{$ext}";
    }
    // Else, we resize the image and return the new resized image url.
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
