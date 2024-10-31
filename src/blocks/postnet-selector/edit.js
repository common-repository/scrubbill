/**
 * External dependencies
 */
import { useBlockProps } from '@wordpress/block-editor';
import { SelectControl, Disabled } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import './style.scss';

export const Edit = () => {
	const blockProps = useBlockProps();

	return (
		<div { ...blockProps } style={ { display: 'block' } }>
			<h2>{ __( 'PostNet Branch', 'scrubbill' ) }</h2>
			<Disabled>
				<SelectControl options={ [ { label: __( 'Select a PostNet', 'scrubbill' ), value: '' } ] } />
			</Disabled>
		</div>
	);
}

