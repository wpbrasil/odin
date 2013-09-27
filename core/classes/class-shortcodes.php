<?php
/**
 * Odin_Shortcodes class.
 *
 * Built Shortcodes.
 *
 * @package  Odin
 * @category Shortcodes
 * @author   WPBrasil
 * @version  2.1.0
 */
class Odin_Shortcodes {

    /**
     * Construct Post Type.
     */
    public function __construct() {
        add_shortcode( 'button', array( $this, 'button' ) );
        add_shortcode( 'button_group', array( $this, 'button_group' ) );
        add_shortcode( 'alert', array( $this, 'alert' ) );
        add_shortcode( 'label', array( $this, 'label' ) );
        add_shortcode( 'badge', array( $this, 'badge' ) );
        add_shortcode( 'icon', array( $this, 'icon' ) );
        add_shortcode( 'well', array( $this, 'well' ) );
        add_shortcode( 'table', array( $this, 'table' ) );
        add_shortcode( 'row', array( $this, 'row' ) );
        add_shortcode( 'col', array( $this, 'col' ) );
        add_shortcode( 'progress', array( $this, 'progress' ) );
        add_shortcode( 'panel', array( $this, 'panel' ) );
        add_shortcode( 'panel_heading', array( $this, 'panel_heading' ) );
        add_shortcode( 'panel_body', array( $this, 'panel_body' ) );
        add_shortcode( 'panel_footer', array( $this, 'panel_footer' ) );
        add_shortcode( 'tabs', array( $this, 'tabs' ) );
        add_shortcode( 'tab', array( $this, 'tab' ) );
        add_shortcode( 'tab_dropdown', array( $this, 'tab_dropdown' ) );
        add_shortcode( 'tab_contents', array( $this, 'tab_contents' ) );
        add_shortcode( 'tab_content', array( $this, 'tab_content' ) );
        add_shortcode( 'tooltip', array( $this, 'tooltip' ) );
        add_shortcode( 'clear', array( $this, 'clear' ) );
    }

