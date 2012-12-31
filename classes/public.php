<?php

class DRMCMedStaffPublic {

	function __construct() {
		//Add custom fields to registration page
		add_action( 'register_form', array($this, 'drmc_username') );
		add_action( 'register_form', array($this, 'drmc_add_dropdown') );
		add_action( 'register_form', array($this, 'drmc_add_warning') );
		add_action( 'user_register', array($this, 'drmc_register_extra_fields', 10) );
	}

	public function drmc_username() {
		$html = '<label>First Name<br />
			<input type="text" name="first_name" id="first_name" class="input" value="" size="25" tabindex="20" /></label>
			<label>Last Name<br />
			<input type="text" name="last_name" id="last_name" class="input" value="" size="25" tabindex="20" /></label>
			<label for="drmc_department" id="drmc_department">Department</label><br />';

		echo $html;
	}

	public function drmc_add_dropdown( $user ) {
		$drmcmedstaff = DRMCMedStaff::instance();
		$drmcmedstaff::make_dropdown( $user );
	}

	public function drmc_add_warning() {
		echo '<br /><br /><p class="message">You must use your DRMC username as your <strong>Username</strong> or your registration will be denied.</p><br />';
	}

	public function drmc_register_extra_fields ( $user_id ) {
		update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
		update_user_meta( $user_id, 'first_name', $_POST['first_name'] );
		update_user_meta( $user_id, 'last_name', $_POST['last_name'] );
	}
	
} //end class DRMCMedStaffPublic
