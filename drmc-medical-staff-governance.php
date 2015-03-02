<?php
/*
Plugin Name:       DRMC Medical Staff Governance
Plugin URI:        https://github.com/afragen/drmc-medical-staff-governance
Description:       This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website for web-based governance.
Version:           1.9.10
Author:            Andy Fragen
License:           GNU General Public License v2
License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
GitHub Plugin URI: https://github.com/afragen/drmc-medical-staff-governance
GitHub Branch:     namespace
Requires WP:       3.8
Requires PHP:      5.3
*/

// Plugin namespace root
$root = array( 'Fragen\DRMC' => __DIR__ . '/src/DRMC' );

// Add extra classes
$extra_classes = array();

// Load Autoloader
require_once( __DIR__ . '/src/DRMC/Autoloader.php' );
$class_loader = 'Fragen\DRMC\Autoloader';
new $class_loader( $root, $extra_classes );

// Launch
$launch_method = array( 'Fragen\DRMC\Base', 'instance' );
$dmrc = call_user_func( $launch_method );

register_activation_hook( __FILE__, array( 'Fragen\DRMC\Base', 'activate' ) );

// add shortcode for [voting]
add_shortcode( 'voting', 'drmc_voting_check_shortcode' );
function drmc_voting_check_shortcode( $attr, $content = null ) {
	$atts = shortcode_atts( array( 'capability' => 'can_vote' ), $attr, 'voting' );
	if ( current_user_can( $atts['capability'] ) && ! is_null( $content ) && ! is_feed() ) {
		return do_shortcode( $content );
	}
	return 'You do not have sufficient privileges to vote for this matter.';
}