<?php
/**
 * Odin_Shortcodes class.
 *
 * Built Shortcodes Menu on editor text.
 *
 * @package  Odin
 * @category Shortcodes
 * @author   WPBrasil
 * @version  2.1.4
 */
class Odin_Shortcodes_Menu {


	public function __construct() {
		add_action( 'admin_head', array( $this, 'add_shortcode_button' ) );
		//add_filter( 'tiny_mce_version', array( $this, 'refresh_mce' ) );
		add_filter( 'mce_external_languages', array( $this, 'add_tinymce_locales' ), 20, 1 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	/**
	 * Add a button for shortcodes to the WP editor.
	 */
	public function add_shortcode_button() {
		if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
			return;
		}

		if ( get_user_option( 'rich_editing' ) == 'true') {
			add_filter( 'mce_external_plugins', array( $this, 'add_shortcode_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_shortcode_button' ) );
		}
	}

	/**
	 * Add the shortcode button to TinyMCE.
	 *
	 * @param  array $plugins TinyMCE plugins.
	 *
	 * @return array          Odin TinyMCE plugin.
	 */
	public function add_shortcode_tinymce_plugin( $plugins ) {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$plugins['odin_shortcodes'] = plugins_url( 'assets/js/editor' . $suffix . '.js', plugin_dir_path( __FILE__ ) );

		return $plugins;
	}

	/**
	 * Register the shortcode button.
	 *
	 * @param array $buttons
	 * @return array
	 */
	public function register_shortcode_button( $buttons ) {
		array_push( $buttons, '|', 'odin_shortcodes' );

		return $buttons;
	}

	/**
	 * TinyMCE locales function.
	 *
	 * @param  array $locales TinyMCE locales.
	 *
	 * @return array
	 */
	public function add_tinymce_locales( $locales ) {
		$locales['odin_shortcodes'] = plugin_dir_path( __FILE__ ) . 'shortcodes-editor-i18n.php';

		return $locales;
	}

	/**
	 * Admin scripts.
	 *
	 * @param  string $hook Page slug.
	 *
	 * @return void
	 */
	public function admin_scripts( $hook ) {
		wp_enqueue_style( 'odin-shortcodes', get_template_directory( 'assets/css/editor.css', plugin_dir_path( __FILE__ ) ), array( 'odin_admin_menu_styles' ), WooCommerce_Shortcodes::VERSION, 'all' );
	}


}

new Odin_Shortcodes_Menu;