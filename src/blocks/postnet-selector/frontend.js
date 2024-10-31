/**
 * External dependencies
 */
const { registerCheckoutBlock } = wc.blocksCheckout;

/**
 * Internal dependencies
 */
import { Block } from './block';
import metadata from './block.json';

registerCheckoutBlock( {
	metadata,
	component: Block,
} );
