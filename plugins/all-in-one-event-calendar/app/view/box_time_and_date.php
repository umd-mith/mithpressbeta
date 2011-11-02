<?php wp_nonce_field( 'ai1ec', AI1EC_POST_TYPE ); ?>
<h4 class="ai1ec-section-title"><?php _e( 'Event date and time', AI1EC_PLUGIN_NAME ); ?></h4>
<table class="ai1ec-form">
	<tbody>
		<tr>
			<td class="ai1ec-first">
				<label for="ai1ec_all_day_event">
					<?php _e( 'All-day event', AI1EC_PLUGIN_NAME ); ?>?
				</label>
			</td>
			<td>
				<input type="checkbox" name="ai1ec_all_day_event" id="ai1ec_all_day_event" <?php echo $all_day_event; ?> />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_start-date-input">
					<?php _e( 'Start date / time', AI1EC_PLUGIN_NAME ); ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_start-date-input" />
				<input type="text" class="ai1ec-time-input" id="ai1ec_start-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="ai1ec_start_time" id="ai1ec_start-time" value="<?php echo $start_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_end-date-input">
					<?php _e( 'End date / time', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_end-date-input" />
				<input type="text" class="ai1ec-time-input" id="ai1ec_end-time-input" />
				<small><?php echo $timezone ?></small>
				<input type="hidden" name="ai1ec_end_time" id="ai1ec_end-time" value="<?php echo $end_timestamp ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="ai1ec_repeat">
					<?php _e( 'Repeat', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<?php echo $repeat; ?>
			</td>
		</tr>
		<tr id="ai1ec_end_holder" <?php if( ! $repeating_event ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_end">
					<?php _e( 'End', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
			  <?php echo $end ?>
			</td>
		</tr>
		<tr id="ai1ec_count_holder" <?php if( $ending != 1 ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_count">
					<?php _e( 'Ending after', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<?php echo $count; ?>
			</td>
		</tr>
		<tr id="ai1ec_until_holder" <?php if( $ending != 2 ) echo 'class="ai1ec_hidden"' ?>>
			<td>
				<label for="ai1ec_until-date-input">
					<?php _e( 'On date', AI1EC_PLUGIN_NAME ) ?>:
				</label>
			</td>
			<td>
				<input type="text" class="ai1ec-date-input" id="ai1ec_until-date-input" />
				<input type="hidden" name="ai1ec_until_time" id="ai1ec_until-time" value="<?php echo !is_null( $until ) && $until > 0 ? $until : '' ?>" />
			</td>
		</tr>
	</tbody>
</table>
