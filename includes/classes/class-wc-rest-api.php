<?php
/**
 * WC_Rest_API
 *
 * Extend the WC Rest API.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

use Automattic\WooCommerce\Blocks\StoreApi\Schemas\CheckoutSchema;

/**
 * Class WC_Rest_API
 *
 * @since 1.0
 */
class WC_Rest_API {

	/**
	 * The namespace of the extension.
	 *
	 * @since 1.1
	 */
	const POSTNET_EXTENSION_NAMESPACE = 'postnet-selector';

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		add_filter( 'woocommerce_rest_orders_prepare_object_query', array( $this, 'add_date_modified_parameter' ), 10, 2 );
		add_action( 'init', array( $this, 'extend_checkout_endpoint' ) );
		add_action( 'woocommerce_store_api_checkout_update_order_from_request', array( $this, 'save_postnet_meta' ), 10, 2 );
	}

	/**
	 * Adds the ability to query orders from the WooCommerce REST API by last modified date.
	 *
	 * @param array            $args Query arguments.
	 * @param \WP_REST_Request $request The REST request object.
	 *
	 * @since  1.0
	 * @return array
	 */
	public function add_date_modified_parameter( $args, $request ) {
		$modified_after = $request->get_param( 'modified_after' );

		if ( empty( $modified_after ) ) {
			return $args;
		}

		$args['date_query'][0]['column'] = 'post_modified';
		$args['date_query'][0]['after']  = $modified_after;

		return $args;
	}

	/**
	 * Extend the endpoint to allow for PostNet data.
	 *
	 * @since 1.1
	 *
	 * @return void
	 */
	public function extend_checkout_endpoint() {
		$extend = \Automattic\WooCommerce\StoreApi\StoreApi::container()->get( \Automattic\WooCommerce\StoreApi\Schemas\ExtendSchema::class );

		if ( is_callable( array( $extend, 'register_endpoint_data' ) ) ) {
			$extend->register_endpoint_data(
				array(
					'endpoint'        => CheckoutSchema::IDENTIFIER,
					'namespace'       => self::POSTNET_EXTENSION_NAMESPACE,
					'schema_callback' => array( $this, 'extend_checkout_schema' ),
					'schema_type'     => ARRAY_A,
				)
			);
		}
	}

	/**
	 * Extend the schema to include branchID.
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	public function extend_checkout_schema() {
		return array(
			'branchId' => array(
				'description' => 'ID of the PostNet branch',
				'type'        => 'integer',
				'context'     => array( 'view', 'edit' ),
				'readonly'    => true,
				'optional'    => true,
				'arg_options' => array(
					'validate_callback' => null,
				),
			),
		);
	}

	/**
	 * Save the PostNet meta data on the API request.
	 *
	 * @since 1.1
	 *
	 * @param object $order The order object.
	 * @param object $request The request object.
	 *
	 * @return void
	 */
	public function save_postnet_meta( $order, $request ) {
		$postnet_data = $request['extensions'][ self::POSTNET_EXTENSION_NAMESPACE ];

		if ( ! empty( $postnet_data['branchId'] ) ) {
			$order->update_meta_data( Checkout_Fields::POSTNET_BRANCH_KEY, $postnet_data['branchId'] );

			$branches    = get_option( Scrubbill_Shipping_Method::POSTNET_BRANCHES_KEY );
			$branch_name = ! empty( $branches[ $postnet_data['branchId'] ]['name'] ) ? $branches[ $postnet_data['branchId'] ]['name'] : '';

			if ( ! empty( $branch_name ) ) {
				$order->update_meta_data( Checkout_Fields::POSTNET_BRANCH_NAME_KEY, $branch_name );
			}
		}

		$order->save();
	}
}
