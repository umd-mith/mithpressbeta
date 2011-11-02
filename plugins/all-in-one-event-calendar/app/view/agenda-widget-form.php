<p>
	<label for="<?php echo $title['id'] ?>"><?php _e( 'Title:', AI1EC_PLUGIN_NAME ) ?></label>
	<input class="widefat" id="<?php echo $title['id'] ?>" name="<?php echo $title['name'] ?>" type="text" value="<?php echo $title['value'] ?>" />
</p>
<p>
	<label for="<?php echo $events_per_page['id'] ?>"><?php _e( 'Number of events to show:', AI1EC_PLUGIN_NAME ) ?></label>
	<input id="<?php echo $events_per_page['id'] ?>" name="<?php echo $events_per_page['name'] ?>" type="text" size="3" value="<?php echo $events_per_page['value'] ?>" />
</p>
<p>
	<input id="<?php echo $show_calendar_button['id'] ?>" name="<?php echo $show_calendar_button['name'] ?>" type="checkbox" value="1" <?php if( $show_calendar_button['value'] ) echo 'checked="checked"' ?> />
	<label for="<?php echo $show_calendar_button['id'] ?>"><?php _e( 'Show <strong>View Calendar</strong> button', AI1EC_PLUGIN_NAME ) ?></label>
	<br />
	<input id="<?php echo $show_subscribe_buttons['id'] ?>" name="<?php echo $show_subscribe_buttons['name'] ?>" type="checkbox" value="1" <?php if( $show_subscribe_buttons['value'] ) echo 'checked="checked"' ?> />
	<label for="<?php echo $show_subscribe_buttons['id'] ?>"><?php _e( 'Show <strong>Subscribe</strong> buttons', AI1EC_PLUGIN_NAME ) ?></label>
	<br />
	<input id="<?php echo $hide_on_calendar_page['id'] ?>" name="<?php echo $hide_on_calendar_page['name'] ?>" type="checkbox" value="1" <?php if( $hide_on_calendar_page['value'] ) echo 'checked="checked"' ?> />
	<label for="<?php echo $hide_on_calendar_page['id'] ?>"><?php _e( 'Hide this widget on calendar page', AI1EC_PLUGIN_NAME ) ?></label>
</p>
