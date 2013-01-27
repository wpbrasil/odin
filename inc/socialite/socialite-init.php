<?php
/**
 * Socialite functions and shortcodes.
 */

/**
 * Load socialite script.
 */
function odin_socialite_scripts() {
    wp_register_script( 'socialite', get_template_directory_uri() . '/inc/socialite/js/socialite.min.js', array( 'jquery' ), null, true );
    wp_enqueue_script( 'socialite' );

    wp_register_style( 'socialite', get_template_directory_uri() . '/inc/socialite/css/socialite.css', array(), null, 'all' );
    wp_enqueue_style( 'socialite' );
}

add_action( 'wp_enqueue_scripts', 'odin_socialite_scripts' );

/**
 * Socialite Twitter buttons.
 *
 * @param  string $text Tweet text.
 * @param  string $url  Url to tweet.
 * @param  string $user Username of the tweet.
 * @param  string $type Button type (horizontal or vertical).
 *
 * @return string       Link to share.
 */
function odin_socialite_twitter( $text, $url, $user = '', $type = 'horizontal' ) {
    return '<a href="http://twitter.com/share?url=' . urlencode( $url ) . '" class="socialite twitter-share" data-text="' . $text .'" data-url="' . $url . '" data-count="' . $type . '" data-via="' . $user . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Google Plus buttons.
 *
 * @param  string $url  URL to share.
 * @param  string $type Button type (medium or tall).
 *
 * @return string       Link to share.
 */
function odin_socialite_googleplus( $url, $type = 'medium' ) {
    return '<a href="https://plus.google.com/share?url=' . urlencode( $url ) . '" class="socialite googleplus-one" data-size="' . $type . '" data-href="' . $url . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Pinterest buttons.
 *
 * @param  string $text  Text to share.
 * @param  string $url   Url do share.
 * @param  string $image Image to share.
 * @param  string $type  Button type (horizontal or vertical).
 *
 * @return string       Link to share.
 */
function odin_socialite_pinterest( $text, $url, $image, $type = 'horizontal' ) {
    return '<a href="http://pinterest.com/pin/create/button/?url=' . urlencode( $url ) . '&amp;media=' . urlencode( $image ) . '&amp;description=' . urlencode( $text ) . '" class="socialite pinterest-pinit" data-count-layout="' . $type . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite Facebook buttons.
 *
 * @param  string $text  Text to share.
 * @param  string $url   Url do share.
 * @param  string $image Image to share.
 * @param  string $type  Button type (button_count or box_count).
 * @param  string $send  Enable Send button (string true or false).
 * @param  string $faces Enable Facebook Faces (string true or false).
 * @param  int    $width Button Width.
 *
 * @return string       Link to share.
 */
function odin_socialite_facebook( $text, $url, $image, $type = 'button_count', $send = 'true', $faces = 'false', $width = 160 ) {
    return '<a href="http://www.facebook.com/sharer.php?u=' . urlencode( $url ) . '&amp;t=' . urlencode( $text ) . '" class="socialite facebook-like" data-href="' . $url . '" data-send="' . $send . '" data-layout="' . $type . '" data-width="' . $width . '" data-show-faces="' . $faces . '" rel="nofollow" target="_blank"></a>';
}

/**
 * Socialite horizontal buttons bar.
 *
 * @param  string $text         Text to share.
 * @param  string $url          Url to share.
 * @param  string $image        Image to share.
 * @param  string $twitter_user Username of the tweet.
 *
 * @return string               Horizontal bar with social buttons.
 */
function odin_socialite_horizontal( $text, $url, $image, $twitter_user = '' ) {
    $html = '<ul class="social-buttons horizontal">';
    $html .= '<li>' . odin_socialite_twitter( $text, $url, $twitter_user ) . '</li>';
    $html .= '<li>' . odin_socialite_googleplus( $url ) . '</li>';
    $html .= '<li>' . odin_socialite_pinterest( $text, $url, $image ) . '</li>';
    $html .= '<li>' . odin_socialite_facebook( $text, $url, $image ) . '</li>';
    $html .= '</ul>';

    return $html;
}

/**
 * Socialite vertical buttons bar.
 *
 * @param  string $text         Text to share.
 * @param  string $url          Url to share.
 * @param  string $image        Image to share.
 * @param  string $twitter_user Username of the tweet.
 *
 * @return string               Vertical bar with social buttons.
 */
function odin_socialite_vertical( $text, $url, $image, $twitter_user = '' ) {
    $html = '<ul class="social-buttons vertical">';
    $html .= '<li>' . odin_socialite_twitter( $text, $url, $twitter_user, 'vertical' ) . '</li>';
    $html .= '<li>' . odin_socialite_googleplus( $url, 'tall' ) . '</li>';
    $html .= '<li>' . odin_socialite_pinterest( $text, $url, $image, 'vertical' ) . '</li>';
    $html .= '<li>' . odin_socialite_facebook( $text, $url, $image, 'box_count' ) . '</li>';
    $html .= '</ul>';

    return $html;
}
