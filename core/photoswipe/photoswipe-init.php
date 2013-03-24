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

    wp_register_style( 'photoswipe', get_template_directory_uri() . '/core/photoswipe/css/photoswipe.css', array(), null, 'all' );
    wp_enqueue_style( 'photoswipe' );
}

add_action( 'wp_enqueue_scripts', 'odin_photoswipe_scripts' );
