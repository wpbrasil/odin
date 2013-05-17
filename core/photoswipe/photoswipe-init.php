<?php
/**
 * Load PhotoSwipe functions.
 */

function odin_photoswipe_scripts() {
    if ( false == ODIN_GRUNT_SUPPORT ) {
        wp_register_script( 'klass', get_template_directory_uri() . '/core/photoswipe/js/klass.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'klass' );

        wp_register_script( 'photoswipe', get_template_directory_uri() . '/core/photoswipe/js/code.photoswipe-3.0.5.min.js', array( 'jquery' ), null, true );
        wp_enqueue_script( 'photoswipe' );
    }

    wp_register_style( 'jquery-mobile-photoswipe', get_template_directory_uri() . '/core/photoswipe/css/jquery-mobile.css', array(), null, 'all' );
    wp_enqueue_style( 'jquery-mobile-photoswipe' );

    wp_register_style( 'photoswipe', get_template_directory_uri() . '/core/photoswipe/css/photoswipe.css', array(), null, 'all' );
    wp_enqueue_style( 'photoswipe' );

    wp_register_style( 'styles-photoswipe', get_template_directory_uri() . '/core/photoswipe/css/styles.css', array(), null, 'all' );
    wp_enqueue_style( 'styles-photoswipe' );
}

add_action( 'wp_enqueue_scripts', 'odin_photoswipe_scripts' );
