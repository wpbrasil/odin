<?php
if ( ! function_exists( 'odin_comment_loop' ) ) {

	/**
	 * Custom comments loop.
	 *
	 * @since 2.2.0
	 *
	 * @param  object $comment Comment object.
	 * @param  array  $args    Comment arguments.
	 * @param  int    $depth   Comment depth.
	 */
	function odin_comments_loop( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
?>
				<li class="media post pingback">
					<p><?php _e( 'Pingback:', 'odin' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link">', '</span>' ); ?></p>
<?php
			break;
			default :
?>
				<li <?php comment_class( 'media' ); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="div-comment-<?php comment_ID(); ?>" class="comment-body comment-author vcard">
						<div class="media-left">
							<?php echo str_replace( "class='avatar", "class='media-object avatar", get_avatar( $comment, 64 ) ); ?>
						</div>
						<div class="media-body">
							<footer class="comment-meta">
								<h5 class="media-heading">
									<?php echo sprintf( '<strong><span class="fn">%1$s</span></strong>
														 %2$s <a href="%3$s"><time datetime="%4$s">%5$s %6$s </time></a>
														 <span class="says"> %7$s</span>',
														 get_comment_author_link(), __( 'in', 'odin' ),
														 esc_url( get_comment_link( $comment->comment_ID ) ),
														 get_comment_time( 'c' ),
														 get_comment_date(), __( 'at', 'odin' ),
														 get_comment_time(), __( 'said:', 'odin' ) ); ?>
								</h5>

								<?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link">', ' </span>' ); ?>

								<?php if ( $comment->comment_approved == '0' ) : ?>
								<p class="comment-awaiting-moderation alert alert-info"><?php _e( 'Your comment is awaiting moderation.', 'odin' ); ?></p>
								<?php endif; ?>
							</footer><!-- .comment-meta -->

							<div class="comment-content">
								<?php comment_text(); ?>
							</div><!-- .comment-content -->

							<div class="comment-metadata">
								<span class="reply-link"><?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Respond', 'odin' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></span>
							</div><!-- .comment-metadata -->
						</div>
					</article><!-- .comment-body -->
<?php
			break;
		}
	}
}
