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
 * Odin Classes.
 */

require_once get_template_directory() . '/inc/classes/abstracts/abstract-front-end-form.php';
require_once get_template_directory() . '/inc/classes/class-bootstrap-nav.php';
require_once get_template_directory() . '/inc/classes/class-shortcodes.php';
require_once get_template_directory() . '/inc/classes/class-shortcodes-menu.php';
require_once get_template_directory() . '/inc/classes/class-thumbnail-resizer.php';
require_once get_template_directory() . '/inc/classes/class-theme-options.php';
require_once get_template_directory() . '/inc/classes/class-options-helper.php';
require_once get_template_directory() . '/inc/classes/class-post-type.php';
require_once get_template_directory() . '/inc/classes/class-taxonomy.php';
require_once get_template_directory() . '/inc/classes/class-metabox.php';
require_once get_template_directory() . '/inc/classes/class-contact-form.php';
require_once get_template_directory() . '/inc/classes/class-post-form.php';
require_once get_template_directory() . '/inc/classes/class-user-meta.php';
require_once get_template_directory() . '/inc/classes/class-post-status.php';
require_once get_template_directory() . '/inc/classes/class-term-meta.php';

/**
 * Odin Widgets.
 */

// Facebook like widget.
require_once get_template_directory() . '/inc/widgets/like-box.php';

/**
 * Odin Functions.
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

// Custom comments loop.
require_once get_template_directory() . '/inc/comments-loop.php';

// Custom templates tags.
require_once get_template_directory() . '/inc/template-tags.php';

// WooCommerce compatibility files.
require_once get_template_directory() . '/inc/template-tags.php';

// Replace 'older/newer' post links with numbered navigation.
require_once get_template_directory() . '/inc/pagination.php';

// Related post function - no need to rely on plugins.
require_once get_template_directory() . '/inc/related-posts.php';

// Breadcrumbs function - no need to rely on plugins.
require_once get_template_directory() . '/inc/breadcrumbs.php';

// Customize the WordPress admin and login menu.
require_once get_template_directory() . '/inc/admin.php';

// Custom limit excerpt for content or title.
require_once get_template_directory() . '/inc/excerpt.php';

// Automatically sets the post thumbnail.
require_once get_template_directory() . '/inc/autoset-featured.php';

// Get a image URL.
require_once get_template_directory() . '/inc/get-image-url.php';

// Get term meta fields.
require_once get_template_directory() . '/inc/get_term_meta.php';

// Custom post thumbnail.
require_once get_template_directory() . '/inc/thumbnail.php';
