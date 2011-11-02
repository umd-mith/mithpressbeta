<?php
//
//  class-ai1ec-settings-helper.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Settings_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class Ai1ec_Settings_Helper {
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
	 * wp_pages_dropdown function
	 *
	 * Display drop-down list selector of pages, including an "Auto-Create New Page"
	 * option which causes the plugin to generate a new page on user's behalf.
	 *
	 * @param string $field_name
	 * @param int  $selected_page_id
	 * @param string $auto_page
	 * @param bool $include_disabled
	 *
	 * @return string
	 **/
	function wp_pages_dropdown( $field_name, $selected_page_id = 0, $auto_page = '', $include_disabled = false ) {
		global $wpdb;
		ob_start();
		$query = "SELECT
								*
							FROM
								{$wpdb->posts}
							WHERE
								post_status = %s
								AND
								post_type = %s";

		$query = $wpdb->prepare( $query, 'publish', 'page' );
		$results = $wpdb->get_results( $query );
		$pages = array();
		if( $results ) {
			$pages = $results;
		}

		?>
		<select class="inputwidth" name="<?php echo $field_name; ?>"
		        id="<?php echo $field_name; ?>"
		        class="wafp-dropdown wafp-pages-dropdown">
			<?php if( ! empty( $auto_page ) ) { ?>
				<option value="__auto_page:<?php echo $auto_page; ?>">
					<?php _e( '- Auto-Create New Page -', AI1EC_PLUGIN_NAME ); ?>
				</option>
			<?php }
			foreach( $pages as $page ) {
				if( $selected_page_id == $page->ID ) {
					$selected = ' selected="selected"';
					$selected_title = $page->post_title;
				} else {
					$selected = '';
				}
				?>
				<option value="<?php echo $page->ID ?>" <?php echo $selected; ?>>
					<?php echo $page->post_title ?>
				</option>
			<?php } ?>
			</select>
		<?php
		if( is_numeric( $selected_page_id ) && $selected_page_id > 0 ) {
			$permalink = get_permalink( $selected_page_id );
			?>
      <br /><a href="<?php echo $permalink ?>" target="_blank">
				<?php printf( __( 'View "%s" »', AI1EC_PLUGIN_NAME ), $selected_title ) ?>
			</a>
			<?php
		}
		return ob_get_clean();
	}

	/**
	 * get_week_dropdown function
	 *
	 * Creates the dropdown element for selecting start of the week
	 *
	 * @param int $week_start_day Selected start day
	 *
	 * @return String dropdown element
	 **/
	function get_week_dropdown( $week_start_day ) {
		global $wp_locale;
		ob_start();
		?>
		<select class="inputwidth" name="week_start_day" id="week_start_day">
		<?php
		for( $day_index = 0; $day_index <= 6; $day_index++ ) :
			$selected = ( $week_start_day == $day_index ) ? 'selected="selected"' : '';
			echo "\n\t<option value='" . esc_attr($day_index) . "' $selected>" . $wp_locale->get_weekday($day_index) . '</option>';
		endfor;
		?>
		</select>
		<?php
		return ob_get_clean();
	}

	/**
	 * get_view_dropdown function
	 *
	 * @return void
	 **/
	function get_view_dropdown( $view = null ) {
		ob_start();
		?>
		<select name="default_calendar_view">
			<option value="month" <?php echo $view == 'month' ? 'selected' : '' ?>>
				<?php _e( 'Month', AI1EC_PLUGIN_NAME ) ?>
			</option>
			<option value="agenda" <?php echo $view == 'agenda' ? 'selected' : '' ?>>
				<?php _e( 'Agenda', AI1EC_PLUGIN_NAME ) ?>
			</option>
		</select>
		<?php
		return ob_get_clean();
	}
	
	/**
	 * get_timezone_dropdown function
	 *
	 *
	 *
	 * @return void
	 **/
  function get_timezone_dropdown( $timezone = null ) {
    $timezone_identifiers = DateTimeZone::listIdentifiers();
    ob_start();
    ?>
    <select id="timezone" name="timezone">
      <?php foreach( $timezone_identifiers as $value ) : ?>
        <?php if( preg_match( '/^(Africa|America|Antartica|Arctic|Asia|Atlantic|Australia|Europe|Indian|Pacific)\//', $value ) ) : ?>
          <?php $ex = explode( "/", $value );  //obtain continent,city ?>
          <?php if( $continent != $ex[0] ) : ?>
            <?php if( ! empty( $continent ) ) : ?>
              </optgroup>
            <?php endif ?>
            <optgroup label="<?php echo $ex[0] ?>">
          <?php endif ?>

          <?php $city = isset( $ex[2] ) ? $ex[2] : $ex[1]; $continent = $ex[0]; ?>
          <option value="<?php echo $value ?>" <?php echo $value == $timezone ? 'selected' : '' ?>><?php echo $city ?></option>
        <?php endif ?>
    <?php endforeach ?>
      </optgroup>
    </select>
    <?php
    return ob_get_clean();
  }
	/**
	 * get_cron_freq_dropdown function
	 *
	 * @return void
	 **/
	function get_cron_freq_dropdown( $cron_freq = null ) {
		ob_start();
		?>
		<select name="cron_freq">
			<option value="hourly" <?php echo $cron_freq == 'hourly' ? 'selected' : ''; ?>>
				<?php _e( 'Hourly', AI1EC_PLUGIN_NAME ) ?>
			</option>
			<option value="twicedaily" <?php echo $cron_freq == 'twicedaily' ? 'selected' : '' ?>>
				<?php _e( 'Twice Daily', AI1EC_PLUGIN_NAME ) ?>
			</option>
			<option value="daily" <?php echo $cron_freq == 'daily' ? 'selected' : '' ?>>
				<?php _e( 'Daily', AI1EC_PLUGIN_NAME ) ?>
			</option>
		</select>
		<?php
		return ob_get_clean();
	}

	/**
	 * get_feed_rows function
	 *
	 * Creates feed rows to display on settings page
	 *
	 * @return String feed rows
	 **/
	function get_feed_rows() {
		global $wpdb,
					 $ai1ec_view_helper;

		// Select all added feeds
		$table_name = $wpdb->prefix . 'ai1ec_event_feeds';
		$sql = "SELECT * FROM {$table_name}";
		$rows = $wpdb->get_results( $sql );

		ob_start();
		foreach( $rows as $row ) :
			$feed_category = get_term( $row->feed_category, 'events_categories' );
			$table_name = $wpdb->prefix . 'ai1ec_events';
			$sql = "SELECT COUNT(*) FROM {$table_name} WHERE ical_feed_url = '%s'";
			$events = $wpdb->get_var( $wpdb->prepare( $sql, $row->feed_url ) );
			$args = array(
				'feed_url' 			 => $row->feed_url,
				'event_category' => $feed_category->name,
				'tags'					 => stripslashes( $row->feed_tags ),
				'feed_id'				 => $row->feed_id,
				'events'				 => $events
			);
			$ai1ec_view_helper->display( 'feed_row.php', $args );
		endforeach;

		return ob_get_clean();
	}

	/**
	 * get_event_categories_select function
	 *
	 * Creates the dropdown element for selecting feed category
	 *
	 * @param int|null $selected The selected category or null
	 *
	 * @return String dropdown element
	 **/
	function get_event_categories_select( $selected = null) {
		ob_start();
		?>
		<select name="ai1ec_feed_category" id="ai1ec_feed_category">
		<?php
		foreach( get_terms( 'events_categories', array( 'hide_empty' => false ) ) as $term ) :
		?>
			<option value="<?php echo $term->term_id; ?>" <?php echo ( $selected === $term->id ) ? 'selected' : '' ?>>
				<?php echo $term->name; ?>
			</option>
		<?php
		endforeach;
		?>
		</select>
		<?php
		return ob_get_clean();
	}

	/**
	 * general_settings_meta_box function
	 *
	 * Displays the General Settings meta box.
	 *
	 * @return void
	 **/
	function general_settings_meta_box( $object, $box ) {
	  global $ai1ec_view_helper,
					 $ai1ec_settings_helper,
					 $ai1ec_settings;

		$calendar_page                  = $ai1ec_settings_helper->wp_pages_dropdown(
			'calendar_page_id',
			$ai1ec_settings->calendar_page_id,
			__( 'Calendar', AI1EC_PLUGIN_NAME )
		);
		$calendar_css_selector          = $ai1ec_settings->calendar_css_selector;
		$week_start_day                 = $ai1ec_settings_helper->get_week_dropdown( get_option( 'start_of_week' ) );
		$agenda_events_per_page         = $ai1ec_settings->agenda_events_per_page;
		$include_events_in_rss          =
			'<input type="checkbox" name="include_events_in_rss"
				id="include_events_in_rss" value="1"'
				. ( $ai1ec_settings->include_events_in_rss ? ' checked="checked"' : '' )
				. '/>';
		$exclude_from_search            = $ai1ec_settings->exclude_from_search ? 'checked=checked' : '';
		$show_publish_button            = $ai1ec_settings->show_publish_button ? 'checked=checked' : '';
		$hide_maps_until_clicked        = $ai1ec_settings->hide_maps_until_clicked ? 'checked=checked' : '';
		$turn_off_subscription_buttons  = $ai1ec_settings->turn_off_subscription_buttons ? 'checked=checked' : '';
		$show_create_event_button       = $ai1ec_settings->show_create_event_button ? 'checked=checked' : '';
		$inject_categories              = $ai1ec_settings->inject_categories ? 'checked=checked' : '';
		$input_us_format                = $ai1ec_settings->input_us_format ? 'checked=checked' : '';
    $input_24h_time                 = $ai1ec_settings->input_24h_time ? 'checked=checked' : '';
	  $default_calendar_view          = $ai1ec_settings_helper->get_view_dropdown( $ai1ec_settings->default_calendar_view );
	  $timezone_control               = $ai1ec_settings_helper->get_timezone_dropdown( $ai1ec_settings->timezone );

	  $args = array(
	    'calendar_page'                 => $calendar_page,
	    'default_calendar_view'         => $default_calendar_view,
			'calendar_css_selector'         => $calendar_css_selector,
			'week_start_day'                => $week_start_day,
			'agenda_events_per_page'        => $agenda_events_per_page,
			'exclude_from_search'           => $exclude_from_search,
			'show_publish_button'		        => $show_publish_button,
			'hide_maps_until_clicked'       => $hide_maps_until_clicked,
			'turn_off_subscription_buttons' => $turn_off_subscription_buttons,
			'show_create_event_button'      => $show_create_event_button,
			'inject_categories'             => $inject_categories,
			'input_us_format'               => $input_us_format,
      'input_24h_time'                => $input_24h_time,
			'show_timezone'                 => ! get_option( 'timezone_string' ),
			'timezone_control'              => $timezone_control
	  );
	  $ai1ec_view_helper->display( 'box_general_settings.php', $args );
	}

	/**
	 * ics_import_settings_meta_box function
	 *
	 * Renders view of iCalendar import meta box on the settings page.
	 *
	 * @return void
	 **/
	function ics_import_settings_meta_box( $object, $box )
	{
	  global $ai1ec_view_helper,
					 $ai1ec_settings_helper,
					 $ai1ec_settings;

	  $args = array(
	    'cron_freq' 						   => $ai1ec_settings_helper->get_cron_freq_dropdown( $ai1ec_settings->cron_freq ),
	    'event_categories'			   => $ai1ec_settings_helper->get_event_categories_select(),
			'feed_rows'							   => $ai1ec_settings_helper->get_feed_rows()
	  );
	  $ai1ec_view_helper->display( 'box_ics_import_settings.php', $args );
	}

	/**
	 * the_seed_studio_meta_box function
	 *
	 *
	 *
	 * @return void
	 **/
	function the_seed_studio_meta_box( $object, $box ) {
	  global $ai1ec_view_helper;
	  $ai1ec_view_helper->display( 'box_the_seed_studio.php' );
	}

	/**
	 * add_meta_boxes function
	 *
	 *
	 *
	 * @return void
	 **/
	function add_meta_boxes(){
	  global $ai1ec_settings;
    do_action( 'add_meta_boxes', $ai1ec_settings->settings_page );
	}
}
// END class
