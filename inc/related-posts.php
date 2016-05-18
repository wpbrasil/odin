<?php
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
					$layout .= sprintf( '<a href="%s" title="%s" class="thumbnail">%s</a>', get_permalink(), get_the_title(), $image );
					$layout .= '</span>';
				}

				$layout .= '<span class="text">';
				$layout .= sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', get_permalink(), get_the_title() );
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
