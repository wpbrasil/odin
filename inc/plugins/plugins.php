<?php
/**
 * Plugins.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Include the TGM_Plugin_Activation class.
 *
 * @link http://tgmpluginactivation.com/
 */
//require_once get_template_directory() . '/inc/plugins/tgm/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 */
if ( class_exists( 'TGM_Plugin_Activation' ) ) {

	add_action( 'tgmpa_register', function() {

		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			array(
				'name'   => 'Odin Toolkit',
				'slug'   => 'odin-toolkit',
				'source' => 'https://github.com/wpbrasil/odin-toolkit/archive/master.zip',
				'required' => false,
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 */
		$config = array(
			'id'           => 'odin',                  // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );

	} );
}
