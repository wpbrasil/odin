<?php
/**
 * The template for displaying search form.
 *
 * @package odin
 *
 */

?>

<form method="get" id="searchform" class="form-inline" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<div class="input-group">
		<input type="search" class="form-control" name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="<?php esc_attr_e( 'Search', 'odin' ); ?>" />
		<span class="input-group-btn">
			<button type="submit" class="btn btn-default" value="<?php esc_attr_e( 'Search', 'odin' ); ?>">
				<i class="glyphicon glyphicon-search"></i>
			</button>
		</span>
	</div>
</form>
