/**
 * Vendors
 */

// Bootstrap
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/alert.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/button.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/carousel.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/popover.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/scrollspy.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/tab.js')
//=include('../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/affix.js')

// FitVids
//=include('../../bower_components/jquery.fitvids/jquery.fitvids.js')

// Moment
//=include('../../bower_components/moment/min/moment.min.js')
//=include('../../bower_components/moment/locale/pt-br.js')


/**
 *	Main
 */

jQuery(document).ready(function($) {

	/**
	 * Responsive wp_video_shortcode().
	 */

	$( '.wp-video-shortcode' ).parent( 'div' ).css( 'width', 'auto' );

	/**
	 * Fluid width video embeds.
	 * @link http://fitvidsjs.com
	 */

	$( '.entry-content' ).fitVids();

	/**
	 * Relative time to date posts.
	 * @link http://momentjs.com
	 */

	moment.locale( $('html').attr('lang') );

	$( '.entry-date' ).each(function() {
  		$(this).text( moment( $(this).children('time').attr('datetime'), moment.ISO_8601 ).startOf('hour').fromNow() );
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
