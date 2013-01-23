<?php
/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 600;
}

/**
 * Setup theme features
 */
function odin_setup_features() {

    $template_dir = get_template_directory();

    /**
     * Register nav menus.
     */
    register_nav_menus(
        array(
            'main-menu' => __( 'Menu Principal', 'odin' )
        )
    );

    /**
     * Add support for multiple languages
     */
    load_theme_textdomain( 'odin', $template_dir . '/languages' );
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register sidebars.
 */
function odin_widgets_init() {
    register_sidebar(
        array(
            'name' => __( 'Sidebar Principal', 'odin' ),
            'id' => 'mao=in-sidebar',
            'description' => __( 'Sidebar Principal do site', 'odin' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widget-title">',
            'after_title' => '</h3>',
        )
    );
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Load site scripts.
 */
function odin_enqueue_scripts() {
    $template_url = get_template_directory_uri();

    wp_enqueue_script( 'jquery');
    wp_register_script( 'odin-main', $template_url . '/js/main.js', array(), null, true );
    wp_enqueue_script( 'odin-main' );

    // Load Thread comments WordPress script.
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts' );

/**
 * Theme tools
 */
require_once get_template_directory() . '/inc/tools.php';
