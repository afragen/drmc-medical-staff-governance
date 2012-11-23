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
				<option value="er" <?php selected( $value, 'er' ); ?>>Emergency Medicine</option>
				<option value="med" <?php selected( $value, 'med' ); ?>>Medicine</option>
				<option value="obgyn" <?php selected( $value, 'obgyn' ); ?>>Obstetrics/Gynecology</option>
				<option value="peds" <?php selected( $value, 'peds' ); ?>>Pediatrics</option>
				<option value="rad" <?php selected( $value, 'rad' ); ?>>Radiology</option>
				<option value="surg" <?php selected( $value, 'surg' ); ?>>Surgery</option>
				</select>
			</td>
		</tr>
		<?php // end of chunk ?>
	</table>
<?php
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