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
	 *
	 * @return void
	 */
	function odin_comments_loop( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
				?>
				<li class="post pingback">
					<p><?php _e( 'Pingback:', 'odin' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link">', '</span>' ); ?></p>
					<?php
					break;
				default :
					?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment">
						<footer class="comment-meta">
							<div class="comment-author vcard">
								<?php echo sprintf( '%1$s<span class="fn">%2$s</span> %3$s <a href="%4$s"><time datetime="%5$s">%6$s %7$s </time></a> <span class="says"> %8$s</span>', get_avatar( $comment, 40 ), get_comment_author_link(), __( 'in', 'odin' ), esc_url( get_comment_link( $comment->comment_ID ) ), get_comment_time( 'c' ), get_comment_date(), __( 'at', 'odin' ), get_comment_time(), __( 'said:', 'odin' ) ); ?>
								<?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link"> | ', '</span>' ); ?>
							</div><!-- .comment-author .vcard -->
							<?php if ( $comment->comment_approved == '0' ) : ?>
								<div class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'odin' ); ?></div>
							<?php endif; ?>
						</footer>
						<div class="comment-content"><?php comment_text(); ?></div>
						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Respond', 'odin' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
						</div><!-- .reply -->
					</article><!-- #comment-## -->

				<?php break;
		}
	}

}
