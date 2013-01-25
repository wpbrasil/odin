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
    
    // Prevent show pagination number is Infinite Scroll of JetPack is active
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
