<?php
/**
 * Odin_Bootstrap_Nav_Walker class.
 *
 * A custom Wordpress nav walker to implement the Twitter Bootstrap 2 dropdown navigation using the Wordpress built in menu manager.
 * Inspired by the class twitter_bootstrap_nav_walker <https://github.com/twittem/wp-bootstrap-navwalker>,
 * created by Edward McIntyre and with the licence WTFPL 2.0 (http://sam.zoy.org/wtfpl/COPYING)
 *
 * @package  Odin
 * @category Bootstrap
 * @author   WPBrasil
 * @version  1.2.2
 */
class Odin_Bootstrap_Nav_Walker extends Walker_Nav_Menu {

    /**
     * Start level.
     *
     * @param string  $output Passed by reference. Used to append additional content.
     * @param int     $depth  Depth of page. Used for padding.
     *
     * @return void
     */
    function start_lvl( &$output, $depth ) {
        $indent = str_repeat( "\t", $depth );
        $output    .= "\n$indent<ul class=\"dropdown-menu\">\n";
    }

    /**
     * Start el.
     *
     * @param string  $output       Passed by reference. Used to append additional content.
     * @param object  $item         Menu item data object.
     * @param int     $depth        Depth of menu item. Used for padding.
     * @param int     $current_page Menu item ID.
     * @param object  $args
     *
     * @return void
     */
    function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if ( strcasecmp( $item->title, 'divider' ) ) {
            $class_names = $value = '';
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = ( $item->current ) ? 'active' : '';
            $classes[] = 'menu-item-' . $item->ID;
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

            if ( $args->has_children && $depth > 0 ) {
                $class_names .= ' dropdown-submenu';
            } else if ( $args->has_children && $depth === 0 ) {
                    $class_names .= ' dropdown';
                }

            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

            $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
            $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

            $output .= $indent . '<li' . $id . $value . $class_names .'>';

            $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
            $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
            $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
            $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
            $attributes .= ( $args->has_children )        ? ' data-toggle="dropdown" data-target="#" class="dropdown-toggle"' : '';

            $item_output = $args->before;
            $item_output .= '<a'. $attributes .'>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= ( $args->has_children && $depth == 0 ) ? ' <span class="caret"></span></a>' : '</a>';
            $item_output .= $args->after;

            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        } else {
            $output .= $indent . '<li class="divider">';
        }
    }

    /**
     * Traverse elements to create list from elements.
     *
     * Display one element if the element doesn't have any children otherwise,
     * display the element and its children. Will only traverse up to the max
     * depth and no ignore elements under that depth.
     *
     * This method shouldn't be called directly, use the walk() method instead.
     *
     * @param object  $element           Data object
     * @param array   $children_elements List of elements to continue traversing.
     * @param int     $max_depth         Max depth to traverse.
     * @param int     $depth             Depth of current element.
     * @param array   $args
     * @param string  $output            Passed by reference. Used to append additional content.
     *
     * @return null                      Null on failure with no changes to parameters.
     */
    function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

        if ( ! $element ) {
            return;
        }

        $id_field = $this->db_fields['id'];

        // Display this element.
        if ( is_array( $args[0] ) )
            $args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );
        else if ( is_object( $args[0] ) )
                $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
            $cb_args = array_merge( array( &$output, $element, $depth ), $args );
        call_user_func_array( array( &$this, 'start_el' ), $cb_args );

        $id = $element->$id_field;

        // Descend only when the depth is right and there are childrens for this element.
        if ( ( $max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id] ) ) {

            foreach ( $children_elements[ $id ] as $child ) {

                if ( ! isset( $newlevel ) ) {
                    $newlevel = true;
                    //start the child delimiter
                    $cb_args = array_merge( array( &$output, $depth ), $args );
                    call_user_func_array( array( &$this, 'start_lvl' ), $cb_args );
                }
                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
            }
            unset( $children_elements[ $id ] );
        }

        if ( isset( $newlevel ) && $newlevel ) {
            // End the child delimiter.
            $cb_args = array_merge( array( &$output, $depth ), $args );
            call_user_func_array( array( &$this, 'end_lvl' ), $cb_args );
        }

        // End this element.
        $cb_args = array_merge( array( &$output, $element, $depth ), $args );
        call_user_func_array( array( &$this, 'end_el' ), $cb_args );
    }
}
