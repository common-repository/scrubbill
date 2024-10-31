/**
 * External dependencies
 */
import { useEffect, useState, useCallback } from '@wordpress/element';
import { useSelect, useDispatch } from '@wordpress/data';
import { SelectControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { debounce } from 'lodash';

export const Block = ( { checkoutExtensionData, cart } ) => {
	const { setExtensionData } = checkoutExtensionData;	

	const debouncedSetExtensionData = useCallback(
		debounce( ( namespace, key, value ) => {
			setExtensionData( namespace, key, value );
		}, 1000 ),
		[ setExtensionData ]
	);

	const validationErrorId = 'postnet-selector';

	const { setValidationErrors, clearValidationError } = useDispatch(
		'wc/store/validation'
	);

	const validationError = useSelect( ( select ) => {
		const store = select( 'wc/store/validation' );
		return store.getValidationError( validationErrorId );
	} );

	const isPostNetSelected = () => {
		if (cart.shippingRates[0] == undefined) {
			return false;
		}

		const rate = cart.shippingRates[0].shipping_rates.find((item) => {
			if (item.selected == true && item.rate_id == 'POSTNET') {
				return true;
			}

			return false;
		});

		if ( rate != undefined ) {
			return true;
		}

		return false;
	}

	const [ showValidationError, setShowValidationError ] = useState( false );
	const [ branchId, setBranchId ] = useState( 0 );

	const checkout = useSelect( ( select ) => {
		const checkout = select( 'wc/store/checkout' );
		return checkout;
	} );

	useEffect( () => {
		debouncedSetExtensionData(
			'postnet-selector',
			'branchId',
			branchId
		);

		if ( branchId != 0 || ! isPostNetSelected() ) {
			if ( validationError ) {
				clearValidationError( validationErrorId );
			}
			return;
		}

		setValidationErrors( {
			[ validationErrorId ]: {
				message: __( 'Select a PostNet', 'scrubbill' ),
				hidden: true,
			},
		} );
	}, [ setExtensionData, branchId, validationError, validationErrorId, isPostNetSelected ] );

	const getOptions = () => {
		return wcSettings['postnet-selector_data'].postnetBranches.map( ( branch ) => {
			return {
				label: branch.name,
				value: branch.id
			};
		} );
	};

	const updateBranchId = ( formId ) => {
		let id = 0;
		
		if (formId != null && formId != '') {
			id = formId;
		}

		setBranchId( id );
	};

	return (
		isPostNetSelected() && (
			<div className="postnet-selector-wrapper" style={ { display: 'block' } }>
				<h2>{ __( 'PostNet Branch', 'scrubbill' ) }</h2>
				<SelectControl
					options={ [ { label: __( 'Select a PostNet', 'scrubbill' ), value: 0 }, ...getOptions() ] }
					onChange={ ( e ) => { updateBranchId( e ); setShowValidationError( true ); } }
				/>
				{ ((branchId == 0 && checkout.hasError()) || !validationError?.hidden || showValidationError) && (
					<div className="wc-block-components-validation-error">
						{ validationError?.message }
					</div>
				) }
			</div>
		)
	);
}