<?php
/**
 * Navigation Main Component.
 *
 * @uses https://developer.wordpress.org/reference/functions/wp_nav_menu
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<nav class="odin-navMain" role="navigation" id="menu">

	<div class="odin-navMain-wrapper">

		<button class="odin-navMain__toggler" type="button" data-toggle="collapse" data-target="#MainMenuCollapse" aria-controls="MainMenuCollapse" aria-expanded="false" aria-label="<?php esc_html_e( 'Toggle navigation', 'odin' ); ?>">
			<span></span>
		</button>

		<div class="odin-navMain__collapse" id="MainMenuCollapse">

			<?php
			/**
			 * Main menu.
			 */
			wp_nav_menu( array(
				'theme_location' => 'menu-main',
				'menu_class'     => 'odin-navMain__mainMenu',
				'container'      => 'ul',
				'depth'          => 2,
			) ); ?>

		</div>

	</div>

</nav>
