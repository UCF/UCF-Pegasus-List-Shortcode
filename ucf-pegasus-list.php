<?php
/*
Plugin Name: UCF Pegasus Issue List
Description: Provides a shortcode for displaying the latest issues of Pegasus, UCF's official alumni magazine.
Version: 1.0.0
Author: UCF Web Communications
License: GPL3
*/
if ( ! defined( 'WPINC' ) ) {
	die;
}

include_once 'includes/ucf-pegasus-list-config.php';
include_once 'includes/ucf-pegasus-list-feed.php';
include_once 'includes/ucf-pegasus-list-common.php';
include_once 'shortcodes/ucf-pegasus-list-shortcode.php';

if ( ! function_exists( 'ucf_pegasus_list_activation' ) ) {
	function ucf_pegasus_list_activation() {
		UCF_Pegasus_List_Config::add_options();
	}

	register_activation_hook( 'ucf_pegasus_list_activation', __FILE__ );
}
