<!DOCTYPE html>
<!--[if IE 7]><html class="no-js ie7 lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie8 lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/images/favicon.ico" rel="shortcut icon" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
    <div class="container">
        <header id="header" role="banner">
            <?php if ( is_home() ) : ?>
                <hgroup>
                    <h1 class="site-title"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                </hgroup>
            <?php else: ?>
                <div class="site-title"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
                <div class="site-description"><?php bloginfo( 'description' ); ?></div>
            <?php endif ?>

            <?php $header_image = get_header_image();
            if ( ! empty( $header_image ) ) : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /></a>
            <?php endif; ?>
            <nav id="main-navigation" class="navbar" role="navigation">
                <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'odin' ); ?>"><?php _e( 'Skip to content', 'odin' ); ?></a>
                <div class="navbar-inner">
                    <div class="container">
                        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </a>
                        <?php /*

                        <a class="brand" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

                        */ ?>
                        <div class="nav-collapse collapse">
                            <form method="get" class="navbar-search pull-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                                <label for="navbar-search" class="assistive-text"><?php _e( 'Search:', 'odin' ); ?></label>
                                <input type="text" class="input-large search-query" name="s" id="navbar-search" placeholder="<?php _e( 'Search:', 'odin' ); ?>" />
                            </form>
                            <?php
                                wp_nav_menu(
                                    array(
                                        'theme_location' => 'main-menu',
                                        'depth'          => 2,
                                        'container'      => false,
                                        'menu_class'     => 'nav',
                                        'fallback_cb'    => 'odin_menu_fallback',
                                        'walker'         => new Odin_Bootstrap_Nav_Walker()
                                    )
                                );
                            ?>
                        </div>
                    </div>
                </div>
            </nav><!-- #main-menu -->
        </header><!-- #header -->
        <div id="main" class="row">