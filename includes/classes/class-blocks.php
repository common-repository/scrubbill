<?php
/**
 * Blocks
 *
 * Handles blocks and block integrations.
 *
 * @since 1.1
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Blocks
 *
 * @since 1.1
 */
class Blocks {

	/**
	 * Hooks.
	 *
	 * @since 1.1
	 */
	public function hooks() {
		add_action( 'woocommerce_blocks_checkout_block_registration', array( $this, 'register_integrations' ) );
		add_action( 'block_categories_all', array( $this, 'register_block_categories' ), 10, 2 );
	}

	/**
	 * Register block integrations.
	 *
	 * @since 1.1
	 *
	 * @param object $integration_registry The integration registry.
	 *
	 * @return void
	 */
	public function register_integrations( $integration_registry ) {
		$integrations = array(
			new PostNet_Selector_Integration(),
		);

		foreach ( $integrations as $integration ) {
			$integration_registry->register( $integration );
		}
	}

	/**
	 * Register block categories.
	 *
	 * @since 1.1
	 *
	 * @param array $categories Existing block categories.
	 * @return array
	 */
	public function register_block_categories( $categories ) {
		return array_merge(
			$categories,
			array(
				array(
					'slug'  => 'scrubbill',
					'title' => __( 'Scrubbill Blocks', 'shipping-workshop' ),
				),
			)
		);
	}
}
