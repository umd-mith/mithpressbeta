<?php
//
//  class-ai1ec-events-controller.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Events_Controller class
 *
 * @package Controllers
 * @author The Seed Studio
 **/
class Ai1ec_Events_Controller {
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
	 **/
	private function __construct() { }

	/**
	 * delete_hook function
	 *
	 * If the deleted post is an event
	 * then all entries that match the post_id are
	 * removed from ai1ec_events and ai1ec_event_instances tables
	 *
	 * @param int $pid Post ID
	 *
	 * @return bool | int
	 **/
	function delete_post( $pid ) {
		global $wpdb;

		$sql = "SELECT
							ID
						FROM
							$wpdb->posts
						WHERE
							ID = %d AND
							post_type = '" . AI1EC_POST_TYPE . "'";

		// is this post an event?
		if( $wpdb->get_var( $wpdb->prepare( $sql, $pid ) ) ) {
			$table_name = $wpdb->prefix . 'ai1ec_events';
			$sql = "DELETE FROM
								$table_name
							WHERE
								post_id = %d";
			// delete from ai1ec_events
			$wpdb->query( $wpdb->prepare( $sql, $pid ) );

			$table_name = $wpdb->prefix . 'ai1ec_event_instances';
			$sql = "DELETE FROM
								$table_name
							WHERE
								post_id = %d";
			// delete from ai1ec_event_instances
			return $wpdb->query( $wpdb->prepare( $sql, $pid ) );
		}
		return true;
	}

	/**
	 * init function
	 *
	 * This function is executed when admin_head hook is called.
	 * Adds CSS and JS files.
	 *
	 * @return void
	 **/
	function init()
	{
		global $ai1ec_events_helper, $ai1ec_settings;

		// Initialize dashboard view
		if( is_admin() ) {
			// ======
			// = JS =
			// ======
			// Include timespan helper functions
			wp_enqueue_script( 'jquery.calendrical', 			AI1EC_JS_URL . '/jquery.calendrical.js', array( 'jquery' ) );
			// Include timespan plugin
			wp_enqueue_script( 'jquery.timespan', 				AI1EC_JS_URL . '/jquery.timespan.js', array( 'jquery', 'jquery.calendrical' ) );
			// Include timespan plugin
			wp_enqueue_script( 'jquery.inputdate', 				AI1EC_JS_URL . '/jquery.inputdate.js', array( 'jquery', 'jquery.calendrical' ) );
			// Include Google Maps API
			wp_enqueue_script( 'gmap_api', 								'http://maps.google.com/maps/api/js?sensor=false' );
			// Include autocomplete_geomod plugin
			wp_enqueue_script( 'autocomplete_geomod', 		AI1EC_JS_URL . '/jquery.autocomplete_geomod.js', array( 'jquery' ) );
			// Include geo_autocomplete plugin
			wp_enqueue_script( 'geo_autocomplete', 				AI1EC_JS_URL . '/geo_autocomplete.js', array( 'jquery', 'autocomplete_geomod' ) );
			// Include element selector function
			wp_enqueue_script( 'ai1ec-element-selector', 	AI1EC_JS_URL . '/element-selector.js', array( 'jquery' ) );
			// Include jQuery Tools form elements
			wp_enqueue_script( 'jquery.tools-form',       'http://cdn.jquerytools.org/1.2.5/form/jquery.tools.min.js', array( 'jquery' ), '1.2.5' );
			// Include add new event script
			wp_enqueue_script( 'ai1ec-add_new_event', 		AI1EC_JS_URL . '/add_new_event.js', array( 'jquery', 'jquery.timespan', 'ai1ec-element-selector', 'jquery.tools-form' ) );
			wp_enqueue_script( 'ai1ec-color-picker', 	    AI1EC_JS_URL . '/colorpicker.js', array( 'jquery' ) );

			// Supply custom value to JavaScript from PHP
			wp_localize_script( 'ai1ec-add_new_event', 'ai1ec_add_new_event', array(
				// Current time, used for date/time pickers
				'now'                    => $ai1ec_events_helper->gmt_to_local( time() ),
				// US input format for date pickers
				'us_format'              => $ai1ec_settings->input_us_format,
        // 24h time format for time pickers
        'twentyfour_hour'        => $ai1ec_settings->input_24h_time,
				// ICS feed error messages
				'duplicate_feed_message' => esc_html__( 'This feed is already being imported.', AI1EC_PLUGIN_NAME ),
				'invalid_url_message'    => esc_html__( 'Please enter a valid iCalendar URL.', AI1EC_PLUGIN_NAME ),
			) );

			// =======
			// = CSS =
			// =======
			// include autocomplete style
			wp_enqueue_style( 'autocomplete',         AI1EC_CSS_URL . '/jquery.autocomplete.css' );
			// include colorpicker style
			wp_enqueue_style( 'colorpicker',          AI1EC_CSS_URL . '/colorpicker.css' );
			// include add new event style
			wp_enqueue_style( 'ai1ec_add_new_event',  AI1EC_CSS_URL . '/add_new_event.css' );
		}
		// Initialize front-end view
		else
		{
			// ======
			// = JS =
			// ======
			wp_enqueue_script( 'ai1ec-event', AI1EC_JS_URL . '/event.js', array( 'jquery' ), 1 );

			// =======
			// = CSS =
			// =======
			wp_enqueue_style( 'ai1ec-general', AI1EC_CSS_URL . '/general.css', array(), 1 );
			wp_enqueue_style( 'ai1ec-event', AI1EC_CSS_URL . '/event.css', array(), 1 );
		}
	}

