<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package Odin
 * @since 1.9.0
 */
?>
<div id="comments" class="content-wrap" itemscope itemtype="http://schema.org/Comment">
	<?php if ( post_password_required() ) : ?>
		<span class="nopassword"><?php _e( 'This post is password protected. Enter the password to view all comments.', 'odin' ); ?></span>
</div><!-- #comments -->
		<?php
		return;
	endif;

	if ( have_comments() ) : ?>
		<h2 id="comments-title">
			<?php
			comments_number( __( '0 Comments', 'odin' ), __( '1 Comment', 'odin' ), __( '% Comments', 'odin' ) );
			echo ' ' . __( 'to', 'odin' ) . ' <span>&quot;' . get_the_title() . '&quot;</span>';
			?>
		</h2>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above">
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Old Comments', 'odin' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'New Comments &rarr;', 'odin' ) ); ?></div>
			</nav>
		<?php endif; ?>
		<ol class="commentlist">
			<?php wp_list_comments( array( 'callback' => 'odin_comments_loop' ) ); ?>
		</ol>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav id="comment-nav-above">
				<div class="nav-previous"><?php previous_comments_link( __( '&larr; Old Comments', 'odin' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'New Comments &rarr;', 'odin' ) ); ?></div>
			</nav>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ( ! comments_open() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<span class="nocomments"><?php _e( 'Comments closed.', 'odin' ); ?></span>
	<?php endif; ?>

	<?php
		$commenter 		= wp_get_current_commenter();
		$req 			= get_option( 'require_name_email' );
		$aria_req 		= ( $req ? " aria-required='true'" : '' );
		$html_req 		= ( $req ? " required='required'" : '' );
		$html5 			= current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : null;
		$comment_field 	= '<div class="comment-form-comment form-group"><label class="control-label" for="comment">' . __( 'Comment', 'odin' ) . ' <span class="required text-danger">*</span></label> ' .
						 '<textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required="required"></textarea></div>';
		$fields 		=  array(
			'author' => '<div class="comment-form-author form-group">' . '<label for="author">' . __( 'Name', 'odin' ) . ( $req ? ' <span class="required text-danger">*</span>' : '' ) . '</label> ' .
			            '<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></div>',
			'email'  => '<div class="comment-form-email form-group"><label for="email">' . __( 'E-mail', 'odin' ) . ( $req ? ' <span class="required text-danger">*</span>' : '' ) . '</label> ' .
			            '<input id="email" name="email" class="form-control" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' /></div>',
			'url'    => '<div class="comment-form-url form-group"><label for="url">' . __( 'Website', 'odin' ) . '</label> ' .
			            '<input id="url" name="url" class="form-control" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'
		);
		comment_form( array(
			'comment_notes_after' 	=> '',
			'comment_field' 		=> $comment_field,
			'fields' 				=> apply_filters( 'comment_form_default_fields', $fields )
		));
	?>
</div><!-- #comments -->
