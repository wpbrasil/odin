<?php
/**
 * Brand Logo Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-brand-logo">

	<?php if ( function_exists( 'the_custom_logo' ) ) : ?>

		<?php the_custom_logo(); ?>

	<?php else : ?>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="odin-logo__link" rel="home" itemprop="url">
			<img width="250" height="250" src="http://placehold.it/250x250" class="odin-logo__image" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" itemprop="logo" />
		</a>

	<?php endif; ?>

</div>
