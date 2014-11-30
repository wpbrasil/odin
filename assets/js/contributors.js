;(function( $ ) {
    var Contributors = (function() {
        var $public = {};
        var $private = {};

        $public.init = function init() {
            $private.getContributors();
        };

        $private.getContributors = function getContributors() {
            $.get( 'https://api.github.com/repos/wpbrasil/odin/contributors' )
            .success(function( members ) {
                var contributors = members.map(function( member ) {
                    return $private.getColaboratorTemplate( member );
                });

                $( '[data-js="contributors"]' ).append( contributors );
            });
        };

        $private.colaboratorTemplate = function colaboratorTemplate() {
            return '' +
            '<div class="member">' +
                '<a href="#{{url}}" title="@#{{login}}" target="_blank" class="thumbnail">' +
                    '<img src="#{{avatar}}" alt="@#{{login}}" width="75" height="75" />' +
                '</a>' +
            '</div>';
        };

        $private.getColaboratorTemplate = function getColaboratorTemplate( data ) {
            return $private.colaboratorTemplate()
                .split( '#{{url}}' ).join( data.url )
                .split( '#{{login}}' ).join( data.login )
                .split( '#{{avatar}}' ).join( data.avatar_url );
        };

        return $public;
    });

    return Contributors().init();
})( jQuery );