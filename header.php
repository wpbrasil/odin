<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="wrapper" class="container"><div class="row">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package odin
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<nav class="navigation-skiplink" role="navigation">
		<a class="navigation-skiplink-link" href="#content"><?php _e( 'Skip to content', 'odin' ); ?></a>
	</nav>

	<header id="header" role="banner">
		<?php get_template_part( 'templates-parts/header', 'branding' ); ?>

		<?php get_template_part( 'templates-parts/navigation', 'top' ); ?>

		<?php
			$header_image = get_header_image();
			if ( ! empty( $header_image ) ) :
		?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( $header_image ); ?>" height="<?php esc_attr_e( $header_image->height ); ?>" width="<?php esc_attr_e( $header_image->width ); ?>" alt="" />
			</a>
		<?php endif; ?>
	</header><!-- #header -->

	<div id="wrapper" class="container">
		<div class="row">
