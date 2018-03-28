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
}

/**
 * Header background image.
 */
if ( get_header_image() && is_home() ) {
	// Header Image (support custom header support) only if is home.
	$header_image_url = get_header_image();
} elseif ( has_post_thumbnail() ) {
	// Thumbnail Post (get original size if not exists the correct).
	$header_image_url = odin_get_attachment_image_src( get_post_thumbnail_id(), 1400, 600 );
	$header_image_url = ( ! isset( $header_image_url ) ) ?: wp_get_attachment_url( get_post_thumbnail_id() );
} else {
	// Default Image.
	$header_image_url = 'http://placehold.it/1400x600';
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

<?php if ( $header_image_url ) : ?>
	<style>
		.odin-header::after {
			background: linear-gradient(to bottom left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)),
									url(<?php echo esc_url_raw( $header_image_url ); ?>)
									no-repeat center center fixed;
			background-size: cover;
		}
	</style>
<?php endif; ?>
