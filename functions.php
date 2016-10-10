<?php
/**
 * Functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * For documentation Odin Framework
 * @link https://github.com/wpbrasil/odin
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package odin
 *
 */

/**
 * TGM.
 */
 require_once get_template_directory() . '/inc/tgm/odin-required-plugins.php';

/**
 * Classes.
 */

require_once get_template_directory() . '/inc/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/inc/classes/class-thumbnail-resizer.php';


/**
 * Shortcodes.
 */

require_once get_template_directory() . '/inc/shortcodes/class-odin-shortcodes.php';
require_once get_template_directory() . '/inc/shortcodes/class-odin-shortcodes-menu.php';

/**
 * Widgets.
 */

// Facebook like box widget.
require_once get_template_directory() . '/inc/widgets/class-odin-widget-like-box.php';

/**
 * Hooks.
 */

// Theme support options.
require_once get_template_directory() . '/inc/theme-support.php';

// WP Head and other cleanup functions.
require_once get_template_directory() . '/inc/cleanup.php';

// Register scripts and stylesheets.
require_once get_template_directory() . '/inc/enqueue-scripts.php';

// Register custom menus and menu walkers.
require_once get_template_directory() . '/inc/menu.php';

// Register sidebars/widget areas.
require_once get_template_directory() . '/inc/sidebar.php';

// Customize the WordPress admin and login menu.
require_once get_template_directory() . '/inc/admin.php';

// Automatically sets the post thumbnail.
require_once get_template_directory() . '/inc/autoset-featured.php';

/**
 * Helpers.
 */

// Custom templates tags.
require_once get_template_directory() . '/inc/template-tags.php';

// Custom comments loop.
require_once get_template_directory() . '/inc/comments-loop.php';

// Replace 'older/newer' post links with numbered navigation.
require_once get_template_directory() . '/inc/pagination.php';

// WooCommerce compatibility files.
require_once get_template_directory() . '/inc/woocommerce.php';

// Post functions.
require_once get_template_directory() . '/inc/post.php';

// Breadcrumbs function - no need to rely on plugins.
require_once get_template_directory() . '/inc/breadcrumbs.php';
