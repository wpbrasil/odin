(function ( $ ) {
	'use strict';

	/**
	 * Custom post status
	 */
	$( window ).load( function() {
		var $odinMeta = document.querySelectorAll( 'meta.odin-custom-status-meta' );
		Array.prototype.forEach.call( $odinMeta, function( item ) {
			var $meta = $( item );
			var args = $.parseJSON( $meta.attr( 'value' ) );

			if( $( document.body ).hasClass( 'post-php' ) || $( document.body ).hasClass( 'post-new-php' ) ) {
				var select = '';
				if( args.select ) {
					console.log('ahoy!');
					select = 'selected="selected"';
					$( 'label[for="post_status"]' ).append( '<span id="post-status-display">&nbsp;' + $.trim( args.appliedLabel ) + '</span>' );
				}
				var html = '<option value="' + $.trim( args.slug ) + '" ' + $.trim( select ) + '>' + $.trim( args.appliedLabel ) + '</option>';
				$( '#post_status' ).append( html );
			}
			if( $( document.body ).hasClass( 'edit-php' ) ) {
				var html = '<option value="' + $.trim( args.slug ) + '">' + $.trim( args.appliedLabel ) + '</option>';
				var $inlineStatus = document.querySelectorAll( '.inline-edit-status select' );
				Array.prototype.forEach.call( $inlineStatus, function( item ) {
					$( item ).append( html );
				});
			}
		});
	});
}( jQuery ));
