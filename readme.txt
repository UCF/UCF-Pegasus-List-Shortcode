=== UCF Pegasus Issues List ===
Contributors: ucfwebcom
Tags: ucf, pegasus, list, shortcode
Requires at least: 5.3
Tested up to: 5.3
Stable tag: 1.0.1
Requires PHP: 7.4
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.


== Description ==

Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.

== Documentation ==

Head over to the [Pegasus List Shortcode plugin wiki](https://github.com/UCF/UCF-Pegasus-List-Shortcode/wiki) for detailed information about this plugin, installation instructions, and more.

== Changelog ==

= 1.0.1 =
Enhancements:
* Added ability to specify a fallback message when no issues are available to display (via inner shortcode contents, similarly to some of our other shortcodes). Example usage: `[ucf-pegasus-list]No results found.[/ucf-pegasus-list]`

Bugfixes:
* Fixed incorrect constant name "HOUR_IN_SECONDS", which prevented transient expiration times from being set properly.
* Updated default feed settings to point to ucf.edu/pegasus/ instead of pegasus.ucf.edu
* Added check in `ucf_pegasus_list_display_default_content()` to ensure `$items` is an array if it is set
* Added additional hardening to `UCF_Pegasus_List_Feed::get_issues()` to ensure the feed response looks valid

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Development ==

[Enabling debug mode](https://codex.wordpress.org/Debugging_in_WordPress) in your `wp-config.php` file is recommended during development to help catch warnings and bugs.

= Requirements =
* node
* gulp-cli

= Instructions =
1. Clone the UCF-Pegasus-List-Shortcode repo into your local development environment, within your WordPress installation's `plugins/` directory: `git clone https://github.com/UCF/UCF-Pegasus-List-Shortcode.git`
2. `cd` into the new UCF-Pegasus-List-Shortcode directory, and run `npm install` to install required packages for development into `node_modules/` within the repo
3. Run `gulp default` to process assets.
4. If you haven't already done so, create a new WordPress site on your development environment to test this plugin against.
5. Activate this plugin on your development WordPress site.
6. Configure plugin settings from the WordPress admin under "Settings > UCF Pegasus List".

= Other Notes =
* This plugin's README.md file is automatically generated. Please only make modifications to the README.txt file, and make sure the `gulp readme` command has been run before committing README changes.
