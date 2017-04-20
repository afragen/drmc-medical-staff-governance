<?php
/**
 * Plugin Name:       DRMC Medical Staff Governance
 * Plugin URI:        https://github.com/afragen/drmc-medical-staff-governance
 * Description:       This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website for web-based governance.
 * Version:           2.0.1
 * Author:            Andy Fragen
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * GitHub Plugin URI: https://github.com/afragen/drmc-medical-staff-governance
 * GitHub Branch:     develop
 * Requires WP:       3.8
 * Requires PHP:      5.3
 */

// Plugin namespace root
$root = array( 'Fragen\DRMC' => __DIR__ . '/src/DRMC' );

// Add extra classes
$extra_classes = array();

// Load Autoloader
require_once( __DIR__ . '/src/Autoloader.php' );
$class_loader = 'Fragen\\Autoloader';
new $class_loader( $root, $extra_classes );

// Launch
$launch_method = array( 'Fragen\\DRMC\\Base', 'instance' );
$drmc          = call_user_func( $launch_method );

register_activation_hook( __FILE__, array( $drmc, 'activate' ) );

// secret ballots in wp-polls
add_filter( 'poll_log_show_log_filter', '__return_false' );
add_filter( 'poll_log_secret_ballot', '__return_empty_string' );
