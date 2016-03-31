<?php

namespace Fragen\DRMC;

//DRMC Medical Staff Governance
class Base {

	public static $depts;
	protected static $object = false;

	public static function instance() {
		$class = __CLASS__;
		if ( false === self::$object ) {
			self::$object = new $class();
		}

		return self::$object;
	}

	public function __construct() {

		self::$depts = array(
			'--'                    => '',
			'Emergency Medicine'    => 'emergency-medicine',
			'Family Medicine'       => 'family-medicine',
			'Medicine'              => 'medicine',
			'Pediatrics'            => 'pediatrics',
			'Obstetrics/Gynecology' => 'obstetrics-gynecology',
			'Radiology'             => 'radiology',
			'Surgery'               => 'surgery',
		);

		add_filter( 'login_redirect', array( &$this, 'change_login_redirect' ), 10, 3 );
		add_action( 'init', array( &$this, 'add_custom_taxonomies' ), 0 );
		add_action( 'init', array( &$this, 'create_post_type' ) );
		add_action( 'plugins_loaded', array( &$this, 'hide_toolbar' ) );

		// add shortcode for [voting]
		add_shortcode( 'voting', array( &$this, 'can_vote' ) );

		is_admin() ? new Admin( &$this ) : new Frontend( &$this );

		//instantiate EDD class
		new EDD();
	}

	public function make_dropdown( $user ) {
		$value = get_user_meta( $user->ID, 'drmc_department' );
		if ( ! $_POST ) {
			$_POST['drmc_department'] = array( 0 => '' );
		}
		if ( ! $value ) {
			$value = $_POST['drmc_department'];
		}
		$dropdown   = array();
		$dropdown[] = '<select name="drmc_department" id="drmc_department">';
		foreach ( self::$depts as $dept => $tax ) {
			$dropdown[] = "<option value='$tax' " . selected( $value[0], $tax, false ) . ">$dept</option>";
			//$dropdown[] = '<option value="'. $tax . '" <' . '?php selected( $value, "' . $tax . '" ); ?' . '>>' . $dept . '</option>';
		}
		$dropdown[] = '</select>';
		$content    = implode( "\n", $dropdown );
		echo $content;
	}


	public function get_department() {
		global $current_user;
		wp_get_current_user();
		$user_dept = get_user_meta( $current_user->ID, 'drmc_department' );

		return $user_dept;
	}

	//http://nathany.com/redirecting-wordpress-subscribers
	public function change_login_redirect( $redirect_to, $request_redirect_to, $user ) {
		if ( $user instanceof \WP_User && false === $user->has_cap( 'add_users' ) ) {
			return get_bloginfo( 'siteurl' );
		}

		return $redirect_to;
	}

	//http://digwp.com/2011/04/admin-bar-tricks/
	public function hide_toolbar() {
		// show admin bar only for admins
		if ( ! current_user_can( 'manage_options' ) ) {
			//add_filter( 'show_admin_bar', '__return_false' );
		}

		// show admin bar only for admins and editors
		//if( ! current_user_can( 'edit_posts' ) ) { add_filter( 'show_admin_bar', '__return_false' ); }
	}


	/**
	 * Add custom taxonomies
	 *
	 * Additional custom taxonomies can be defined here
	 * http://codex.wordpress.org/Function_Reference/register_taxonomy
	 * http://wp.smashingmagazine.com/2012/01/04/create-custom-taxonomies-wordpress/
	 */
	public function add_custom_taxonomies() {
		// Add new "Departments" taxonomy to Posts
		register_taxonomy( 'department', 'drmc_voting', array(
			// Hierarchical taxonomy (like categories)
			'hierarchical' => false,
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels'       => array(
				'name'              => _x( 'Departments', 'taxonomy general name' ),
				'singular_name'     => _x( 'Department', 'taxonomy singular name' ),
				'search_items'      => __( 'Search Departments' ),
				'all_items'         => __( 'All Departments' ),
				'parent_item'       => __( 'Parent Department' ),
				'parent_item_colon' => __( 'Parent Department:' ),
				'edit_item'         => __( 'Edit Department' ),
				'update_item'       => __( 'Update Department' ),
				'add_new_item'      => __( 'Add New Department' ),
				'new_item_name'     => __( 'New Department Name' ),
				'menu_name'         => __( 'Departments' ),
			),
			'query_var'    => 'department',
			// Control the slugs used for this taxonomy
			'rewrite'      => array(
				'slug'         => 'department', // This controls the base slug that will display before each term
				'with_front'   => false, // Don't display the category base before "/locations/"
				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
			),
		) );
	}

	public function create_post_type() {
		register_post_type( 'drmc_voting',
			array(
				'labels'        => array(
					'name'          => __( 'Elections' ),
					'singular_name' => __( 'Election' ),
				),
				'public'        => true,
				'menu_position' => 5,
				'menu_icon'     => 'dashicons-chart-bar',
				'rewrite'       => array( 'slug' => 'elections' ),
				'taxonomies'    => array( 'department' ),
				'supports'      => array( 'title', 'editor', 'comments', 'post-formats' ),
			)
		);
	}

	public function add_user_roles() {
		add_role( 'voting_staff', 'Voting Staff',
			array(
				'read'     => true,
				'can_vote' => true,
			)
		);

		add_role( 'non_voting_staff', 'Non-Voting Staff',
			array(
				'read'     => true,
				'can_vote' => false,
			)
		);

		$editor = get_role( 'editor' );
		add_role( 'chief_of_staff', 'Chief of Staff', $editor->capabilities );
		$cos = get_role( 'chief_of_staff' );
		$cos->add_cap( 'can_vote' );
	}

	public function add_admin_voting() {
		$role = get_role( 'administrator' );
		$role->add_cap( 'can_vote' );
	}

	public function can_vote( $attr, $content = null ) {
		$atts = shortcode_atts( array( 'capability' => 'can_vote' ), $attr, 'voting' );
		if ( current_user_can( $atts['capability'] ) && ! is_null( $content ) && ! is_feed() ) {
			return do_shortcode( $content );
		}

		return '<div class="drmc_vote_message">Either you do not have sufficient privileges or you need to login to vote.</div>';
	}

	public function activate() {
		$this->add_user_roles();
		$this->add_admin_voting();
	}

} //end class DRMC_Med_Staff
