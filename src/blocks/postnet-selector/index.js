/**
 * External dependencies
 */
import { registerBlockType } from '@wordpress/blocks';

/**
 * Internal dependencies
 */
import { Edit } from './edit';
import metadata from './block.json';

registerBlockType( metadata, {
	edit: Edit,
} );
