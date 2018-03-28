<?php
/**
 * Header component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get header title and description.
 */
if ( is_front_page() && is_home() || is_home() ) {
	// Front-page || Blog (home).
	$header_title = get_bloginfo( 'name' );
	$header_description = get_bloginfo( 'description' );
} elseif ( is_singular( array( 'post', 'page' ) ) ) {
	// Singular (post|page).
	$header_title = get_the_title();
	$header_description = the_excerpt();
} elseif ( is_archive() ) {
	// Archive.
	$header_title = get_the_archive_title();
	$header_description = get_the_archive_description();
} elseif ( is_search() ) {
	// Search.
	$header_title = sprintf( esc_attr__( 'Search Results for: %s', 'odin' ), get_search_query() );
	$header_description = null;
} else {
	return;
}

/**
 * If don't exists title and description return.
 */
if ( ! $header_title && ! $header_description ) {
	return;
} ?>

<div class="odin-header">

	<div class="odin-header-wrapper">

		<?php
		/**
		 * Site logo component (display only in home|front-page).
		 */
		if ( is_front_page() && is_home() || is_home() ) {
			get_template_part( 'components/shared/brand-logo' );
		} ?>

		<div class="odin-header__caption">

			<?php if ( $header_title ) : ?>
				<h1 class="odin-header__title"><?php echo wp_strip_all_tags( $header_title ); ?></h1>
			<?php endif; ?>

			<?php if ( $header_description ) : ?>
				<p class="odin-header__description"><?php echo wp_strip_all_tags( $header_description ); ?></p>
			<?php endif; ?>

		</div>

		<!-- Scroll link to #content -->
		<div class="odin-header__scrollLink">
			<a href="#content" aria-label="<?php esc_html_e( 'Skip to content', 'odin' ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</a>
		</div>

	</div><!-- .odin-header-wrapper -->

</div><!-- .odin-header -->

<?php
/**
* Background Header Component.
*/
get_template_part( 'components/header/background', 'header' );
