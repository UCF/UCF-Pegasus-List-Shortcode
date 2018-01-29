# UCF Pegasus Issues List #

Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.


## Description ##

Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.

## Installation ##

### Manual Installation ###
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress

### WP CLI Installation ###
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Pegasus-List-Shortcode/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.


## Changelog ##

### 1.0.1 ###
Enhancements:
* Added ability to specify a fallback message when no issues are available to display (via inner shortcode contents, similarly to some of our other shortcodes). Example usage: `[ucf-pegasus-list]No results found.[/ucf-pegasus-list]`

Bugfixes:
* Fixed incorrect constant name "HOUR_IN_SECONDS", which prevented transient expiration times from being set properly.
* Updated default feed settings to point to ucf.edu/pegasus/ instead of pegasus.ucf.edu
* Added check in `ucf_pegasus_list_display_default_content()` to ensure `$items` is an array if it is set
* Added additional hardening to `UCF_Pegasus_List_Feed::get_issues()` to ensure the feed response looks valid

### 1.0.0 ###
* Initial release


## Upgrade Notice ##

n/a


## Installation Requirements ##

None


## Development & Contributing ##

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.
