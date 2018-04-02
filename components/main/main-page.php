<?php
/**
 * Main Page Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<main class="odin-main" id="content" tabindex="-1" role="main">

	<div class="odin-main-wrapper">

		<?php
		if ( have_posts() ) :

			while ( have_posts() ) : the_post();

				/**
				 * Page Component.
				 */
				get_template_part( 'components/page/page' );

			endwhile;

		endif; ?>

	</div>

</main><!-- .odin-main -->
