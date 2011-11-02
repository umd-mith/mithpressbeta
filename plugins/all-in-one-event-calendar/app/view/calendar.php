<table class="ai1ec-calendar-toolbar">
	<tbody>
		<tr>

			<td>
				<ul class="ai1ec-view-tabs">
					<li>
						<a id="ai1ec-view-month" class="ai1ec-load-view ai1ec-button"
							href="#action=ai1ec_month">
							<img src="<?php echo AI1EC_IMAGE_URL ?>/month-view.png" alt="<?php _e( 'Month', AI1EC_PLUGIN_NAME ) ?>" />
							<?php _e( 'Month', AI1EC_PLUGIN_NAME ) ?>
						</a>
					</li>
					<li>
						<a id="ai1ec-view-agenda" class="ai1ec-load-view ai1ec-button"
							href="#action=ai1ec_agenda">
							<img src="<?php echo AI1EC_IMAGE_URL ?>/agenda-view.png" alt="<?php _e( 'Month', AI1EC_PLUGIN_NAME ) ?>" />
							<?php _e( 'Agenda', AI1EC_PLUGIN_NAME ) ?>
						</a>
					</li>
				</ul>
			</td>

			<?php if( $create_event_url ): ?>
				<td>
					<a class="ai1ec-button" href="<?php echo $create_event_url ?>">
						<?php _e( '+ Post Your Event', AI1EC_PLUGIN_NAME ) ?>
					</a>
				</td>
			<?php endif ?>

			<?php if( $categories || $tags ): ?>
				<td>
					<div class="ai1ec-filters-container">
						<label class="ai1ec-label">
							<a class="ai1ec-clear-filters" title="<?php _e( 'Clear Filters', AI1EC_PLUGIN_NAME ) ?>"><?php _e( '✘', AI1EC_PLUGIN_NAME ) ?></a>
							<?php _e( 'Filter:', AI1EC_PLUGIN_NAME ) ?>
						</label>

						<?php if( $categories ): ?>
							<span class="ai1ec-filter-selector-container">
								<a class="ai1ec-button ai1ec-dropdown"><?php _e( 'Categories ▾', AI1EC_PLUGIN_NAME ) ?></a>
								<input class="ai1ec-selected-terms"
									id="ai1ec-selected-categories"
									type="hidden"
									value="<?php echo $selected_cat_ids ?>" />
								<div class="ai1ec-filter-selector ai1ec-category-filter-selector">
									<ul>
										<?php foreach( $categories as $cat ): ?>
											<li class="ai1ec-category"
												<?php if( $cat->description ) echo 'title="' . esc_attr( $cat->description ) . '"' ?>>
												<?php echo $cat->color ?>
												<?php echo esc_html( $cat->name ) ?>
												<input class="ai1ec-term-ids" name="ai1ec-categories" type="hidden" value="<?php echo $cat->term_id ?>" />
											</li>
										<?php endforeach ?>
									</ul>
								</div>
							</span>
						<?php endif // $categories ?>

						<?php if( $tags ): ?>
							<span class="ai1ec-filter-selector-container">
								<a class="ai1ec-button ai1ec-dropdown"><?php _e( 'Tags ▾', AI1EC_PLUGIN_NAME ) ?></a>
								<input class="ai1ec-selected-terms"
									id="ai1ec-selected-tags"
									type="hidden"
									value="<?php echo $selected_tag_ids ?>" />
								<div class="ai1ec-filter-selector ai1ec-tag-filter-selector">
									<ul>
										<?php foreach( $tags as $tag ): ?>
											<li class="ai1ec-tag"
												<?php if( $tag->description ) echo 'title="' . esc_attr( $tag->description ) . '"' ?>
												style="<?php echo $tag->count > 1 ? 'font-weight: bold;' : 'font-size: 10px !important;' ?>">
												<?php echo esc_html( $tag->name ) . " ($tag->count)" ?>
												<input class="ai1ec-term-ids" name="ai1ec-tags" type="hidden" value="<?php echo $tag->term_id ?>" />
											</li>
										<?php endforeach ?>
									</ul>
									<input class="ai1ec-selected-terms" id="ai1ec-selected-tags" type="hidden" />
								</div>
							</span>
						<?php endif // $tags ?>
					</div>
				</td>
			<?php endif // $categories || $tags ?>
		</tr>
	</tbody>
</table>

<div id="ai1ec-calendar-view-container">
	<div id="ai1ec-calendar-view-loading" class="ai1ec-loading"></div>
	<div id="ai1ec-calendar-view">
		<?php echo $view ?>
	</div>
</div>

<?php if( $show_subscribe_buttons ): ?>
	<a class="ai1ec-button ai1ec-subscribe"
		href="<?php echo AI1EC_EXPORT_URL ?>"
		title="<?php _e( 'Subscribe to this calendar using your favourite calendar program (iCal, Outlook, etc.)', AI1EC_PLUGIN_NAME ) ?>" />
		<?php _e( '✔ Subscribe', AI1EC_PLUGIN_NAME ) ?>
		<span class="ai1ec-subscribe-filtered"><?php _e( 'to this filtered calendar', AI1EC_PLUGIN_NAME ) ?></span>
	</a>
	<a class="ai1ec-button ai1ec-subscribe-google" target="_blank"
		href="http://www.google.com/calendar/render?cid=<?php echo urlencode( str_replace( 'webcal://', 'http://', AI1EC_EXPORT_URL ) ) ?>"
		title="<?php _e( 'Subscribe to this calendar in your Google Calendar', AI1EC_PLUGIN_NAME ) ?>" />
		<img src="<?php echo AI1EC_IMAGE_URL ?>/google-calendar.png" />
		<?php _e( 'Subscribe in Google Calendar', AI1EC_PLUGIN_NAME ) ?>
	</a>
<?php endif ?>
