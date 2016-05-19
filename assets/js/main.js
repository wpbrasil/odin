jQuery(document).ready(function($) {
	// fitVids.
	$( '.entry-content' ).fitVids();

	// Responsive wp_video_shortcode().
	$( '.wp-video-shortcode' ).parent( 'div' ).css( 'width', 'auto' );

	/**
	 * Odin Core shortcodes
	 */

	// Tabs.
	$( '.odin-tabs a' ).click(function(e) {
		e.preventDefault();
		$(this).tab( 'show' );
	});

	// Tooltip.
	//$( '.odin-tooltip' ).tooltip();

	// Moment
	$( '.entry-date' ).each(function() {
  		$(this).text( 'há ' + moment( $(this).data('datetime') ).startOf('hour').fromNow() );
	});

});
