<?php

//Add custom fields to registration page
add_action( 'register_form', 'drmc_username' );
add_action( 'register_form', 'drmc_add_dropdown' );
add_action( 'register_form', 'drmc_add_warning' );
add_action( 'user_register', 'drmc_register_extra_fields', 10 );

function drmc_username() {
	$html = '<label>First Name<br />
			<input type="text" name="first_name" id="first_name" class="input" value="" size="25" tabindex="20" /></label>
			<label>Last Name<br />
			<input type="text" name="last_name" id="last_name" class="input" value="" size="25" tabindex="20" /></label>
			<label for="drmc_department" id="drmc_department">Department</label><br />';

	echo $html;
}

function drmc_add_dropdown( $user ) {
	$drmcmedstaff = DRMCMedStaff::instance();
	$drmcmedstaff::make_dropdown( $user );
}

function drmc_add_warning() {
	echo '<br /><br /><p class="message">You must use your DRMC username as your <strong>Username</strong> or your registration will be denied.</p><br />';
}

//not sure this does anything
//add_action( 'register_post', 'drmc_check_fields', 10, 2 );
function drmc_check_fields ( $login, $email ) {
	//global $department;
	//$department = $_POST['drmc_department'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
}

function drmc_register_extra_fields ( $user_id ) {
	update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
	update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
	update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
	
}
//end add custom fields to registration page

?>