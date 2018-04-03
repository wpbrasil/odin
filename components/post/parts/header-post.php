<?php
/**
 * Taxonomy Tag Post Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<header class="odin-post-header">

	<?php
	if ( is_single() ) :
		the_title( '<h1 class="odin-post-header__title">', '</h1>' );
	else :
		the_title( '<h2 class="odin-post-header__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	endif;
	?>

	<div class="odin-post-header__meta">

		<?php get_template_part( 'components/post/parts/meta-date-post' ); ?>

	</div>

</header>
