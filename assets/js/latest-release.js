;(function( $ ) {
    $(document).ready(function() {
        $.get( 'https://api.github.com/repos/wpbrasil/odin/tags?per_page=1' )
        .success(function( release ) {
            $( '.download-odin' ).attr( 'href', release[0].zipball_url );
        });
    });
})( jQuery );
