<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package Odin
 * @since 1.9.0
 */
?>
<div class="post no-results not-found">
	<header class="entry-header">
		<h1 class="entry-title"><?php _e( 'Nothing Found', 'odin' ); ?></h1>
	</header><!-- .entry-header -->
	<div class="entry-content">
		<p><?php _e( 'No results were found for the requested archive. Maybe a search can help you to find any related post.', 'odin' ); ?></p>
		<?php get_search_form(); ?>
	</div><!-- .entry-content -->
</div><!-- .no-results -->
