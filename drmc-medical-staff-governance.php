<?php
/*
Plugin Name:       DRMC Medical Staff Governance
Plugin URI:        https://github.com/afragen/drmc-medical-staff-governance
Description:       This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website for web-based governance.
Requires at least: 3.8
Tested up to:      3.9.1
Version:           1.9.8.3
Author:            Andy Fragen
Author URI:        http://thefragens.com
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/afragen/drmc-medical-staff-governance
GitHub Branch:     develop
*/

// We'll use PHP 5.2 syntax to get the plugin directory
define('DRMC_DIR', dirname(__FILE__));
define('DRMC_CLASSES', DRMC_DIR . '/classes');
define('DRMC_INCLUDES', DRMC_DIR . '/includes');
//define('DRMC_VIEWS', DRMC_DIR . '/views');

//Load base class
require_once( DRMC_CLASSES . '/class-drmc-msg.php' );
require_once( DRMC_CLASSES . '/class-drmc-edd.php' );

// Launch
DRMC_Med_Staff::instance();

// add support for Markdown on Save Improved plugin
//add_action( 'init', 'drmc_prefix_add_markdown_support' );
function drmc_prefix_add_markdown_support(){
    add_post_type_support( 'drmc_voting', 'markdown-osi' );
}

// add shortcode for [voting]
// assumes Role Manager plugin added 'can_vote' capability
add_shortcode( 'voting', 'drmc_voting_check_shortcode' );
function drmc_voting_check_shortcode( $attr, $content = null ) {
	$atts = shortcode_atts( array( 'capability' => 'can_vote' ), $attr, 'voting' );
	if ( current_user_can( $atts['capability'] ) && !is_null( $content ) && !is_feed() ) {
		return do_shortcode( $content );
	}
	return 'You do not have sufficient privileges to vote for this matter.';
}