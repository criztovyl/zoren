( function( $ ) {
	$( document ).ready( function() {

	// Widget title
	$( 'h1.widget-title' ).each( function() {
		if ( $( this ).is( ':empty' ) ) {
			$( this ).remove();
		}
	} );

	// Flickr widget remove <br />
	$( '.widget_flickr br' ).remove();

	// Placeholder
	if ( ( isInputSupported = 'placeholder' in document.createElement( 'input' ) )!== true ) {
        $( 'input[placeholder]' ).each( function() {
            if ( $( this ).val() == '' ) $( this ).val( $( this ).attr( 'placeholder' ) );
        } );
        $( 'input[placeholder]' ).focus( function() {
            if ( $( this ).attr( 'placeholder ') == $( this ).val() ) $( this ).val( '' );
        } );
        $( 'input[placeholder]' ).blur( function() {
            if ( $( this ).val()=='') $( this ).val( $( this ).attr( 'placeholder' ) );
        } );
    }

    });
} )( jQuery );