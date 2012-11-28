<?php

add_filter( 'user_contactmethods', 'remove_contactmethods');
function remove_contactmethods($user_contactmethods) {
	// You can get rid of ones you don't want
	unset($user_contactmethods['jabber']);
	unset($user_contactmethods['yim']);
	unset($user_contactmethods['aim']);

	return $user_contactmethods;
}

// Add additional custom fields to profile page
// http://pastebin.com/0zhWAtqY

add_action ( 'show_user_profile', 'wpq_show_extra_profile_fields' );
add_action ( 'edit_user_profile', 'wpq_show_extra_profile_fields' );

function wpq_show_extra_profile_fields ( $user ) {

	if ( current_user_can( 'add_users' ) ) { //only admin user can edit department affiliation
	?>

		<h3><?php _e( 'Extra Profile Info'); ?></h3>
		<table class="form-table">
			<?php // duplicate this chunk (changing the meta field) for more fields ?>
			<tr>
				<th><label for="drmc-department" id="drmc-department"><?php _e( 'Department' ); ?></label></th>
				<td>
				<?php $value = get_the_author_meta( 'drmc-department', $user->ID ); ?>
				<select name="drmc-department" id="drmc-department">
					<option value="--" <?php selected( $value, '--' ); ?>>--</option>
					<option value="emergency-medicine" <?php selected( $value, 'emergency-medicine' ); ?>>Emergency Medicine</option>
					<option value="medicine" <?php selected( $value, 'medicine' ); ?>>Medicine</option>
					<option value="obstetrics-gynecology" <?php selected( $value, 'obstetrics-gynecology' ); ?>>Obstetrics/Gynecology</option>
					<option value="pediatrics" <?php selected( $value, 'pediatrics' ); ?>>Pediatrics</option>
					<option value="radiology" <?php selected( $value, 'radiology' ); ?>>Radiology</option>
					<option value="surgery" <?php selected( $value, 'surgery' ); ?>>Surgery</option>
				</select>
				</td>
			</tr>
			<?php // end of chunk ?>
		</table>
	<?php
	}
}

// Save data input from custom field on profile page

add_action ( 'personal_options_update', 'wpq_save_extra_profile_fields' );
add_action ( 'edit_user_profile_update', 'wpq_save_extra_profile_fields' );

function wpq_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;		
	// copy this line for other fields
	update_user_meta( $user_id, 'drmc-department', $_POST['drmc-department'] );
}


?>