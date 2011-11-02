<?php
//
//  class-ai1ec-calendar-controller.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Calendar_Controller class
 *
 * @package Controllers
 * @author The Seed Studio
 **/
class Ai1ec_Calendar_Controller {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	static $_instance = NULL;

	/**
	 * request class variable
	 *
	 * Stores a custom $_REQUEST array for all calendar requests
	 *
	 * @var array
	 **/
	private $request = array();

	/**
	 * __construct function
	 *
	 * Default constructor - calendar initialization
	 **/
	private function __construct() {
		// ===========
		// = ACTIONS =
		// ===========
		// Handle AJAX requests
		// Strange! Now regular WordPress requests will respond to the below AJAX
		// hooks! Thus we need to check to make sure we are being called by the
		// AJAX script before returning AJAX responses.
		if( basename( $_SERVER['SCRIPT_NAME'] ) == 'admin-ajax.php' )
		{
			add_action( 'wp_ajax_ai1ec_month', array( &$this, 'ajax_month' ) );
			add_action( 'wp_ajax_ai1ec_agenda', array( &$this, 'ajax_agenda' ) );
			add_action( 'wp_ajax_nopriv_ai1ec_month', array( &$this, 'ajax_month' ) );
			add_action( 'wp_ajax_nopriv_ai1ec_agenda', array( &$this, 'ajax_agenda' ) );
			add_action( 'wp_ajax_ai1ec_term_filter', array( &$this, 'ajax_term_filter' ) );
			add_action( 'wp_ajax_nopriv_ai1ec_term_filter', array( &$this, 'ajax_term_filter' ) );
		}
	}

