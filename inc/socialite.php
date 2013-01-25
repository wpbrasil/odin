<?php
/**
 * Socialite functions and shortcodes.
 */

/**
 * Load socialite script.
 */
function odin_socialite_scripts() {
    wp_enqueue_script( 'jquery');
    wp_register_script( 'socialite', get_template_directory_uri() . '/js/socialite.min.js', array(), null, true );
    wp_enqueue_script( 'socialite' );
}

add_action( 'wp_enqueue_scripts', 'odin_socialite_scripts' );

/**
 * Socialite Twitter buttons.
 *
 * @param  string $text Tweet text.
 * @param  string $url  Url to tweet.
 * @param  string $user Username of the tweet.
 * @param  string $type Button type.
 *
 * @return string       A link with.
 */
function odin_socialite_twitter( $text, $url, $user = '', $type = 'horizontal' ) {
    return '<a href="http://twitter.com/share?url=' . urlencode( $url ) . '" class="socialite twitter-share" data-text="' . $text .'" data-url="' . $url . '" data-count="' . $type . '" data-via="' . $user . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Google Plus buttons.
 *
 * @param  [type] $url  [description]
 * @param  string $type [description]
 *
 * @return [type]       [description]
 */
function odin_socialite_googleplus( $url, $type = 'medium' ) {
    return '<a href="https://plus.google.com/share?url=' . urlencode( $url ) . '" class="socialite googleplus-one" data-type="' . $type . '" data-href="' . $url . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Pinterest buttons.
 *
 * @param  [type] $text  [description]
 * @param  [type] $url   [description]
 * @param  [type] $image [description]
 * @param  string $type  [description]
 *
 * @return [type]        [description]
 */
function odin_socialite_pinterest( $text, $url, $image, $type = 'horizontal' ) {
    return '<a href="http://pinterest.com/pin/create/button/?url=' . urlencode( $url ) . '&amp;media=' . urlencode( $image ) . '&amp;description=' . urlencode( $text ) . '" class="socialite pinterest-pinit" data-count-layout="' . $type . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Facebook buttons.
 *
 * @param  [type] $text  [description]
 * @param  [type] $url   [description]
 * @param  [type] $image [description]
 * @param  string $type  [description]
 * @param  string $send  [description]
 * @param  string $faces [description]
 * @param  int    $width [description]
 *
 * @return [type]        [description]
 */
function odin_socialite_facebook( $text, $url, $image, $type = 'button_count', $send = 'true', $faces = 'false', $width = 160 ) {
    return '<a href="http://www.facebook.com/sharer.php?u=' . urlencode( $url ) . '&amp;t=' . urlencode( $text ) . '" class="socialite facebook-like" data-href="' . $url . '" data-send="' . $send . '" data-layout="' . $type . '" data-width="' . $width . '" data-show-faces="' . $faces . '" rel="nofollow" target="_blank"></a>';
}

function odin_socialite_horizontal( $text, $url, $image, $twitter_user = '' ) {
    $html = '<ul class="social-buttons">';
    $html .= '<li>' . odin_socialite_twitter( $text, $url, $twitter_user ) . '</li>';
    $html .= '<li>' . odin_socialite_googleplus( $url ) . '</li>';
    $html .= '<li>' . odin_socialite_pinterest( $text, $url, $image ) . '</li>';
    $html .= '<li>' . odin_socialite_facebook( $text, $url, $image ) . '</li>';
    $html .= '</ul>';

    return $html;
}