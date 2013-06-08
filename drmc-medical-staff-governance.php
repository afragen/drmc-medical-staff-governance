<?php

/*
Plugin Name: DRMC Medical Staff Governance
Plugin URI: https://github.com/afragen/drmc-medical-staff-governance
Description: This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website for web-based governance.
Requires at least: 3.1
Tested up to: 3.5
Version: 1.1
Author: Andy Fragen
Author URI: http://drmcmedstaff.org
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
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

//Load Github Plugin Updater code
if ( is_admin() )
	add_action( 'plugins_loaded', 'drmc_github_plugin_updater' );
	
function drmc_github_plugin_updater() {

	if ( ! function_exists( 'github_plugin_updater_register' ) )
		return false;

	github_plugin_updater_register( array(
		'owner'	=> 'afragen',
		'repo'	=> 'drmc-medical-staff-governance',
		'slug'	=> 'drmc-medical-staff-governance/drmc-medical-staff-governance.php', // defaults to the repo value ('repo/repo.php')
	) );
}
