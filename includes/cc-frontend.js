/**
 * cc-frontend.
 *
 * Renders the background change.
 *
 * @link   URL
 * @file   cc-frontend.js
 * @author mikesm1118
 * @since  0.1.0
 */

jQuery( document ).ready( function() {
	jQuery( 'body' ).addClass( 'cc-custom-background' );
	jQuery( 'body.cc-custom-background' ).attr( 'style', 'background-color: ' +  ccBG[0] + ' !important' );
} );
