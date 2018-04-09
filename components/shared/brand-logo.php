<?php
/**
 * Brand Logo Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-brand-logo">

	<?php if ( has_custom_logo() ) : ?>

		<?php the_custom_logo(); ?>

	<?php else : ?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="odin-brand-logo__link odin-brand-logo__link--image" rel="home" itemprop="url">
			<img src="<?php echo get_template_directory_uri() . '/dist/img/theme-logo.png'; ?>" class="odin-brand-logo__image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="logo" />
		</a>

	<?php endif; ?>

</div>
