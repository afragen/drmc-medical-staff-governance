<?php

/*
Plugin Name: DRMC Plugin
Plugin URI: https://github.com/afragen/drmc-plugin
Description: This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website.
Version: 0.1
Author: Andy Fragen
Author URI: http://drmcmedstaff.org
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

require_once( 'drmc-profile-page.php' );
require_once( 'drmc-registration.php' );

//http://nathany.com/redirecting-wordpress-subscribers
function change_login_redirect($redirect_to, $request_redirect_to, $user) {
  if (is_a($user, 'WP_User') && $user->has_cap('edit_posts') === false) {
    return get_bloginfo('siteurl');
  }
  return $redirect_to;
}
// add filter with default priority (10), filter takes (3) parameters
add_filter('login_redirect','change_login_redirect', 10, 3);



add_action( wp_head, 'return_depts' );

function get_users_by_meta_data( $meta_key ) {

	// Query for users based on the meta data
	$user_query = new WP_User_Query(
		array( 'meta_key' => $meta_key )
	);
	
	// Get the results from the query, returning the first user
	$users = $user_query->get_results();
	//print_r( $users );
	return $users;
} // end get_users_by_meta_data

function return_depts( ) {
	foreach ( get_users_by_meta_data( 'drmc-department' ) as $user ) {
		// Do something with each $user
		$depts[] = get_user_meta( $user->ID, 'drmc-department' );
	} // end foreach
	$drmc_depts = array();
	foreach ( $depts as $dept ) {
		if ( ! in_array( $dept[0], $drmc_depts ) ) {
		$drmc_depts[] = $dept[0];
		}
	}
	//print_r ( $drmc_depts );
}




// GithubUpdater
if ( is_admin() ) {
	global $wp_version;
	include_once( 'updater.php' );
	$config = array(		
		'slug' => plugin_basename(__FILE__),
		'proper_folder_name' => dirname( plugin_basename(__FILE__) ),
		'api_url' => 'https://api.github.com/repos/afragen/drmc-plugin',
		'raw_url' => 'https://raw.github.com/afragen/drmc-plugin/master',
		'github_url' => 'https://github.com/afragen/drmc-plugin',
		'zip_url' => 'https://github.com/afragen/drmc-plugin/zipball/master',
		'sslverify' => true,
		'requires' => $wp_version,
		'tested' => $wp_version,
		'readme' => 'readme.txt'

	);
	new WPGitHubUpdater($config);
}

?>