<h2 class="ai1ec-calendar-title"><?php echo esc_html( $title ) ?></h2>
<span class="ai1ec-title-buttons">
	<?php if( $dates ): ?>
		<a id="ai1ec-expand-all" class="ai1ec-button">
			<?php _e( '+ Expand All', AI1EC_PLUGIN_NAME ) ?>
		</a><a
		id="ai1ec-collapse-all" class="ai1ec-button">
			<?php _e( '− Collapse All', AI1EC_PLUGIN_NAME ) ?>
		</a
	><?php endif ?><a
		id="ai1ec-today" class="ai1ec-load-view ai1ec-button" href="#action=ai1ec_agenda">
		<?php _e( 'Today', AI1EC_PLUGIN_NAME ) ?>
	</a>
</span>
<ul class="ai1ec-pagination">
	<?php foreach( $pagination_links as $link ): ?>
		<li>
			<a id="<?php echo $link['id'] ?>" class="ai1ec-load-view ai1ec-button ai1ec-pagination"
				href="<?php echo esc_attr( $link['href'] ) ?>">
				<?php echo esc_html( $link['text'] ) ?>
			</a>
		</li>
	<?php endforeach ?>
</ul>
<ol class="ai1ec-agenda-view">
	<?php if( ! $dates ): ?>
		<p class="ai1ec-no-results">
			<?php _e( 'There are no upcoming events to display at this time.', AI1EC_PLUGIN_NAME ) ?>
		</p>
	<?php else: ?>
		<?php foreach( $dates as $timestamp => $date_info ): ?>
			<li class="ai1ec-date <?php if( $date_info['today'] ) echo 'ai1ec-today' ?>">
				<h3 class="ai1ec-date-title">
					<div class="ai1ec-month"><?php echo date_i18n( 'M', $timestamp, true ) ?></div>
					<div class="ai1ec-day"><?php echo date_i18n( 'j', $timestamp, true ) ?></div>
					<div class="ai1ec-weekday"><?php echo date_i18n( 'D', $timestamp, true ) ?></div>
				</h3>
				<ol class="ai1ec-date-events">
					<?php foreach( $date_info['events'] as $category ): ?>
						<?php foreach( $category as $event ): ?>
							<li class="ai1ec-event
								ai1ec-event-id-<?php echo $event->post_id ?>
								ai1ec-event-instance-id-<?php echo $event->instance_id ?>
								<?php if( $event->allday ) echo 'ai1ec-allday' ?>
								<?php if( $event->post_id == $active_event ) echo 'ai1ec-active-event' ?>">

								<?php // Insert post ID for use by JavaScript filtering later ?>
								<input type="hidden" class="ai1ec-post-id" value="<?php echo $event->post_id ?>" />

								<?php // Hidden summary, until clicked ?>
								<div class="ai1ec-event-summary">
									<div class="ai1ec-event-click">
										<div class="ai1ec-event-expand">−</div>
										<div class="ai1ec-event-title">
											<?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?>
											<?php if( $event->allday ): ?>
												<span class="ai1ec-allday-label"><?php _e( '(all-day)', AI1EC_PLUGIN_NAME ) ?></span>
											<?php endif ?>
										</div>
										<div class="ai1ec-event-time">
											<?php if( $event->allday ): ?>
												<?php echo esc_html( $event->short_start_date ) ?>
												<?php if( $event->short_end_date != $event->short_start_date ): ?>
													– <?php echo esc_html( $event->short_end_date ) ?>
												<?php endif ?>
											<?php else: ?>
												<?php echo esc_html( $event->start_time . ' – ' . $event->end_time ) ?></span>
											<?php endif ?>
										</div>
									</div>
									<div class="ai1ec-event-description">
										<div class="ai1ec-event-overlay">
											<a class="ai1ec-read-more ai1ec-button"
												href="<?php echo esc_attr( get_permalink( $event->post_id ) ) ?>">
												<?php _e( 'Read more', AI1EC_PLUGIN_NAME ) ?>
											</a>
											<?php if( $event->categories_html ): ?>
												<div class="ai1ec-categories">
													<label class="ai1ec-label"><?php _e( 'Categories:', AI1EC_PLUGIN_NAME ) ?></label>
													<?php echo $event->categories_html ?>
												</div>
											<?php endif ?>
											<?php if( $event->tags_html ): ?>
												<div class="ai1ec-tags">
													<label class="ai1ec-label"><?php _e( 'Tags:', AI1EC_PLUGIN_NAME ) ?></label>
													<?php echo $event->tags_html ?>
												</div>
											<?php endif ?>
										</div>
										<?php echo apply_filters( 'the_content', $event->post->post_content ) ?>
									</div>
								</div>

								<div class="ai1ec-event-click">
									<?php if( $event->category_colors ): ?>
										<div class="ai1ec-category-colors"><?php echo $event->category_colors ?></div>
									<?php endif ?>
									<div class="ai1ec-event-expand">+</div>
									<?php if( ! $event->allday ): ?>
										<div class="ai1ec-event-time">
											<?php echo esc_html( $event->start_time ) ?></span>
										</div>
									<?php endif ?>
									<div class="ai1ec-event-title">
										<?php echo esc_html( apply_filters( 'the_title', $event->post->post_title ) ) ?>
										<?php if( $event->allday ): ?>
											<span class="ai1ec-allday-label"><?php _e( '(all-day)', AI1EC_PLUGIN_NAME ) ?></span>
										<?php endif ?>
									</div>
								</div>

							</li>
						<?php endforeach ?>
					<?php endforeach ?>
				</ol>
			</li>
		<?php endforeach ?>
	<?php endif ?>
</ol>
