=== Plugin Name ===
Contributors: afragen
Requires at least: 3.3
Tested up to: 3.4.1
Git URI: https://github.com/afragen/drmc-plugin
Stable tag: 0.7

License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adding registration and custom user meta to site.

== Description ==

This plugin adds registration, custom user meta and other things to the DRMC Medical Staff website.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `drmc-plugin.php` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.


== Changelog ==

= 0.1 =
* Initial commit

= 0.2 =
* redirect all but admin role
* rework get_user_meta_field_data function to take 1 or 2 parameters and return corresponding array

= 0.3 =
* added custom post taxonomy for Departments

= 0.4 =
* added custom post type for Elections

= 0.5 =
* added template for Medical Staff Elections, still have to do one for Departmental Elections
* made all department meta tags same

= 0.6 =
* added class DRMCMedStaff
* added template for Departmental Elections
* added get emails code to drmc-get-emails.php

= 0.7 =
* only admin user can change Department affiliation

== Current Version ==

Using https://github.com/jkudish/WordPress-GitHub-Plugin-Updater

The line below is used for the updater API, please leave it untouched unless bumping the version up :)

~Current Version:0.6~