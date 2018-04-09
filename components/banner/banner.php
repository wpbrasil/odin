<?php
/**
 * Banner Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

if ( ! odin_get_banner_title() ) {
	return;
} ?>

<div class="odin-banner">

	<div class="odin-banner-wrapper">

		<div class="odin-banner-content">

			<h1 class="odin-banner-content__title"><?php echo wp_strip_all_tags( odin_get_banner_title() ); ?></h1>

			<?php if ( odin_get_banner_description() ) : ?>
				<p class="odin-banner-content__description"><?php echo wp_strip_all_tags( odin_get_banner_description() ); ?></p>
			<?php endif; ?>

		</div>

	</div>

</div>

<?php if ( odin_get_banner_image() ) : ?>
	<style>
	.odin-banner::after {
		background: linear-gradient(to bottom left, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)),
					url(<?php echo esc_url_raw( odin_get_banner_image() ); ?>)
					no-repeat center center fixed;
		background-size: cover;
	}
	</style>
<?php endif; ?>
