<?php
/*
Plugin Name: UCF Pegasus Issue List
Description: Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.
Version: 1.1.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'UCF_PEGASUS_LIST__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );


include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'includes/ucf-pegasus-list-config.php';
include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'includes/ucf-pegasus-list-feed.php';
include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'includes/ucf-pegasus-list-common.php';

include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'shortcodes/ucf-pegasus-list-shortcode.php';

include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'layouts/ucf-pegasus-list-default.php';
include_once UCF_PEGASUS_LIST__PLUGIN_DIR . 'layouts/ucf-pegasus-list-modern.php';


if ( ! function_exists( 'ucf_pegasus_list_activation' ) ) {
	function ucf_pegasus_list_activation() {
		UCF_Pegasus_List_Config::add_options();
	}

	register_activation_hook( 'ucf_pegasus_list_activation', __FILE__ );
}
