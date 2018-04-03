<?php
/**
 * Header component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<header class="odin-header">

	<div class="odin-header-wrapper">

		<?php
		/**
		* Navigation Topbar Component.
		*/
		get_template_part( 'components/navigation/navigation', 'topbar' ); ?>

		<?php
		/**
		* Banner Component.
		*/
		get_template_part( 'components/banner/banner' ); ?>

		<?php
		/**
		* Navigation Main Component.
		*/
		get_template_part( 'components/navigation/navigation', 'main' ); ?>


	</div><!-- .odin-header-wrapper -->

</header><!-- .odin-header -->


