<?php
/**
 * Plugin Name: All-in-One Event Calendar Plugin
 * Plugin URI: http://theseedstudio.com/software/all-in-one-event-calendar-wordpress/
 * Description: An event calendar system with month and agenda views, upcoming events widget, color-coded categories, recurrence, and import/export of .ics feeds.
 * Version: 1.0.9
 * Author: The Seed Studio
 * Author URI: http://theseedstudio.com/
 */
@set_time_limit( 0 );
@ini_set( "memory_limit", 				"256M" );
@ini_set( "max_input_time", 			"-1" );

// ===============
// = Plugin Name =
// ===============
define( 'AI1EC_PLUGIN_NAME', 			basename( dirname( __FILE__ ) ) );

// ===================
// = Plugin Basename =
// ===================
define( 'AI1EC_PLUGIN_BASENAME',  plugin_basename( __FILE__ ) );

// ====================
// = Database Version =
// ====================
define( 'AI1EC_DB_VERSION', 			107 );

// ================
// = Cron Version =
// ================
define( 'AI1EC_CRON_VERSION', 		102 );

// ===============
// = Plugin Path =
// ===============
define( 'AI1EC_PATH', 						dirname( __FILE__ ) );

// ===============
// = Images Path =
// ===============
define( 'AI1EC_IMAGE_PATH', 			AI1EC_PATH . '/img' );

// ============
// = CSS Path =
// ============
define( 'AI1EC_CSS_PATH', 				AI1EC_PATH . '/css' );

// ===========
// = JS Path =
// ===========
define( 'AI1EC_JS_PATH', 					AI1EC_PATH . '/js' );

// ============
// = Lib Path =
// ============
define( 'AI1EC_LIB_PATH', 				AI1EC_PATH . '/lib' );

// =================
// = Language Path =
// =================
define( 'AI1EC_LANGUAGE_PATH', 	  AI1EC_PLUGIN_NAME . '/language' );

// ============
// = App Path =
// ============
define( 'AI1EC_APP_PATH', 				AI1EC_PATH . '/app' );

// ===================
// = Controller Path =
// ===================
define( 'AI1EC_CONTROLLER_PATH', 	AI1EC_APP_PATH . '/controller' );

// ==============
// = Model Path =
// ==============
define( 'AI1EC_MODEL_PATH', 			AI1EC_APP_PATH . '/model' );

// =============
// = View Path =
// =============
define( 'AI1EC_VIEW_PATH', 				AI1EC_APP_PATH . '/view' );

// ===============
// = Helper Path =
// ===============
define( 'AI1EC_HELPER_PATH', 			AI1EC_APP_PATH . '/helper' );

// ==================
// = Exception Path =
// ==================
define( 'AI1EC_EXCEPTION_PATH', 	AI1EC_APP_PATH . '/exception' );

// ==============
// = Plugin Url =
// ==============
define( 'AI1EC_URL', 							plugins_url( '', __FILE__ ) );

// ==============
// = Images URL =
// ==============
define( 'AI1EC_IMAGE_URL', 				AI1EC_URL . '/img' );

// ===========
// = CSS URL =
// ===========
define( 'AI1EC_CSS_URL', 					AI1EC_URL . '/css' );

// ==========
// = JS URL =
// ==========
define( 'AI1EC_JS_URL', 					AI1EC_URL . '/js' );

// =============
// = POST TYPE =
// =============
define( 'AI1EC_POST_TYPE', 				'ai1ec_event' );

// ======================================
// = FAKE CATEGORY ID FOR CALENDAR PAGE =
// ======================================
define( 'AI1EC_FAKE_CATEGORY_ID', -4113473042 ); // Numeric-only 1337-speak of AI1EC_CALENDAR - ID must be numeric

// ==============
// = SCRIPT URL =
// ==============
$ai1ec_script_url = get_option( 'home' ) . '/?plugin=' . AI1EC_PLUGIN_NAME;
define( 'AI1EC_SCRIPT_URL', 			$ai1ec_script_url );

// ====================================================
// = Convert http:// to webcal:// in AI1EC_SCRIPT_URL =
// =  (webcal:// protocol does not support https://)  =
// ====================================================
$tmp = str_replace( 'http://', 'webcal://', AI1EC_SCRIPT_URL );

// ==============
// = EXPORT URL =
// ==============
define( 'AI1EC_EXPORT_URL', "$tmp&controller=ai1ec_exporter_controller&action=export_events" );

// ====================================
// = Include iCal parsers and helpers =
// ====================================
require_once( AI1EC_LIB_PATH . '/iCalcreator.class.php' );
require_once( AI1EC_LIB_PATH . '/iCalUtilityFunctions.class.php' );
require_once( AI1EC_LIB_PATH . '/SG_iCal.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Line.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Duration.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Freq.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Recurrence.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Parser.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Query.php' );
require_once( AI1EC_LIB_PATH . '/helpers/SG_iCal_Factory.php' );

// ===============================
// = The autoload function =
// ===============================
function ai1ec_autoload( $class_name )
{
	// Convert class name to filename format.
	$class_name = strtr( strtolower( $class_name ), '_', '-' );
	$paths = array(
		AI1EC_CONTROLLER_PATH,
		AI1EC_MODEL_PATH,
		AI1EC_HELPER_PATH,
		AI1EC_EXCEPTION_PATH,
		AI1EC_LIB_PATH,
		AI1EC_VIEW_PATH,
	);

	// Search each path for the class.
	foreach( $paths as $path ) {
		if( file_exists( "$path/class-$class_name.php" ) )
		 	require_once( "$path/class-$class_name.php" );
	}
}
spl_autoload_register( 'ai1ec_autoload' );

// ===============================
// = Initialize and setup MODELS =
// ===============================
global $ai1ec_settings;

$ai1ec_settings = Ai1ec_Settings::get_instance();


// ================================
// = Initialize and setup HELPERS =
// ================================
global $ai1ec_view_helper,
       $ai1ec_settings_helper,
			 $ai1ec_calendar_helper,
			 $ai1ec_app_helper,
			 $ai1ec_events_helper,
			 $ai1ec_importer_helper,
			 $ai1ec_exporter_helper;

$ai1ec_view_helper     = Ai1ec_View_Helper::get_instance();
$ai1ec_settings_helper = Ai1ec_Settings_Helper::get_instance();
$ai1ec_calendar_helper = Ai1ec_Calendar_Helper::get_instance();
$ai1ec_app_helper			 = Ai1ec_App_Helper::get_instance();
$ai1ec_events_helper	 = Ai1ec_Events_Helper::get_instance();
$ai1ec_importer_helper = Ai1ec_Importer_Helper::get_instance();
$ai1ec_exporter_helper = Ai1ec_Exporter_Helper::get_instance();


// ====================================
// = Initialize and setup CONTROLLERS =
// ====================================
global $ai1ec_app_controller,
       $ai1ec_settings_controller,
       $ai1ec_events_controller,
       $ai1ec_calendar_controller,
       $ai1ec_importer_controller,
       $ai1ec_exporter_controller;

$ai1ec_app_controller      = Ai1ec_App_Controller::get_instance();
$ai1ec_settings_controller = Ai1ec_Settings_Controller::get_instance();
$ai1ec_events_controller   = Ai1ec_Events_Controller::get_instance();
$ai1ec_calendar_controller = Ai1ec_Calendar_Controller::get_instance();
$ai1ec_importer_controller = Ai1ec_Importer_Controller::get_instance();
$ai1ec_exporter_controller = Ai1ec_Exporter_Controller::get_instance();

// ===================
// = Call admin menu =
// ===================
$ai1ec_app_controller->setup_menus();
