<?php 
/**
* Dynamic To Top Uninstall
*
* @package 	Dynamic To Top
* @author 	Matt Varone
*/

// If uninstall not called from WordPress exit 
if( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
exit();
// Delete option from options table 
delete_option( 'dynamic_to_top' );