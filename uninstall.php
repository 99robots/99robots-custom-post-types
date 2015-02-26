<?php

	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
		exit ();

	$version_option_name = 'gabfire_custom_post_type_version';
	$option_name = 'gabfire_custom_post_settings';

	if (is_multisite()) {
		delete_site_option($option_name);
		delete_site_option($version_option_name);
	}else {
		delete_option($option_name);
		delete_option($version_option_name);
	}
?>