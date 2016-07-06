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

/**
 * Get term meta fields
 *
 * Usage:
 * <?php echo odin_get_term_meta( $term_id, $field );?>
 *
 * @since  2.2.7
 *
 * @param  int    $term_id      Term ID
 * @param  string $field        Field slug
 *
 * @return string               Field value
 */
function odin_get_term_meta( $term_id, $field ) {
	// First try to get value in the new Term Meta WP API.
	if ( $value = get_term_meta( $term_id, $field, true ) ) {
		return $value;
	}

	// After, try to get in the old way (option API).
	$option_name = sprintf( 'odin_term_meta_%s_%s', $term_id, $field );
	$value       = get_option( $name );

	// Upgrade to new update_term_meta().
	if ( false !== $value ) {
		update_term_meta( $term_id, $field, $value );
		delete_option( $option_name );
	}

	return $value;
}

/**
 * Custom excerpt for content or title.
 *
 * Usage:
 * Place: <?php echo odin_excerpt( 'excerpt', value ); ?>
 *
 * @since  2.2.0
 *
 * @param  string $type  Sets excerpt or title.
 * @param  int    $limit Sets the length of excerpt.
 *
 * @return string       Return the excerpt.
 */
function odin_excerpt( $type = 'excerpt', $limit = 40 ) {
	$limit = (int) $limit;

	// Set excerpt type.
	switch ( $type ) {
		case 'title':
			$excerpt = get_the_title();
			break;

		default :
			$excerpt = get_the_excerpt();
			break;
	}

	return wp_trim_words( $excerpt, $limit );
}

/**
 * Related Posts.
 *
 * Usage:
 * To show related by categories:
 * Add in single.php <?php odin_related_posts(); ?>
 * To show related by tags:
 * Add in single.php <?php odin_related_posts( 'tag' ); ?>
 *
 * @since  2.2.0
 *
 * @global array $post         WP global post.
 *
 * @param  string $display      Set category or tag.
 * @param  int    $qty          Number of posts to be displayed (default 4).
 * @param  string $title        Set the widget title.
 * @param  bool   $thumb        Enable or disable displaying images (default true).
 * @param  string $post_type    Post type (default post).
 *
 * @return string              Related Posts.
 */
function odin_related_posts( $display = 'category', $qty = 4, $title = '', $thumb = true, $post_type = 'post' ) {
	global $post;

	$show = false;
	$post_qty = (int) $qty;
	! empty( $title ) || $title = __( 'Related Posts', 'odin' );

	// Creates arguments for WP_Query.
	switch ( $display ) {
		case 'tag':
			$tags = wp_get_post_tags( $post->ID );

			if ( $tags ) {
				// Enables the display.
				$show = true;

				$tag_ids = array();
				foreach ( $tags as $tag ) {
					$tag_ids[] = $tag->term_id;
				}

				$args = array(
					'tag__in' => $tag_ids,
					'post__not_in' => array( $post->ID ),
					'posts_per_page' => $post_qty,
					'post_type' => $post_type,
					'ignore_sticky_posts' => 1
				);
			}
			break;

		default :
			$categories = get_the_category( $post->ID );

			if ( $categories ) {

				// Enables the display.
				$show = true;

				$category_ids = array();
				foreach ( $categories as $category ) {
					$category_ids[] = $category->term_id;
				}

				$args = array(
					'category__in' => $category_ids,
					'post__not_in' => array( $post->ID ),
					'posts_per_page' => $post_qty,
					'post_type' => $post_type,
					'ignore_sticky_posts' => 1,
				);
			}
			break;
	}

	if ( $show ) {

		$related = new WP_Query( $args );
		if ( $related->have_posts() ) {

			$layout = '<div id="related-post">';
			$layout .= '<h3>' . esc_attr( $title ) . '</h3>';
			$layout .= ( $thumb ) ? '<div class="row">' : '<ul>';

			while ( $related->have_posts() ) {
				$related->the_post();

				$layout .= ( $thumb ) ? '<div class="col-md-' . ceil( 12 / $qty ) . '">' : '<li>';

				if ( $thumb ) {
					if ( has_post_thumbnail() ) {
						$img = get_the_post_thumbnail( get_the_ID(), 'thumbnail' );
					} else {
						$img = '<img src="' . get_template_directory_uri() . '/core/assets/images/odin-thumb-placeholder.jpg" alt="' . get_the_title() . '">';
					}
					// Filter to replace the image.
					$image = apply_filters( 'odin_related_posts_thumbnail', $img );

					$layout .= '<span class="thumb">';
					$layout .= sprintf( '<a href="%s" title="%s" class="thumbnail">%s</a>', esc_url( get_permalink() ), get_the_title(), $image );
					$layout .= '</span>';
				}

				$layout .= '<span class="text">';
				$layout .= sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', esc_url( get_permalink() ), get_the_title() );
				$layout .= '</span>';

				$layout .= ( $thumb ) ? '</div>' : '</li>';
			}

			$layout .= ( $thumb ) ? '</div>' : '</ul>';
			$layout .= '</div>';

			echo $layout;
		}
		wp_reset_postdata();
	}
}
