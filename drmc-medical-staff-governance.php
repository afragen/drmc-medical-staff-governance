<?php

/*
Plugin Name:       DRMC Medical Staff Governance
Plugin URI:        https://github.com/afragen/drmc-medical-staff-governance
GitHub Plugin URI: afragen/drmc-medical-staff-governance
GitHub Branch:     master
Description:       This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website for web-based governance.
Requires at least: 3.5
Tested up to:      3.7
Version:           1.7.4
Author:            Andy Fragen
Author URI:        http://thefragens.com
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// We'll use PHP 5.2 syntax to get the plugin directory
define('DRMC_DIR', dirname(__FILE__));
define('DRMC_CLASSES', DRMC_DIR.'/classes');
define('DRMC_INCLUDES', DRMC_DIR.'/includes');
//define('DRMC_VIEWS', DRMC_DIR.'/views');
//define('DRMC_RESOURCES', plugin_dir_url(__FILE__).'resources');

//Load base class
require_once( DRMC_CLASSES.'/class-drmc-msg.php' );
//require_once( DRMC_INCLUDES.'/drmc-get-emails.php' );

// Launch
DRMC_Med_Staff::instance();

// add support for Markdown on Save Improved plugin
add_action( 'init', 'drmc_prefix_add_markdown_support' );
function drmc_prefix_add_markdown_support(){
    add_post_type_support( 'drmc_voting', 'markdown-osi' );
}

// add shortcode for [voting] with Members plugin
// assumes Role Manager plugin added 'can_vote' capability
add_shortcode( 'voting', 'drmc_voting_check_shortcode' );
function drmc_voting_check_shortcode( $attr, $content = null ) {
	extract( shortcode_atts( array( 'capability' => 'can_vote' ), $attr ) );
	if ( current_user_can( $capability ) && !is_null( $content ) && !is_feed() )
		return do_shortcode( $content );
	return 'You do not have sufficient privileges to vote for this matter.';
}