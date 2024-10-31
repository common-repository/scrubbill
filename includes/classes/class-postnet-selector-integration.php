<?php
/**
 * PostNet Selector Integration.
 *
 * Handles integration of the PostNet selector with WooCommerce Blocks.
 *
 * @since 1.1
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

/**
 * Class PostNet_Selector_Integration
 *
 * @since 1.1
 */
class PostNet_Selector_Integration implements IntegrationInterface {

	/**
	 * The name of the integration.
	 *
	 * @since 1.1
	 *
	 * @return string
	 */
	public function get_name() {
		return 'postnet-selector';
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 *
	 * @since 1.1
	 *
	 * @return void
	 */
	public function initialize() {
		$this->register_editor_scripts();
		$this->register_frontend_scripts();
		$this->register_main_integration();
	}

	/**
	 * Get script handles.
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	public function get_script_handles() {
		return array( 'postnet-selector-integration', 'postnet-selector-frontend' );
	}

	/**
	 * Get editor script handles.
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	public function get_editor_script_handles() {
		return array( 'postnet-selector-integration', 'postnet-selector-editor' );
	}

	/**
	 * Get script data.
	 *
	 * @since 1.1
	 *
	 * @return array
	 */
	public function get_script_data() {
		// Get PostNet branches.
		$branches        = array();
		$cached_branches = get_option( Scrubbill_Shipping_Method::POSTNET_BRANCHES_KEY );

		if ( ! empty( $cached_branches ) ) {
			foreach ( $cached_branches as $branch_id => $branch ) {
				$branches[] = array(
					'id'       => $branch_id,
					'name'     => $branch['name'],
					'suburb'   => $branch['suburb'],
					'postcode' => $branch['postcode'],
				);
			}
		}

		return array(
			'postnetBranches' => $branches,
		);
	}

	/**
	 * Registers the main JS file required to add filters and Slot/Fills.
	 *
	 * @since 1.1
	 *
	 * @return void
	 */
	private function register_main_integration() {
		$script_asset = require SCRUBBILL_DIR . 'build/index.asset.php';

		wp_enqueue_style(
			'postnet-selector-editor',
			SCRUBBILL_URL . 'build/blocks/postnet-selector/style-index.css',
			array(),
			'1.0'
		);

		wp_register_script(
			'postnet-selector-integration',
			SCRUBBILL_URL . 'build/index.js',
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_set_script_translations(
			'postnet-selector-integration',
			'scrubbill',
			SCRUBBILL_DIR . 'languages'
		);
	}

	/**
	 * Register the editor scripts.
	 *
	 * @since 1.1
	 *
	 * @return void
	 */
	public function register_editor_scripts() {
		$script_asset = require SCRUBBILL_DIR . 'build/blocks/postnet-selector/index.asset.php';

		wp_enqueue_style(
			'postnet-selector-editor',
			SCRUBBILL_URL . 'build/blocks/postnet-selector/style-index.css',
			array(),
			'1.0'
		);

		wp_register_script(
			'postnet-selector-editor',
			SCRUBBILL_URL . 'build/blocks/postnet-selector/index.js',
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_set_script_translations(
			'postnet-selector-editor',
			'scrubbill',
			SCRUBBILL_DIR . 'languages'
		);
	}

	/**
	 * Register the frontend scripts for displaying the PostNet selector block.
	 *
	 * @since 1.1
	 *
	 * @return void
	 */
	public function register_frontend_scripts() {
		$script_asset = require SCRUBBILL_DIR . 'build/blocks/postnet-selector/frontend.asset.php';

		wp_register_script(
			'postnet-selector-frontend',
			SCRUBBILL_URL . 'build/blocks/postnet-selector/frontend.js',
			$script_asset['dependencies'],
			$script_asset['version'],
			true
		);

		wp_set_script_translations(
			'postnet-selector-frontend',
			'scrubbill',
			SCRUBBILL_DIR . 'languages'
		);
	}
}
