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
 * @since 2.2.0
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 600;
}

/**
 * Odin Classes.
 */
require_once get_template_directory() . '/core/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/core/classes/class-shortcodes.php';
require_once get_template_directory() . '/core/classes/class-thumbnail-resizer.php';
// require_once get_template_directory() . '/core/classes/class-theme-options.php';
// require_once get_template_directory() . '/core/classes/class-options-helper.php';
// require_once get_template_directory() . '/core/classes/class-post-type.php';
// require_once get_template_directory() . '/core/classes/class-taxonomy.php';
// require_once get_template_directory() . '/core/classes/class-metabox.php';
// require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
// require_once get_template_directory() . '/core/classes/class-contact-form.php';
// require_once get_template_directory() . '/core/classes/class-post-form.php';
// require_once get_template_directory() . '/core/classes/class-user-meta.php';

/**
 * Odin Widgets.
 */
require_once get_template_directory() . '/core/classes/widgets/class-widget-like-box.php';

if ( ! function_exists( 'odin_setup_features' ) ) {

	/**
	 * Setup theme features.
	 *
	 * @since  2.2.0
	 *
	 * @return void
	 */
	function odin_setup_features() {

		/**
		 * Add support for multiple languages.
		 */
		load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'odin' )
			)
		);

		/*
		 * Add post_thumbnails suport.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add feed link.
		 */
		add_theme_support( 'automatic-feed-links' );

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
		 * Add support for infinite scroll.
		 */
		add_theme_support(
			'infinite-scroll',
			array(
				'type'           => 'scroll',
				'footer_widgets' => false,
				'container'      => 'content',
				'wrapper'        => false,
				'render'         => false,
				'posts_per_page' => get_option( 'posts_per_page' )
			)
		);

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
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Register widget areas.
 *
 * @since  2.2.0
 *
 * @return void
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
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_flush_rewrite() {
	flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * Load site scripts.
 *
 * @since  2.2.0
 *
 * @return void
 */
function odin_enqueue_scripts() {
	$template_url = get_template_directory_uri();

	// Loads Odin main stylesheet.
	wp_enqueue_style( 'odin-style', get_stylesheet_uri(), array(), null, 'all' );

	// jQuery.
	wp_enqueue_script( 'jquery' );

	// Twitter Bootstrap.
	wp_enqueue_script( 'bootstrap', $template_url . '/assets/js/libs/bootstrap.min.js', array(), null, true );

	// General scripts.
	// FitVids.
	wp_enqueue_script( 'fitvids', $template_url . '/assets/js/libs/jquery.fitvids.js', array(), null, true );

	// Main jQuery.
	wp_enqueue_script( 'odin-main', $template_url . '/assets/js/main.js', array(), null, true );

	// Grunt main file with Bootstrap, FitVids and others libs.
	// wp_enqueue_script( 'odin-main-min', $template_url . '/assets/js/main.min.js', array(), null, true );

	// Load Thread comments WordPress script.
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'odin_enqueue_scripts', 1 );

/**
 * Odin custom stylesheet URI.
 *
 * @since  2.2.0
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
	return $dir . '/assets/css/style.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Core Helpers.
 */
require_once get_template_directory() . '/core/helpers.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/admin.php';

/**
 * Comments loop.
 */
require_once get_template_directory() . '/inc/comments-loop.php';

/**
 * WP optimize functions.
 */
require_once get_template_directory() . '/inc/optimize.php';

/**
 * WP Custom Admin.
 */
require_once get_template_directory() . '/inc/plugins-support.php';

/**
 * Custom template tags.
 */
require_once get_template_directory() . '/inc/template-tags.php';

require_once get_template_directory() . '/core/classes/class-metabox.php';

function video_metabox_example() {

    $videos_metabox = new Odin_Metabox(
        'videos', // Slug/ID of the Metabox (Required)
        'Videos Configuration', // Metabox name (Required)
        array( 'post', 'page' ), // Slug of Post Type (Optional)
        'normal', // Context (options: normal, advanced, or side) (Optional)
        'high' // Priority (options: high, core, default or low) (Optional)
    );

    $videos_metabox->set_fields(
        array(
            /**
             * Default input examples.
             */

            // Text Field.
            array(
                'id'         => 'test_text', // Required
                'label'      => __( 'Test Text', 'odin' ), // Required
                'type'       => 'text', // Required
                'attributes' => array( // Optional (html input elements)
                    'placeholder' => __( 'Some text here!' )
                ),
                // 'default'  => 'Default text', // Optional
                'description' => __( 'Text field description', 'odin' ) // Optional
            ),
            // Textarea Field.
            array(
                'id'          => 'test_textarea', // Required
                'label'       => __( 'Test Textarea', 'odin' ), // Required
                'type'        => 'textarea', // Required
                'attributes'  => array( // Optional (html input elements)
                    'placeholder' => __( 'Some text here!' )
                ),
                // 'default'  => 'Default text', // Optional
                'description' => __( 'Textaera field description', 'odin' ) // Optional
            ),
            // Checkbox field.
            array(
                'id'          => 'test_checkbox', // Required
                'label'       => __( 'Test Checkbox', 'odin' ), // Required
                'type'        => 'checkbox', // Required
                // 'attributes' => array(), // Optional (html input elements)
                // 'default'    => '', // Optional (1 for checked)
                'description' => __( 'Checkbox field description', 'odin' ), // Optional
            ),
            // Select field.
            array(
                'id'          => 'test_select', // Required
                'label'       => __( 'Test Select', 'odin' ), // Required
                'type'        => 'select', // Required
                // 'attributes' => array(), // Optional (html input elements)
                // 'default'    => 'three', // Optional
                'description' => __( 'Select field description', 'odin' ), // Optional
                'options' => array( // Required (id => title)
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                    'four'  => 'Four'
                ),
            ),
            // Radio field.
            array(
                'id'          => 'test_radio', // Required
                'label'       => __( 'Test Radio', 'odin' ), // Required
                'type'        => 'radio', // Required
                // 'attributes' => array(), // Optional (html input elements)
                // 'default'    => 'three', // Optional
                'description' => __( 'Radio field description', 'odin' ), // Optional
                'options' => array( // Required (id => title)
                    'one'   => 'One',
                    'two'   => 'Two',
                    'three' => 'Three',
                    'four'  => 'Four'
                ),
            ),
            // Editor field.
            array(
                'id'          => 'test_editor', // Required
                'label'       => __( 'Test Editor', 'odin' ), // Required
                'type'        => 'editor', // Required
                // 'default'     => 'Default text', // Optional
                'description' => __( 'Editor field description', 'odin' ), // Optional
                'options'     => array( // Optional
                    // Arguments of wp_editor().
                    // See more http://codex.wordpress.org/Function_Reference/wp_editor
                    'textarea_rows' => 10
                ),
            ),
            // Image field.
            array(
                'id'          => 'test_image', // Required
                'label'       => __( 'Test Image', 'odin' ), // Required
                'type'        => 'image', // Required
                // 'default'     => '', // Optional (image attachment id)
                'description' => __( 'Image field description', 'odin' ), // Optional
            ),
            // Image Plupload field.
            array(
                'id'          => 'test_image_plupload', // Required
                'label'       => __( 'Test Image Plupload', 'odin' ), // Required
                'type'        => 'image_plupload', // Required
                // 'default'     => '', // Optional (image attachment ids separated with comma)
                'description' => __( 'Image Plupload field description', 'odin' ), // Optional
            ),
            // Upload field.
            array(
                'id'          => 'test_upload', // Required
                'label'       => __( 'Test Upload', 'odin' ), // Required
                'type'        => 'upload', // Required
                // 'attributes' => array(), // Optional (html input elements)
                // 'default'    => '', // Optional (file url)
                'description' => __( 'Upload field description', 'odin' ), // Optional
            ),
            // Color field.
            array(
                'id'          => 'test_color', // Required
                'label'       => __( 'Test Color', 'odin' ), // Required
                'type'        => 'color', // Required
                // 'attributes' => array(), // Optional (html input elements)
                'default'     => '#ffffff', // Optional (color in hex)
                'description' => __( 'Color field description', 'odin' ), // Optional
            ),
            // Generic input field.
            array(
                'id'          => 'test_input', // Required
                'label'       => __( 'Test Input', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'Textaera field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)

                )
            ),
            // Separator.
            array(
                'id'   => 'separator1', // Obrigatório
                'type' => 'separator' // Obrigatório
            ),
            // Title.
            array(
                'id'   => 'test_title', // Required
                'label'=> __( 'Test Title', 'odin' ), // Required
                'type' => 'title', // Required
            ),

            /**
             * HTML 5 examples
             */
            // HTML5 color field.
            array(
                'id'          => 'test_html5_color', // Required
                'label'       => __( 'Test HTML5 color', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 color field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'color'
                )
            ),
            // HTML5 date field.
            array(
                'id'          => 'test_html5_date', // Required
                'label'       => __( 'Test HTML5 date', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 date field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'date'
                )
            ),
            // HTML5 datetime field.
            array(
                'id'          => 'test_html5_datetime', // Required
                'label'       => __( 'Test HTML5 datetime', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 datetime field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'datetime'
                )
            ),
            // HTML5 datetime-local field.
            array(
                'id'          => 'test_html5_datetime_local', // Required
                'label'       => __( 'Test HTML5 datetime-local', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 datetime-local field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'datetime-local'
                )
            ),
            // HTML5 email field.
            array(
                'id'          => 'test_html5_email', // Required
                'label'       => __( 'Test HTML5 email', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 email field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'email'
                )
            ),
            // HTML5 month field.
            array(
                'id'          => 'test_html5_month', // Required
                'label'       => __( 'Test HTML5 month', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 month field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'month'
                )
            ),
            // HTML5 number field.
            array(
                'id'          => 'test_html5_number', // Required
                'label'       => __( 'Test HTML5 number', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 number field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'number',
                    'max'  => 6,
                    'min'  => 1
                )
            ),
            // HTML5 range field.
            array(
                'id'          => 'test_html5_range', // Required
                'label'       => __( 'Test HTML5 range', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 range field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'range',
                    'max'  => 6,
                    'min'  => 1
                )
            ),
            // HTML5 search field.
            array(
                'id'          => 'test_html5_search', // Required
                'label'       => __( 'Test HTML5 search', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 search field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'search'
                )
            ),
            // HTML5 tel field.
            array(
                'id'          => 'test_html5_tel', // Required
                'label'       => __( 'Test HTML5 tel', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 tel field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'tel'
                )
            ),
            // HTML5 time field.
            array(
                'id'          => 'test_html5_time', // Required
                'label'       => __( 'Test HTML5 time', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 time field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'time'
                )
            ),
            // HTML5 url field.
            array(
                'id'          => 'test_html5_url', // Required
                'label'       => __( 'Test HTML5 url', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 url field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'url'
                )
            ),
            // HTML5 week field.
            array(
                'id'          => 'test_html5_week', // Required
                'label'       => __( 'Test HTML5 week', 'odin' ), // Required
                'type'        => 'input', // Required
                // 'default'  => 'Default text', // Optional
                'description' => __( 'HTML5 week field description', 'odin' ), // Optional
                'attributes'  => array( // Optional (html input elements)
                    'type' => 'week'
                )
            ),
        )
    );
}

add_action( 'init', 'video_metabox_example', 1 );
