/**
 * Dependencies
 */
const path = require( 'path' );
const defaultConfig = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
    ...defaultConfig,
    entry: {
		index: path.resolve( process.cwd(), 'src', 'index.js' ),
		'blocks/postnet-selector/index': path.resolve(
			process.cwd(),
			'src',
			'blocks',
			'postnet-selector',
			'index.js'
		),
		'blocks/postnet-selector/frontend': path.resolve(
			process.cwd(),
			'src',
			'blocks',
			'postnet-selector',
			'frontend.js'
		),
	}
}
