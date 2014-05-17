<?php

add_filter( 'edd_downloads_query', 'DRMC_Med_Staff_EDD::sumobi_edd_downloads_query', 10, 2 );
add_action( 'edd_purchase_form_user_info', 'DRMC_Med_Staff_EDD::pippin_edd_custom_checkout_fields');
add_filter( 'edd_payment_meta', 'DRMC_Med_Staff_EDD::pippin_edd_store_custom_fields');
add_action( 'edd_payment_personal_details_list', 'DRMC_Med_Staff_EDD::pippin_edd_purchase_details', 10, 2);
add_filter( 'edd_sale_notification', 'DRMC_Med_Staff_EDD::pippin_edd_sale_notification', 10, 3 );
add_filter( 'edd_download_supports', 'DRMC_Med_Staff_EDD::pw_edd_add_author_support');


class DRMC_Med_Staff_EDD {
	public function sumobi_edd_downloads_query( $query, $atts ) {
		global $wp_query;

		if ( 'cme-symposia-tickets' === $wp_query->query_vars['pagename'] ) {
			$query['meta_key'] = '_tribe_eddticket_for_event';
		}
		return $query;
	}

	// output our custom field HTML
	public function pippin_edd_custom_checkout_fields() { ?>
		<p>
			<label class="edd-label" for="drmc-memo"><?php _e('Memo', 'drmc'); ?></label>
			<input class="edd-input required" type="text" name="drmc_memo" id="drmc-memo" placeholder="<?php _e('Memo', 'drmc'); ?>" value=""/>
		</p>
	<?php }

	// store the custom field data in the payment meta
	public function pippin_edd_store_custom_fields( $payment_meta ) {
		$payment_meta['memo']   = isset( $_POST['drmc_memo'] ) ? sanitize_text_field( $_POST['drmc_memo'] ) : '';
		return $payment_meta;
	}

	// show the custom fields in the "View Order Details" popup
	public function pippin_edd_purchase_details( $payment_meta, $user_info ) {
		$memo = isset( $payment_meta['memo'] ) ? $payment_meta['memo'] : 'none';
		?>
		<li><?php echo __('Memo:', 'drmc') . ' ' . $memo; ?></li>
		<?php
	}

	public function pippin_edd_sale_notification( $email_body, $payment_id, $payment_data ) {
		// retrieve payment meta array and unserialize it
		$payment_meta = maybe_unserialize( get_post_meta( $payment_id, '_edd_payment_meta', true ) );

		// add your fields here
		$memo = $payment_meta['memo'];

		// append information to email body
		$email_body .= '<br /><br />' . '<strong>Additional Information</strong>' . '<br />';
		$email_body .= 'Memo: ' . $memo . '<br />';

		return $email_body;
	}

	public function pw_edd_add_author_support( $supports ) {
		$supports[] = 'author';
		return $supports;	
	}

}