<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package odin
 */

get_header(); ?>

	<main id="content" class="<?php echo odin_classes_page_sidebar(); ?>" tabindex="-1" role="main">

		<?php
		if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'odin' ), get_search_query() ); ?></h1>
			</header>

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
		 		 * Include the Post-Format-specific template for the content.
		 		 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			odin_paging_nav();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

	</main>

<?php
get_sidebar();
get_footer();
