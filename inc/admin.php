<?php
/**
 * Custom admin css.
 */
function odin_admin_css() {
    wp_register_style( 'dfw-admin-styles', get_template_directory_uri() . '/inc/css/custom-admin.css' );
    wp_enqueue_style( 'dfw-admin-styles' );
}

add_action( 'admin_enqueue_scripts', 'odin_admin_css' );

/**
 * Remove logo from admin bar.
 */
function odin_admin_adminbar_remove_logo() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wp-logo' );
}

add_action( 'wp_before_admin_bar_render', 'odin_admin_adminbar_remove_logo' );

/**
 * Custom Footer.
 */
function odin_admin_footer() {
    echo date( 'Y' ) . ' - ' . get_bloginfo( 'name' );
}

add_filter( 'admin_footer_text', 'odin_admin_footer' );

/**
 * Custom login logo.
 */
function odin_admin_login_logo() {
    echo '<link rel="stylesheet" href="' . get_stylesheet_directory_uri() . '/inc/css/custom-admin.css">';
}

add_action( 'login_head', 'odin_admin_login_logo' );

/**
 * Custom logo URL.
 */
function odin_admin_logo_url() {
    return home_url();
}

add_filter( 'login_headerurl', 'odin_admin_logo_url' );

/**
 * Custom logo title.
 */
function odin_admin_logo_title() {
    return get_bloginfo( 'name' );
}

add_filter( 'login_headertitle', 'odin_admin_logo_title' );

/**
 * Remove widgets dashboard.
 */
function odin_admin_remove_dashboard_widgets() {
    // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    // remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );

    // Yoast's SEO Plugin Widget
    remove_meta_box( 'yoast_db_widget', 'dashboard', 'normal' );
}

add_action( 'wp_dashboard_setup', 'odin_admin_remove_dashboard_widgets' );
