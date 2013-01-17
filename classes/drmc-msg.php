<?php

//DRMC Medical Staff Governance
class DRMCMedStaff {

	static $depts;
	protected static $object = false;
	
	public static function instance() {
		$class = __CLASS__;
		if (self::$object === false) self::$object = new $class();
		return self::$object;
	}
	
	function __construct() {
			
		self::$depts = array(
			'--' => '',
			'Emergency Medicine' => 'emergency-medicine',
			'Medicine' => 'medicine',
			'Pediatrics' => 'pediatrics',
			'Obstetrics/Gynecology' => 'obstetrics-gynecology',
			'Radiology' => 'radiology',
			'Surgery' => 'surgery'
			);	
								
		add_filter('login_redirect', array( $this, 'change_login_redirect' ), 10, 3);
		add_action( 'init', array( $this, 'add_custom_taxonomies' ), 0 );
		add_action( 'init', array( $this, 'create_post_type' ) );
		
		is_admin() ? $this->load_admin() : $this->load_public() ;
	}
	
	protected function load_admin() {
		require_once DRMC_CLASSES.'/admin.php';
		new DRMCMedStaffAdmin($this);
	}

	protected function load_public() {
		require_once DRMC_CLASSES.'/public.php';
		new DRMCMedStaffPublic($this);
	}

	static function make_dropdown( $user ) {

		$value = get_user_meta( $user->ID, 'drmc_department' );
		if ( ! $value) { $value = $_POST['drmc_department']; }
		$dropdown = array();
		$dropdown[] = '<select name="drmc_department" id="drmc_department">';
		foreach ( self::$depts as $dept => $tax ) {
			$dropdown[] = "<option value='$tax' " . selected($value[0], $tax, false) . ">$dept</option>";
			//$dropdown[] = '<option value="'. $tax . '" <' . '?php selected( $value, "' . $tax . '" ); ?' . '>>' . $dept . '</option>';
		}
		$dropdown[] = '</select>';
		$content = implode( "\n", $dropdown );
		echo $content;
	}

	
	public function get_department() {
		global $current_user;
		get_currentuserinfo();
		$user_dept = get_user_meta( $current_user->ID, 'drmc_department' );
		return $user_dept;
	}
	
	//http://nathany.com/redirecting-wordpress-subscribers
	public function change_login_redirect($redirect_to, $request_redirect_to, $user) {
		if (is_a($user, 'WP_User') && $user->has_cap('add_users') === false) {
			return get_bloginfo('siteurl');
		}
		return $redirect_to;
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
		register_taxonomy('department', 'drmc_voting', array(
			// Hierarchical taxonomy (like categories)
			'hierarchical' => false,
			// This array of options controls the labels displayed in the WordPress Admin UI
			'labels' => array(
				'name' => _x( 'Departments', 'taxonomy general name' ),
				'singular_name' => _x( 'Department', 'taxonomy singular name' ),
				'search_items' =>  __( 'Search Departments' ),
				'all_items' => __( 'All Departments' ),
				'parent_item' => __( 'Parent Department' ),
				'parent_item_colon' => __( 'Parent Department:' ),
				'edit_item' => __( 'Edit Department' ),
				'update_item' => __( 'Update Department' ),
				'add_new_item' => __( 'Add New Department' ),
				'new_item_name' => __( 'New Department Name' ),
				'menu_name' => __( 'Departments' ),
			),
			'query_var' => 'department',
			// Control the slugs used for this taxonomy
			'rewrite' => array(
				'slug' => 'department', // This controls the base slug that will display before each term
				'with_front' => false, // Don't display the category base before "/locations/"
				'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
			),
		));
	}
	
	public function create_post_type() {
		register_post_type( 'drmc_voting',
			array(
				'labels' => array(  
					'name' => __( 'Elections' ),  
					'singular_name' => __( 'Election' )
				),
			'public' => true,
			'menu_position' => 5,
			'rewrite' => array('slug' => 'elections'),
			'taxonomies' => array( 'department' ),
			'supports' => array('title', 'editor', 'comments', 'post-formats') 
			)
		);
	}
	
} //end class DRMCMedStaff
