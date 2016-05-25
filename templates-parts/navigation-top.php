<nav id="navigation-top" class="navbar navbar-inverse" role="navigation">
	<div class="container">
		<header class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only"><?php _e( 'Toggle navigation', 'odin' ); ?></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<?php bloginfo( 'name' ); ?>
			</a>
		</header>
		<div class="collapse navbar-collapse">
			<?php
				wp_nav_menu( array(
						'theme_location' => 'main-menu',
						'depth'          => 2,
						'container'      => false,
						'menu_class'     => 'nav navbar-nav',
						'fallback_cb'    => 'Odin_Bootstrap_Nav_Walker::fallback',
						'walker'         => new Odin_Bootstrap_Nav_Walker(),
				) );
			?>
			<form method="get" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
				<label for="navbar-search" class="sr-only">
					<?php _e( 'Search:', 'odin' ); ?>
				</label>
				<div class="form-group">
					<input type="search" value="<?php echo get_search_query(); ?>" class="form-control" name="s" id="navbar-search" />
				</div>
				<button type="submit" class="btn btn-default"><?php _e( 'Search', 'odin' ); ?></button>
			</form>
		</div><!-- .navbar-collapse -->
	</div><!-- .container -->
</nav>
