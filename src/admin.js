(function( $, app ) {
    'use strict';

    var options = {
        buttonClass: '.js-insert-getbeyond-link'
    };

    function openModal() {
        var url = null;
        var title = null;

        url = prompt( app.msg.url );

        if ( ! url ) {
            return;
        }

        title = prompt( app.msg.title );

        if ( ! title ) {
            return;
        }

        window.send_to_editor( buildShortcode( url, title ) );

        return;
    }

    function buildShortcode( href, title ) {
        var shortcode = null;

        shortcode = '[getbeyond href="';
        shortcode += href;
        shortcode += '"]';
        shortcode += title;
        shortcode += '[/getbeyond]';

        return shortcode;
    }

    $(options.buttonClass ).on("click", function(e) {
        e.preventDefault();
        openModal();
    });

}( jQuery, getbeyondioAdminJs ));
