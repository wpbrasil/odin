<?php
/**
 * Automatically sets the post thumbnail.
 *
 * Use:
 * add_action( 'the_post', 'odin_autoset_featured' );
 * add_action( 'save_post', 'odin_autoset_featured' );
 * add_action( 'draft_to_publish', 'odin_autoset_featured' );
 * add_action( 'new_to_publish', 'odin_autoset_featured' );
 * add_action( 'pending_to_publish', 'odin_autoset_featured' );
 * add_action( 'future_to_publish', 'odin_autoset_featured' );
 *
 * @since  2.2.0
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
