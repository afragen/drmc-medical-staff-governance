<?php

namespace Fragen\DRMC;

class Frontend {

	public function __construct() {
		//Add custom fields to registration page
		add_action( 'register_form', array( &$this, 'drmc_username' ) );
		add_action( 'register_form', array( &$this, 'drmc_add_dropdown' ) );
		add_action( 'register_form', array( &$this, 'drmc_add_warning' ) );
		add_action( 'register_post', array( &$this, 'drmc_registration_errors' ), 10, 3 );
		add_action( 'user_register', array( &$this, 'drmc_register_extra_fields' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'add_css' ), 99 );
		add_filter( 'wp_nav_menu_items', array( &$this, 'menu_login_logout_link' ), 10, 2 );
	}

	public function menu_login_logout_link( $nav, $args ) {
		$logoutlink = '<li><a href="' . wp_logout_url() . '">Logout</a></li>';
		$loginlink  = '<li class="drmc-highlight-menu"><a href="' . wp_login_url() . '">Login</a></li>';
		if ( is_user_logged_in() ) {
			return $nav . $logoutlink;
		} else {
			return $nav . $loginlink;
		}
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
		Base::instance()->make_dropdown( $user );
	}

	public function drmc_add_warning() {
		?>
		<p style="margin: 15px 0;" class="message">
			You must use your DRMC username as your <strong>Username</strong> or your registration will be denied.
		</p>
		<?php
	}

	public function drmc_register_extra_fields( $user_id ) {
		$fname = $this->ucname( $_POST['first_name'] );
		$lname = $this->ucname( $_POST['last_name'] );
		update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
		update_user_meta( $user_id, 'first_name', $fname );
		update_user_meta( $user_id, 'last_name', $lname );
		wp_update_user( array(
				ID             => $user_id,
				'display_name' => $fname . ' ' . $lname,
			)
		);
	}

	private function ucname( $string ) {
		$string = ucwords( strtolower( $string ) );
		foreach ( array( '-', '\'' ) as $delimiter ) {
			if ( false !== strpos( $string, $delimiter ) ) {
				$string = implode( $delimiter, array_map( 'ucfirst', explode( $delimiter, $string ) ) );
			}
		}

		return $string;
	}

	public function drmc_registration_errors( $sanitized_user_login, $user_email, $errors ) {
		if ( preg_match( '/[^-\.\w]/', $sanitized_user_login ) ) {
			$errors->add( 'user_name', '<strong>ERROR</strong>: Your username contains one or more invalid characters. Please use your DRMC username.' );
		}
		if ( empty( $_POST['first_name'] ) ) {
			$errors->add( 'first_name_error', '<strong>ERROR</strong>: You must include a first name.' );
		}
		if ( empty( $_POST['last_name'] ) ) {
			$errors->add( 'last_name_error', '<strong>ERROR</strong>: You must include a last name.' );
		}
		if ( empty( $_POST['drmc_department'] ) ) {
			$errors->add( 'drmc_department_error', '<strong>ERROR</strong>: You must include a department.' );
		}

		return $errors;
	}

	public static function add_css() {
		wp_enqueue_style( 'drmc', plugins_url( 'includes/drmc.css', dirname( dirname( __FILE__ ) ) ) );
	}

} //end class DRMC_Med_Staff_Public
