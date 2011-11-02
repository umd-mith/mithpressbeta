<h2><?php _e( 'Viewing Events', AI1EC_PLUGIN_NAME ) ?></h2>

<label class="textinput" for="calendar_page_id"><?php _e( 'Calendar page:', AI1EC_PLUGIN_NAME ) ?></label>
<div class="alignleft"><?php echo $calendar_page ?></div>
<br class="clear" />

<label class="textinput" for="default_calendar_view"><?php _e( 'Default calendar view:', AI1EC_PLUGIN_NAME ) ?></label>
<?php echo $default_calendar_view ?>
<br class="clear" />

<?php if( $show_timezone ) : ?>
  <label class="textinput" for="default_calendar_view"><?php _e( 'Timezone:', AI1EC_PLUGIN_NAME ) ?></label>
  <?php echo $timezone_control ?>
<?php endif; ?>
<br class="clear" />

<label class="textinput" for="calendar_css_selector"><?php _e( 'Contain calendar in this DOM element:', AI1EC_PLUGIN_NAME ) ?></label>
<input name="calendar_css_selector" id="calendar_css_selector" type="text" size="20" value="<?php echo esc_attr( $calendar_css_selector ) ?>" />
<div class="description"><?php _e( 'Optional. Provide a <a href="http://api.jquery.com/category/selectors/" target="_blank">jQuery selector</a> that evaluates to a single DOM element. Replaces any existing markup found within target. If left empty, calendar is shown in normal page content container.', AI1EC_PLUGIN_NAME ) ?></div>

<label class="textinput" for="week_start_day"><?php _e( 'Week starts on', AI1EC_PLUGIN_NAME ) ?></label>
<?php echo $week_start_day ?>
<br class="clear" />

<label class="textinput" for="agenda_events_per_page"><?php _e( 'Agenda pages show at most', AI1EC_PLUGIN_NAME ) ?></label>
<input name="agenda_events_per_page" id="agenda_events_per_page" type="text" size="1" value="<?php echo esc_attr( $agenda_events_per_page ) ?>" />&nbsp;<?php _e( 'events', AI1EC_PLUGIN_NAME ) ?>
<br class="clear" />

<label for="exclude_from_search">
<input class="checkbox" name="exclude_from_search" id="exclude_from_search" type="checkbox" value="1" <?php echo $exclude_from_search ?> />
<?php _e( '<strong>Exclude</strong> events from search results', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<label for="show_create_event_button">
<input class="checkbox" name="show_create_event_button" id="show_create_event_button" type="checkbox" value="1" <?php echo $show_create_event_button ?> />
<?php _e( 'Show <strong>Post Your Event</strong> button above the calendar to privileged users', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<label for="turn_off_subscription_buttons">
<input class="checkbox" name="turn_off_subscription_buttons" id="turn_off_subscription_buttons" type="checkbox" value="1" <?php echo $turn_off_subscription_buttons ?> />
<?php _e( 'Hide <strong>Subscribe</strong>/<strong>Add to Calendar</strong> buttons in calendar and single event views', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<label for="hide_maps_until_clicked">
<input class="checkbox" name="hide_maps_until_clicked" id="hide_maps_until_clicked" type="checkbox" value="1" <?php echo $hide_maps_until_clicked ?> />
<?php _e( 'Hide <strong>Google Maps</strong> until clicked', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<label for="inject_categories">
<input class="checkbox" name="inject_categories" id="inject_categories" type="checkbox" value="1" <?php echo $inject_categories ?> />
<?php _e( 'Include <strong>event categories</strong> in post category lists', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<h2><?php _e( 'Adding/Editing Events', AI1EC_PLUGIN_NAME ) ?></h2>

<label for="input_us_format">
<input class="checkbox" name="input_us_format" id="input_us_format" type="checkbox" value="1" <?php echo $input_us_format ?> />
<?php _e( 'Input dates in <strong>US format</strong>', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />

<label for="input_24h_time"> 
<input class="checkbox" name="input_24h_time" id="input_24h_time" type="checkbox" value="1" <?php echo $input_24h_time ?> /> 
<?php _e( 'Use <strong>24h time</strong> in time pickers', AI1EC_PLUGIN_NAME ) ?> 
</label> 
<br class="clear" />

<label for="show_publish_button">
<input class="checkbox" name="show_publish_button" id="show_publish_button" type="checkbox" value="1" <?php echo $show_publish_button ?> />
<?php _e( 'Display <strong>Publish</strong> at bottom of Edit Event form', AI1EC_PLUGIN_NAME ) ?>
</label>
<br class="clear" />
