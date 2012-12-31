=== Plugin Name ===
Contributors: afragen
Requires at least: 3.3
Tested up to: 3.4.1
Git URI: https://github.com/afragen/drmc-plugin
Stable tag: 0.9.6
~Current Version:0.9.6~

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adding registration and custom user meta to site. 

== Description ==

This plugin adds registration, custom user meta, role and custom user meta specific menu options and other things for Medical Staff governance to the [DRMC Medical Staff website](http://drmcmedstaff.org).

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `drmc-plugin.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= What other plugins are needed? =

This plugin requires several other plugins to achieve full functionality for the site.

* [Members](http://justintadlock.com/archives/2009/09/17/members-wordpress-plugin) by Justin Tadlock
* [New User Approve](http://www.picklewagon.com/wordpress/new-user-approve/) by Josh Harrison
* [WordPress Access Control](http://brandonwamboldt.ca/plugins/members-only-menu-plugin/) by Brandon Wamboldt
* [WP Polls](http://lesterchan.net/portfolio/programming/php/) by Lester 'GaMerZ' Chan


== Changelog ==

= 0.9.6 =
* refactored classes

= 0.9.5 =
* bug fix

= 0.9.4 =
* more restructuring

= 0.9.3 =
* minor restructuring
* readme updated

= 0.9.2 =
* fixed whitespace problem

= 0.9.1 =
* bug fixes

= 0.9 =
* bug fixes
* changed user meta key to drmc_department
* better OOP to class DRMCMedStaff, profile and registration pages
* dropdown list now working as class method

= 0.8 =
* added custom post types and taxonomy to class DRMCMedStaff

= 0.7 =
* only admin user can change Department affiliation

= 0.6 =
* added class DRMCMedStaff
* added template for Departmental Elections
* added get emails code to drmc-get-emails.php

= 0.5 =
* added template for Medical Staff Elections, still have to do one for Departmental Elections
* made all department meta tags same

= 0.4 =
* added custom post type for Elections

= 0.3 =
* added custom post taxonomy for Departments

= 0.2 =
* redirect all but admin role
* rework get_user_meta_field_data function to take 1 or 2 parameters and return corresponding array

= 0.1 =
* Initial commit

