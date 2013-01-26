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
     * Support Custom Header.
     */
	$default = array(
		'width'        			 => 0,
		'height'       			 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'header-text'            => false,
		'default-image' => get_template_directory_uri() . '/images/default-header.jpg',
		'uploads'       => true,
	);
	add_theme_support( 'custom-header', $default );

	/**
     * Support Custom Background.
     */
	$defaults = array(
		'default-color'          => '',
		'default-image' => get_template_directory_uri() . '/images/default-background.jpg',
	);
	add_theme_support( 'custom-background', $defaults );

	/**
     * Support Custom Editor Style.
     */
	add_editor_style('custom-editor-style.css');

    /**
     * Add support for multiple languages
     */
    load_theme_textdomain( 'odin', $template_dir . '/languages' );

    /**
     * Add support for infinite scroll
     */
        add_theme_support( 'infinite-scroll', array(
            'type'           => 'scroll',
            'footer_widgets' => false,
            'container'      => 'content',
            'wrapper'        => false,
            'render'         => false,
            'posts_per_page' => get_option('posts_per_page')
        ) );
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
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * Theme tools
 */
require_once get_template_directory() . '/inc/tools.php';

/**
 * Add Custom post_thumbnails tools.
 */
require_once get_template_directory() . '/inc/thumbnails.php';

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
//require_once get_template_directory() . '/inc/socialite.php';

/**
 * Theme Options Class.
 */
// require_once get_template_directory() . '/inc/classes/class-theme-options.php';
