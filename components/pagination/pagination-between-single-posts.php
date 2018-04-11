<?php
/**
 * Pagination Between Single Posts.
 *
 * @link https://developer.wordpress.org/themes/functionality/pagination/#pagination-between-single-posts
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<nav class="odin-pagination-between-single-posts">

	<?php previous_post_link( '<div class="odin-pagination-between-single-posts__item"><span>&laquo; %link</span></div>' ); ?>

	<?php next_post_link( '<div class="odin-pagination-between-single-posts__item"><span>%link &raquo;</span></div>' ); ?>

</nav>
