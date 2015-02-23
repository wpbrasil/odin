<?php
/**
 * Custom template tags used to integrate this theme with WooCommerce.
 *
 * @package odin
 */

if ( ! function_exists( 'odin_cart_link' ) ) {
	/**
	 * Cart Link
	 * Displayed a link to the cart including the number of items present and the cart total
	 * @param  array $settings Settings
	 * @return array           Settings
	 * @since  2.2.6
	 */
	function odin_cart_link() {
		if ( is_cart() ) {
			$class = 'current-menu-item active';
		} else {
			$class = '';
		}
		?>
		<li class="<?php echo esc_attr( $class ); ?>">
			<a class="cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" title="<?php _e( 'View your shopping cart', 'odin' ); ?>">
				<?php echo wp_kses_data( WC()->cart->get_cart_total() ); ?> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'odin' ), WC()->cart->get_cart_contents_count() ) );?></span>
			</a>
		</li>
		<?php
	}
}

if ( ! function_exists( 'odin_product_search' ) ) {
	/**
	 * Display Product Search
	 * @since  2.2.6
	 * @uses  is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function odin_product_search() {
		if ( is_woocommerce_activated() ) { ?>
			<div class="site-search">
				<?php the_widget( 'WC_Widget_Product_Search', 'title=' ); ?>
			</div>
		<?php
		}
	}
}

if ( ! function_exists( 'odin_header_cart' ) ) {
	/**
	 * Display Header Cart
	 * @since  2.2.6
	 * @uses  is_woocommerce_activated() check if WooCommerce is activated
	 * @return void
	 */
	function odin_header_cart() {
		if ( is_woocommerce_activated() ) { ?>
			<ul class="site-header-cart menu">
				<?php odin_cart_link(); ?>
				<?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
			</ul>
		<?php
		}
	}
}