<?php
//
//  class-ai1ec-app-helper.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_App_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class Ai1ec_App_Helper {
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
	 * map_meta_cap function
	 *
	 * Assigns proper capability
	 *
	 * @return void
	 **/
	function map_meta_cap( $caps, $cap, $user_id, $args ) {
		// If editing, deleting, or reading an event, get the post and post type object.
		if( 'edit_ai1ec_event' == $cap || 'delete_ai1ec_event' == $cap || 'read_ai1ec_event' == $cap ) {
			$post = get_post( $args[0] );
			$post_type = get_post_type_object( $post->post_type );
			/* Set an empty array for the caps. */
			$caps = array();
		}

		/* If editing an event, assign the required capability. */
		if( 'edit_ai1ec_event' == $cap ) {
			if( $user_id == $post->post_author )
				$caps[] = $post_type->cap->edit_posts;
			else
				$caps[] = $post_type->cap->edit_others_posts;
		}

		/* If deleting an event, assign the required capability. */
		else if( 'delete_ai1ec_event' == $cap ) {
			if( $user_id == $post->post_author )
				$caps[] = $post_type->cap->delete_posts;
			else
				$caps[] = $post_type->cap->delete_others_posts;
		}

		/* If reading a private event, assign the required capability. */
		else if( 'read_ai1ec_event' == $cap ) {
			if( 'private' != $post->post_status )
				$caps[] = 'read';
			elseif ( $user_id == $post->post_author )
				$caps[] = 'read';
			else
				$caps[] = $post_type->cap->read_private_posts;
		}

		/* Return the capabilities required by the user. */
		return $caps;
	}

	/**
	 * create_post_type function
	 *
	 * Create event's custom post type
	 * and registers events_categories and events_tags under
	 * event's custom post type taxonomy
	 *
	 * @return void
	 **/
	function create_post_type() {
	  global $ai1ec_settings;

    // if the event contributor role is not created, create it
		if( !get_role( 'ai1ec_event_assistant' ) ) {

		  // creating event contributor role with the same capabilities
		  // as subscriber role, later in this file, event contributor role will be extended
		  // to include more capabilities
			$caps = get_role( 'subscriber' )->capabilities;
			add_role( 'ai1ec_event_assistant', 'Event Contributor', $caps );

			// add event managing capability to administrator, editor, author
			foreach( array( 'administrator', 'editor', 'author' ) as $user ) {
			  $role = get_role( $user );
			  // read events
			  $role->add_cap( 'read_ai1ec_event' );
			  // edit events
			  $role->add_cap( 'edit_ai1ec_event' );
			  $role->add_cap( 'edit_ai1ec_events' );
			  $role->add_cap( 'edit_others_ai1ec_events' );
			  $role->add_cap( 'edit_private_ai1ec_events' );
			  $role->add_cap( 'edit_published_ai1ec_events' );
			  // delete events
			  $role->add_cap( 'delete_ai1ec_event' );
			  $role->add_cap( 'delete_ai1ec_events' );
			  $role->add_cap( 'delete_others_ai1ec_events' );
			  $role->add_cap( 'delete_published_ai1ec_events' );
			  $role->add_cap( 'delete_private_ai1ec_events' );
			  // publish events
			  $role->add_cap( 'publish_ai1ec_events' );
			  // read private events
			  $role->add_cap( 'read_private_ai1ec_events' );
			}

			// add event managing capability to contributors
			$role = get_role( 'ai1ec_event_assistant' );
			$role->add_cap( 'edit_ai1ec_events' );
			$role->add_cap( 'delete_ai1ec_event' );
			$role->add_cap( 'read' );
		}
		// ===============================
		// = labels for custom post type =
		// ===============================
		$labels = array(
			'name' 								=> _x( 'Events', 'Custom post type name', AI1EC_PLUGIN_NAME ),
			'singular_name' 			=> _x( 'Event', 'Custom post type name (singular)', AI1EC_PLUGIN_NAME ),
			'add_new'							=> __( 'Add New', AI1EC_PLUGIN_NAME ),
			'add_new_item'				=> __( 'Add New Event', AI1EC_PLUGIN_NAME ),
			'edit_item'						=> __( 'Edit Event', AI1EC_PLUGIN_NAME ),
			'new_item'						=> __( 'New Event', AI1EC_PLUGIN_NAME ),
			'view_item'						=> __( 'View Event', AI1EC_PLUGIN_NAME ),
			'search_items'				=> __( 'Search Events', AI1EC_PLUGIN_NAME ),
			'not_found'						=> __( 'No Events found', AI1EC_PLUGIN_NAME ),
			'not_found_in_trash'	=> __( 'No Events found in Trash', AI1EC_PLUGIN_NAME ),
			'parent_item_colon'		=> __( 'Parent Event', AI1EC_PLUGIN_NAME ),
			'menu_name'						=> __( 'Events', AI1EC_PLUGIN_NAME ),
			'all_items'						=> $this->get_all_items_name()
		);


		// ================================
		// = support for custom post type =
		// ================================
		$supports = array( 'title', 'editor', 'comments' );

		// =============================
		// = args for custom post type =
		// =============================
		$args = array(
			'labels'							=> $labels,
			'public' 							=> true,
	    'publicly_queryable' 	=> true,
	    'show_ui' 						=> true,
	    'show_in_menu' 				=> true,
	    'query_var' 					=> true,
	    'rewrite' 						=> true,
	    'capability_type'			=> array( 'ai1ec_event', 'ai1ec_events' ),
	    'capabilities'        => array(
	      'read_post'               => 'read_ai1ec_event',
	      'edit_post'               => 'edit_ai1ec_event',
        'edit_posts'              => 'edit_ai1ec_events',
        'edit_others_posts'       => 'edit_others_ai1ec_events',
        'edit_private_posts'      => 'edit_private_ai1ec_events',
        'edit_published_posts'    => 'edit_published_ai1ec_events',
        'delete_post'             => 'delete_ai1ec_event',
        'delete_posts'            => 'delete_ai1ec_events',
        'delete_others_posts'     => 'delete_others_ai1ec_events',
        'delete_published_posts'  => 'delete_published_ai1ec_events',
        'delete_private_posts'    => 'delete_private_ai1ec_events',
        'publish_posts'           => 'publish_ai1ec_events',
        'read_private_posts'      => 'read_private_ai1ec_events' ),
	    'has_archive' 				=> true,
	    'hierarchical' 				=> false,
	    'menu_position' 			=> 5,
	    'supports'						=> $supports,
	    'exclude_from_search' => $ai1ec_settings->exclude_from_search
		);

		// ========================================
		// = labels for event categories taxonomy =
		// ========================================
		$events_categories_labels = array(
			'name'					=> _x( 'Event Categories', 'Event categories taxonomy', AI1EC_PLUGIN_NAME ),
			'singular_name'	=> _x( 'Event Category', 'Event categories taxonomy (singular)', AI1EC_PLUGIN_NAME )
		);

		// ==================================
		// = labels for event tags taxonomy =
		// ==================================
		$events_tags_labels = array(
			'name'					=> _x( 'Event Tags', 'Event tags taxonomy', AI1EC_PLUGIN_NAME ),
			'singular_name'	=> _x( 'Event Tag', 'Event tags taxonomy (singular)', AI1EC_PLUGIN_NAME )
		);

		// ======================================
		// = args for event categories taxonomy =
		// ======================================
		$events_categories_args = array(
			'labels'				=> $events_categories_labels,
			'hierarchical'	=> true,
			'rewrite'				=> array( 'slug' => 'events_categories' ),
			'capabilities'	=> array(
				'manage_terms' => 'manage_categories',
    		'edit_terms'   => 'manage_categories',
    		'delete_terms' => 'manage_categories',
    		'assign_terms' => 'edit_ai1ec_events'
			)
		);

		// ================================
		// = args for event tags taxonomy =
		// ================================
		$events_tags_args = array(
			'labels'				=> $events_tags_labels,
			'hierarchical'	=> false,
			'rewrite'				=> array( 'slug' => 'events_tags' ),
			'capabilities'	=> array(
				'manage_terms' => 'manage_categories',
    		'edit_terms'   => 'manage_categories',
    		'delete_terms' => 'manage_categories',
    		'assign_terms' => 'edit_ai1ec_events'
			)
		);

		// ======================================
		// = register event categories taxonomy =
		// ======================================
		register_taxonomy( 'events_categories', array( AI1EC_POST_TYPE ), $events_categories_args );

		// ================================
		// = register event tags taxonomy =
		// ================================
		register_taxonomy( 'events_tags', array( AI1EC_POST_TYPE ), $events_tags_args );

		// ========================================
		// = register custom post type for events =
		// ========================================
		register_post_type( AI1EC_POST_TYPE, $args );
	}

	/**
	 * taxonomy_filter_restrict_manage_posts function
	 *
	 * Adds filter dropdowns for event categories and event tags
	 *
	 * @return void
	 **/
	function taxonomy_filter_restrict_manage_posts() {
		global $typenow;

		// =============================================
		// = add the dropdowns only on the events page =
		// =============================================
		if( $typenow == AI1EC_POST_TYPE ) {
			$filters = get_object_taxonomies( $typenow );
			foreach( $filters as $tax_slug ) {
				$tax_obj = get_taxonomy( $tax_slug );
				wp_dropdown_categories( array(
					'show_option_all'	=> __( 'Show All ' . $tax_obj->label, AI1EC_PLUGIN_NAME ),
					'taxonomy'				=> $tax_slug,
          'name'						=> $tax_obj->name,
          'orderby'					=> 'name',
          'selected'				=> $_GET[$tax_slug],
          'hierarchical'		=> $tax_obj->hierarchical,
          'show_count'			=> true,
          'hide_if_empty'   => true
				));
			}
		}
	}

	/**
	 * get_all_items_name function
	 *
	 * If current user can publish events and there
	 * is at least 1 event pending, append the pending
	 * events number to the menu
	 *
	 * @return string
	 **/
	function get_all_items_name() {

	  // if current user can publish events
	  if( current_user_can( 'publish_ai1ec_events' ) ) {
	    // get all pending events
	    $query = new WP_Query(  array ( 'post_type' => 'ai1ec_event', 'post_status' => 'pending', 'posts_per_page' => -1,  ) );

	    // at least 1 pending event?
      if( $query->post_count > 0 ) {
        // append the pending events number to the menu
        return sprintf( __( 'All Events <span class="update-plugins count-%d" title="%d Pending Events"><span class="update-count">%d</span></span>', AI1EC_PLUGIN_NAME ),
  	                    $query->post_count, $query->post_count, $query->post_count );
      }
    }

	  // no pending events, or the user doesn't have sufficient capabilities
	  return __( 'All Events', AI1EC_PLUGIN_NAME );
	}

	/**
	 * taxonomy_filter_post_type_request function
	 *
	 * Adds filtering of events list by event tags and event categories
	 *
	 * @return void
	 **/
	function taxonomy_filter_post_type_request( $query ) {
		global $pagenow, $typenow;
		if( 'edit.php' == $pagenow ) {
			$filters = get_object_taxonomies( $typenow );
			foreach( $filters as $tax_slug ) {
				$var = &$query->query_vars[$tax_slug];
				if( isset( $var ) ) {
				  $term = null;

				  if( is_numeric( $var ) )
					  $term = get_term_by( 'id', $var, $tax_slug );
					else
					  $term = get_term_by( 'slug', $var, $tax_slug );

					$var = $term->slug;
				}
			}
		}
		// ===========================
		// = Order by Event date ASC =
		// ===========================
		if( $typenow == 'ai1ec_event' ) {
			if( ! array_key_exists( 'orderby', $query->query_vars ) ) {
				$query->query_vars["orderby"] = 'ai1ec_event_date';
				$query->query_vars["order"] 	= 'desc';
			}
		}

	}

	/**
	 * orderby function
	 *
	 * Orders events by event date
	 *
	 * @param string $orderby Orderby sql
	 * @param object $wp_query
	 *
	 * @return void
	 **/
	function orderby( $orderby, $wp_query ) {
		global $typenow, $wpdb, $post;

		if( $typenow == 'ai1ec_event' ) {
			$wp_query->query = wp_parse_args( $wp_query->query );
			$table_name = $wpdb->prefix . 'ai1ec_events';
			if( 'ai1ec_event_date' == @$wp_query->query['orderby'] ) {
				$orderby = "(SELECT start FROM {$table_name} WHERE post_id =  $wpdb->posts.ID) " . $wp_query->get('order');
			} else if( empty( $wp_query->query['orderby'] ) ) {
				$orderby = "(SELECT start FROM {$table_name} WHERE post_id =  $wpdb->posts.ID) " . 'desc';
			}
		}
		return $orderby;
	}

	/**
	 * add_meta_boxes function
	 *
	 * Display event meta_box when creating or editing an event
	 *
	 * @return void
	 **/
	function add_meta_boxes() {
		global $ai1ec_events_controller;
		add_meta_box(
		        AI1EC_POST_TYPE,
		        __( 'Event Details', AI1EC_PLUGIN_NAME ),
		        array( &$ai1ec_events_controller, 'meta_box_view' ),
		        AI1EC_POST_TYPE
		    );
	}

	/**
	 * change_columns function
	 *
	 * Adds Event date/time column to our custom post type
	 * and renames Date column to Post Date
	 *
	 * @param array $columns Existing columns
	 *
	 * @return array Updated columns array
	 **/
	function change_columns( $columns ) {
		$columns["date"] 							= __( 'Post Date', 			 AI1EC_PLUGIN_NAME );
		$columns["ai1ec_event_date"] 	= __( 'Event date/time', AI1EC_PLUGIN_NAME );
		return $columns;
	}

	/**
	 * custom_columns function
	 *
	 * Adds content for custom columns
	 *
	 * @return void
	 **/
	function custom_columns( $column, $post_id ) {
		global $ai1ec_events_helper;
		switch( $column ) {
			case 'ai1ec_event_date':
				$e = new Ai1ec_Event( $post_id );
				echo $e->short_start_date . ' ' . $e->short_start_time . " - " . $e->short_end_date . ' ' .$e->short_end_time;
				break;
		}
	}

	/**
	 * sortable_columns function
	 *
	 * Enable sorting of columns
	 *
	 * @return void
	 **/
	function sortable_columns( $columns ) {
		$columns["ai1ec_event_date"] = 'ai1ec_event_date';
		return $columns;
	}

	/**
	 * get_param function
	 *
	 * Tries to return the parameter from POST and GET
	 * incase it is missing, default value is returned
	 *
	 * @param string $param Parameter to return
	 * @param mixed $default Default value
	 *
	 * @return mixed
	 **/
	function get_param( $param, $default='' ) {
    return isset( $_POST[$param] )
    	? $_POST[$param]
    	: isset( $_GET[$param] )
    		? $_GET[$param]
    		: $default;
  }

	/**
	 * get_param_delimiter_char function
	 *
	 * Returns the delimiter character in a link
	 *
	 * @param string $link Link to parse
	 *
	 * @return string
	 **/
  function get_param_delimiter_char( $link ) {
    return strpos( $link, '?' ) === false ? '?' : '&';
	}

  /**
	 * inject_categories function
	 *
	 * Displays event categories whenever post categories are requested
	 *
	 * @param array $terms Terms to be returned by get_terms()
	 * @param array $taxonomies Taxonomies requested in get_terms()
	 * @param array $args Args passed to get_terms()
	 *
	 * @return string|array If "category" taxonomy was requested, then returns
	 *                      $terms with fake category pointing to calendar page
	 *                      with its children being the event categories
	 **/
	function inject_categories( $terms, $taxonomies, $args )
	{
		global $ai1ec_settings;

    if( in_array( 'category', $taxonomies ) )
    {
    	// Create fake calendar page category
    	$count_args = $args;
    	$count_args['fields'] = 'count';
    	$count = get_terms( 'events_categories', $count_args );
    	$post = get_post( $ai1ec_settings->calendar_page_id );
    	switch( $args['fields'] )
    	{
    		case 'all':
		    	$calendar = (object) array(
			    	'term_id'     => AI1EC_FAKE_CATEGORY_ID,
			    	'name'		    => $post->post_title,
			    	'slug'		    => $post->post_name,
			    	'taxonomy'    => 'events_categories',
			    	'description' => '',
			    	'parent'      => 0,
			    	'count'       => $count,
		    	);
		    	break;
	    	case 'ids':
	    		$calendar = 'ai1ec_calendar';
	    		break;
    		case 'names':
	    		$calendar = $post->post_title;
	    		break;
    	}
    	$terms[] = $calendar;

    	if( $args['hierarchical'] ) {
    		$children = get_terms( 'events_categories', $args );
	    	foreach( $children as &$child ) {
	    		if( is_object( $child ) && $child->parent == 0 )
	    			$child->parent = AI1EC_FAKE_CATEGORY_ID;
	 				$terms[] = $child;
	    	}
	    }
    }

    return $terms;
  }

  /**
   * function calendar_term_link
   *
   * Corrects the URL for the calendar page when injected into the post
   * categories.
   *
   * @param string $link The normally generated link
   * @param object $term The term that we're getting the link for
   * @param string $taxonomy The name of the taxonomy of interest
   *
   * @return string The correct link to the calendar page
   */
  function calendar_term_link( $link, $term, $taxonomy )
  {
  	global $ai1ec_calendar_helper;

  	if( $taxonomy == 'events_categories' ) {
	  	if( $term->term_id == AI1EC_FAKE_CATEGORY_ID )
	  		$link = $ai1ec_calendar_helper->get_calendar_url( null );
	  	else
	  		$link = $ai1ec_calendar_helper->get_calendar_url( null, array( $term->term_id ) );
	  }

  	return $link;
  }

  /**
   * function selected_category_link
   *
   * Corrects the output of wp_list_categories so that the currently viewed
   * event category (in calendar view) has the "active" CSS class applied to it.
   *
   * @param string $output The normally generated output of wp_list_categories()
   * @param object $args The args passed to wp_list_categories()
   *
   * @return string The corrected output
   */
  function selected_category_link( $output, $args )
  {
  	global $ai1ec_calendar_controller, $ai1ec_settings;

  	// First check if current page is calendar
  	if( is_page( $ai1ec_settings->calendar_page_id ) )
  	{
	  	$cat_ids = array_filter( explode( ',', $ai1ec_calendar_controller->get_requested_categories() ), 'is_numeric' );
	  	if( $cat_ids ) {
	  		// Mark each filtered event category link as selected
		  	foreach( $cat_ids as $cat_id ) {
		  		$output = str_replace(
			  		'class="cat-item cat-item-' . $cat_id . '"',
			  		'class="cat-item cat-item-' . $cat_id . ' current-cat current_page_item"',
			  		$output );
		  	}
		  	// Mark calendar page link as selected parent
		  	$output = str_replace(
			  	'class="cat-item cat-item-' . AI1EC_FAKE_CATEGORY_ID . '"',
			  	'class="cat-item cat-item-' . AI1EC_FAKE_CATEGORY_ID . ' current-cat-parent"',
			  	$output );
		  } else {
		  	// No categories filtered, so mark calendar page link as selected
		  	$output = str_replace(
			  	'class="cat-item cat-item-' . AI1EC_FAKE_CATEGORY_ID . '"',
			  	'class="cat-item cat-item-' . AI1EC_FAKE_CATEGORY_ID . ' current-cat current_page_item"',
			  	$output );
	  	}
	  }

  	return $output;
  }

  /**
   * admin_notices function
   *
   * Notify the user about anything special.
   *
   * @return void
   **/
  function admin_notices() {
    global $ai1ec_view_helper,
           $ai1ec_settings,
           $plugin_page;

    // If calendar page ID has not been set, and we're not updating the settings
    // page, the calendar is not properly set up yet
    if( ! $ai1ec_settings->calendar_page_id || ! get_option( 'timezone_string' ) && ! isset( $_REQUEST['ai1ec_save_settings'] ) )
    {
    	$args = array();

    	// Display messages for blog admin
    	if( current_user_can( 'manage_options' ) ) {
	    	// If not on the settings page already, direct user there with a message
	    	if( $plugin_page == 'all-in-one-event-calendar-settings' ) {
	    	  if( ! $ai1ec_settings->calendar_page_id && ! get_option( 'timezone_string' ) )
					  $args['msg'] = sprintf( __( '%sTo set up the plugin: %s 1. Select an option in the <strong>Calendar page</strong> dropdown list. %s 2. Select an option in the <strong>Timezone</strong> dropdown list. %s 3. Click <strong>Update Settings</strong>. %s', AI1EC_PLUGIN_NAME ), '<br /><br />', '<ul><ol>', '</ol><ol>', '</ol><ol>', '</ol><ul>' );
					else if( ! $ai1ec_settings->calendar_page_id )
					  $args['msg'] = __( 'To set up the plugin: Select an option in the <strong>Calendar page</strong> dropdown list, the click <strong>Update Settings</strong>.', AI1EC_PLUGIN_NAME );
					else
					  $args['msg'] = __( 'To set up the plugin: Select an option in the <strong>Timezone</strong> dropdown list, the click <strong>Update Settings</strong>.', AI1EC_PLUGIN_NAME );
				// Else instruct user as to what to do on the settings page
				} else {
		      $args['msg'] = sprintf(
			        __( 'The plugin is installed, but has not been configured. <a href="%s">Click here to set it up now »</a>', AI1EC_PLUGIN_NAME ),
							admin_url( 'edit.php?post_type=ai1ec_event&page=all-in-one-event-calendar-settings' )
						);
				}
			// Else display messages for other blog users
			} else {
				$args['msg'] = __( 'The plugin is installed, but has not been configured. Please log in as a WordPress Administrator to set it up.', AI1EC_PLUGIN_NAME );
			}

      $ai1ec_view_helper->display( 'admin_notices.php', $args );
    }
  }
}
// END class
