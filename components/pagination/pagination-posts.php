<?php
/**
 * Pagination posts.
 *
 * @link https://developer.wordpress.org/themes/functionality/pagination
 *
 * @package Odin
 * @subpackage Custom_Theme
 */

?>

<div class="odin-pagination-posts">
	<?php
	/*
	* Numerical Pagination.
	*
	* You must use paginate_links() iIf you want your pagination
	* to support older versions of(For WordPress prior to 4.1) WordPress.
	*/
	the_posts_pagination(); ?>
</div>