	/**
	 * process_request function
	 *
	 * Initialize/validate custom request array, based on contents of $_REQUEST,
	 * to keep track of this component's request variables.
	 *
	 * @return void
	 **/
	function process_request()
	{
		global $ai1ec_settings;

		// Find out which view of the calendar page was requested, then validate
		// request parameters accordingly and save them to our custom request
		// object
		$this->request['action'] = $_REQUEST['action'];
		if( ! in_array( $this->request['action'],
			      array( 'ai1ec_month', 'ai1ec_agenda', 'ai1ec_term_filter' ) ) )
			$this->request['action'] = 'ai1ec_' . $ai1ec_settings->default_calendar_view;

		switch( $this->request['action'] )
		{
			case 'ai1ec_month':
				$this->request['ai1ec_month_offset'] =
					$_REQUEST['ai1ec_month_offset'] ?
					intval( $_REQUEST['ai1ec_month_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['ai1ec_active_event'] = intval( $_REQUEST['ai1ec_active_event'] );
				// Category/tag filter parameters
				$this->request['ai1ec_cat_ids'] = $_REQUEST['ai1ec_cat_ids'];
				$this->request['ai1ec_tag_ids'] = $_REQUEST['ai1ec_tag_ids'];
				break;

			case 'ai1ec_agenda':
				$this->request['ai1ec_page_offset'] =
					$_REQUEST['ai1ec_page_offset'] ?
					intval( $_REQUEST['ai1ec_page_offset'] ) : 0;
				// Parse active event parameter as an integer ID
				$this->request['ai1ec_active_event'] = intval( $_REQUEST['ai1ec_active_event'] );
				// Category/tag filter parameters
				$this->request['ai1ec_cat_ids'] = $_REQUEST['ai1ec_cat_ids'];
				$this->request['ai1ec_tag_ids'] = $_REQUEST['ai1ec_tag_ids'];
				break;

			case 'ai1ec_term_filter':
				$this->request['ai1ec_post_ids'] = $_REQUEST['ai1ec_post_ids'];
				$this->request['ai1ec_term_ids'] = $_REQUEST['ai1ec_term_ids'];
				break;
		}
	}

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
	 * view function
	 *
	 * Display requested calendar page.
	 *
	 * @return void
	 **/
	function view()
 	{
		global $ai1ec_view_helper,
		       $ai1ec_settings,
		       $ai1ec_events_helper;

		$this->process_request();

		// Set body class
		add_filter( 'body_class', array( &$this, 'body_class' ) );
		// Queue any styles, scripts
		$this->load_css();
		$this->load_js();

		// Define arguments for specific calendar sub-view (month, agenda, etc.)
		$args = array(
			'active_event' => $this->request['ai1ec_active_event'],
		);

		// Find out which view of the calendar page was requested
		switch( $this->request['action'] )
		{
			case 'ai1ec_month':
				$args['month_offset'] = $this->request['ai1ec_month_offset'];
				$view = $this->get_month_view( $args );
				break;

			case 'ai1ec_agenda':
				$args['page_offset'] = $this->request['ai1ec_page_offset'];
				$view = $this->get_agenda_view( $args );
				break;
		}

	  if( $ai1ec_settings->show_create_event_button && current_user_can( 'edit_ai1ec_events' ) )
	  	$create_event_url = admin_url( 'post-new.php?post_type=' . AI1EC_POST_TYPE );
	  else
	  	$create_event_url = false;

	  // Validate preselected category/tag IDs
	  $cat_ids = join( ',', array_filter( explode( ',', $this->request['ai1ec_cat_ids'] ), 'is_numeric' ) );
	  $tag_ids = join( ',', array_filter( explode( ',', $this->request['ai1ec_tag_ids'] ), 'is_numeric' ) );

	  $categories = get_terms( 'events_categories', array( 'orderby' => 'name' ) );
    foreach( $categories as &$cat ) {
      $cat->color = $ai1ec_events_helper->get_category_color_square( $cat->term_id );
    }
		// Define new arguments for overall calendar view
		$args = array(
			'view'                    => $view,
			'create_event_url'        => $create_event_url,
			'categories'              => $categories,
			'tags'                    => get_terms( 'events_tags', array( 'orderby' => 'name' ) ),
			'selected_cat_ids'        => $cat_ids,
			'selected_tag_ids'        => $tag_ids,
			'show_subscribe_buttons'  => ! $ai1ec_settings->turn_off_subscription_buttons
		);

		// Feed month view into generic calendar view
		$ai1ec_view_helper->display( 'calendar.php', $args );
	}

	/**
	 * get_month_view function
	 *
	 * Return the embedded month view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int month_offset  => specifies which month to display relative to the
	 *                        current month
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *
	 * @return string	        returns string of view output
	 **/
	function get_month_view( $args )
 	{
		global $ai1ec_view_helper,
		       $ai1ec_events_helper,
		       $ai1ec_calendar_helper;

		extract( $args );

		// Get components of localized time
		$bits = $ai1ec_events_helper->gmgetdate( $ai1ec_events_helper->gmt_to_local( time() ) );
		// Use first day of the month as reference timestamp, and apply month offset
		$timestamp = gmmktime( 0, 0, 0, $bits['mon'] + $month_offset, 1, $bits['year'] );

		$days_events = $ai1ec_calendar_helper->get_events_for_month( $timestamp, $categories, $tags );
		$cell_array = $ai1ec_calendar_helper->get_month_cell_array( $timestamp, $days_events );
		$pagination_links = $ai1ec_calendar_helper->get_month_pagination_links( $month_offset );

		$view_args = array(
			'title' => date_i18n( 'F Y', $timestamp, true ),
			'weekdays' => $ai1ec_calendar_helper->get_weekdays(),
			'cell_array' => $cell_array,
			'pagination_links' => $pagination_links,
			'active_event' => $active_event,
		);
		return $ai1ec_view_helper->get_view( 'month.php', $view_args );
	}

	/**
	 * get_agenda_view function
	 *
	 * Return the embedded agenda view of the calendar, optionally filtered by
	 * event categories and tags.
	 *
	 * @param array $args     associative array with any of these elements:
	 *   int page_offset   => specifies which page to display relative to today's page
	 *   int active_event  => specifies which event to make visible when
	 *                        page is loaded
	 *   array categories  => restrict events returned to the given set of
	 *                        event category slugs
	 *   array tags        => restrict events returned to the given set of
	 *                        event tag names
	 *
	 * @return string	        returns string of view output
	 **/
	function get_agenda_view( $args )
 	{
		global $ai1ec_view_helper,
		       $ai1ec_events_helper,
		       $ai1ec_calendar_helper,
		       $ai1ec_settings;

		extract( $args );

		// Get localized time
		$timestamp = $ai1ec_events_helper->gmt_to_local( time() );

		// Get events, then classify into date array
		$event_results = $ai1ec_calendar_helper->get_events_relative_to(
			$timestamp,
			$ai1ec_settings->agenda_events_per_page,
			$page_offset
		);
		$dates = $ai1ec_calendar_helper->get_agenda_date_array( $event_results['events'] );

		$pagination_links =
			$ai1ec_calendar_helper->get_agenda_pagination_links(
			 	$page_offset, $event_results['prev'], $event_results['next'] );

		// Incorporate offset into date
		$args = array(
			'title' => __( 'Agenda', AI1EC_PLUGIN_NAME ),
			'dates' => $dates,
			'page_offset' => $page_offset,
			'pagination_links' => $pagination_links,
			'active_event' => $active_event,
		);
		return $ai1ec_view_helper->get_view( 'agenda.php', $args );
	}

	/**
	 * ajax_month function
	 *
	 * AJAX request handler for month view.
	 *
	 * @return void
	 **/
	function ajax_month() {
		global $ai1ec_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'month_offset' => $this->request['ai1ec_month_offset'],
			'active_event' => $this->request['ai1ec_active_event'],
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_month_view( $args ),
		);
		$ai1ec_view_helper->json_response( $data );
	}

	/**
	 * ajax_agenda function
	 *
	 * AJAX request handler for agenda view.
	 *
	 * @return void
	 **/
	function ajax_agenda() {
		global $ai1ec_view_helper;

		$this->process_request();

		// View arguments
		$args = array(
			'page_offset' => $this->request['ai1ec_page_offset'],
			'active_event' => $this->request['ai1ec_active_event'],
		);

		// Return this data structure to the client
		$data = array(
			'body_class' => join( ' ', $this->body_class() ),
			'html' => $this->get_agenda_view( $args ),
		);
		$ai1ec_view_helper->json_response( $data );
	}

	/**
	 * ajax_term_filter function
	 *
	 * AJAX request handler that takes a comma-separated list of event IDs and
	 * comma-separated list of term IDs and returns those event IDs within the
	 * set that have any of the term IDs.
	 *
	 * @return void
	 **/
	function ajax_term_filter() {
		global $ai1ec_view_helper, $ai1ec_events_helper;

		$this->process_request();

		$post_ids = array_unique( explode( ',', $this->request['ai1ec_post_ids'] ) );

		if( $this->request['ai1ec_term_ids'] ) {
			$term_ids = explode( ',', $this->request['ai1ec_term_ids'] );
			$matching_ids = $ai1ec_events_helper->filter_by_terms( $post_ids, $term_ids );
		} else {
			// If no term IDs were provided for filtering, then return all posts
			$matching_ids = $post_ids;
		}

		$unmatching_ids = array_diff( $post_ids, $matching_ids );

		$data = array(
			'matching_ids' => $matching_ids,
			'unmatching_ids' => $unmatching_ids,
	 	);
		$ai1ec_view_helper->json_response( $data );
	}

	/**
	 * body_class function
	 *
	 * Append custom classes to body element.
	 *
	 * @return void
	 **/
	function body_class( $classes = array() ) {
		$classes[] = 'ai1ec-calendar';

		// Reformat action for body class
		$action = $this->request['action'];
		$action = strtr( $action, '_', '-' );
		$action = preg_replace( '/^ai1ec-/', '', $action );

		$classes[] = "ai1ec-action-$action";
		if( ! $this->request['ai1ec_month_offset'] &&
				! $this->request['ai1ec_page_offset'] ) {
			$classes[] = 'ai1ec-today';
		}
		return $classes;
	}

	/**
	 * load_css function
	 *
	 * Enqueue any CSS files required by the calendar views, as well as embeds any
	 * CSS rules necessary for calendar container replacement.
	 *
	 * @return void
	 **/
	function load_css()
	{
		global $ai1ec_settings;

		wp_enqueue_style( 'ai1ec-general', AI1EC_CSS_URL . '/general.css', array(), 1 );
		wp_enqueue_style( 'ai1ec-calendar', AI1EC_CSS_URL . '/calendar.css', array(), 1 );

		if( $ai1ec_settings->calendar_css_selector )
			add_action( 'wp_head', array( &$this, 'selector_css' ) );
	}

	/**
	 * selector_css function
	 *
	 * Inserts dynamic CSS rules into <head> section of page to replace
	 * desired CSS selector with calendar.
	 */
	function selector_css() {
		global $ai1ec_view_helper, $ai1ec_settings;

		$ai1ec_view_helper->display_css(
			'selector.css',
			array( 'selector' => $ai1ec_settings->calendar_css_selector )
		);
	}

	/**
	 * load_js function
	 *
	 * Enqueue any JavaScript files required by the calendar views.
	 *
	 * @return void
	 **/
	function load_js()
 	{
 		global $ai1ec_settings;

		// Include scrollTo jQuery plugin
		wp_enqueue_script( 'jquery.scrollTo', AI1EC_JS_URL . '/jquery.scrollTo-min.js', array( 'jquery' ), 1 );
		// Include element selector function
		wp_enqueue_script( 'ai1ec-element-selector', AI1EC_JS_URL . '/element-selector.js', array( 'jquery', 'jquery.scrollTo' ), 1 );
		// Include custom script
		wp_enqueue_script( 'ai1ec-calendar', AI1EC_JS_URL . '/calendar.js', array( 'jquery', 'jquery.scrollTo' ), 1 );

		$data = array(
			// Point script to AJAX URL
			'ajaxurl'       => admin_url( 'admin-ajax.php' ),
			// What this view defaults to, in case there is no #hash appended
			'default_hash'  => '#' . http_build_query( $this->request ),
			'export_url'    => AI1EC_EXPORT_URL,
			// Body classes if need to be set manually
			'body_class'    => join( ' ', $this->body_class() ),
		);
		// Replace desired CSS selector with calendar, if selector has been set
		if( $ai1ec_settings->calendar_css_selector )
		{
			$page = get_post( $ai1ec_settings->calendar_post_id );
			$data['selector'] = $ai1ec_settings->calendar_css_selector;
			$data['title']    = $page->post_title;
		}

		wp_localize_script( 'ai1ec-calendar', 'ai1ec_calendar', $data );
	}

	/**
	 * function is_category_requested
	 *
	 * Returns the comma-separated list of category IDs that the calendar page
	 * was requested to be prefiltered by.
	 *
	 * @return string
	 */
	function get_requested_categories() {
		return $this->request['ai1ec_cat_ids'];
	}
}
// END class
