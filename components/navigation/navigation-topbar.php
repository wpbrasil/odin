<?php
/**
 * Navigation Topbar Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<nav class="odin-navigation-topbar">

	<div class="odin-navigation-topbar-wrapper">

		<div class="odin-navigation-topbar-container">

			<?php
			/**
			 * Brand Logo Component.
			 */
			get_template_part( 'components/shared/brand-logo' ); ?>

			<?php
			/**
			 * Form Search Component.
			 */
			get_search_form(); ?>

	  	</div>

	</div>

</nav>