	/**
	 * meta_box_view function
	 *
	 * Add Events Calculator box to the Add New Event page
	 *
	 * @return void
	 **/
	function meta_box_view() {
		global $ai1ec_view_helper,
					 $ai1ec_events_helper,
					 $post,
					 $wpdb,
					 $ai1ec_settings;

		try
	 	{
			$event = new Ai1ec_Event( $post->ID );

			// Existing event was found. Initialize form values with values from
			// event object.

			$all_day_event = $event->allday ? 'checked="checked"' : '';

			$start_timestamp = $ai1ec_events_helper->gmt_to_local( $event->start );
			$end_timestamp 	 = $ai1ec_events_helper->gmt_to_local( $event->end );

			$show_map = $event->show_map;
			$google_map = $show_map ? 'checked="checked"' : '';

			$venue         = $event->venue;
			$country       = $event->country;
			$address       = $event->address;
			$city          = $event->city;
			$province      = $event->province;
			$postal_code   = $event->postal_code;
			$contact_name  = $event->contact_name;
			$contact_phone = $event->contact_phone;
			$contact_email = $event->contact_email;
			$cost          = $event->cost;
		}
		catch( Ai1ec_Event_Not_Found $e ) {
			// Event does not exist.
			// Leave form fields undefined (= zero-length strings)
			$event = null;
	 	}

		// Recurrence fields
		$recurrence = $ai1ec_events_helper->parse_recurrence_rules( $event );
		extract( $recurrence );

		// Time zone
		$timezone = get_option( 'gmt_offset' );
		$timezone = sprintf( '(GMT%+d:%02d)', intval( $timezone ), ( abs( $timezone ) * 60 ) % 60 );

		// ===============================
		// = Display event time and date =
		// ===============================
		if( is_null( $until ) ) $until = gmmktime();
		$repeating_event = is_null( $repeat ) ? false : true;
		$args = array(
			'all_day_event'   => $all_day_event,
			'start_timestamp' => $start_timestamp,
			'end_timestamp'   => $end_timestamp,
			'repeat'          => $ai1ec_events_helper->create_repeat_dropdown( $repeat ),
			'count'           => $ai1ec_events_helper->create_count_input( $count ),
			'end'             => $ai1ec_events_helper->create_end_dropdown( $end ),
			'until'           => $until,
			'repeating_event' => $repeating_event,
			'timezone'        => $timezone,
			'ending'          => $end
		);
		$ai1ec_view_helper->display( 'box_time_and_date.php', $args );

		// =================================================
		// = Display event location details and Google map =
		// =================================================
		$args = array(
			'venue'						=> $venue,
			'country' 				=> $country,
			'address'					=> $address,
			'city'						=> $city,
			'province' 				=> $province,
			'postal_code' 		=> $postal_code,
			'google_map' 			=> $google_map,
			'show_map'        => $show_map,
		);
		$ai1ec_view_helper->display( 'box_event_location.php', $args );

		// ======================
		// = Display event cost =
		// ======================
		$args = array(
			'cost' => $cost
		);
		$ai1ec_view_helper->display( 'box_event_cost.php', $args );

		// =========================================
		// = Display organizer contact information =
		// =========================================
		$args = array(
			'contact_name'    => $contact_name,
			'contact_phone'   => $contact_phone,
			'contact_email'   => $contact_email,
		);
		$ai1ec_view_helper->display( 'box_event_contact.php', $args );

		if( $ai1ec_settings->show_publish_button ) {
			$args = array();
			$post_type = $post->post_type;
			$post_type_object = get_post_type_object( $post_type );
			if( current_user_can( $post_type_object->cap->publish_posts ) )
				$args["button_value"] = is_null( $event ) ? __( 'Publish', AI1EC_PLUGIN_NAME ) : __( 'Update', AI1EC_PLUGIN_NAME );
			else
				$args["button_value"] = __( 'Submit for Review', AI1EC_PLUGIN_NAME );

			$ai1ec_view_helper->display( 'box_publish_button.php', $args );
		}

		/*
			TODO Display Eventbrite ticketing
			$ai1ec_view_helper->display( 'box_eventbrite.php' );
		*/
	}

