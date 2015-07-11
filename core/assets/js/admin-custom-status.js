(function ( $ ) {
	'use strict';

	/**
	 * Custom post status
	 */
	$( window ).load( function() {
		$( 'meta.odin-custom-status-meta' ).each( function() {
			if( $( document.body ).hasClass( 'post-php' ) || $( document.body ).hasClass( 'post-new-php' ) ) {
				console.log('ahoy');
				var select = '';
				if( typeof args.select !== 'undefined' ) {
					select = 'selected="selected"';
					$( 'label[for="post_status"]').append( '<span id="post-status-display">&nbsp;' + $.trim( args.appliedLabel ) + '</span>' );
				}
				var html = '<option value="' + $.trim( args.slug ) + '" ' + $.trim( select ) + '>' + $.trim( args.appliedLabel ) + '</option>';
				$( '#post_status' ).append( html );
			}
			if( $( document.body ).hasClass( 'edit-php' ) ) {
				var args = $.parseJSON( $(this).attr('value') );
				var html = '<option value="' + $.trim( args.slug ) + '">' + $.trim( args.appliedLabel ) + '</option>';
				$( '.inline-edit-status select' ).each(function(){
					$(this).append( html );
				});
			}
		});
	});
}( jQuery ));
