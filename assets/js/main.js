jQuery(document).ready(function($) {

	/**
	 * Responsive wp_video_shortcode().
	 */
	$( '.wp-video-shortcode' ).parent( 'div' ).css( 'width', 'auto' );

	/**
	 * Fluid width video embeds. (http://fitvidsjs.com)
	 */
	$( '.entry-content' ).fitVids();

	/**
	 * Relative time to date posts. (http://momentjs.com)
	 */
	$( '.entry-date' ).each(function() {
  		$(this).text( moment( $(this).children('time').attr('datetime'), moment.ISO_8601, $('html').attr('lang') ).startOf('hour').fromNow() );
	});

	/**
	 * Odin Core shortcodes.
	 */

	// Tabs.
	//$( '.odin-tabs a' ).click(function(e) {
	//	e.preventDefault();
	//	$(this).tab( 'show' );
	//});

	// Tooltip.
	//$( '.odin-tooltip' ).tooltip();

});
