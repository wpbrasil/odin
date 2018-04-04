<?php
/**
 * Comment form component.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

// Commenter.
$commenter = wp_get_current_commenter();

// If is require name and email option.
$require_name_email = get_option( 'require_name_email' ) ?: ' required ';

// Comment fields.
$fields = array(
	'author' =>
		'<div class="odin-commentForm__group odin-commentForm__group--author">
			<label class="odin-commentForm__label" for="author">' . esc_attr__( 'Name', 'odin' ) . ( $require_name_email ? ' <span>*</span>' : '' ) . '</label>
			<input class="odin-commentForm__control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $require_name_email. '>
		</div>',
	'email'  =>
		'<div class="odin-commentForm__group odin-commentForm__group--email">
			<label class="odin-commentForm__label" for="email">' . __( 'E-mail', 'odin' ) . ( $require_name_email ? ' <span>*</span>' : '' ) . '</label>
			<input class="odin-commentForm__control" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" ' . $require_name_email  . '>
		</div>',
	'url'    =>
		'<div class="odin-commentForm__group odin-commentForm__group--url">
			<label class="odin-commentForm__label" for="url">' . __( 'Website', 'odin' ) . '</label>
			<input class="odin-commentForm__control" type="url" id="url" name="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30">
		</div>',
);

$comment_field =
	'<div class="odin-commentForm__group odin-commentForm__group--comment">
		<label class="odin-commentForm__label" for="comment">' . __( 'Comment', 'odin' ) . ' <span>*</span></label>
		<textarea class="odin-commentForm__control" id="comment" name="comment" cols="45" rows="8" required></textarea>
	</div>';

/**
 * Display comment form.
 *
 * @link https://developer.wordpress.org/reference/functions/comment_form
 */
comment_form( array(
	'format'              => 'xhtml',
	'comment_notes_after' => '',
	'comment_field'       => $comment_field,
	'fields'              => apply_filters( 'comment_form_default_fields', $fields ),
	'class_form'          => 'odin-commentForm',
	'class_submit'        => 'odin-commentForm__btn',
));
