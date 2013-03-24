<?php
/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 600;
}

/**
 * WooCommerce Support
 */
add_theme_support( 'woocommerce' );

/**
 * Setup theme features
 */
function odin_setup_features() {

    /**
     * Register nav menus.
     */
    register_nav_menus(
        array(
            'main-menu' => __( 'Menu Principal', 'odin' )
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
    add_editor_style( 'custom-editor-style.css' );

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
            'name' => __( 'Sidebar Principal', 'odin' ),
            'id' => 'mao=in-sidebar',
            'description' => __( 'Sidebar Principal do site', 'odin' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widgettitle widget-title">',
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

    // bxSlider.
    // wp_register_script( 'bxslider', $template_url . '/js/jquery.bxslider.min.js', array(), null, true );
    // wp_enqueue_script( 'bxslider' );

    // General scripts.
    wp_register_script( 'odin-main', $template_url . '/js/main.js', array(), null, true );
    wp_enqueue_script( 'odin-main' );

    // Load Thread comments WordPress script.
    if ( is_singular() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( is_single() ) {
        wp_register_script( 'validate', $template_url . '/js/jquery.validate.min.js', array(), null, true );
        wp_enqueue_script( 'validate' );
    }
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts' );

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
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Socialite.
 *
 * Use in loop:
 * <?php echo odin_socialite_horizontal( get_the_title(), get_permalink(), get_the_post_thumbnail( $post->ID, 'thumbnail' ) ); ?>
 */
// require_once get_template_directory() . '/core/socialite/socialite-init.php';

/**
 * Colorbox.
 */
// require_once get_template_directory() . '/core/colorbox/colorbox-init.php';

/**
 * Photoswipe.
 */
// require_once get_template_directory() . '/core/photoswipe/photoswipe-init.php';

/**
 * LazyLoad.
 */
// require_once get_template_directory() . '/core/lazyload/lazyload-init.php';

/**
 * Theme Options Class.
 */
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
