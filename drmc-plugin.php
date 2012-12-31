<?php

/*
Plugin Name: DRMC Plugin
Plugin URI: https://github.com/afragen/drmc-plugin
Description: This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website.
Requires at least: 3.1
Tested up to: 3.5
Version: 0.9.7
Author: Andy Fragen
Author URI: http://drmcmedstaff.org
License: GNU General Public License v2
License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
*/

// We'll use PHP 5.2 syntax to get the plugin directory
define('DRMC_DIR', dirname(__FILE__));
define('DRMC_CLASSES', DRMC_DIR.'/classes');
define('DRMC_INCLUDES', DRMC_DIR.'/includes');
define('DRMC_VIEWS', DRMC_DIR.'/views');
//define('DRMC_RESOURCES', plugin_dir_url(__FILE__).'resources');

//Load base class
require_once( DRMC_CLASSES.'/drmc-msg.php' );

// Launch
DRMCMedStaff::instance();


// GithubUpdater
if ( is_admin() ) {
	global $wp_version;
	include_once( DRMC_INCLUDES.'/updater.php' );
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
