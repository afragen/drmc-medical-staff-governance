<?php

//add_action( wp_head, 'return_meta', 10, 2 );
function return_meta() {
	get_user_meta_field_data( 'drmc-department' );
	get_user_meta_field_data( 'drmc-department', 'emergency-medicine' );
}

function get_users_by_meta_data( $meta_key, $meta_value ) {
	// Query for users based on the meta data
	$user_query = new WP_User_Query(
		array( 'meta_key' => $meta_key, 'meta_value' => $meta_value )
	);	
	// Get the results from the query, returning the first user
	$users = $user_query->get_results();
	return $users;
} // end get_users_by_meta_data

function get_user_meta_field_data( $user_meta_field, $user_meta_field_value=NULL ) {
	$meta_field_values = array();
	$user_meta_field_values = array();
	foreach ( get_users_by_meta_data( $user_meta_field, $user_meta_field_value ) as $user ) {
		$meta_field_values[] = get_user_meta( $user->ID, $user_meta_field );
		
		//get emails for specified custom user meta field value
		if ( ! is_null( $user_meta_field_value ) ) {
			$emails[] =  $user->user_email;
		}
	}
	
	//get values for custom user meta field and return array
	if ( is_null( $user_meta_field_value ) ) {
		foreach ( $meta_field_values as $meta_field_value ) {
			if ( ! in_array( $meta_field_value[0], $user_meta_field_values ) ) {
				$user_meta_field_values[] = $meta_field_value[0];
			}
		}
		print_r ( $user_meta_field_values );
		return $user_meta_field_values;
	}
	
	//return array of email addresses for specific custom user meta field value
	if ( ! is_null( $user_meta_field_value ) ) {
		print_r ($emails);
		return $emails;
	}
}
