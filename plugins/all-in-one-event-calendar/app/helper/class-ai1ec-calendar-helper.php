<?php
//
//  class-ai1ec-calendar-helper.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Calendar_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class Ai1ec_Calendar_Helper {
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
	 * get_events_for_month function
	 *
	 * Return an array of all dates for the current month as an associative
	 * array, with each element's value being another array of event objects
	 * representing the events occuring on that date.
	 *
	 * @param int $time         the UNIX timestamp of a date within the desired month
	 * @param array $categories the categories to filter events by
	 * @param array $tags       the tags to filter events by
	 *
	 * @return array            array of arrays as per function description
	 **/
	function get_events_for_month( $time, $categories = array(), $tags = array() )
	{
		global $ai1ec_events_helper;

		$days_events = array();

		$bits = $ai1ec_events_helper->gmgetdate( $time );
		$last_day = gmdate( 't', $time );

		// ==========================================
		// = Iterate through each date of the month =
		// ==========================================
		for( $day = 1; $day <= $last_day; $day++ )
	 	{
			$start_time = gmmktime( 0, 0, 0, $bits['mon'], $day, $bits['year'] );
			$end_time = gmmktime( 0, 0, 0, $bits['mon'], $day + 1, $bits['year'] );

			$days_events[$day] = $this->get_events_between(
				$start_time, $end_time, 'publish', $categories, $tags );
		}

		return $days_events;
	}

	/**
	 * get_month_cell_array function
	 *
	 * Return an array of weeks, each containing an array of days, each
	 * containing the date for the day ['date'] (if inside the month) and
	 * the events ['events'] (if any) for the day.
	 *
	 * @param int $timestamp	    UNIX timestamp of the 1st day of the desired
	 *                            month to display
	 * @param array $days_events  list of events for each day of the month in
	 *                            the format returned by get_events_for_month()
	 *
	 * @return void
	 **/
	function get_month_cell_array( $timestamp, $days_events )
	{
		global $ai1ec_settings, $ai1ec_events_helper;

		// Decompose date into components, used for calculations below
		$bits = $ai1ec_events_helper->gmgetdate( $timestamp );
		$today = $ai1ec_events_helper->gmgetdate( $ai1ec_events_helper->gmt_to_local( time() ) );	// Used to flag today's cell

		// Figure out index of first table cell
		$first_cell_index = gmdate( 'w', $timestamp );
		// Modify weekday based on start of week setting
		$first_cell_index = ( 7 + $first_cell_index - $ai1ec_settings->week_start_day ) % 7;

		// Get the last day of the month
		$last_day = gmdate( 't', $timestamp );
		$last_timestamp = gmmktime( 0, 0, 0, $bits['mon'], $last_day, $bits['year'] );
		// Figure out index of last table cell
		$last_cell_index = gmdate( 'w', $last_timestamp );
		// Modify weekday based on start of week setting
		$last_cell_index = ( 7 + $last_cell_index - $ai1ec_settings->week_start_day ) % 7;

		$weeks = array();
		$week = 0;
		$weeks[$week] = array();

		// Insert any needed blank cells into first week
		for( $i = 0; $i < $first_cell_index; $i++ ) {
			$weeks[$week][] = array( 'date' => null, 'events' => array() );
		}

		// Insert each month's day and associated events
		for( $i = 1; $i <= $last_day; $i++ ) {
			$weeks[$week][] = array(
				'date' => $i,
				'today' =>
					$bits['year'] == $today['year'] &&
					$bits['mon']  == $today['mon'] &&
				 	$i            == $today['mday'],
				'events' => $days_events[$i]
		 	);
			// If reached the end of the week, increment week
			if( count( $weeks[$week] ) == 7 )
				$week++;
		}

		// Insert any needed blank cells into last week
		for( $i = $last_cell_index + 1; $i < 7; $i++ ) {
			$weeks[$week][] = array( 'date' => null, 'events' => array() );
		}

		return $weeks;
	}

	/**
	 * get_events_between function
	 *
	 * Return all events starting after the given start time and before the
	 * given end time. If there are any all-day events spanning this period,
	 * then return those as well. All-day events are returned first.
	 *
	 * @param	int	$start_time     limit to events starting after this (local) UNIX time
	 * @param int $end_time       limit to events starting before this (local) UNIX time
	 * @param string $post_status limit to events matching this post_status
	 *                            (null for no restriction)
	 *
	 * @return array              list of matching event objects
	 **/
	function get_events_between( $start_time, $end_time, $post_status = 'publish' ) {
		global $wpdb, $ai1ec_events_helper, $current_user;

		// Convert timestamps to MySQL format in GMT time
		$start_time = $ai1ec_events_helper->local_to_gmt( $start_time );
		$end_time = $ai1ec_events_helper->local_to_gmt( $end_time );

		// Query arguments
		$args = array(
			$start_time,
			$end_time,
	 	);
	 	
	 	if( current_user_can( 'administrator' ) || current_user_can( 'editor' ) ) {
      $post_status = "AND ( post_status = %s OR post_status = %s ) ";
      $args[] = 'publish';
      $args[] = 'private';
    }
    else if( is_user_logged_in() ) {
      // get user info
      get_currentuserinfo();
      
      /**
       * include post_status = published
       * or
       * post_status = private and author = logged in user
       */
      $post_status = "AND " .
                        "( " .
                          "post_status = %s " .
                          
                          "OR " .
                          
                          "( " .
                            "post_status = %s " .
                            
                            "AND " .
                            
                            "post_author = %d " .
                          ") " .
                        ") ";

      $args[] = 'publish';
      $args[] = 'private';
      $args[] = $current_user->ID;
    } else {
      $post_status = "AND post_status = %s ";
      $args[] = 'publish';
    }

		$query = $wpdb->prepare(
			"SELECT p.*, e.post_id, i.id AS instance_id, " .
			"UNIX_TIMESTAMP( i.start ) AS start, " .
			"UNIX_TIMESTAMP( i.end ) AS end, " .
			// Treat event instances that span 24 hours as all-day
			"IF( e.allday, e.allday, i.end = DATE_ADD( i.start, INTERVAL 1 DAY ) ) AS allday, " .
			"e.recurrence_rules, e.exception_rules, e.recurrence_dates, e.exception_dates, " .
			"e.venue, e.country, e.address, e.city, e.province, e.postal_code, " .
			"e.show_map, e.contact_name, e.contact_phone, e.contact_email, e.cost, " .
			"e.ical_feed_url, e.ical_source_url, e.ical_organizer, e.ical_contact, e.ical_uid " .
			"FROM {$wpdb->prefix}ai1ec_events e " .
				"INNER JOIN $wpdb->posts p ON p.ID = e.post_id " .
				"INNER JOIN {$wpdb->prefix}ai1ec_event_instances i ON e.post_id = i.post_id " .
			"WHERE post_type = '" . AI1EC_POST_TYPE . "' " .
			"AND i.start >= FROM_UNIXTIME( %d ) " .
			"AND i.start < FROM_UNIXTIME( %d ) " .
			$post_status .
			"ORDER BY allday DESC, i.start ASC, post_title ASC",
			$args );

		$events = $wpdb->get_results( $query, ARRAY_A );
		foreach( $events as &$event ) {
			$event = new Ai1ec_Event( $event );
		}

		return $events;
	}

	/**
	 * get_events_relative_to function
	 *
	 * Return all events starting after the given reference time, limiting the
	 * result set to a maximum of $limit items, offset by $page_offset. A
	 * negative $page_offset can be provided, which will return events *before*
	 * the reference time, as expected.
	 *
	 * @param	int	$time	          limit to events starting after this (local) UNIX time
	 * @param int $limit          return a maximum of this number of items
	 * @param int $page_offset    offset the result set by $limit times this number
	 * @param string $post_status limit to events matching this post_status
	 *                            (null for no restriction)
	 *
	 *
	 * @return array              three-element array:
	 *                              ['events'] an array of matching event objects
	 *															['prev'] true if more previous events
	 *															['next'] true if more next events
	 **/
	function get_events_relative_to( $time, $limit = 0, $page_offset = 0, $post_status = 'publish' ) {
		global $wpdb, $ai1ec_events_helper, $current_user;

		// Figure out what the beginning of the day is to properly query all-day
		// events; then convert to GMT time
		$bits = $ai1ec_events_helper->gmgetdate( $time );

		// Convert timestamp to GMT time
		$time = $ai1ec_events_helper->local_to_gmt( $time );

		// Query arguments
		$args = array( $time );

		if( $page_offset >= 0 )
			$first_record = $page_offset * $limit;
		else
			$first_record = ( -$page_offset - 1 ) * $limit;
		
		// administrators and editors can see private posts
		if( current_user_can( 'administrator' ) || current_user_can( 'editor' ) ) {
      $post_status = "AND ( post_status = %s OR post_status = %s ) ";
      $args[] = 'publish';
      $args[] = 'private';
    }
    else if( is_user_logged_in() ) {
      // get user info
      get_currentuserinfo();
      
      /**
       * include post_status = published
       * or
       * post_status = private and author = logged in user
       */
      $post_status = "AND " .
                        "( " .
                          "post_status = %s " .
                          
                          "OR " .
                          
                          "( " .
                            "post_status = %s " .
                            
                            "AND " .
                            
                            "post_author = %d " .
                          ") " .
                        ") ";

      $args[] = 'publish';
      $args[] = 'private';
      $args[] = $current_user->ID;
    } else {
      $post_status = "AND post_status = %s ";
      $args[] = 'publish';
    }

		$query = $wpdb->prepare(
			"SELECT SQL_CALC_FOUND_ROWS p.*, e.post_id, i.id AS instance_id, " .
			"UNIX_TIMESTAMP( i.start ) AS start, " .
			"UNIX_TIMESTAMP( i.end ) AS end, " .
			// Treat event instances that span 24 hours as all-day
			"IF( e.allday, e.allday, i.end = DATE_ADD( i.start, INTERVAL 1 DAY ) ) AS allday, " .
			"e.recurrence_rules, e.exception_rules, e.recurrence_dates, e.exception_dates, " .
			"e.venue, e.country, e.address, e.city, e.province, e.postal_code, " .
			"e.show_map, e.contact_name, e.contact_phone, e.contact_email, e.cost, " .
			"e.ical_feed_url, e.ical_source_url, e.ical_organizer, e.ical_contact, e.ical_uid " .
			"FROM {$wpdb->prefix}ai1ec_events e " .
				"INNER JOIN $wpdb->posts p ON e.post_id = p.ID " .
				"INNER JOIN {$wpdb->prefix}ai1ec_event_instances i ON e.post_id = i.post_id " .
			"WHERE post_type = '" . AI1EC_POST_TYPE . "' " .
			"AND " .
				( $page_offset >= 0 ? "i.end >= FROM_UNIXTIME( %d ) "
					: "i.start < FROM_UNIXTIME( %d ) "
				) .
      $post_status .
			// Reverse order when viewing negative pages, to get correct set of
			// records. Then reverse results later to order them properly.
			"ORDER BY i.start " . ( $page_offset >= 0 ? 'ASC' : 'DESC' ) .
				", post_title " . ( $page_offset >= 0 ? 'ASC' : 'DESC' ) .
			" LIMIT $first_record, $limit",
			$args );

		$events = $wpdb->get_results( $query, ARRAY_A );

		// Re-order records if in negative page offset
		if( $page_offset < 0 ) $events = array_reverse( $events );

		foreach( $events as &$event ) {
			$event = new Ai1ec_Event( $event );
		}

		// Find out if there are more records in the current nav direction
		$more = $wpdb->get_var( 'SELECT FOUND_ROWS()' ) > $first_record + $limit;

		// Navigating in the future
		if( $page_offset > 0 ) {
			$prev = true;
			$next = $more;
		}
		// Navigating in the past
	 	elseif( $page_offset < 0 ) {
			$prev = $more;
			$next = true;
		}
		// Navigating from the reference time
	 	else {
			$query = $wpdb->prepare(
				"SELECT COUNT(*) " .
				"FROM {$wpdb->prefix}ai1ec_events e " .
				"INNER JOIN {$wpdb->prefix}ai1ec_event_instances i ON e.post_id = i.post_id " .
				"INNER JOIN $wpdb->posts p ON e.post_id = p.ID " .
				"WHERE post_type = '" . AI1EC_POST_TYPE . "' " .
				"AND i.start < FROM_UNIXTIME( %d ) " .
				( $post_status == null ? '' : "AND post_status = %s " ),
				$args );
			$prev = $wpdb->get_var( $query );
			$next = $more;
		}
		return array(
			'events' => $events,
			'prev' => $prev,
			'next' => $next,
		);
	}

	/**
	 * get_agenda_date_array function
	 *
	 * Breaks down the given ordered array of event objects into dates, and
	 * outputs an ordered array of two-element associative arrays in the
	 * following format:
	 *	key: localized UNIX timestamp of date
	 *	value:
	 *		['events'] => two-element associatative array broken down thus:
	 *			['allday'] => all-day events occurring on this day
	 *			['notallday'] => all other events occurring on this day
	 *		['today'] => whether or not this date is today
	 *
	 * @param array $events
	 *
	 * @return array
	 **/
	function get_agenda_date_array( $events ) {
		global $ai1ec_events_helper;

		$dates = array();

		// Classify each event into a date/allday category
		foreach( $events as $event ) {
			$date = $ai1ec_events_helper->gmt_to_local( $event->start );
			$date = $ai1ec_events_helper->gmgetdate( $date );
			$timestamp = gmmktime( 0, 0, 0, $date['mon'], $date['mday'], $date['year'] );
			$category = $event->allday ? 'allday' : 'notallday';
			$dates[$timestamp]['events'][$category][] = $event;
		}

		// Flag today
		$today = $ai1ec_events_helper->gmt_to_local( time() );
		$today = $ai1ec_events_helper->gmgetdate( $today );
		$today = gmmktime( 0, 0, 0, $today['mon'], $today['mday'], $today['year'] );
		if( isset( $dates[$today] ) )
			$dates[$today]['today'] = true;

		return $dates;
	}

	/**
	 * get_calendar_url function
	 *
	 * Returns the URL of the configured calendar page in the default view,
	 * optionally preloaded at the month containing the given event (rather than
	 * today's date), and optionally prefiltered by the given category IDs and/or
	 * tag IDs.
	 *
	 * @param object|null $event The event to focus the calendar on
	 * @param array $cat_ids The category IDs to filter the calendar by
	 * @param array $tag_ids The tag IDs to filter the calendar by
	 *
	 * @return string The URL for this calendar
	 **/
	function get_calendar_url( $event = null, $cat_ids = array(), $tag_ids = array() ) {
		global $ai1ec_settings, $ai1ec_events_helper, $ai1ec_app_helper, $wpdb;

		$url = get_permalink( $ai1ec_settings->calendar_page_id );

		if( $event )
		{
			$url .= $ai1ec_app_helper->get_param_delimiter_char( $url );

			switch( $ai1ec_settings->default_calendar_view )
			{
				case 'month':
					// Get components of localized timstamps and calculate month offset
					$today = $ai1ec_events_helper->gmgetdate( $ai1ec_events_helper->gmt_to_local( time() ) );
					$desired = $ai1ec_events_helper->gmgetdate( $ai1ec_events_helper->gmt_to_local( $event->start ) );
					$month_offset =
					 	( $desired['year'] - $today['year'] ) * 12 +
						$desired['mon'] - $today['mon'];

					$url .= "ai1ec_month_offset=$month_offset";
					break;

				case 'agenda':
					// Find out how many event instances are between today's first
					// instance and the desired event's instance
					$now = $ai1ec_events_helper->local_to_gmt( time() );
					$after_today = $event->end >= $now;
					$query = $wpdb->prepare(
						"SELECT COUNT(*) FROM {$wpdb->prefix}ai1ec_events e " .
							"INNER JOIN $wpdb->posts p ON e.post_id = p.ID " .
							"INNER JOIN {$wpdb->prefix}ai1ec_event_instances i ON e.post_id = i.post_id " .
						"WHERE post_type = '" . AI1EC_POST_TYPE . "' " .
						"AND post_status = 'publish' " .
						( $after_today
							? "AND i.end >= FROM_UNIXTIME( %d ) AND i.end < FROM_UNIXTIME( %d ) "
							: "AND i.start < FROM_UNIXTIME( %d ) AND i.start >= FROM_UNIXTIME( %d ) "
						) .
						"ORDER BY i.start ASC",
						array( $now, $after_today ? $event->end : $event->start ) );
					$count = $wpdb->get_var( $query );
					// ( $count - 1 ) below solves boundary case for first event of each agenda page
					$page_offset = intval( ( $count - 1 ) / $ai1ec_settings->agenda_events_per_page );
					if( ! $after_today ) $page_offset = -1 - $page_offset;

					$url .= "ai1ec_page_offset=$page_offset";
					break;
			}

			$url .= "&ai1ec_active_event=$event->post_id";
		}

		if( $cat_ids )
			$url .= $ai1ec_app_helper->get_param_delimiter_char( $url ) .
				'ai1ec_cat_ids=' . join( ',', $cat_ids );
		if( $tag_ids )
			$url .= $ai1ec_app_helper->get_param_delimiter_char( $url ) .
				'ai1ec_tag_ids=' . join( ',', $tag_ids );

		return $url;
	}

	/**
	 * get_weekdays function
	 *
	 * Returns a list of abbreviated weekday names starting on the configured
	 * week start day setting.
	 *
	 * @return array
	 **/
	function get_weekdays() {
		global $ai1ec_settings;
		static $weekdays;

		if( ! isset( $weekdays ) )
	 	{
			$time = strtotime( 'next Sunday' );
			$time = strtotime( "+{$ai1ec_settings->week_start_day} days", $time );

			$weekdays = array();
			for( $i = 0; $i < 7; $i++ ) {
				$weekdays[] = date_i18n( 'D', $time );
				$time += 60 * 60 * 24; // Add a day
			}
		}
		return $weekdays;
	}

	/**
	 * get_month_pagination_links function
	 *
	 * Returns an associative array of four links for the month view of the
	 * calendar:
	 * previous year, previous month, next month, and next year, in that order.
	 * Each element's key is an associative array containing the link's ID
	 * ['id'], text ['text'] and value to assign to link's href ['href'].
	 *
	 * @param int $cur_offset month offset of current month, needed for hrefs
	 *
	 * @return array          array of link information as described above
	 **/
	function get_month_pagination_links( $cur_offset ) {
		global $ai1ec_events_helper;

		$links = array();

		// Base timestamp on offset month
		$bits = $ai1ec_events_helper->gmgetdate( $ai1ec_events_helper->gmt_to_local( time() ) );
		$bits['mon'] += $cur_offset;
		// 'mon' may now be out of range (< 1 or > 12), so recreate $bits to make sane
		$bits = $ai1ec_events_helper->gmgetdate( gmmktime( 0, 0, 0, $bits['mon'], 1, $bits['year'] ) );

		$links[] = array(
			'id' => 'ai1ec-prev-year',
			'text' => '« ' . ( $bits['year'] - 1 ),
			'href' => '#action=ai1ec_month&ai1ec_month_offset=' . ( $cur_offset - 12 ),
		);
		$links[] = array(
			'id' => 'ai1ec-prev-month',
			'text' => '‹ ' . date_i18n( 'M', gmmktime( 0, 0, 0, $bits['mon'] - 1, 1, $bits['year'] ), true ),
			'href' => '#action=ai1ec_month&ai1ec_month_offset=' . ( $cur_offset - 1 ),
		);
		$links[] = array(
			'id' => 'ai1ec-next-month',
			'text' => date_i18n( 'M', gmmktime( 0, 0, 0, $bits['mon'] + 1, 1, $bits['year'] ), true ) . ' ›',
			'href' => '#action=ai1ec_month&ai1ec_month_offset=' . ( $cur_offset + 1 ),
		);
		$links[] = array(
			'id' => 'ai1ec-next-year',
			'text' => ( $bits['year'] + 1 ) . ' »',
			'href' => '#action=ai1ec_month&ai1ec_month_offset=' . ( $cur_offset + 12 ),
		);

		return $links;
	}

	/**
	 * get_agenda_pagination_links function
	 *
	 * Returns an associative array of two links for the agenda view of the
	 * calendar: previous page (if previous events exist), next page (if next
	 * events exist), in that order.
	 * Each element' is an associative array containing the link ID ['id'],
	 * text ['text'] and value to assign to link's href ['href'].
	 *
	 * @param int $cur_offset page offset of agenda view, needed for hrefs
	 * @param int $prev       whether there are more events before the current page
	 * @param int $next       whether there are more events after the current page
	 *
	 * @return array          array of link information as described above
	 **/
	function get_agenda_pagination_links( $cur_offset, $prev = false, $next = false ) {
		global $ai1ec_settings;

		$links = array();

		if( $prev ) {
			$links['prev'] = array(
				'id' => 'ai1ec-prev-page',
				'text' => sprintf( __( '« Previous Events', AI1EC_PLUGIN_NAME ), $ai1ec_settings->agenda_events_per_page ),
				'href' => '#action=ai1ec_agenda&ai1ec_page_offset=' . ( $cur_offset - 1 ),
			);
		}
		if( $next ) {
			$links['next'] = array(
				'id' => 'ai1ec-next-page',
				'text' => sprintf( __( 'Next Events »', AI1EC_PLUGIN_NAME ), $ai1ec_settings->agenda_events_per_page ),
				'href' => '#action=ai1ec_agenda&ai1ec_page_offset=' . ( $cur_offset + 1 ),
			);
		}

		return $links;
	}
}
// END class
