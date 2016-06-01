<div id="header-branding">
	<div class="container">
		<?php odin_the_custom_logo(); ?>

		<?php if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</h1>
		<?php else : ?>
			<div class="site-title">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
			</div>
		<?php
		endif;

		if ( get_bloginfo( 'description' ) || is_customize_preview() ) : ?>
			<p class="site-description"><?php bloginfo( 'description' ); ?></p>
		<?php endif ?>
	</div>
</div>
