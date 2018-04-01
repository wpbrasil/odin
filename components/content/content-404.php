<?php
/**
 * Content 404 component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<section class="odin-content">

	<div class="odin-content-wrapper">

		<header class="odin-content-header">
			<h1 class="odin-content-header__title"><?php esc_html_e( 'Not Found', 'odin' ); ?></h1>
		</header>

		<div class="odin-content-main">
			<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'odin' ); ?></p>

			<?php
			/**
			 * Form Search Component.
			 */
			get_search_form(); ?>
		</div>

	</div>

</section><!-- .odin-content -->
