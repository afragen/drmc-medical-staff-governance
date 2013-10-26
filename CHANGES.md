# Changelog for DRMC Medical Staff Governance

## 1.7.3

 * added 'can\_vote' capability via Members plugin to _Administrator_ and _Active Staff_ roles.
 * added shortcode `[voting]` for Members plugin

## 1.7.2

* added support for drmc_voting CPT in MOSI plugin

## 1.7.1

* split out CHANGES.MD
* added Family Practice Department
* minor WP Coding guidelines fixes

## 1.7

* added toolbar removal other than administrator and editor to plugin

## 1.6

* add validation to username

## 1.5

* removed extra checks from drmc\_register\_extra_fields
* set display\_name

## 1.4

* finally got registration validation working correctly

## 1.3

* automatically fix new user first/last name case

## 1.2

* add Department column to Users table
* removed `new_user_approve_user_denied` hook

## 1.1.1

* minor fix from v1.1

## 1.1

* updated for WordPress Code Standards for naming

## 1.0.1

* added delete user code for hook to `new_user_approve_user_denied`
* change to Github Plugin Updater code

## 1.0

* refactored GithubUpdater code to own directory

## 0.9.9

* updated to new GithubUpdater code

## 0.9.8.1

* updated to generic GithubUpdater code
* later reverted, it doesn't like generic

## 0.9.7

* code cleanup
* rename to DMRC Medical Staff Governance

## 0.9.6

* refactored classes

## 0.9.5

* bug fix

## 0.9.4

* more restructuring

## 0.9.3

* minor restructuring
* readme updated

## 0.9.2

* fixed whitespace problem

## 0.9.1

* bug fixes

## 0.9

* bug fixes
* changed user meta key to drmc\_department
* better OOP to class DRMC\_Med_Staff, profile and registration pages
* dropdown list now working as class method

## 0.8

* added custom post types and taxonomy to class DRMC\_Med_Staff

## 0.7

* only admin user can change Department affiliation

## 0.6

* added class DRMC\_Med_Staff
* added template for Departmental Elections
* added get emails code to drmc-get-emails.php

## 0.5

* added template for Medical Staff Elections, still have to do one for Departmental Elections
* made all department meta tags same

## 0.4

* added custom post type for Elections

## 0.3

* added custom post taxonomy for Departments

## 0.2

* redirect all but admin role
* rework get_user_meta_field_data function to take 1 or 2 parameters and return corresponding array

## 0.1

* Initial commit