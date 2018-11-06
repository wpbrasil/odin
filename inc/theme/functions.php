<?php
/**
 * Theme Functions.
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
			$layout .= '<h3>' . esc_html( $title ) . '</h3>';
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
 * Breadcrumbs.
 *
 * @since  2.2.0
 *
 * @param  string $homepage  Homepage name.
 *
 * @return string            HTML of breadcrumbs.
 */
function odin_breadcrumbs( $homepage = '' ) {
	global $wp_query, $post, $author;

	! empty( $homepage ) || $homepage = __( 'Home', 'odin' );

	// Default html.
	$current_before = '<li class="active">';
	$current_after  = '</li>';

	if ( ! is_home() && ! is_front_page() || is_paged() ) {

		// First level.
		echo '<ol id="breadcrumbs" class="breadcrumb">';
		echo '<li><a href="' . home_url() . '" rel="nofollow">' . $homepage . '</a></li>';

		// Single post.
		if ( is_single() && ! is_attachment() ) {

			// Checks if is a custom post type.
			if ( 'post' != $post->post_type ) {
				// But if Woocommerce
				if ( 'product' === $post->post_type ) {
					if ( is_woocommerce_activated() ) {
						$shop_page    = get_post( wc_get_page_id( 'shop' ) );
						echo '<li><a href="' . esc_url( get_permalink( $shop_page ) ) . '">' . get_the_title( $shop_page ) . '</a></li>';
					}

					// Gets post type taxonomies.
					$taxonomies = get_object_taxonomies( 'product' );
					$taxonomy = 'product_cat';
				} else {
					$post_type = get_post_type_object( $post->post_type );

					echo '<li><a href="' . get_post_type_archive_link( $post_type->name ) . '">' . $post_type->label . '</a></li> ';

					// Gets post type taxonomies.
					$taxonomies = get_object_taxonomies( $post_type->name );
				}

				if ( $taxonomies ) {
					// If is woocommerce product post type, $taxonomy already defined
					if ( 'product' !== $post->post_type ) {
						$taxonomy = $taxonomies[0];
					}
					// Gets post terms.
					$terms = get_the_terms( $post->ID, $taxonomy );
					$term  = $terms ? array_shift( $terms ) : '';
					// Gets parent post terms.
					$parent_term = get_term( $term->parent, $taxonomy );

					if ( $term ) {
						if ( $term->parent ) {
							echo '<li><a href="' . get_term_link( $parent_term ) . '">' . $parent_term->name . '</a></li> ';
						}
						echo '<li><a href="' . get_term_link( $term ) . '">' . $term->name . '</a></li> ';
					}
				}
			} else {
				$category = get_the_category();
				$category = $category[0];
				// Gets parent post terms.
				$parent_cat = get_term( $category->parent, 'category' );
				// Gets top term
				$cat_tree = get_category_parents($category, FALSE, ':');
				$top_cat = explode(':', $cat_tree);
				$top_cat = $top_cat[0];

				if ( $category->parent ) {
					if ( $parent_cat->parent ) {
						echo '<li><a href="' . get_term_link( $top_cat, 'category' ) . '">' . $top_cat . '</a></li>';
					}
					echo '<li><a href="' . get_term_link( $parent_cat ) . '">' . $parent_cat->name. '</a></li>';
				}

				echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';
			}

			echo $current_before . get_the_title() . $current_after;

		// Single attachment.
		} elseif ( is_attachment() ) {
			$parent   = get_post( $post->post_parent );
			$category = get_the_category( $parent->ID );
			$category = $category[0];

			echo '<li><a href="' . get_category_link( $category->term_id ) . '">' . $category->name . '</a></li>';

			echo '<li><a href="' . esc_url( get_permalink( $parent ) ) . '">' . $parent->post_title . '</a></li>';

			echo $current_before . get_the_title() . $current_after;

		// Page without parents.
		} elseif ( is_page() && ! $post->post_parent ) {
			echo $current_before . get_the_title() . $current_after;

		// Page with parents.
		} elseif ( is_page() && $post->post_parent ) {
			$parent_id   = $post->post_parent;
			$breadcrumbs = array();

			while ( $parent_id ) {
				$page = get_page( $parent_id );

				$breadcrumbs[] = '<li><a href="' . esc_url( get_permalink( $page->ID ) ) . '">' . get_the_title( $page->ID ) . '</a></li>';
				$parent_id  = $page->post_parent;
			}

			$breadcrumbs = array_reverse( $breadcrumbs );

			foreach ( $breadcrumbs as $crumb ) {
				echo $crumb . ' ';
			}

			echo $current_before . get_the_title() . $current_after;

		// Category archive.
		} elseif ( is_category() ) {
			$category_object  = $wp_query->get_queried_object();
			$category_id      = $category_object->term_id;
			$current_category = get_category( $category_id );
			$parent_category  = get_category( $current_category->parent );

			// Displays parent category.
			if ( 0 != $current_category->parent ) {
				$parents = get_category_parents( $parent_category, TRUE, false );
				$parents = str_replace( '<a', '<li><a', $parents );
				$parents = str_replace( '</a>', '</a></li>', $parents );
				echo $parents;
			}

			printf( __( '%sCategory: %s%s', 'odin' ), $current_before, single_cat_title( '', false ), $current_after );

		// Tags archive.
		} elseif ( is_tag() ) {
			printf( __( '%sTag: %s%s', 'odin' ), $current_before, single_tag_title( '', false ), $current_after );

		// Custom post type archive.
		} elseif ( is_post_type_archive() ) {
			// Check if Woocommerce Shop
			if ( is_woocommerce_activated() && is_shop() ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				echo $current_before . get_the_title( $shop_page_id ) . $current_after;

			} else {
				echo $current_before . post_type_archive_title( '', false ) . $current_after;
			}

		// Search page.
		} elseif ( is_search() ) {
			printf( __( '%sSearch result for: &quot;%s&quot;%s', 'odin' ), $current_before, get_search_query(), $current_after );

		// Author archive.
		} elseif ( is_author() ) {
			$userdata = get_userdata( $author );

			echo $current_before . __( 'Posted by', 'odin' ) . ' ' . $userdata->display_name . $current_after;

		// Archives per days.
		} elseif ( is_day() ) {
			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';

			echo '<li><a href="' . get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . '">' . get_the_time( 'F' ) . '</a></li>';

			echo $current_before . get_the_time( 'd' ) . $current_after;

		// Archives per month.
		} elseif ( is_month() ) {
			echo '<li><a href="' . get_year_link( get_the_time( 'Y' ) ) . '">' . get_the_time( 'Y' ) . '</a></li>';

			echo $current_before . get_the_time( 'F' ) . $current_after;

		// Archives per year.
		} elseif ( is_year() ) {
			echo $current_before . get_the_time( 'Y' ) . $current_after;

		// Archive fallback for custom taxonomies.
		} elseif ( is_archive() ) {
			$current_object = $wp_query->get_queried_object();
			$taxonomy       = get_taxonomy( $current_object->taxonomy );
			$term_name      = $current_object->name;

			// Displays the post type that the taxonomy belongs.
			if ( ! empty( $taxonomy->object_type ) ) {
				// Get correct Woocommerce Post Type crumb
				if ( is_woocommerce() ) {
					$shop_page    = get_post( wc_get_page_id( 'shop' ) );
					echo '<li><a href="' . esc_url( get_permalink( $shop_page ) ) . '">' . get_the_title( $shop_page ) . '</a></li>';
				} else {
					$_post_type = array_shift( $taxonomy->object_type );
					$post_type = get_post_type_object( $_post_type );
					echo '<li><a href="' . get_post_type_archive_link( $post_type->name ) . '">' . $post_type->label . '</a></li> ';
				}
			}

			// Displays parent term.
			if ( 0 != $current_object->parent ) {
				$parent_term = get_term( $current_object->parent, $current_object->taxonomy );

				echo '<li><a href="' . get_term_link( $parent_term ) . '">' . $parent_term->name . '</a></li>';
			}

			echo $current_before . $taxonomy->label . ': ' . $term_name . $current_after;

		// 404 page.
		} elseif ( is_404() ) {
			echo $current_before . __( '404 Error', 'odin' ) . $current_after;
		}

		// Gets pagination.
		if ( get_query_var( 'paged' ) ) {
			echo ' (' . sprintf( __( 'Page %s', 'odin' ), get_query_var( 'paged' ) ) . ')';
		}

		echo '</ol>';
	}
}

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
 * @param  string  $alt     Alt attribute of the image. If left empty the attribute of the image is used.
 * @param  boolean $crop    Image crop.
 * @param  string  $class   Custom HTML classes.
 * @param  boolean $upscale Force the resize.
 *
 * @return string         Return the post thumbnail.
 */
