<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till #main div
 *
 * @package Odin
 * @since 1.9.0
 */
?><!DOCTYPE html>
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
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" rel="shortcut icon" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.min.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> itemscope="" itemtype="http://schema.org/WebPage">
    <div class="container">

        <?php
            require_once get_template_directory() . '/core/classes/abstracts/abstract-front-end-form.php';
            require_once get_template_directory() . '/core/classes/class-contact-form.php';

            $odin_contact_form = new Odin_Contact_Form(
                'form_id',
                '',
                'post',
                array(
                    'accept-charset' => 'UTF-8'
                )
            );
            $odin_contact_form->set_fields(
                array(
                    array(
                        'legend' => __( 'Fieldset 1', 'odin' ),
                        'fields' => array(
                            array(
                                'id'          => 'test_text', // Required
                                'label'       => __( 'Test Text', 'odin' ), // Required
                                'type'        => 'text', // Required
                                'attributes'  => array( // Optional (html input elements)
                                    'placeholder' => __( 'Some text here!' )
                                ),
                                // 'default'     => 'Default text', // Optional
                                'description' => __( 'Text field description', 'odin' ) // Optional
                            ),
                            array(
                                'id'          => 'test_email', // Required
                                'label'       => __( 'Test Email', 'odin' ), // Required
                                'type'        => 'email', // Required
                                'attributes'  => array( // Optional (html input elements)
                                    'placeholder' => __( 'Some text here!' )
                                ),
                                // 'default'     => 'Default text', // Optional
                                'description' => __( 'Email field description', 'odin' ) // Optional
                            )
                        )
                    ),
                    array(
                        'legend' => __( 'Fieldset 2', 'odin' ),
                        'fields' => array(
                            array(
                                'id'          => 'test_file', // Required
                                'label'       => __( 'Test File', 'odin' ), // Required
                                'type'        => 'file', // Required
                                // 'attributes'  => array() // Optional (html input elements)
                                // 'default'     => 'Default text', // Optional
                                'description' => __( 'File field description', 'odin' ) // Optional
                            ),
                            array(
                                'id'          => 'test_textarea', // Required
                                'label'       => __( 'Test Textarea', 'odin' ), // Required
                                'type'        => 'textarea', // Required
                                'attributes'  => array( // Optional (html input elements)
                                    'placeholder' => __( 'Some text here!' )
                                ),
                                // 'default'     => 'Default text', // Optional
                                'description' => __( 'Textarea field description', 'odin' ) // Optional
                            ),
                            array(
                                'id'          => 'test_checkbox', // Required
                                'label'       => __( 'Test Checkbox', 'odin' ), // Required
                                'type'        => 'checkbox', // Required
                                // 'attributes'  => array() // Optional (html input elements)
                                // 'default'     => 'Default text', // Optional
                                'description' => __( 'Checkbox field description', 'odin' ) // Optional
                            ),
                            array(
                                'id'          => 'test_select', // Required
                                'label'       => __( 'Test Select', 'odin' ), // Required
                                'type'        => 'select', // Required
                                // 'attributes'  => array(), // Optional (html input elements)
                                // 'default'     => 'three', // Optional
                                'description' => __( 'Select field description', 'odin' ), // Optional
                                'options'     => array( // Required (id => title)
                                    'one'   => 'One',
                                    'two'   => 'Two',
                                    'three' => 'Three',
                                    'four'  => 'Four'
                                ),
                            ),
                            array(
                                'id'          => 'test_radio', // Required
                                'type'        => 'radio', // Required
                                // 'attributes'  => array(), // Optional (html input elements)
                                // 'default'     => 'three', // Optional
                                'description' => __( 'Radio field description', 'odin' ), // Optional
                                'options'     => array( // Required (id => title)
                                    'one'   => 'One',
                                    'two'   => 'Two',
                                    'three' => 'Three',
                                    'four'  => 'Four'
                                ),
                            )
                        )
                    )
                )
            );
            $odin_contact_form->set_buttons(
                array(
                    array(
                        'id'         => 'test_submit', // Required
                        'type'       => 'submit', // Required
                        'label'      => __( 'Submit', 'odin' ), // Required
                        // 'attributes' => array() // Optional (html input elements)
                    ),
                    array(
                        'id'         => 'test_reset', // Required
                        'type'       => 'reset', // Required
                        'label'      => __( 'Reset', 'odin' ), // Required
                        'attributes' => array( // Optional (html input elements)
                            'class' => 'btn btn-danger'
                        )
                    )
                )
            );

            echo $odin_contact_form->render();


        ?>

        <header id="header" role="banner">
            <?php if ( is_home() ) : ?>
                <hgroup>
                    <h1 class="site-title"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
                </hgroup>
            <?php else: ?>
                <div class="site-title h1"><a href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
                <div class="site-description h2"><?php bloginfo( 'description' ); ?></div>
            <?php endif ?>

            <?php $header_image = get_header_image();
            if ( ! empty( $header_image ) ) : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( $header_image ); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" /></a>
            <?php endif; ?>
            <nav id="main-navigation" class="navbar navbar-default" role="navigation">
                <a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'odin' ); ?>"><?php _e( 'Skip to content', 'odin' ); ?></a>
                    <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-navigation">
                    <span class="sr-only"><?php _e( 'Toggle navigation', 'odin' ); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <?php /*

                    <a class="navbar-brand" href="<?php echo home_url(); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>

                    */ ?>
                </div>
                <div class="collapse navbar-collapse navbar-main-navigation">
                    <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'main-menu',
                                'depth'          => 2,
                                'container'      => false,
                                'menu_class'     => 'nav navbar-nav',
                                'fallback_cb'    => 'odin_menu_fallback',
                                'walker'         => new Odin_Bootstrap_Nav_Walker()
                            )
                        );
                    ?>
                    <form method="get" class="navbar-form navbar-right" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                        <label for="navbar-search" class="sr-only"><?php _e( 'Search:', 'odin' ); ?></label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="s" id="navbar-search" />
                        </div>
                        <button type="submit" class="btn btn-default"><?php _e( 'Search', 'odin' ); ?></button>
                    </form>
                </div><!-- /.navbar-collapse -->
            </nav><!-- #main-menu -->
        </header><!-- #header -->
        <div id="main" class="row">
