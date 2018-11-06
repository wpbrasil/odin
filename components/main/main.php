<?php
/**
 * Main Component.
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
				 * Post Component.
				 */
				get_template_part( 'components/post/post', get_post_format() );

			endwhile;

			/**
			 * Pagination Posts Component.
			 */
			get_template_part( 'components/pagination/pagination', 'posts' );

		else :

			/**
			 * Post None Component.
			 */
			get_template_part( 'components/post/post', 'none' );

		endif; ?>

	</div>

</main><!-- .odin-main -->
