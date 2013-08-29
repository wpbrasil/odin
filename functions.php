<?php
/**
 * Odin functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Odin
 * @since 1.9.0
 */

/**
 * Grunt Support.
 */
define( 'ODIN_GRUNT_SUPPORT', false );

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) )
    $content_width = 600;

/**
 * Setup theme features
 */
function odin_setup_features() {

    /**
     * Register nav menus.
     */
    register_nav_menus(
        array(
            'main-menu' => __( 'Main Menu', 'odin' )
        )
    );

    /**
     * Support Custom Header.
     */
    $default = array(
        'width'         => 0,
        'height'        => 0,
        'flex-height'   => false,
        'flex-width'    => false,
        'header-text'   => false,
        'default-image' => '',
        'uploads'       => true,
    );

    add_theme_support( 'custom-header', $default );

    /**
     * Support Custom Background.
     */
    $defaults = array(
        'default-color' => '',
        'default-image' => '',
    );

    add_theme_support( 'custom-background', $defaults );

    /**
     * Support Custom Editor Style.
     */
    add_editor_style( 'assets/css/editor-style.css' );

    /**
     * Add support for multiple languages.
     */
    load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

    /**
     * Add support for infinite scroll.
     */
    add_theme_support( 'infinite-scroll', array(
        'type'           => 'scroll',
        'footer_widgets' => false,
        'container'      => 'content',
        'wrapper'        => false,
        'render'         => false,
        'posts_per_page' => get_option( 'posts_per_page' )
    ) );

    /**
     * Add support for Post Formats.
     */
    // add_theme_support( 'post-formats', array(
    //     'aside',
    //     'gallery',
    //     'link',
    //     'image',
    //     'quote',
    //     'status',
    //     'video',
    //     'audio',
    //     'chat'
    // ) );

    /**
     * Support The Excerpt on pages.
     */
    // add_post_type_support( 'page', 'excerpt' );
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register sidebars.
 */
function odin_widgets_init() {
    register_sidebar(
        array(
            'name' => __( 'Main Sidebar', 'odin' ),
            'id' => 'main-sidebar',
            'description' => __( 'Site Main Sidebar', 'odin' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widgettitle widget-title">',
            'after_title' => '</h3>',
        )
    );
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 */
function odin_flush_rewrite() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * Theme tools
 */
require_once get_template_directory() . '/core/tools.php';

/**
 * Add Custom post_thumbnails tools.
 */
require_once get_template_directory() . '/core/thumbnails.php';

/**
 * Automatically sets the post thumbnail.
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

// add_action( 'the_post', 'odin_autoset_featured' );
// add_action( 'save_post', 'odin_autoset_featured' );
// add_action( 'draft_to_publish', 'odin_autoset_featured' );
// add_action( 'new_to_publish', 'odin_autoset_featured' );
// add_action( 'pending_to_publish', 'odin_autoset_featured' );
// add_action( 'future_to_publish', 'odin_autoset_featured' );

/**
 * Custom Related Posts Image.
 *
 * Use this filter for use aq_resize() in place of the_post_thumbnails().
 *
 * @param  string $thumbnail the_post_thumbnail().
 *
 * @return string            Custom thumbnails.
 */
function odin_related_posts_custom_thumbnails( $thumbnail ) {
    // Edit these variables:
    $width  = 100;
    $height = 100;
    $crop   = true;

    if ( get_post_thumbnail_id() ) {
        $url = wp_get_attachment_url( get_post_thumbnail_id(), 'full' );
        $image = aq_resize( $url, $width, $height, $crop );

        $html = '<img class="wp-image-thumb" src="' . $image . '" width="' . $width . '" height="' . $height . '" alt="' . get_the_title() . '" />';

        return apply_filters( 'odin_thumbnail_html', $html );
    }
}

// add_filter( 'odin_related_posts', 'odin_related_posts_custom_thumbnails' );

/**
 * WooCommerce and Jigoshop theme support.
 */
function odin_woocommerce_jigoshop_content_wrapper() {
    echo '<div id="primary" class="col-md-8">';
}

function odin_woocommerce_jigoshop_content_wrapper_end() {
    echo '</div>';
}

/**
 * WooCommerce.
 */
// add_theme_support( 'woocommerce' );
// add_action( 'woocommerce_before_main_content', 'odin_woocommerce_jigoshop_content_wrapper', 10 );
// add_action( 'woocommerce_after_main_content', 'odin_woocommerce_jigoshop_content_wrapper_end', 10 );

/**
 * Jigoshop.
 */
// add_action( 'jigoshop_before_main_content', 'odin_jigoshop_output_content_wrapper', 10 );
// add_action( 'jigoshop_after_main_content', 'odin_jigoshop_output_content_wrapper_end', 10 );

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Odin LazyLoad support.
 */
// add_filter( 'odin_thumbnail_html', 'odin_lazyload_placeholder' );

/**
 * Theme Options Class.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';

/**
 * Load site scripts.
 */
function odin_enqueue_scripts() {
    $template_url = get_template_directory_uri();

    wp_enqueue_script( 'jquery');

    // bxSlider.
    // wp_enqueue_script( 'bxslider', $template_url . '/js/jquery.bxslider.min.js', array(), null, true );

    // General scripts.
    if ( false == ODIN_GRUNT_SUPPORT ) {

        // FitVids.
        wp_enqueue_script( 'fitvids', $template_url . '/assets/js/jquery.fitvids.min.js', array(), null, true );

        // Main jQuery.
        wp_enqueue_script( 'odin-main', $template_url . '/assets/js/main.js', array(), null, true );
    } else {
        wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js', array(), null, true );
    }

    // Twitter Bootstrap.
    wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/bootstrap.min.js', array(), null, true );

    // Load Thread comments WordPress script.
    if ( is_singular() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    if ( is_single() )
        wp_enqueue_script( 'validate', $template_url . '/assets/js/jquery.validate.min.js', array(), null, true );
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );
