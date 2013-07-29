<?php

add_filter( 'user_contactmethods', 'DRMC_Med_Staff_Admin::remove_contactmethods', 100 );
//add columns to User panel list page
add_action( 'manage_users_custom_column', 'DRMC_Med_Staff_Admin::add_custom_user_columns', 15, 3 );
add_filter( 'manage_users_columns', 'DRMC_Med_Staff_Admin::add_user_columns', 15, 1 );

class DRMC_Med_Staff_Admin {

	public function __construct() {
		
		// Add additional custom fields to profile page
		// http://pastebin.com/0zhWAtqY
		add_action ( 'show_user_profile', array($this, 'wpq_show_extra_profile_fields') );
		add_action ( 'edit_user_profile', array($this, 'wpq_show_extra_profile_fields') );

		// Save data input from custom field on profile page
		add_action( 'personal_options_update', array($this, 'wpq_save_extra_profile_fields') );
		add_action( 'edit_user_profile_update', array($this, 'wpq_save_extra_profile_fields') );
		add_action( 'admin_print_scripts-profile.php', array( $this, 'hideAdminBar' ) );
		add_action( 'admin_print_styles-user-edit.php', array( $this, 'hideAdminBar' ) );

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


	public function wpq_show_extra_profile_fields ( $user ) {
		$drmcmedstaff = DRMC_Med_Staff::instance();

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


	public function wpq_save_extra_profile_fields( $user_id ) {
		if ( ! current_user_can( 'add_users' ) ) { return false; }
		
		// copy this line for other fields
		update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
	}

	//http://wordpress.org/support/topic/make-extra-columns-in-userphp-sortable?replies=17#post-2317114
	public function add_user_columns( $defaults ) {
		$defaults['drmc_department'] = 'Department';
		return $defaults;
	}

	public function add_custom_user_columns($value, $column_name, $id) {
		if( $column_name == 'drmc_department' )
			return get_the_author_meta( 'drmc_department', $id );
	}
	
	//hide toolbar option in profile - http://digwp.com/2011/04/admin-bar-tricks/
	public function hideAdminBar() { ?>
		<style type="text/css">.show-admin-bar { display: none; }</style>
		<?php }


}
