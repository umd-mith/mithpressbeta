<?php
//
//  class-ai1ec-exporter-controller.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Exporter_Controller class
 *
 * @package Controllers
 * @author The Seed Studio
 **/
class Ai1ec_Exporter_Controller {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return object
	 **/
	static function get_instance() {
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * Default constructor
	 **/
	private function __construct() { }

	/**
	 * export_events function
	 *
	 * Export events
	 *
	 * @return void
	 **/
	function export_events() {
		global $ai1ec_events_helper,
					 $ai1ec_exporter_helper;
		$ai1ec_cat_ids 	= isset( $_REQUEST['ai1ec_cat_ids'] ) 	&& ! empty( $_REQUEST['ai1ec_cat_ids'] ) 	? $_REQUEST['ai1ec_cat_ids'] 	: false;
		$ai1ec_tag_ids 	= isset( $_REQUEST['ai1ec_tag_ids'] ) 	&& ! empty( $_REQUEST['ai1ec_tag_ids'] ) 	? $_REQUEST['ai1ec_tag_ids'] 	: false;
		$ai1ec_post_ids = isset( $_REQUEST['ai1ec_post_ids'] )	&& ! empty( $_REQUEST['ai1ec_post_ids'] ) ? $_REQUEST['ai1ec_post_ids'] : false;
		// when exporting events by post_id, do not look up the event's start/end date/time
		$start				 	= $ai1ec_post_ids !== false ? false : gmmktime() - 24 * 60 * 60; // Include any events ending today
		$end 					 	= false;
		$events = $ai1ec_events_helper->get_matching_events( $start, $end, $ai1ec_tag_ids, $ai1ec_cat_ids, $ai1ec_post_ids );
		$c = new vcalendar();
		$c->setProperty( 'calscale', 'GREGORIAN' );
		$c->setProperty( 'method', 'PUBLISH' );
		$c->setProperty( 'X-WR-CALNAME', get_bloginfo( 'name' ) );
		$c->setProperty( 'X-WR-CALDESC', get_bloginfo( 'description' ) );
		// Timezone setup
		$tz = get_option( 'timezone_string' );
		if( $tz ) {
		  $c->setProperty( 'X-WR-TIMEZONE', $tz );
  		$tz_xprops = array( 'X-LIC-LOCATION' => $tz );
  		iCalUtilityFunctions::createTimezone( $c, $tz, $tz_xprops );
		}

		foreach( $events as $event ) {
			$ai1ec_exporter_helper->insert_event_in_calendar( $event, $c );
		}
		$str = $c->createCalendar();

		header( 'Content-type: text/calendar' );
		echo $str;
		exit;
	}
}
// END class
