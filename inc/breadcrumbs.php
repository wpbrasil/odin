<?php
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
