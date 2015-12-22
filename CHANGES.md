#### 2.0.0
* added class for Easy Digital Downloads customizations
* bring up to WP Coding Guidelines
* remove 'Events' menu for user's below Editor
* updated README.md and code cleanup
* added dashicon
* added plugin specific CSS to load from plugin
* removed `extract()`
* added `register_activation_hook` to create Voting/Non-Voting roles
* add 'can_vote' to admin user.
* refactor to PSR 4
* add hooks to WP-Polls to remove names from casted ballots
* add memo field to EDD emails
* add automatic login/logout menu

#### 1.9.0
* remove a few more admin menu items

#### 1.8.0
* remove Facebook profile setting
* fix undefined index error in `DRMC_Med_Staff::make_dropdown`
* remove admin menu pages for non-admin users

#### 1.7.4
* evaluate shortcode inside of `[voting]` shortcode

#### 1.7.3
* added 'can\_vote' capability via Members plugin to _Administrator_ and _Active Staff_ roles.
* added shortcode `[voting]` for Members plugin

#### 1.7.2
* added support for drmc_voting CPT in MOSI plugin

#### 1.7.1
* split out CHANGES.MD
* added Family Practice Department
* minor WP Coding guidelines fixes

#### 1.7
* added toolbar removal other than administrator and editor to plugin

#### 1.6
* add validation to username

#### 1.5
* removed extra checks from drmc\_register\_extra_fields
* set display\_name

#### 1.4
* finally got registration validation working correctly

#### 1.3
* automatically fix new user first/last name case

#### 1.2
* add Department column to Users table
* removed `new_user_approve_user_denied` hook

#### 1.1.1
* minor fix from v1.1

#### 1.1
* updated for WordPress Code Standards for naming

#### 1.0.1
* added delete user code for hook to `new_user_approve_user_denied`
* change to Github Plugin Updater code

#### 1.0
* refactored GithubUpdater code to own directory

#### 0.9.9
* updated to new GithubUpdater code

#### 0.9.8.1
* updated to generic GithubUpdater code
* later reverted, it doesn't like generic

#### 0.9.7
* code cleanup
* rename to DMRC Medical Staff Governance

#### 0.9.6
* refactored classes

#### 0.9.5
* bug fix

#### 0.9.4
* more restructuring

#### 0.9.3
* minor restructuring
* readme updated

#### 0.9.2
* fixed whitespace problem

#### 0.9.1
* bug fixes

#### 0.9
* bug fixes
* changed user meta key to drmc\_department
* better OOP to class DRMC\_Med_Staff, profile and registration pages
* dropdown list now working as class method

#### 0.8
* added custom post types and taxonomy to class DRMC\_Med_Staff

#### 0.7
* only admin user can change Department affiliation

#### 0.6
* added class DRMC\_Med_Staff
* added template for Departmental Elections
* added get emails code to drmc-get-emails.php

#### 0.5
* added template for Medical Staff Elections, still have to do one for Departmental Elections
* made all department meta tags same

#### 0.4
* added custom post type for Elections

#### 0.3
* added custom post taxonomy for Departments

#### 0.2
* redirect all but admin role
* rework get_user_meta_field_data function to take 1 or 2 parameters and return corresponding array

#### 0.1
* Initial commit
