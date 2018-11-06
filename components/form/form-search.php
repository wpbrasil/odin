<?php
/**
 * Form Search Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<form class="odin-formSearch" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">

	<!-- <input type="hidden" value="post" name="post_type" id="post_type" /> -->

	<div class="odin-formSearch__group odin-formSearch__group--search">
		<label class="odin-formSearch__label" for="search"><?php esc_html_e( 'Search', 'odin' ); ?></label>
		<input class="odin-formSearch__control" id="search" type="search" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php esc_html_e( 'Search', 'odin' ); ?>">
	</div>

	<div class="odin-formSearch__group odin-formSearch__group--submit">
		<button class="odin-formSearch__btn" type="submit"><?php esc_html_e( 'Search', 'odin' ); ?></button>
	</div>

</form>