	/**
	 * save_post function
	 *
	 * Saves meta post data
	 *
	 * @param int $post_id Post ID
	 *
	 * @return void
	 **/
	function save_post( $post_id ) {
		global $wpdb, $ai1ec_events_helper;
		
		// verify if this is not an auto save routine.
		if( ! defined( 'DOING_AUTOSAVE' ) && ! DOING_AUTOSAVE ) {

		  // verify this came from the our screen and with proper authorization,
		  // because save_post can be triggered at other times
		  if ( ! wp_verify_nonce( $_POST[AI1EC_POST_TYPE], 'ai1ec' ) ) {
			  return;
		  }
	  }
	  
	  // verify if this is not inline-editing
	  if( $_REQUEST['action'] == 'inline-save' ) {
	    return;
	  }

		// verify that the post_type is that of an event
		if( $_POST['post_type'] != AI1EC_POST_TYPE ) {
			return;
		}

		$all_day          = isset( $_POST['ai1ec_all_day_event'] )    ? 1                                             : 0;
		$start_time       = isset( $_POST['ai1ec_start_time'] )       ? $_POST['ai1ec_start_time']                    : '';
		$end_time         = isset( $_POST['ai1ec_end_time'] )         ? $_POST['ai1ec_end_time']                      : '';
		$venue            = isset( $_POST['ai1ec_venue'] )            ? stripslashes( $_POST['ai1ec_venue'] )         : '';
		$address          = isset( $_POST['ai1ec_address'] )          ? stripslashes( $_POST['ai1ec_address'] )       : '';
		$city             = isset( $_POST['ai1ec_city'] )             ? stripslashes( $_POST['ai1ec_city'] )          : '';
		$province         = isset( $_POST['ai1ec_province'] )         ? stripslashes( $_POST['ai1ec_province'] )      : '';
		$postal_code      = isset( $_POST['ai1ec_postal_code'] )      ? stripslashes( $_POST['ai1ec_postal_code'] )   : '';
		$country          = isset( $_POST['ai1ec_country'] )          ? stripslashes( $_POST['ai1ec_country'] )       : '';
		$google_map       = isset( $_POST['ai1ec_google_map'] )       ? 1                                             : 0;
		$cost             = isset( $_POST['ai1ec_cost'] )             ? stripslashes( $_POST['ai1ec_cost'] )          : '';
		$contact_name     = isset( $_POST['ai1ec_contact_name'] )     ? stripslashes( $_POST['ai1ec_contact_name'] )  : '';
		$contact_phone    = isset( $_POST['ai1ec_contact_phone'] )    ? stripslashes( $_POST['ai1ec_contact_phone'] ) : '';
		$contact_email    = isset( $_POST['ai1ec_contact_email'] )    ? stripslashes( $_POST['ai1ec_contact_email'] ) : '';

		$rrule = null;

		if( isset( $_POST['ai1ec_repeat'] ) && ! empty( $_POST['ai1ec_repeat'] ) && $_POST['ai1ec_repeat'] != ' ' ) {
			// ================================
			// = Repeating event, build rrule =
			// ================================
			$end = (int) $_POST['ai1ec_end'];
			switch( $end ) {
			  // Never
			  case 0:
			    $end = '';
			    break;
			  // After
			  case 1:
			    $end = ';COUNT=' . (int) $_POST['ai1ec_count'];
			    break;
			  // On date
			  case 2:
			    $until = $_POST['ai1ec_until_time'];
    			$until = gmdate( 'Ymd', $until );
			    $end = ';UNTIL=' . $until;
			    break;
			}

			switch( $_POST['ai1ec_repeat'] ) {
			  // Daily
				case 'DAILY':
					$rrule = 'FREQ=DAILY';
					break;
				// Mondays
				case 'MO':
					$rrule = 'FREQ=DAILY;BYDAY=MO';
					break;
				// Tuesdays
				case 'TU':
					$rrule = 'FREQ=DAILY;BYDAY=TU';
					break;
				// Wednesdays
				case 'WE':
					$rrule = 'FREQ=DAILY;BYDAY=WE';
					break;
				// Thursdays
				case 'TH':
					$rrule = 'FREQ=DAILY;BYDAY=TH';
					break;
				// Fridays
				case 'FR':
					$rrule = 'FREQ=DAILY;BYDAY=FR';
					break;
				// Tuesdays and Thursdays
				case 'TU+TH':
					$rrule = 'FREQ=DAILY;BYDAY=TU,TH';
					break;
				// Mondays Wednesdays Fridays
				case 'MO+WE+FR':
					$rrule = 'FREQ=DAILY;BYDAY=MO,WE,FR';
					break;
				// Weekends
				case 'WEEKDAYS':
					$rrule = 'FREQ=DAILY;BYDAY=MO,TU,WE,TH,FR';
					break;
				// Saturdays
				case 'SA':
					$rrule = 'FREQ=DAILY;BYDAY=SA';
					break;
				// Sundays
				case 'SU':
					$rrule = 'FREQ=DAILY;BYDAY=SU';
					break;
				// Weekends
				case 'WEEKENDS':
					$rrule = 'FREQ=DAILY;BYDAY=SA+SU';
					break;
			  // Weekly
				case 'WEEKLY':
					$rrule = 'FREQ=WEEKLY';
					break;
				// Monthly
				case 'MONTHLY':
					$rrule = 'FREQ=MONTHLY';
					break;
				// Yearly
				case 'YEARLY':
					$rrule = 'FREQ=YEARLY';
					break;
			}

			$rrule .= $end;
		}

		$is_new = false;
		$event 	= null;
		try {
			$event = new Ai1ec_Event( $post_id ? $post_id : null );
		} catch( Ai1ec_Event_Not_Found $e ) {
			// Post exists, but event data hasn't been saved yet. Create new event
			// object.
			$is_new = true;
			$event = new Ai1ec_Event();
			$event->post_id = $post_id;
		}

		$event->start 						= $ai1ec_events_helper->local_to_gmt( $start_time );
		$event->end 							= $ai1ec_events_helper->local_to_gmt( $end_time );
		$event->allday 						= $all_day;
		$event->venue 						= $venue;
		$event->address 					= $address;
		$event->city 							= $city;
		$event->province 					= $province;
		$event->postal_code 			= $postal_code;
		$event->country 					= $country;
		$event->show_map 					= $google_map;
		$event->cost				 			= $cost;
		$event->contact_name			= $contact_name;
		$event->contact_phone			= $contact_phone;
		$event->contact_email			= $contact_email;
		$event->recurrence_rules 	= $rrule;
		$event->save( ! $is_new );

		$ai1ec_events_helper->delete_event_cache( $post_id );
		$ai1ec_events_helper->cache_event( $event );
		return;
	}

