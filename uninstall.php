<?php
/**
 * Handles uninstallation logic
 **/
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}

require_once 'includes/ucf-pegasus-list-config.php';

// Delete options
UCF_Pegasus_List_Config::delete_options();
