/**
 * External dependencies
 */
import { registerPlugin } from '@wordpress/plugins';

const render = () => {};

registerPlugin( 'postnet-selector', {
	render,
	scope: 'woocommerce-checkout',
} );
