<?php
// 
//  class-ai1ec-exporter-helper.php
//  all-in-one-event-calendar
//  
//  Created by The Seed Studio on 2011-07-13.
// 

/**
 * Ai1ec_Exporter_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class Ai1ec_Exporter_Helper {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 * 
	 * @var null | object
	 **/
	private static $_instance = NULL;
	
	/**
	 * Constructor
	 *
	 * Default constructor
	 **/
	private function __construct() { }

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
	 * insert_event_in_calendar function
	 *
	 * Add event to the calendar
	 *
	 * @param object $event Event object
	 * @param object $c Calendar object
	 *
	 * @return void
	 **/
	function insert_event_in_calendar( $event, &$c )
	{
		global $ai1ec_events_helper;

		$tz = get_option( 'timezone_string' );

		$e = & $c->newComponent( 'vevent' );
		$uid = $event->ical_uid ? $event->ical_uid : $event->post->guid;
		$e->setProperty( 'uid', $uid );
		$e->setProperty( 'url', get_permalink( $event->post_id ) );
		$e->setProperty( 'summary', html_entity_decode( apply_filters( 'the_title', $event->post->post_title ), ENT_QUOTES ) );
		$content = apply_filters( 'the_content', $event->post->post_content );
		$content = str_replace(']]>', ']]&gt;', $content);
		$e->setProperty( 'description', $content );
		if( $event->allday ) {
		  $dtstart = $dtend = array();
		  $dtstart["VALUE"] = $dtend["VALUE"] = 'DATE';
		  if( $tz )
		    $dtstart["TZID"] = $dtend["TZID"] = $tz;

			$e->setProperty( 'dtstart', gmdate( "Ymd\T", $ai1ec_events_helper->gmt_to_local( $event->start ) ), $dtstart );

			$e->setProperty( 'dtend', gmdate( "Ymd\T", $ai1ec_events_helper->gmt_to_local( $event->end ) ), $dtend );
		} else {
		  $dtstart = $dtend = array();
		  if( $tz )
		    $dtstart["TZID"] = $dtend["TZID"] = $tz;

			$e->setProperty( 'dtstart', gmdate( "Ymd\THis\Z", $ai1ec_events_helper->gmt_to_local( $event->start ) ), $dtstart );

			$e->setProperty( 'dtend', gmdate( "Ymd\THis\Z", $ai1ec_events_helper->gmt_to_local( $event->end ) ), $dtend );
		}
		$e->setProperty( 'location', $event->address );
		
		$contact = ! empty( $event->contact_name ) ? $event->contact_name : '';
		$contact .= ! empty( $event->contact_phone ) ? " ($event->contact_phone)" : '';
		$contact .= ! empty( $event->contact_email ) ? " <$event->contact_email>" : '';
		$e->setProperty( 'contact', $contact );
		
		$rrule = array();
		if( ! empty( $event->recurrence_rules ) ) {
			$rules = array();
			foreach( explode( ';', $event->recurrence_rules ) AS $v) {
				list($k, $v) = explode( '=', $v );
				// If $v is a comma-separated list, turn it into array for iCalcreator
				switch( $k ) {
					case 'BYSECOND':
          case 'BYMINUTE':
          case 'BYHOUR':
          case 'BYDAY':
          case 'BYMONTHDAY':
          case 'BYYEARDAY':
          case 'BYWEEKNO':
          case 'BYMONTH':
          case 'BYSETPOS':
						$exploded = explode( ',', $v );
						break;
					default:
						$exploded = $v;
						break;
				}
				// iCalcreator requires a more complex array structure for BYDAY...
				if( $k == 'BYDAY' ) {
					$v = array();
					foreach( $exploded as $day ) {
						$v[] = array( 'DAY' => $day );
					}
				} else {
					$v = $exploded;
				}
				$rrule[ $k ] = $v;
			}
		}

		if( ! empty( $rrule ) ) $e->setProperty( 'rrule', $rrule );
	}
}
