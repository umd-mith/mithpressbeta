<h2 class="ai1ec-calendar-title"><?php echo esc_html( $title ) ?></h2>
<span class="ai1ec-title-buttons">
	<a id="ai1ec-today" class="ai1ec-load-view ai1ec-button" href="#action=ai1ec_month">
		<?php _e( 'Today', AI1EC_PLUGIN_NAME ) ?>
	</a>
</span>
<ul class="ai1ec-pagination">
	<?php foreach( $pagination_links as $link ): ?>
		<li>
			<a id="<?php echo $link['id'] ?>"
				class="ai1ec-load-view ai1ec-button"
				href="<?php echo esc_attr( $link['href'] ) ?>">
				<?php echo esc_html( $link['text'] ) ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>
<table class="ai1ec-month-view">
	<thead>
		<tr>
			<?php foreach( $weekdays as $weekday ): ?>
				<th class="ai1ec-weekday"><?php echo $weekday; ?></th>
			<?php endforeach // weekday ?>
		</tr>
	</thead>
	<tbody>
		<?php foreach( $cell_array as $week ): ?>
			<tr class="ai1ec-week">
				<?php foreach( $week as $day ): ?>
					<?php if( $day['date'] ): ?>
						<td <?php if( $day['today'] ) echo 'class="ai1ec-today"' ?>>
							<div class="ai1ec-day">
								<div class="ai1ec-date"><?php echo $day['date'] ?></div>
								<?php foreach( $day['events'] as $event ): ?>
									<a href="<?php echo esc_attr( get_permalink( $event->post_id ) ) ?>"
										class="ai1ec-event-container
											ai1ec-event-id-<?php echo $event->post_id ?>
											ai1ec-event-instance-id-<?php echo $event->instance_id ?>
											<?php if( $event->allday ) echo 'ai1ec-allday' ?>">

										<?php // Insert post ID for use by JavaScript filtering later ?>
										<input type="hidden" class="ai1ec-post-id" value="<?php echo $event->post_id ?>" />

										<div class="ai1ec-event-popup">
											<div class="ai1ec-event-summary">
												<?php if( $event->category_colors ): ?>
												  <div class="ai1ec-category-colors"><?php echo $event->category_colors ?></div>
												<?php endif ?>
												<?php if( $event->post_excerpt ): ?>
													<strong><?php _e( 'Summary:', AI1EC_PLUGIN_NAME ) ?></strong>
													<p><?php echo esc_html( $event->post_excerpt ) ?></p>
												<?php endif ?>
												<div class="ai1ec-read-more"><?php esc_html_e( 'click anywhere for details', AI1EC_PLUGIN_NAME ) ?></div>
											</div>
											<div class="ai1ec-event-popup-bg">
												<?php if( ! $event->allday ): ?>
													<span class="ai1ec-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
												<?php endif ?>
												<span class="ai1ec-event-title">
												  <?php if( function_exists( 'mb_strimwidth' ) ) : ?>
												    <?php echo esc_html( mb_strimwidth( apply_filters( 'the_title', $event->post->post_title ), 0, 35, '...' ) ) ?></span>
												  <?php else : ?>
												    <?php $read_more = strlen( apply_filters( 'the_title', $event->post->post_title ) ) > 35 ? '...' : '' ?>
                            <?php echo esc_html( substr( apply_filters( 'the_title', $event->post->post_title ), 0, 35 ) . $read_more );  ?>
												  <?php endif; ?>
												</span>
												<?php if( $event->allday ): ?>
													<small><?php esc_html_e( '(all-day)', AI1EC_PLUGIN_NAME ) ?></small>
												<?php endif ?>
											</div>
										</div><!-- .event-popup -->

										<div class="ai1ec-event <?php if( $event->post_id == $active_event ) echo 'ai1ec-active-event' ?>" <?php echo $event->color_style; ?>>
											<?php if( ! $event->allday ): ?>
												<span class="ai1ec-event-time"><?php echo esc_html( $event->short_start_time ) ?></span>
											<?php endif ?>
											<span class="ai1ec-event-title"><?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?></span>
										</div>

									</a>
								<?php endforeach // events ?>
							</div>
						</td>
					<?php else: ?>
						<td class="ai1ec-empty"></td>
					<?php endif // date ?>
				<?php endforeach // day ?>
			</tr>
		<?php endforeach // week ?>
	</tbody>
</table>
