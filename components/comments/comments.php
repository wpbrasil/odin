<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
} ?>

<section class="odin-comments" id="comments">

	<div class="odin-comments-wrapper">

		<?php
		if ( have_comments() ) : ?>
			<h2 class="odin-comments__title">
				<?php
				comments_number( __( '0 Comments', 'odin' ), __( '1 Comment', 'odin' ), __( '% Comments', 'odin' ) );
				echo ' ' . esc_attr__( 'to', 'odin' ) . ' <span>&quot;' . get_the_title() . '&quot;</span>';
				?>
			</h2>

			<div class="odin-comments__list">
				<?php
				// Displays all comments
				wp_list_comments( array(
					'callback' => 'odin_comments_loop',
				) ); ?>
			</div>

			<?php
			// Comments pagination.
			the_comments_pagination( array(
				'prev_text' => __( '&larr; Old Comments', 'odin' ),
				'next_text' => __( 'New Comments &rarr;', 'odin' ),
			) );
		endif; // Check for have_comments().

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
			<div class="odin-comments__noComments">
				<p><?php esc_attr_e( 'Comments closed.', 'odin' ); ?></p>
			</div>
		<?php
		endif; ?>

		<?php
		// Comment form.
		get_template_part( 'components/form/form-comment' ); ?>

	</div>

</section><!-- #comments -->
