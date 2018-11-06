<?php
/**
 * Comments Link Post Component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

if ( post_password_required() && ( ! comments_open() || ! get_comments_number() ) ) {
	return;
} ?>

<div class="odin-comments-link-post">

	<div class="odin-comments-link-post-wrapper">

	<?php comments_popup_link( __( 'Leave a comment', 'odin' ), __( '1 Comment', 'odin' ), __( '% Comments', 'odin' ) ); ?>

	</div>

</div>