    /**
     * Button shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Button HTML.
     */
    function button( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'      => 'default',
            'size'      => false,
            'link'      => '#',
            'class'     => false,
            'tooltip'   => false,
            'direction' => 'top'
        ), $atts ) );

        $html = '<a href="' . $link . '" class="btn';
        $html .= ( $type ) ? ' btn-' . $type : '';
        $html .= ( $size ) ? ' btn-' . $size : '';
        $html .= ( $class ) ? ' ' . $class : '';
        $html .= ( $tooltip ) ? ' odin-tooltip' : '';
        $html .= '"';
        $html .= ( $tooltip ) ? ' data-placement="' . $direction . '" data-toggle="tooltip" data-original-title="' . $tooltip . '"' : '';
        $html .= '>';
        $html .= do_shortcode( $content );
        $html .= '</a>';

        return $html;
    }

    /**
     * Button Group shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Button Group HTML.
     */
    function button_group( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'  => 'group',
            'size'  => false,
            'justified' => false
        ), $atts ) );

        $html = '<div class="btn-' . $type . '';
        $html .= ( $size ) ? ' btn-group-' . $size : '';
        $html .= ( $justified ) ? ' btn-group-justified' : '';
        $html .= '">';
        $html .= str_replace( '<br />', '', do_shortcode( $content ) );
        $html .= '</div>';

        return $html;
    }

    /**
     * Alert shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Alert HTML.
     */
    function alert( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'  => 'info',
            'close' => false
        ), $atts ) );

        $html = '<div class="alert alert-' . $type;
        $html .= ( $close ) ? ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' : '">';
        $html .= do_shortcode( $content );
        $html .= '</div>';

        return $html;
    }

    /**
     * Label shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Label HTML.
     */
    function label( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type' => 'default'
        ), $atts ) );

        return '<span class="label label-' . $type . '">' . do_shortcode( $content ) . '</span>';
    }

    /**
     * Badge shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Badge HTML.
     */
    function badge( $atts, $content = null ) {
        return '<span class="badge">' . do_shortcode( $content ) . '</span>';
    }

    /**
     * Icon shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     *
     * @return string          Icon HTML.
     */
    function icon( $atts ) {
        extract( shortcode_atts( array(
            'type' => 'thumbs-up'
        ), $atts ) );

        return '<span class="glyphicon glyphicon-' . $type . '"></span>';
    }

    /**
     * Well shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Well HTML.
     */
    function well( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'size' => false
        ), $atts ) );

        $html = '<div class="well';
        $html .= ( $size ) ? ' well-' . $size . '">' : '">';
        $html .= do_shortcode( $content );
        $html .= '</div>';

        return $html;
    }

    /**
     * Table shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Table HTML.
     */
    function table( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'   => false,
            'border' => false,
            'cols'   => '',
            'rows'   => ''
        ), $atts ) );

        $html = '<table class="table';
        $html .= ( $type ) ? ' table-' . $type : '';
        $html .= ( $border ) ? ' table-bordered">' . PHP_EOL : '">' . PHP_EOL;
        $html .= '<thead>' . PHP_EOL;
        $html .= '<tr>' . PHP_EOL;

        foreach ( explode( ',', $cols ) as $col )
            $html .= '<th>' . $col . '</th>' . PHP_EOL;

        $html .= '</tr>' . PHP_EOL;
        $html .= '</thead>' . PHP_EOL;
        $html .= '<tbody>' . PHP_EOL;

        foreach ( explode( '|', $rows ) as $row ) {
            $html .= '<tr>' . PHP_EOL;

            foreach ( explode( ',', $row ) as $item )
                $html .= '<td>' . $item . '</td>' . PHP_EOL;

            $html .= '</tr>' . PHP_EOL;
        }

        $html .= '</tbody>' . PHP_EOL;
        $html .= '</table>' . PHP_EOL;

        return $html;
    }

    /**
     * Row shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Row HTML.
     */
    function row( $atts, $content = null ) {
        return '<div class="row">' . str_replace( 'div><br />', 'div>', do_shortcode( $content ) ) . '</div>';
    }

    /**
     * Col shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Col HTML.
     */
    function col( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'class' => false
        ), $atts ) );

        $html = '<div';
        $html .= ( $class ) ? ' class="' . $class . '"' : '';
        $html .= '>';
        $html .= do_shortcode( $content );
        $html .= '</div>';

        return $html;
    }

    /**
     * Progress shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Progress HTML.
     */
    function progress( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'  => false,
            'class' => false,
            'value' => 50,
            'max'   => 100,
            'min'   => 0
        ), $atts ) );

        $html = '<div class="progress';
        $html .= ( $class ) ? ' ' . $class . '">' : '">';
        $html .= '<div class="progress-bar';
        $html .= ( $type ) ? ' progress-bar-' . $type . '" ' : '" ';
        $html .= 'role="progressbar" ';
        $html .= 'aria-valuenow="' . $value . '" ';
        $html .= 'aria-valuemin="' . $min . '" ';
        $html .= 'aria-valuemax="' . $max . '" ';
        $html .= 'style="width: ' . $value . '%">';
        $html .= ( $content ) ? '<span class="sr-only">' . $content . '</span>' : '';
        $html .= '</div>';
        $html .= '</div>';

        return $html;
    }

    /**
     * Panel shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Panel HTML.
     */
    function panel( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'type'  => 'default'
        ), $atts ) );

        return '<div class="panel panel-' . $type . '">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</div>';
    }

    /**
     * Panel Heading shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Panel Heading HTML.
     */
    function panel_heading( $atts, $content = null ) {
        return '<div class="panel-heading">' . do_shortcode( $content ) . '</div>';
    }

    /**
     * Panel Body shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Panel Body HTML.
     */
    function panel_body( $atts, $content = null ) {
        return '<div class="panel-body">' . do_shortcode( $content ) . '</div>';
    }

    /**
     * Panel Footer shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Panel Footer HTML.
     */
    function panel_footer( $atts, $content = null ) {
        return '<div class="panel-footer">' . do_shortcode( $content ) . '</div>';
    }

    /**
     * Tabs shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tabs HTML.
     */
    function tabs( $atts, $content = null ) {
        return '<ul class="nav nav-tabs odin-tabs">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</ul>';
    }

    /**
     * Tab shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tab HTML.
     */
    function tab( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'id'     => '',
            'active' => false
        ), $atts ) );

        $html = '<li';
        $html .= ( $active ) ? ' class="active"' : '';
        $html .= '>';
        $html .= '<a href="#' . $id . '">';
        $html .= do_shortcode( $content );
        $html .= '</a>';
        $html .= '</li>';

        return $html;
    }

    /**
     * Tab Dropdown shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tab Dropdown HTML.
     */
    function tab_dropdown( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'title' => '',
        ), $atts ) );

        $id = sanitize_title( $title );

        $html = '<li class="dropdown">';
        $html .= '<a href="#" id="' . $id . '" class="dropdown-toggle" data-toggle="dropdown">';
        $html .= $title;
        $html .= ' <b class="caret"></b>';
        $html .= '</a>';
        $html .= '<ul class="dropdown-menu" role="menu" aria-labelledby="' . $id . '">';
        $html .= do_shortcode( $content );
        $html .= '</ul>';
        $html .= '</li>';

        return $html;
    }

    /**
     * Tabs Contents shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tabs Contents HTML.
     */
    function tab_contents( $atts, $content = null ) {
        return '<div class="tab-content">' . str_replace( '<br />', '', do_shortcode( $content ) ) . '</div>';
    }

    /**
     * Tabs Content shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tabs Content HTML.
     */
    function tab_content( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'id' => '',
            'active' => false,
        ), $atts ) );

        $html = '<div class="tab-pane';
        $html .= ( $active ) ? ' active"' : '"';
        $html .= ' id="' . $id . '">';
        $html .= do_shortcode( $content );
        $html .= '</div>';

        return $html;
    }

    /**
     * Tooltip shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Tooltip HTML.
     */
    function tooltip( $atts, $content = null ) {
        extract( shortcode_atts( array(
            'title'     => '',
            'link'      => '#',
            'direction' => 'top'
        ), $atts ) );

        $html = '<a class="odin-tooltip" data-original-title="' . $title . '" href="' . $link .'" data-placement="' . $direction . '" data-toggle="tooltip">';
        $html .= do_shortcode( $content );
        $html .= '</a>';
        return $html;
    }

    /**
     * Clear Float shortcode.
     *
     * @param  array  $atts    Shortcode attributes.
     * @param  string $content Content.
     *
     * @return string          Clear Float HTML.
     */
    function clear( $atts ) {
        return '<br class="clear" />';
    }

}

new Odin_Shortcodes;