function odin_thumbnail( $width, $height, $alt = '', $crop = true, $class = '', $upscale = false ) {
	if ( ! class_exists( 'Odin_Thumbnail_Resizer' ) ) {
		return;
	}

	$thumb = get_post_thumbnail_id();

	if ( $thumb ) {
		$image = odin_get_image_url( $thumb, $width, $height, $crop, $upscale );
		! empty( $alt ) || $alt = get_post_meta($thumb, '_wp_attachment_image_alt', true);
		$html  = '<img class="wp-image-thumb img-responsive ' . esc_attr( $class ) . '" src="' . esc_url( $image ) . '" width="' . esc_attr( $width ) . '" height="' . esc_attr( $height ) . '" alt="' . esc_attr( $alt ) . '" />';

		return apply_filters( 'odin_thumbnail_html', $html );
	}
}

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

/**
 * Debug variables.
 *
 * @since  2.2.0
 *
 * @param  mixed $variable Object or Array for debug.
 *
 * @return string          Human-readable information.
 */
function odin_debug( $variable ) {
	echo '<pre>' . print_r( $variable, true ) . '</pre>';
	exit;
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
	$value       = get_option( $option_name );

	// Upgrade to new update_term_meta().
	if ( false !== $value ) {
		update_term_meta( $term_id, $field, $value );
		delete_option( $option_name );
	}

	return $value;
}
