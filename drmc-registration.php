<?php


//Add custom fields to registration page
add_action( 'register_form', 'drmc_username' );
add_action( 'register_post', 'check_fields', 10, 2 );
add_action( 'user_register', 'register_extra_fields' );

function drmc_username() {
	$html = '<label>First Name<br />
			<input type="text" name="first_name" id="first_name" class="input" value="" size="25" tabindex="20" /></label>
			<label>Last Name<br />
			<input type="text" name="last_name" id="last_name" class="input" value="" size="25" tabindex="20" /></label>
			<label for="drmc-department">Department</label><br />
			<select name="drmc-department" id="drmc-department">
			<option value="--" <?php selected( $value, "--" ); ?> --</option>
			<option value="emergency-medicine" <?php selected( $value, "emergency-medicine" ); ?> Emergency Medicine</option>
			<option value="medicine" <?php selected( $value, "medicine" ); ?> Medicine</option>
			<option value="obstetrics-gynecology" <?php selected( $value, "obstetrics-gynecology" ); ?> Obstetrics/Gynecology</option>
			<option value="pediatrics" <?php selected( $value, "pediatrics" ); ?> Pediatrics</option>
			<option value="radiology" <?php selected( $value, "radiology" ); ?> Radiology</option>
			<option value="surgery" <?php selected( $value, "surgery" ); ?> Surgery</option>
			</select><br /><br />
			<p class="message">You must use your DRMC username as your <strong>Username</strong> or your registration will be denied.</p><br />';
	echo $html;
}
function check_fields ( $login, $email ) {
	global $department;
	$department = $_POST['drmc-department'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
}

function register_extra_fields ( $user_id, $password = "", $meta = array() ) {
	update_user_meta( $user_id, 'drmc-department', $_POST['drmc-department'] );
	update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
	update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
	
}
//end add custom fields to registration page


?>