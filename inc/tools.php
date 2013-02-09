<?php

/**
 * Pagination.
 *
 * @global array $wp_query Global wordpress query tag.
 *
 * @param int $mid         Total of items that will show along with the current page.
 * @param int $end         Total of items displayed for the last few pages.
 * @param bool $show       Show all items.
 *
 * @return string          Return the pagination.
 */
function odin_pagination( $mid = 2, $end = 1, $show = false ) {

    // Prevent show pagination number if Infinite Scroll of JetPack is active
    if ( !isset( $_GET[ 'infinity' ] ) == 0) {

        global $wp_query;
        $total_pages = $wp_query->max_num_pages;

        if ( $total_pages > 1 ) {
            $current_page = max( 1, get_query_var( 'paged' ) );

            $pagination = '<div class="page-nav">';
            $pagination .= paginate_links( array(
                'base' => get_pagenum_link(1) . '%_%',
                'format' => '/page/%#%',
                'current' => $current_page,
                'total' => $total_pages,
                'show_all' => $show,
                'end_size' => $end,
                'mid_size' => $mid,
                'prev_text' => __( '&laquo; Anterior', 'odin' ),
                'next_text' => __( 'Pr&oacute;ximo &raquo;', 'odin' ),
                    ));
            $pagination .= '</div>';

            // Prevents duplicate bars in the middle of the url.
            $html = str_replace( '//page/', '/page/', $pagination );

            return $html;
        }
    }
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
 * @global array $post         WP global post.
 *
 * @param string $display      Set category or tag.
 * @param int    $qty          Number of posts to be displayed (default 5).
 * @param string $title        Set the widget title.
 * @param bool   $thumb        Enable or disable displaying images.
 *
 * @return string              Related Posts.
 */
function odin_related_posts( $display = 'category', $qty = 5, $title = 'Artigos Relacionados', $thumb = true ) {
    global $post;

    $show = false;
    $post_qty = (int) $qty;

    // Creates arguments for WP_Query.
    switch ( $display ) {
        case 'tag':
            $tags = wp_get_post_tags( $post->ID );

            if ( $tags ) {
                // Enables the display.
                $show = true;

                $tag_ids = array();
                foreach ( $tags as $individual_tag ) {
                    $tag_ids[] = $individual_tag->term_id;
                }

                $args = array(
                    'tag__in' => $tag_ids,
                    'post__not_in' => array( $post->ID ),
                    'posts_per_page' => $post_qty,
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
                foreach ( $categories as $individual_category ) {
                    $category_ids[] = $individual_category->term_id;
                }

                $args = array(
                    'category__in' => $category_ids,
                    'post__not_in' => array( $post->ID ),
                    'showposts' => $post_qty,
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
            $layout .= '<ul>';

            while ( $related->have_posts() ) {
                $related->the_post();

                $layout .= '<li>';

                if ( $thumb ) {
                    // Filter for use the functions of thumbnails.php in place of the_post_thumbnails().
                    $image = apply_filters( 'odin_related_posts', get_the_post_thumbnail( get_the_ID(), 'thumbnail' ) );

                    $layout .= '<span class="thumb">';
                    $layout .= sprintf( '<a href="%s" title="%s">%s</a>', get_permalink(), get_the_title(), $image );
                    $layout .= '</span>';
                }

                $layout .= '<span class="text">';
                $layout .= sprintf( '<a href="%1$s" title="%2$s">%2$s</a>', get_permalink(), get_the_title() );
                $layout .= '</span>';

                $layout .= '</li>';
            }

            $layout .= '</ul>';
            $layout .= '</div>';

            echo $layout;
        }
        wp_reset_postdata();
    }
}

