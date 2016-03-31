<?php

namespace Fragen\DRMC;


class EDD {

	public function __construct() {
		add_filter( 'edd_downloads_query', array( &$this, 'edd_downloads_query' ), 10, 2 );
		add_action( 'edd_purchase_form_user_info', array( &$this, 'edd_custom_checkout_fields' ) );
		add_filter( 'edd_payment_meta', array( &$this, 'edd_store_custom_fields' ), 10, 1 );
		add_action( 'edd_payment_personal_details_list', array( &$this, 'edd_purchase_details' ), 10, 2 );
		add_filter( 'edd_sale_notification', array( &$this, 'edd_sale_notification' ), 10, 3 );
		add_filter( 'edd_download_supports', array( &$this, 'edd_add_author_support' ), 10, 1 );
		add_filter( 'edd_purchase_form_required_fields', array( &$this, 'edd_required_checkout_fields' ), 10, 1 );
		add_filter( 'edd_email_preview_template_tags', array( &$this, 'edd_email_preview_template_tags' ), 10, 1 );

		/**
		 * Add a {memo} tag for use in either the purchase receipt email or admin notification emails
		 */
		if ( function_exists( 'edd_add_email_tag' ) ) {
			edd_add_email_tag( 'memo', 'Purchase memo', array( &$this, 'edd_email_tag_memo' ) );
		}

	}

	public function edd_downloads_query( $query, $atts ) {
		global $wp_query;

		if ( 'cme-symposia-tickets' === $wp_query->query_vars['pagename'] ) {
			$query['meta_key'] = '_tribe_eddticket_for_event';
		}

		return $query;
	}

	// output our custom field HTML
	public function edd_custom_checkout_fields() {
		?>
		<p>
			<label class="edd-label" for="drmc-memo"><?php _e( 'Memo', 'drmc' ); ?></label>
			<input class="edd-input required" type="text" name="drmc_memo" id="drmc-memo" placeholder="<?php _e( 'Memo', 'drmc' ); ?>" value="" />
		</p>
		<?php
	}

	// store the custom field data in the payment meta
	public function edd_store_custom_fields( $payment_meta ) {
		$payment_meta['memo'] = isset( $_POST['drmc_memo'] ) ? sanitize_text_field( $_POST['drmc_memo'] ) : '';

		return $payment_meta;
	}

	// show the custom fields in the "View Order Details" popup
	public function edd_purchase_details( $payment_meta, $user_info ) {
		$memo = isset( $payment_meta['memo'] ) ? $payment_meta['memo'] : 'none';
		?>
		<div class="column-container">
			<div class="column">
				<strong><?php echo __( 'Memo:', 'drmc' ); ?></strong>&nbsp;<?php echo $memo; ?>
			</div>
		</div>
		<?php
	}

	public function edd_sale_notification( $email_body, $payment_id, $payment_data ) {
		// retrieve payment meta array and unserialize it
		$payment_meta = maybe_unserialize( get_post_meta( $payment_id, '_edd_payment_meta', true ) );

		// add your fields here
		$memo = $payment_meta['memo'];

		// append information to email body
		$email_body .= '<br /><br />' . '<strong>Additional Information</strong>' . '<br />';
		$email_body .= 'Memo: ' . $memo . '<br />';

		return $email_body;
	}

	public function edd_add_author_support( $supports ) {
		$supports[] = 'author';

		return $supports;
	}

	/**
	 * The {memo} email tag
	 */
	public function edd_email_tag_memo( $payment_id ) {
		$payment_data = edd_get_payment_meta( $payment_id );

		return $payment_data['memo'];
	}

	/**
	 * Make memo required
	 * Add more required fields here if you need to
	 */
	public function edd_required_checkout_fields( $required_fields ) {
		$required_fields = array(
			'drmc_memo' => array(
				'error_id'      => 'invalid_memo',
				'error_message' => 'Please enter a purchase memo',
			),
		);

		return $required_fields;
	}

	public function edd_email_preview_template_tags( $message ) {
		$message = str_replace( '{memo}', 'This is a purchase memo.', $message );

		return $message;
	}

}
