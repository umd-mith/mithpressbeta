<?php
/**
* Dynamic To Top CSS
*
* @package 	Dynamic To Top
* @author 	Matt Varone
*/

// set the correct header
header( "content-type: text/css; charset: UTF-8" );

// require WordPress
require_once( '../../../../wp-load.php' );

if( ! defined( 'MV_DYNAMIC_TO_TOP_VERSION' ) ) 
die();

global $OBJ_dynamic_to_top;

if ( ! isset( $OBJ_dynamic_to_top ) OR ! is_object( $OBJ_dynamic_to_top ) ) {
	if ( ! class_exists( 'Dynamic_To_Top' ) )
	die();
	
	$OBJ_dynamic_to_top = new Dynamic_To_Top();
}

echo $OBJ_dynamic_to_top->get_css();