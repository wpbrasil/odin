(function ( $ ) {
	'use strict';

	/**
	 * Custom post status
	 */
	$( window ).load( function() {
		$( 'meta.odin-custom-status-meta' ).each( function() {
			var meta = $( this );
			if( $( document.body ).hasClass( 'post-php' ) || $( document.body ).hasClass( 'post-new-php' ) ) {
				var args = $.parseJSON( meta.attr( 'value' ) );
				var select = '';
				if( ! args.select ) {
					select = 'selected="selected"';
					$( 'label[for="post_status"]' ).append( '<span id="post-status-display">&nbsp;' + $.trim( args.appliedLabel ) + '</span>' );
				}
				var html = '<option value="' + $.trim( args.slug ) + '" ' + $.trim( select ) + '>' + $.trim( args.appliedLabel ) + '</option>';
				$( '#post_status' ).append( html );
			}
			if( $( document.body ).hasClass( 'edit-php' ) ) {
				var html = '<option value="' + $.trim( args.slug ) + '">' + $.trim( args.appliedLabel ) + '</option>';
				$( '.inline-edit-status select' ).each(function(){
					$( this ).append( html );
				});
			}
		});
	});
}( jQuery ));
