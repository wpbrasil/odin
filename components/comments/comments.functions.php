<?php
/**
 * Comments Functions.
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/**
 * Loop Comments Component.
 */

if ( ! function_exists( 'odin_comments_loop' ) ) {

	/**
	 * Custom comments loop.
	 *
	 * @param  object $comment Comment object.
	 * @param  array  $args    Comment arguments.
	 * @param  int    $depth   Comment depth.
	 */
	function odin_comments_loop( $comment, $args, $depth ) {
		switch ( $comment->comment_type ) {
			case 'pingback' :
			case 'trackback' :
			?>
				<article class="odin-comment odin-comment--pingback odin-comment--trackback">
					<p>
						<?php esc_attr_e( 'Pingback:', 'odin' ); ?>
						<?php comment_author_link(); ?>
						<?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link">', '</span>' ); ?>
					</p>
				</article><!--.comment.pingback-->
			<?php
			break;
			default :
			?>
				<article <?php comment_class('odin-comment'); ?> id="comment-<?php comment_ID(); ?>">

					<div class="odin-comment-wrapper">

						<div class="odin-comment-avatar">
							<?php echo get_avatar( $comment, 64 ); ?>
						</div>

						<div class="odin-comment-body">
							<header class="odin-comment-body__header">
								<?php
								echo sprintf(
									'<h5><strong><span class="fn">%1$s</span></strong> %2$s <a href="%3$s"><time datetime="%4$s">%5$s %6$s </time></a> <span class="says"> %7$s</span></h5>',
									get_comment_author_link(), esc_attr__( 'in', 'odin' ),
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									get_comment_date(), esc_attr__( 'at', 'odin' ),
									get_comment_time(), esc_attr__( 'said:', 'odin' )
								); ?>
							</header>

							<div class="odin-comment-body__content">

								<?php if ( '0' === $comment->comment_approved ) : ?>
								<div class="odin-alert-info" role="alert">
									<?php esc_attr_e( 'Your comment is awaiting moderation.', 'odin' ); ?>
								</div>
								<?php endif; ?>

								<?php comment_text(); ?>
							</div>

							<footer class="odin-comment-body__footer">
								<div class="odin-comment-reply-link">
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Respond', 'odin' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
								</div>

								<div class="odin-comment-edit-link">
									<?php edit_comment_link( __( 'Edit', 'odin' ), '<span class="edit-link">', ' </span>' ); ?>
								</div>
							</footer>
						</div><!--comment-body-->

					</div>

				</article>
			<?php
			break;
		}
	}
}
