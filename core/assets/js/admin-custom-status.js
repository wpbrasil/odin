(function ( $ ) {
	'use strict';

	/**
	 * Custom post status
	 */
	$( window ).load( function() {
		var html = '';
		var label = false;
		var $odinMeta = document.querySelectorAll( 'meta.odin-custom-status-meta' );

		Array.prototype.forEach.call( $odinMeta, function( item ) {
			var $meta = $( item );
			var args = $.parseJSON( $meta.attr( 'value' ) );

			if( $( document.body ).hasClass( 'post-php' ) || $( document.body ).hasClass( 'post-new-php' ) ) {
				var select = '';
				if( args.select ) {
					select = 'selected="selected"';
					label = '<span id="post-status-display">&nbsp;' + $.trim( args.appliedLabel ) + '</span>';
				}
				html += '<option value="' + $.trim( args.slug ) + '" ' + $.trim( select ) + '>' + $.trim( args.appliedLabel ) + '</option>';
			}
			if( $( document.body ).hasClass( 'edit-php' ) ) {
				html += '<option value="' + $.trim( args.slug ) + '">' + $.trim( args.appliedLabel ) + '</option>';
			}
		});
		if( $( document.body ).hasClass( 'post-php' ) || $( document.body ).hasClass( 'post-new-php' ) ) {
			$( '#post_status ').append( html );
			if( label ) {
				$( 'label[for="post_status"]' ).append( label );
			}
		}
		if( $( document.body ).hasClass( 'edit-php' ) ) {
			var $inlineStatus = document.querySelectorAll( '.inline-edit-status select' );
			Array.prototype.forEach.call( $inlineStatus, function( item ) {
				$( item ).append( html );
			});
		}
	});
}( jQuery ));
