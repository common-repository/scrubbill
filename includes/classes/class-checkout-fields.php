<?php
/**
 * Checkout Fields.
 *
 * Custom fields for the checkout process.
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */

namespace Scrubbill\Plugin\Scrubbill;

/**
 * Class Checkout_Fields
 *
 * @since 1.0
 *
 * @package Scrubbill\Plugin\Scrubbill
 */
class Checkout_Fields {

	/**
	 * Postnet branch ID order custom field key.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const POSTNET_BRANCH_KEY = 'scrubbill_postnet_branch_id';

	/**
	 * Postnet branch key for storing the branch name.
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	const POSTNET_BRANCH_NAME_KEY = 'scrubbill_postnet_branch_name';

	/**
	 * Hooks.
	 *
	 * @since 1.0
	 */
	public function hooks() {
		add_action( 'woocommerce_review_order_after_shipping', array( $this, 'render_postnet_selector' ) );
		add_action( 'woocommerce_after_checkout_validation', array( $this, 'validate_postnet_field' ), 10, 2 );
		add_action( 'woocommerce_checkout_create_order', array( $this, 'save_postnet_field' ), 10, 1 );
		add_action( 'woocommerce_before_order_itemmeta', array( $this, 'show_postnet_branch' ), 10, 2 );
	}

	/**
	 * Render Postnet selector custom field.
	 *
	 * @since 1.0
	 */
	public function render_postnet_selector() {
		$shipping_method = WC()->session->get( 'chosen_shipping_methods' );

		// Only show this form when Postnet has been selected.
		if ( 'POSTNET' !== $shipping_method[0] ) {
			return;
		}
		?>
		<tr class="shipping-postnet">
			<th><?php esc_html_e( 'PostNet Branch', 'scrubbill' ); ?></th>
			<td>
				<script>
					(function($){
						$(document).ready(function(){
							$('#scrubbill_postnet_branch_id').selectWoo({
								matcher: function(params, data) {
									// Custom matcher to search branch name and suburb.
									if ($.trim(params.term) === '') {
										return data;
									}

									if (typeof data.text === 'undefined') {
										return null;
									}

									const text = data.text.toLowerCase(),
										term = params.term.toLowerCase();

									if (text.indexOf(term) > -1) {
										return data;
									}

									const suburb = $(data.element).data('suburb');
									if (suburb !== undefined && suburb.toString().toLowerCase().indexOf(term) > -1) {
										return data;
									}

									return null;
								}
							});
						});
					})(jQuery);
				</script>
				<select name="<?php echo esc_attr( self::POSTNET_BRANCH_KEY ); ?>" id="scrubbill_postnet_branch_id" class="select" data-allow_clear="true" data-placeholder="<?php echo esc_attr( __( 'Select a PostNet', 'scrubbill' ) ); ?>" style="width: 100%;" required>
					<option value=""><?php echo esc_html( __( 'Select a PostNet', 'scrubbill' ) ); ?></option>
					<?php
					$branches = $this->get_postnet_branches();

					if ( ! empty( $branches ) ) :
						foreach ( $branches as $key => $branch ) :
							if ( is_array( $branch ) ) :
								?>
							<option value="<?php echo esc_attr( $key ); ?>" data-suburb="<?php echo esc_attr( $branch['suburb'] ) . ' ' . esc_attr( $branch['postcode'] ); ?>"><?php echo esc_html( $branch['name'] ); ?></option>
							<?php else : ?>
							<option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $branch ); ?></option>
								<?php
							endif;
						endforeach;
					endif;
					?>
				</select>
			</td>
		</tr>
		<?php
	}

	/**
	 * Make sure the user enters a Postnet branch if they selected the Postnet shipping method.
	 *
	 * @param array  $fields The form fields.
	 * @param object $errors Errors object.
	 *
	 * @since 1.0
	 */
	public function validate_postnet_field( $fields, $errors ) {
		if (
			empty( $_POST['shipping_method'][0] ) || 'POSTNET' !== sanitize_text_field( wp_unslash( $_POST['shipping_method'][0] ) ) ) { // @phpcs:ignore
			return;
		}

		if ( empty( $_POST[ self::POSTNET_BRANCH_KEY ] ) ) { // @phpcs:ignore
			$errors->add( 'validation', __( 'Please select a PostNet branch.', 'scrubbill' ) );
		}
	}

	/**
	 * Save the postnet field that was selected.
	 *
	 * @since 1.0
	 *
	 * @param object $order The order object.
	 */
	public function save_postnet_field( $order ) {
		if ( ! empty( $_POST[ self::POSTNET_BRANCH_KEY ] ) ) { // @phpcs:ignore
			$branch_id = sanitize_text_field( wp_unslash( $_POST[ self::POSTNET_BRANCH_KEY ] ) ); // @phpcs:ignore
			$order->update_meta_data( self::POSTNET_BRANCH_KEY, $branch_id );

			$branches    = $this->get_postnet_branches();
			$branch_name = ! empty( $branches[ $branch_id ]['name'] ) ? $branches[ $branch_id ]['name'] : '';

			if ( ! empty( $branch_name ) ) {
				$order->update_meta_data( self::POSTNET_BRANCH_NAME_KEY, $branch_name );
			}
		}
	}

	/**
	 * Display the Postnet branch that the user selected.
	 *
	 * @since 1.0
	 *
	 * @param int    $item_id The ID of the item.
	 * @param object $item The item object.
	 */
	public function show_postnet_branch( $item_id, $item ) {
		if ( ! is_object( $item ) || ! is_a( $item, 'WC_Order_Item_Shipping' ) ) {
			return;
		}

		$order       = $item->get_order();
		$branch_name = $order->get_meta( self::POSTNET_BRANCH_NAME_KEY );

		if ( ! empty( $branch_name ) ) {
			?>
			<div class="view">
				<?php esc_html_e( 'Postnet branch:', 'scrubbill' ); ?>
				<?php echo esc_html( $branch_name ); ?>
			</div>
			<?php
		}
	}

	/**
	 * Get Postnet branches.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	protected function get_postnet_branches() {
		return get_option( Scrubbill_Shipping_Method::POSTNET_BRANCHES_KEY );
	}
}