	/**
	 * post_updated_messages function
	 *
	 * Filter success messages returned by WordPress when an event post is
	 * updated/saved.
	 */
	function post_updated_messages( $messages )
	{
		global $post, $post_ID;

		$messages[AI1EC_POST_TYPE] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __( 'Event updated. <a href="%s">View event</a>', AI1EC_PLUGIN_NAME ), esc_url( get_permalink( $post_ID ) ) ),
			2 => __( 'Custom field updated.', AI1EC_PLUGIN_NAME ),
			3 => __( 'Custom field deleted.', AI1EC_PLUGIN_NAME ),
			4 => __( 'Event updated.', AI1EC_PLUGIN_NAME ),
			/* translators: %s: date and time of the revision */
			5 => isset( $_GET['revision'] ) ? sprintf( __( 'Event restored to revision from %s', AI1EC_PLUGIN_NAME ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __( 'Event published. <a href="%s">View event</a>', AI1EC_PLUGIN_NAME ), esc_url( get_permalink($post_ID) ) ),
			7 => __( 'Event saved.' ),
			8 => sprintf( __( 'Event submitted. <a target="_blank" href="%s">Preview event</a>', AI1EC_PLUGIN_NAME ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9 => sprintf( __( 'Event scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview event</a>', AI1EC_PLUGIN_NAME ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', AI1EC_PLUGIN_NAME ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __( 'Event draft updated. <a target="_blank" href="%s">Preview event</a>', AI1EC_PLUGIN_NAME ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
		);

		return $messages;
	}

	/**
	 * event_content function
	 *
	 * Filter event post content by inserting relevant details of the event
	 * alongside the regular post content.
	 *
	 * @param string $content Post/Page content
	 *
	 * @return string         Post/Page content
	 **/
	function event_content( $content )
	{
		global $ai1ec_events_helper;

		if( get_post_type() == AI1EC_POST_TYPE ) {
			$event = $ai1ec_events_helper->get_event( get_the_ID() );
			$content = $this->get_view( $event, $content );
		}
		return $content;
	}

	/**
	 * event_excerpt function
	 *
	 * Overrides what wp_trim_excerpt() returned if the post is an event,
	 * and outputs better rich-text (but not too rich) excerpt instead.
	 *
	 * @return void
	 **/
	function event_excerpt( $text )
 	{
		global $ai1ec_view_helper,
		       $ai1ec_events_helper;

		if( get_post_type() != AI1EC_POST_TYPE )
			return $text;

		$event = new Ai1ec_Event( get_the_ID() );

		ob_start();

		$this->excerpt_view( $event );

		// Re-apply any filters to the post content that normally would have been
		// applied if it weren't for our interference (below).
		echo
		 	shortcode_unautop( wpautop(
				$ai1ec_events_helper->trim_excerpt( $event->post->post_content )
			) );

		$page_content = ob_get_contents();
		ob_end_clean();

		return $page_content;
	}

	/**
	 * event_excerpt_noautop function
	 *
	 * Conditionally apply wpautop() filter to content, only if it is not an
	 * event.
	 *
	 * @return void
	 **/
	function event_excerpt_noautop( $content )
	{
		if( get_post_type() != AI1EC_POST_TYPE )
			return wpautop( $content );
		return $content;
	}

	/**
	 * get_view function
	 *
	 * Returns the appropriate output to prepend to an event post, depending on
	 * WP loop context.
	 *
	 * @param Ai1ec_Event $event  The event post being displayed
	 * @param string $content     The post's original content
	 *
	 * @return string             The event data markup to prepend to the post content
	 **/
	function get_view( &$event, &$content )
 	{
		global $ai1ec_view_helper;

		ob_start();

		if( is_single() ) {
			$this->single_view( $event );
		} else {
			$this->multi_view( $event );
		}

		echo $content;

		if( is_single() )
			$this->single_event_footer( $event );

		$page_content = ob_get_contents();
		ob_end_clean();

		return $page_content;
	}

	/**
	 * single_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed as a single page.
	 *
	 * @param Ai1ec_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function single_view( &$event )
	{
		global $ai1ec_view_helper,
		       $ai1ec_calendar_helper,
		       $ai1ec_settings;

		$subscribe_url = AI1EC_EXPORT_URL . "&ai1ec_post_ids=$event->post_id";
		$subscribe_url = str_replace( 'webcal://', 'http://', $subscribe_url );

		$args = array(
			'event'                   => &$event,
			'recurrence'              => $event->recurrence_html,
			'categories'              => $event->categories_html,
			'tags'                    => $event->tags_html,
			'location'                => nl2br( $event->location ),
			'map'                     => $this->get_map_view( $event ),
			'contact'                 => $event->contact_html,
			'calendar_url'            => $ai1ec_calendar_helper->get_calendar_url( $event ),
			'subscribe_url'           => $subscribe_url,
			'google_url'              => 'http://www.google.com/calendar/render?cid=' . urlencode( $subscribe_url ),
			'show_subscribe_buttons'  => ! $ai1ec_settings->turn_off_subscription_buttons
		);
		$ai1ec_view_helper->display( 'event-single.php', $args );
	}

	/**
	 * multi_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed in a loop alongside other posts.
	 *
	 * @param Ai1ec_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function multi_view( &$event )
	{
		global $ai1ec_view_helper,
		       $ai1ec_calendar_helper;

		$location = str_replace( "\n", ', ', rtrim( $event->location ) );

		$args = array(
			'event' => &$event,
			'recurrence' => $event->recurrence_html,
			'categories' => $event->categories_html,
			'tags' => $event->tags_html,
			'location' => $location,
			'contact' => $event->contact_html,
			'calendar_url' => $ai1ec_calendar_helper->get_calendar_url( $event ),
		);
		$ai1ec_view_helper->display( 'event-multi.php', $args );
	}

	/**
	 * excerpt_view function
	 *
	 * Outputs event-specific details as HTML to be prepended to post content
	 * when displayed in an excerpt format.
	 *
	 * @param Ai1ec_Event $event  The event being displayed
	 *
	 * @return void
	 **/
	function excerpt_view( &$event )
	{
		global $ai1ec_view_helper,
		       $ai1ec_calendar_helper;

		$location = str_replace( "\n", ', ', rtrim( $event->location ) );

		$args = array(
			'event' => &$event,
			'location' => $location,
		);
		$ai1ec_view_helper->display( 'event-excerpt.php', $args );
	}

	/**
	 * get_map_view function
	 *
	 * Returns HTML markup displaying a Google map of the given event, if the event
	 * has show_map set to true. Returns a zero-length string otherwise.
	 *
	 * @return void
	 **/
	function get_map_view( &$event )
	{
		global $ai1ec_view_helper, $ai1ec_events_helper, $ai1ec_settings;

		if( ! $event->show_map )
			return '';

		$args = array(
			'address' => $event->address,
			'gmap_url_link' => $ai1ec_events_helper->get_gmap_url( $event, false ),
			'hide_maps_until_clicked' => $ai1ec_settings->hide_maps_until_clicked
		);
		return $ai1ec_view_helper->get_view( 'event-map.php', $args );
	}

	/**
	 * single_event_footer function
	 *
	 * Outputs any markup that should appear below the post's content on the
	 * single post page for this event.
	 *
	 * @return void
	 **/
	function single_event_footer( &$event )
	{
		global $ai1ec_view_helper;

		$args = array(
			'event' => &$event,
		);
		return $ai1ec_view_helper->display( 'event-single-footer.php', $args );
	}

	/**
	 * events_categories_add_form_fields function
	 *
	 *
	 *
	 * @return void
	 **/
	 function events_categories_add_form_fields() {
	   global $ai1ec_view_helper;

	   $args = array();
	   $ai1ec_view_helper->display( 'event_categories-color_picker.php' );
	 }

	 /**
 	 * events_categories_edit_form_fields function
 	 *
 	 *
 	 *
 	 * @return void
 	 **/
 	 function events_categories_edit_form_fields( $term ) {
 	   global $ai1ec_view_helper, $wpdb;

 	   $table_name = $wpdb->prefix . 'ai1ec_event_category_colors';
 	   $color = $wpdb->get_var( "SELECT term_color FROM {$table_name} WHERE term_id = {$term->term_id}" );

 	   $style = '';
 	   $clr = '';

 	   if( ! is_null( $color ) && ! empty( $color ) ) {
 	     $style = 'style="background-color: ' . $color . '"';
 	     $clr = $color;
 	   }
 	   $args = array(
 	    'style' => $style,
 	    'color' => $clr,
 	    'edit'  => true,
 	   );
 	   $ai1ec_view_helper->display( 'event_categories-color_picker.php', $args );
 	 }

	 /**
	  * edited_events_categories function
	  *
	  *
	  *
	  * @return void
	  **/
	function created_events_categories( $term_id ) {
	  global $wpdb;
	  $tag_color_value = '';
	  if( isset( $_POST["tag-color-value"] ) && ! empty( $_POST["tag-color-value"] ) ) {
	    $tag_color_value = $_POST["tag-color-value"];
	  }

	  $table_name = $wpdb->prefix . 'ai1ec_event_category_colors';
	  $wpdb->insert( $table_name, array( 'term_id' => $term_id, 'term_color' => $tag_color_value ), array( '%d', '%s' ) );
	}

	function edited_events_categories( $term_id ) {
	  global $wpdb;
	  $tag_color_value = '';
	  if( isset( $_POST["tag-color-value"] ) && ! empty( $_POST["tag-color-value"] ) ) {
	    $tag_color_value = $_POST["tag-color-value"];
	  }

	  $table_name = $wpdb->prefix . 'ai1ec_event_category_colors';
	  $term = $wpdb->get_var( "SELECT term_id FROM {$table_name} WHERE term_id = {$term_id}" );

	  if( is_null( $term ) ) {
	    // term doesn't exist, create it
	    $wpdb->insert( $table_name, array( 'term_id' => $term_id, 'term_color' => $tag_color_value ), array( '%d', '%s' ) );
	  } else {
	    // term exist, update it
	    $wpdb->update( $table_name, array( 'term_color' => $tag_color_value ), array( 'term_id' => $term_id ), array( '%s' ), array( '%d' ) );
	  }


	}
}
// END class
