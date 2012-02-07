<?php
/*
Plugin Name: Dynamic To Top
Version: 3.1.8
Plugin URI: http://www.mattvarone.com/featured-content/dynamic-to-top/
Description: Adds an automatic and dynamic "To Top" button to scroll long pages back to the top.
Author: Matt Varone
Author URI: http://www.mattvarone.com

Copyright 2011  ( email: contact@mattvarone.com )

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
( at your option ) any later version.

This program is distributed in the hope that it will be useful, 
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/**
* Dynamic To Top Initialize
*
* @package 	Dynamic To Top
* @author 	Matt Varone
*/
		
/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP CONSTANTS
|--------------------------------------------------------------------------
*/

define( 'MV_DYNAMIC_TO_TOP_BASENAME', plugin_basename( __FILE__ ) );
define( 'MV_DYNAMIC_TO_TOP_URL', plugins_url( '', __FILE__ ) );
define( 'MV_DYNAMIC_TO_TOP_PATH', plugin_dir_path( __FILE__ ) );
define( 'MV_DYNAMIC_TO_TOP_VERSION', '3.1.7' );
define( 'MV_DYNAMIC_TO_TOP_FOLDER', basename( dirname( __FILE__ ) ) );

/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP INTERNALIZATION
|--------------------------------------------------------------------------
*/

load_plugin_textdomain( 'dynamic-to-top', false, '/' . MV_DYNAMIC_TO_TOP_FOLDER . '/lan' );

/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP INCLUDES
|--------------------------------------------------------------------------
*/

if ( is_admin() )
	require_once( MV_DYNAMIC_TO_TOP_PATH . 'inc/dynamic-to-top-options.php' );
else
	require_once( MV_DYNAMIC_TO_TOP_PATH . 'inc/dynamic-to-top-class.php' );
	
/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP ON ACTIVATION
|--------------------------------------------------------------------------
*/
	
/** 
* Dynamic To Top Activation
*
* @package 	Dynamic To Top
* @since 	3.1.5
*/
if ( ! function_exists( 'mv_dynamic_to_top_activation' ) )
{	
	function mv_dynamic_to_top_activation()
	{
		// check compatibility
		if ( version_compare( get_bloginfo( 'version' ), '3.0' ) >= 0 )
		deactivate_plugins( basename( __FILE__ ) );
		
		// refresh cache
		delete_transient( 'dynamic_to_top_transient_css' );
	}
	
	register_activation_hook( __FILE__, 'mv_dynamic_to_top_activation' );
}