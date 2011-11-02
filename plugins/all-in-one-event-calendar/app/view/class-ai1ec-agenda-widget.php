<?php

/**
 * Ai1ec_Agenda_Widget class
 *
 * A widget that displays the next X upcoming events (similar to Agenda view).
 */
class Ai1ec_Agenda_Widget extends WP_Widget
{
	/**
	 * _construct function
	 *
	 * Constructor for widget.
	 */
	function __construct() {
		parent::__construct(
			'ai1ec_agenda_widget',
			__( 'Upcoming Events', AI1EC_PLUGIN_NAME ),
			array(
				'description' => __( 'All-in-One Event Calendar: Lists upcoming events in Agenda view', AI1EC_PLUGIN_NAME ),
				'class' => 'ai1ec-agenda-widget',
			)
		);
	}

	/**
	 * form function
	 *
	 * Renders the widget's configuration form for the Manage Widgets page.
	 *
	 * @param array $instance The data array for the widget instance being
	 *                        configured.
	 */
	function form( $instance )
	{
		global $ai1ec_view_helper;

		$default = array(
			'title'                  => __( 'Upcoming Events', AI1EC_PLUGIN_NAME ),
			'events_per_page'        => 10,
			'show_subscribe_buttons' => true,
			'show_calendar_button'   => true,
			'hide_on_calendar_page'  => true,
		);
		$instance = wp_parse_args( (array) $instance, $default );

		// Generate unique IDs and NAMEs of all needed form fields
		$fields = array(
			'title'                  => array(),
			'events_per_page'        => array(),
			'show_subscribe_buttons' => array(),
			'show_calendar_button'   => array(),
			'hide_on_calendar_page'  => array(),
		);
		foreach( $fields as $field => $data ) {
			$fields[$field]['id'] = $this->get_field_id( $field );
			$fields[$field]['name'] = $this->get_field_name( $field );
			$fields[$field]['value'] = $instance[$field];
		}

		$ai1ec_view_helper->display( 'agenda-widget-form.php', $fields );
	}

	/**
	 * update function
	 *
	 * Called when a user submits the widget configuration form. The data should
	 * be validated and returned.
	 *
	 * @param array $new_instance The new data that was submitted.
	 * @param array $old_instance The widget's old data.
	 * @return array The new data to save for this widget instance.
	 */
	function update( $new_instance, $old_instance )
	{
		// Save existing data as a base to modify with new data
		$instance = $old_instance;

		$instance['title']                  = strip_tags( $new_instance['title'] );
		$instance['events_per_page']        = intval( $new_instance['events_per_page'] );
		if( $instance['events_per_page'] < 1 ) $instance['events_per_page'] = 1;
		$instance['show_subscribe_buttons'] = $new_instance['show_subscribe_buttons'] ? true : false;
		$instance['show_calendar_button']   = $new_instance['show_calendar_button'] ? true : false;
		$instance['hide_on_calendar_page']  = $new_instance['hide_on_calendar_page'] ? true : false;

		return $instance;
	}

	/**
	 * widget function
	 *
	 * Outputs the given instance of the widget to the front-end.
	 *
	 * @param array $args Display arguments passed to the widget
	 * @param array $instance The settings for this widget instance
	 */
	function widget( $args, $instance )
	{
		global $ai1ec_view_helper,
		       $ai1ec_events_helper,
		       $ai1ec_calendar_helper,
		       $ai1ec_settings;

		if( $instance['hide_on_calendar_page'] &&
		    is_page( $ai1ec_settings->calendar_page_id ) )
			return;

		// Get localized time
		$timestamp = $ai1ec_events_helper->gmt_to_local( time() );
		// Get events, then classify into date array
		$event_results = $ai1ec_calendar_helper->get_events_relative_to(
			$timestamp, $instance['events_per_page'], 0 );
		$dates = $ai1ec_calendar_helper->get_agenda_date_array( $event_results['events'] );

		$args['title']                  = $instance['title'];
		$args['show_subscribe_buttons'] = $instance['show_subscribe_buttons'];
		$args['show_calendar_button']   = $instance['show_calendar_button'];
		$args['dates']                  = $dates;
		$args['calendar_url']           = $ai1ec_calendar_helper->get_calendar_url();

		$ai1ec_view_helper->display( 'agenda-widget.php', $args );
	}
}
