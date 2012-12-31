<?php

add_filter( 'user_contactmethods', 'DRMCMedStaffAdmin::remove_contactmethods', 100 );

class DRMCMedStaffAdmin {

	function __construct() {
		
		// Add additional custom fields to profile page
		// http://pastebin.com/0zhWAtqY
		add_action ( 'show_user_profile', array($this, 'wpq_show_extra_profile_fields') );
		add_action ( 'edit_user_profile', array($this, 'wpq_show_extra_profile_fields') );

		// Save data input from custom field on profile page

		add_action ( 'personal_options_update', array($this, 'wpq_save_extra_profile_fields') );
		add_action ( 'edit_user_profile_update', array($this, 'wpq_save_extra_profile_fields') );
	}
	
	
	public function remove_contactmethods($user_contactmethods) {
		// You can get rid of ones you don't want
		unset($user_contactmethods['jabber']);
		unset($user_contactmethods['yim']);
		unset($user_contactmethods['aim']);

		//Added by WordPress SEO
		unset($user_contactmethods['googleplus']);
		unset($user_contactmethods['twitter']);

		return $user_contactmethods;
	}


	function wpq_show_extra_profile_fields ( $user ) {
		$drmcmedstaff = DRMCMedStaff::instance();

		?>
			<h3><?php _e( 'Extra Profile Info'); ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="drmc_department" id="drmc_department"><?php _e( 'Department' ); ?></label></th>
					<td>
						<?php $drmcmedstaff::make_dropdown( $user ); ?>
					</td>
				</tr>
			</table>
		<?php
	}


	function wpq_save_extra_profile_fields( $user_id ) {
		if ( ! current_user_can( 'add_users' ) ) { return false; }
		
		// copy this line for other fields
		update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
	}

}

