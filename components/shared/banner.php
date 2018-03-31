<?php
/**
 * Banner Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Get image to apply background header.
 */
if ( get_header_image() && is_home() ) {
	// Header Image (support custom header support) only if is home.
	$banner['image'] = get_header_image();
} elseif ( has_post_thumbnail() ) {
	// Thumbnail Post (get original size if not exists the correct).
	$banner['image'] = odin_get_attachment_image_src( get_post_thumbnail_id(), 1400, 600 );
	$banner['image'] = ( ! isset( $banner['image'] ) ) ?: wp_get_attachment_url( get_post_thumbnail_id() );
} else {
	$banner['image'] = '';
} ?>

<div class="odin-banner">

	<div class="odin-banner-wrapper">

		<div class="odin-banner-content">

			<?php
			/**
			* Page Title Component.
			*/
			get_template_part( 'components/shared/page', 'title' ); ?>

			<?php
			/**
			* Page Description Component.
			*/
			get_template_part( 'components/shared/page', 'description' ); ?>

		</div>

		<!-- Scroll link to #content -->
		<div class="odin-banner-scrollLink">
			<a href="#content" aria-label="<?php esc_html_e( 'Skip to content', 'odin' ); ?>">
				<span></span>
				<span></span>
				<span></span>
			</a>
		</div>

	</div>

</div>

<?php if ( $banner['image'] ) : ?>
<style>
.odin-banner::after {
	background: linear-gradient(to bottom left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)),
				url(<?php echo esc_url_raw( $banner['image'] ); ?>)
				no-repeat center center fixed;
	background-size: cover;
}
</style>
<?php endif; ?>
