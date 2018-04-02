<?php
/**
 * Main 404 component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<main class="odin-main" id="content" tabindex="-1" role="main">

	<div class="odin-main-wrapper">

		<header class="odin-main-header">
			<h1 class="odin-main-header__title"><?php esc_html_e( 'Not Found', 'odin' ); ?></h1>
		</header>

		<div class="odin-main-body">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'odin' ); ?></p>

			<?php
			/**
			 * Form Search Component.
			 */
			get_search_form(); ?>
		</div>

	</div>

</main><!-- .odin-main -->
