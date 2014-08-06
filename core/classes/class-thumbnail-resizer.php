<?php
/**
 * Odin_Thumbnail_Resizer class.
 *
 * Resizer thumbnails.
 * Inspired by the class Aq_Resize <https://github.com/sy4mil/Aqua-Resizer/>,
 * created by Syamil MJ and with the licence WTFPL.
 *
 * @package  Odin
 * @category Thumbnail_Resizer
 * @author   WPBrasil
 * @version  2.1.5
 */
class Odin_Thumbnail_Resizer {

	/**
	 * The singleton instance.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Image properties
	 */
	protected static $image_url = null;
	protected static $width = null;
	protected static $height = null;

	/**
	 * No initialization allowed.
	 */
	private function __construct() {}

	/**
	 * No cloning allowed.
	 */
	private function __clone() {}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Gets the upload path (directory and url).
	 *
	 * @param  string $url Image URL.
	 *
	 * @return array       Upload directory and URL.
	 */
	protected static function get_upload_path( $url ) {
		$upload_info  = wp_upload_dir();
		$upload_dir   = $upload_info['basedir'];
		$upload_url   = $upload_info['baseurl'];
		$http_prefix  = 'http://';
		$https_prefix = 'https://';

		// If the $url scheme differs from $upload_url scheme, make them match,
		// If the schemes differe, images don't show up.
		if ( ! strncmp( $url, $https_prefix, strlen( $https_prefix ) ) ) {
			// If url begins with https:// make $upload_url begin with https:// as well.
			$upload_url = str_replace( $http_prefix, $https_prefix, $upload_url );
		} elseif ( ! strncmp( $url, $http_prefix, strlen( $http_prefix ) ) ) {
			// If url begins with http:// make $upload_url begin with http:// as well.
			$upload_url = str_replace( $https_prefix, $http_prefix, $upload_url );
		}

		return array(
			'upload_dir' => $upload_dir,
			'upload_url' => $upload_url
		);
	}

	/**
	 * Process the thumbnail.
	 *
	 * @param  string  $url     Image URL (must be uploaded using wp media uploader).
	 * @param  int     $width   Thumbnail width.
	 * @param  int     $height  Thumbnail height.
	 * @param  boolean $crop    Soft (false) or hard (true) crop.
	 * @param  boolean $upscale Force the resize.
	 *
	 * @return string           New thumbnail.
	 */
	public function process( $url, $width = null, $height = null, $crop = false, $upscale = false ) {
		// Validate inputs.
		if ( ! $url || ( ! $width && ! $height ) ) {
			return false;
		}

		// Caipt'n, ready to hook.
		if ( true === $upscale ) {
			add_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ), 10, 6 );
		}

		// Define upload path, directory and http prefix.
		$generate_paths = self::get_upload_path( $url );
		$upload_dir     = $generate_paths['upload_dir'];
		$upload_url     = $generate_paths['upload_url'];

		// Check if $image_url is local.
		if ( false === strpos( $url, $upload_url ) ) {
			return false;
		}

		// Define path of image.
		$rel_path = str_replace( $upload_url, '', $url );
		$image_path = $upload_dir . $rel_path;

		// Check if img path exists, and is an image indeed.
		if ( ! file_exists( $image_path ) || ! getimagesize( $image_path ) ) {
			return false;
		}

		// Get image info.
		$info = pathinfo( $image_path );
		$ext = $info['extension'];
		list( $original_width, $original_height ) = getimagesize( $image_path );

		// Get image size after cropping.
		$dimensions = image_resize_dimensions( $original_width, $original_height, $width, $height, $crop );
		$original_width = $dimensions[4];
		$original_height = $dimensions[5];

		// Return the original image only if it exactly fits the needed measures.
		if ( ! $dimensions && ( ( ( null === $height && $original_width == $width ) xor ( null === $width && $original_height == $height ) ) xor ( $height == $original_height && $width == $original_width ) ) ) {
			$image_url = $url;
		} else {
			// Use this to check if cropped image already exists, so we can return that instead.
			$suffix = $original_width . 'x' . $original_height;
			$original_rel_path = str_replace( '.' . $ext, '', $rel_path );
			$destfilename = $upload_dir . $original_rel_path . '-' . $suffix . '.' . $ext;

			// Can't resize, so return false saying that the action to do could not be processed as planned.
			if ( ! $dimensions || ( true == $crop && false == $upscale && ( $original_width < $width || $original_height < $height ) ) ) {
				return false;

			// Else check if cache exists.
			} elseif ( file_exists( $destfilename ) && @getimagesize( $destfilename ) ) {
				$image_url = $upload_url . $original_rel_path . '-' . $suffix . '.' . $ext;

			// Else, we resize the image and return the new resized image url.
			} else {
				$editor = wp_get_image_editor( $image_path );
				if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) ) {
					return false;
				}

				$resized_file = $editor->save();

				if ( ! is_wp_error( $resized_file ) ) {
					$resized_rel_path = str_replace( $upload_dir, '', $resized_file['path'] );
					$image_url = $upload_url . $resized_rel_path;
				} else {
					return false;
				}

			}
		}

		self::$image_url = $image_url;
		self::$width = $original_width;
		self::$height = $original_height;

		// Okay, leave the ship.
		if ( true === $upscale ) {
			remove_filter( 'image_resize_dimensions', array( $this, 'aq_upscale' ) );
		}

		return $image_url;
	}

	/**
	 * Callback to overwrite WP computing of thumbnail measures
	 */
	public function aq_upscale( $default, $original_width, $original_height, $new_width, $new_height, $crop ) {
		// Let the wordpress default function handle this.
		if ( ! $crop ) {
			return null;
		}

		// Here is the point we allow to use larger image size than the original one.
		$aspect_ratio = $original_width / $original_height;

		if ( ! $new_width ) {
			$new_width = intval( $new_height * $aspect_ratio );
		}

		if ( ! $new_height ) {
			$new_height = intval( $new_width / $aspect_ratio );
		}

		$size_ratio = max( $new_width / $original_width, $new_height / $original_height );

		$crop_width = round( $new_width / $size_ratio );
		$crop_height = round( $new_height / $size_ratio );

		$s_x = floor( ( $original_width - $crop_width ) / 2 );
		$s_y = floor( ( $original_height - $crop_height ) / 2 );

		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_width, (int) $new_height, (int) $crop_width, (int) $crop_height );
	}

	/**
	 * Return array with image url, width and height
	 */
    public function get_image_url_with_dimensions() {
        return array( self::$image_url, self::$width, self::$height );
    }
}
