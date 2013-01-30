<!DOCTYPE html>
<!--[if IE 7]><html class="no-js ie7 lt-ie9 lt-ie8" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8]><html class="no-js ie8 lt-ie9" <?php language_attributes(); ?>><![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5-3.6-respond-1.1.0.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
    <div class="wrapper">
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
            <nav id="main-menu" role="navigation">
                <?php wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); ?>
            </nav><!-- #main-menu -->
        </header><!-- #header -->
        <div id="main">