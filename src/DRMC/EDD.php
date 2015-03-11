<?php

namespace Fragen\DRMC;

add_filter( 'edd_downloads_query', 'Fragen\DRMC\EDD::edd_downloads_query', 10, 2 );
add_action( 'edd_purchase_form_user_info', 'Fragen\DRMC\EDD::edd_custom_checkout_fields');
add_filter( 'edd_payment_meta', 'Fragen\DRMC\EDD::edd_store_custom_fields', 10, 1 );
add_action( 'edd_payment_personal_details_list', 'Fragen\DRMC\EDD::edd_purchase_details', 10, 2);
add_filter( 'edd_sale_notification', 'Fragen\DRMC\EDD::edd_sale_notification', 10, 3 );
add_filter( 'edd_download_supports', 'Fragen\DRMC\EDD::edd_add_author_support', 10, 1 );
add_filter( 'edd_purchase_form_required_fields', 'Fragen\DRMC\EDD::edd_required_checkout_fields', 10, 1 );

/**
 * Add a {memo} tag for use in either the purchase receipt email or admin notification emails
 */
if ( function_exists( 'edd_add_email_tag' ) ) {
	edd_add_email_tag( 'memo', 'Purchase memo', 'Fragen\DRMC\EDD::edd_email_tag_memo' );
}


class EDD {

	public static function edd_downloads_query( $query, $atts ) {
		global $wp_query;

		if ( 'cme-symposia-tickets' === $wp_query->query_vars['pagename'] ) {
			$query['meta_key'] = '_tribe_eddticket_for_event';
		}

		return $query;
	}

	// output our custom field HTML
	public static function edd_custom_checkout_fields() {
		?>
		<p>
			<label class="edd-label" for="drmc-memo"><?php _e('Memo', 'drmc'); ?></label>
			<input class="edd-input required" type="text" name="drmc_memo" id="drmc-memo" placeholder="<?php _e('Memo', 'drmc'); ?>" value=""/>
		</p>
		<?php
	}

	// store the custom field data in the payment meta
	public static function edd_store_custom_fields( $payment_meta ) {
		$payment_meta['memo'] = isset( $_POST['drmc_memo'] ) ? sanitize_text_field( $_POST['drmc_memo'] ) : '';

		return $payment_meta;
	}

	// show the custom fields in the "View Order Details" popup
	public static function edd_purchase_details( $payment_meta, $user_info ) {
		$memo = isset( $payment_meta['memo'] ) ? $payment_meta['memo'] : 'none';
		?>
		<div class="column-container">
			<div class="column">
				<strong><?php echo __('Memo:', 'drmc'); ?></strong>&nbsp;<?php echo $memo; ?>
			</div>
		</div>
		<?php
	}

	public static function edd_sale_notification( $email_body, $payment_id, $payment_data ) {
		// retrieve payment meta array and unserialize it
		$payment_meta = maybe_unserialize( get_post_meta( $payment_id, '_edd_payment_meta', true ) );

		// add your fields here
		$memo = $payment_meta['memo'];

		// append information to email body
		$email_body .= '<br /><br />' . '<strong>Additional Information</strong>' . '<br />';
		$email_body .= 'Memo: ' . $memo . '<br />';

		return $email_body;
	}

	public static function edd_add_author_support( $supports ) {
		$supports[] = 'author';

		return $supports;	
	}

	/**
	 * The {memo} email tag
	 */
	public static function edd_email_tag_memo( $payment_id ) {
		$payment_data = edd_get_payment_meta( $payment_id );
		return $payment_data['memo'];
	}

	/**
	 * Make memo required
	 * Add more required fields here if you need to
	 */
	public static function edd_required_checkout_fields( $required_fields ) {
		$required_fields = array(
			'drmc_memo' => array(
				'error_id' => 'invalid_memo',
				'error_message' => 'Please enter a purchase memo'
			),
		);

		return $required_fields;
	}

}