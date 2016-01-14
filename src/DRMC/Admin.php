<?php

namespace Fragen\DRMC;

add_filter( 'user_contactmethods', 'Fragen\\DRMC\\Admin::remove_contactmethods', 100 );

//add columns to User panel list page
add_action( 'manage_users_custom_column', 'Fragen\\DRMC\\Admin::add_custom_user_columns', 15, 3 );
add_filter( 'manage_users_columns', 'Fragen\\DRMC\\Admin::add_user_columns', 15, 1 );

class Admin {

	public function __construct() {

		// Add additional custom fields to profile page
		// http://pastebin.com/0zhWAtqY
		add_action ( 'show_user_profile', array( &$this, 'wpq_show_extra_profile_fields' ) );
		add_action ( 'edit_user_profile', array( &$this, 'wpq_show_extra_profile_fields' ) );

		// Save data input from custom field on profile page
		add_action( 'personal_options_update', array( &$this, 'wpq_save_extra_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( &$this, 'wpq_save_extra_profile_fields' ) );
		add_action( 'admin_print_scripts-profile.php', array( &$this, 'hide_admin_items' ) );
		add_action( 'admin_print_styles-user-edit.php', array( &$this, 'hide_admin_items' ) );

		add_action( 'admin_menu', array( $this, 'edit_admin_menus' ) );

}


	public static function remove_contactmethods( $user_contactmethods ) {
		// You can get rid of ones you don't want
		unset( $user_contactmethods['jabber'] );
		unset( $user_contactmethods['yim'] );
		unset( $user_contactmethods['aim'] );

		//Added by WordPress SEO
		unset( $user_contactmethods['googleplus'] );
		unset( $user_contactmethods['twitter'] );
		unset( $user_contactmethods['facebook'] );

		return $user_contactmethods;
	}


	public static function wpq_show_extra_profile_fields( $user ) {
		?>
			<h3><?php _e( 'Extra Profile Info'); ?></h3>
			<table class="form-table">
				<tr>
					<th><label for="drmc_department" id="drmc_department"><?php _e( 'Department' ); ?></label></th>
					<td>
						<?php Base::make_dropdown( $user ); ?>
					</td>
				</tr>
			</table>
		<?php
	}


	public static function wpq_save_extra_profile_fields( $user_id ) {
		if ( ! current_user_can( 'add_users' ) ) { return false; }

		// copy this line for other fields
		update_user_meta( $user_id, 'drmc_department', $_POST['drmc_department'] );
	}

	//http://wordpress.org/support/topic/make-extra-columns-in-userphp-sortable?replies=17#post-2317114
	public function add_user_columns( $defaults ) {
		$defaults['drmc_department'] = 'Department';

		return $defaults;
	}

	public static function add_custom_user_columns( $value, $column_name, $id ) {
		if ( 'drmc_department' == $column_name ) {
			return get_the_author_meta( 'drmc_department', $id );
		}
	}

	//hide toolbar option in profile - http://digwp.com/2011/04/admin-bar-tricks/
	public static function hide_admin_items() {
		if ( ! current_user_can( 'add_users' ) ) {
			?>
			<style type="text/css">
				.show-admin-bar { display: none; }
				input#eddc_user_paypal.regular-text, input#eddc_user_rate.small-text { display: none; }
				input[id*="email_users_accept_"] { display: none; }
				tr.user-nickname-wrap { display: none; }
			</style>
			<?php
		}
	}

	public static function edit_admin_menus() {
		remove_menu_page( 'link-manager.php' );
		if ( ! current_user_can( 'add_users' ) ) {
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'edit-comments.php' );
			remove_menu_page( 'edit.php?post_type=feedback' );
			remove_menu_page( 'options-general.php' );
			remove_menu_page( 'edit.php?post_type=drmc_voting' );
		}
		if ( ! current_user_can( 'publish_posts' ) ) {
			remove_menu_page( 'edit.php?post_type=tribe_events' );
		}
	}

}
