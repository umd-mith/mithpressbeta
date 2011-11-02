jQuery( function( $ ){

	/**
	 * Event post creation/edit form
	 */
	if( $('#ai1ec_event' ).length )
	{
		// Selector for repeat weekly
		element_selector( '.ai1ec_week_days_list > li', 'ai1ec_selected', 'ai1ec_weekday_value', '#ai1ec_weekly_days' );

		// Selector for repeat monthly
		element_selector( '.ai1ec_month_days_list > li', 'ai1ec_selected', 'ai1ec_monthday_value', '#ai1ec_monthly_days' );

		// Selector for repeat yearly
		element_selector( '.ai1ec_yearly_months_list > li', 'ai1ec_selected', 'ai1ec_yearmonth_value', '#ai1ec_yearly_months' );

		var now = new Date( ai1ec_add_new_event.now * 1000 );

		/**
		 * Timespan plugin setup
		 */

		// Initialize timespan plugin on our date/time inputs.
		var data = {
			allday: 					'#ai1ec_all_day_event',
			start_date_input: '#ai1ec_start-date-input',
			start_time_input: '#ai1ec_start-time-input',
			start_time: 			'#ai1ec_start-time',
			end_date_input: 	'#ai1ec_end-date-input',
			end_time_input: 	'#ai1ec_end-time-input',
			end_time: 				'#ai1ec_end-time',
			us_format:        ai1ec_add_new_event.us_format,
			twentyfour_hour:  ai1ec_add_new_event.twentyfour_hour,
			now:              now
		}
		$.timespan( data );

		// Initialize inputdate plugin on our "until" date input.
		data = {
			start_date_input: '#ai1ec_until-date-input',
			start_time:       '#ai1ec_until-time',
			us_format:        ai1ec_add_new_event.us_format,
			now:              now
		}
		$.inputdate( data );

		// Initialize count range slider
		$( '#ai1ec_count' ).rangeinput( {
			css: {
				input: 'ai1ec-range',
				slider: 'ai1ec-slider',
				progress: 'ai1ec-progress',
				handle: 'ai1ec-handle'
			}
		} );

		/**
		 * Google map setup
		 */

		// If the user is updating an event, initialize the map to the event
		// location, otherwise if the user is creating a new event initialize
		// the map to the whole world
		var ai1ec_geocoder = new google.maps.Geocoder();
		//world = map.setCenter(new GLatLng(9.965, -83.327), 1);
		//africa = map.setCenter(new GLatLng(-3, 27), 3);
		//europe = map.setCenter(new GLatLng(47, 19), 3);
		//asia = map.setCenter(new GLatLng(32, 130), 3);
		//south pacific = map.setCenter(new GLatLng(-24, 134), 3);
		//north america = map.setCenter(new GLatLng(50, -114), 3);
		//latin america = map.setCenter(new GLatLng(-20, -70), 3);
		var ai1ec_default_location = new google.maps.LatLng( 9.965, -83.327 );
		var ai1ec_myOptions = {
			zoom: 0,
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			center: ai1ec_default_location
		};
		var ai1ec_map = new google.maps.Map( $( '#ai1ec_map_canvas' ).get(0), ai1ec_myOptions );
		var ai1ec_marker = new google.maps.Marker({ map: ai1ec_map });

		/**
		 * Given a location, update the address field with a reformatted version,
		 * update hidden location fields with address data, and center map on
		 * new location.
		 *
		 * @param object result  single result of a Google geocode() call
		 */
		function ai1ec_update_address( result )
		{
			ai1ec_map.setCenter( result.geometry.location );
			ai1ec_map.setZoom( 15 );
			ai1ec_marker.setPosition( result.geometry.location );
			$( '#ai1ec_address' ).val( result.formatted_address );

			var street_number = '';
			var street_name = '';
			var city = '';
			var state = '';
			var postal_code = 0;
			var country = 0;
			for( var i = 0; i < result.address_components.length; i++ ) {
				switch( result.address_components[i].types[0] ) {
					case 'street_number':
						street_number = result.address_components[i].long_name;
						break;
					case 'route':
						street_name = result.address_components[i].long_name;
						break;
					case 'locality':
						city = result.address_components[i].long_name;
						break;
					case 'administrative_area_level_1':
						province = result.address_components[i].long_name;
						break;
					case 'postal_code':
						postal_code = result.address_components[i].long_name;
						break;
					case 'country':
						country = result.address_components[i].long_name;
						break;
				}
			}
			// Combine street number with street address
			var address = street_number.length > 0 ? street_number + ' ' : '';
			address += street_name.length > 0 ? street_name : '';
			// Clean up postal code if necessary
			postal_code = postal_code != 0 ? postal_code : '';

			$( '#ai1ec_city' ).val( city );
			$( '#ai1ec_province' ).val( province );
			$( '#ai1ec_postal_code' ).val( postal_code );
			$( '#ai1ec_country' ).val( country );
		}

		$( '#ai1ec_address' )
			/**
			 * Initialize geo_autocomplete plugin
			 */
			.geo_autocomplete(
				new google.maps.Geocoder,
				{
					selectFirst: false,
					minChars: 3,
					cacheLength: 50,
					width: 300,
					scroll: true,
					scrollHeight: 330
				}
			).result(
				function( _event, _data ) {
					if( _data ) {
						ai1ec_update_address( _data );
					}
				}
			)
			/**
			 * Each time user changes address field, reformat field and update map
			 */
			.change(
				function() {
					// Position map based on provided address value
					if( $( this ).val().length > 0 ) {
						var address = $( this ).val();

						ai1ec_geocoder.geocode(
							{
								'address': address
							},
							function( results, status ) {
								if( status == google.maps.GeocoderStatus.OK ) {
									ai1ec_update_address( results[0] );
								}
							}
						);
					}
				}
			)
			// Now trigger the event on load to initialize map
			.change();

		// Toggle the visibility of google map on checkbox click
		$( '#ai1ec_google_map' ).click( function() {
			if( $( this ).is( ':checked' ) ) {
				// show the map
				$( '.ai1ec_box_map' )
					.addClass( 'ai1ec_box_map_visible')
					.hide()
					.slideDown( 'fast' );
			} else {
				// hide the map
				$( '.ai1ec_box_map' ).slideUp( 'fast' );
			}
		});

		/**
		 * Show/hide elements that show selectors for ending until/after events
		 */
		function show_end_fields() {
			var selected = $( '#ai1ec_end option:selected' ).val();
			switch( selected ) {
				// Never selected, hide end fields
				case '0':
					hide_all_end_fields();
					break;
				// After selected
				case '1':
					if( $( '#ai1ec_count_holder' ).css( 'display' ) == 'none' ) {
						hide_all_end_fields();
						$( '#ai1ec_count_holder' ).fadeIn();
					}
					break;
				// On date selected
				case '2':
					if( $( '#ai1ec_until_holder' ).css( 'display' ) == 'none' ) {
						hide_all_end_fields();
						$( '#ai1ec_until_holder' ).fadeIn();
					}
					break;
			}
		}
		/**
		 * Show/hide elements that show selectors for repeating events
		 */
		function show_all_repeat_fields() {
			$( '#ai1ec_end_holder' ).fadeIn();
			show_end_fields();
		}
		function hide_all_repeat_fields() {
			hide_all_end_fields();
			$( '#ai1ec_end_holder' ).fadeOut();
		}
		function hide_all_end_fields() {
			$( '#ai1ec_count_holder, #ai1ec_until_holder' ).hide();
		}

		// ===========================
		// = Repeat dropdown clicked =
		// ===========================
		$( '#ai1ec_repeat' ).change( function() {
			// hide all helper elements

			var selected = $( '#ai1ec_repeat option:selected' ).val();
			switch( selected ) {
				// =============================
				// = None selected, hide repeating fields =
				// =============================
				case ' ':
					hide_all_repeat_fields();
					break;

				// =====================
				// = Repeating event, show repeating fields =
				// =====================
				default:
					show_all_repeat_fields();
					break;
			}
		});
		// ========================
		// = End dropdown clicked =
		// ========================
		$( '#ai1ec_end' ).change( show_end_fields );

		/**
		 * Bottom publish button click event handler
		 */
		if( $( '#ai1ec_bottom_publish' ).length > 0 ) {
			$( '#ai1ec_bottom_publish' ).click( function() {
				$( '#publish' ).trigger( 'click' );
			});
		}
	}

	/**
	 * ICS feeds
	 */

	if( $( '#ai1ec_add_new_ics' ).length )
	{
		/**
		 * Click event handler for + Add new subscription button
		 * checks to see if the feed url is valid url
		 * and makes an ajax call with the feed details
		 */
		$( '#ai1ec_add_new_ics' ).click( function() {
			var $button = $( this );
			var $url = $( '#ai1ec_feed_url' );
			var url = $url.val().replace( 'webcal://', 'http://' );
			var invalid = false;
			var error_message;

			// restore feed url border colors if it has been changed
			$('.ai1ec-feed-url, #ai1ec_feed_url').css( 'border-color', '#DFDFDF' );
			$('#ai1ec-feed-error').remove();

			// Check for duplicates
			$('.ai1ec-feed-url').each( function() {
				if( this.value == url ) {
					// This feed's already been added
					$(this).css( 'border-color', '#FF0000' );
					invalid = true;
					error_message = ai1ec_add_new_event.duplicate_feed_message;
				}
			} );
			// Check for valid URL
			if( ! isUrl( url ) ) {
				invalid = true;
				error_message = ai1ec_add_new_event.invalid_url_message;
			}

			if( invalid ) {
				// color the feed url input field in red and output error message
				$url
					.css( 'border-color', '#FF0000' )
					.focus()
					.before( '<div class="error" id="ai1ec-feed-error"><p>' + error_message + '</p></div>' );
			} else {
				// disable the add button for now
				$button.attr( 'disabled', true );
				// create the data to send
				var data = {
					action: 'ai1ec_add_ics',
					feed_url: url,
					feed_category: $( '#ai1ec_feed_category option:selected' ).val(),
					feed_tags: $( '#ai1ec_feed_tags' ).val()
				};
				// make an ajax call to save the new feed
				$.getJSON( ajaxurl, data,
					function( response ) {
						// restore add button
						$button.removeAttr( 'disabled' );
						if( response.error ) {
							// tell the user there is an error
							// TODO: Use other method of notification
							alert( response.message );
						} else {
							$url.val( '' );
							// Add the feed to the settings screen
							$( '#ai1ec-feeds-after' ).after( response.message );
						}
					}
				);
			}

		});

		/**
		 * Click event handler for X Delete button
		 * that deletes the feed by sending the feed_id via ajax
		 */
		$( '.ai1ec_delete_ics' ).live( 'click', function() {
			// store clicked button for later use
			var $button = $( this );
			// disable the delete button
			$button.attr( 'disabled', true );
			// table row to delete
			var $feed_row = $button.closest( '.ai1ec-feed-container' );
			// get the selected feed id
			var ics_id = $button.siblings( '.ai1ec_feed_id' ).val();
			// create the data to send
			var data = {
				action: 'ai1ec_delete_ics',
				ics_id: ics_id
			};
			// remove the feed from the database
			$.getJSON( ajaxurl, data,
				function( response ) {
					// restore the delete button
					$button.removeAttr( 'disabled' );
					if( response.error ) {
						// tell the user there is an error
						alert( response.message );
					} else {
						// remove the feed from the settings screen
						$feed_row.remove();
					}
				}
			);
		});

		/**
		 * Click event handler for Flush events button
		 * that deletes all event posts that came from that feed by sending the feed_id via ajax
		 */
		$( '.ai1ec_flush_ics' ).live( 'click', function() {
			// store clicked button for later use
			var $button = $( this );
			// disable the flush button
			$button.attr( 'disabled', true );
			// get the selected feed id
			var ics_id = $button.siblings( '.ai1ec_feed_id' ).val();
			$button.siblings( '.ajax-loading' ).css( 'visibility', 'visible' );
			// create the data to send
			var data = {
				action: 'ai1ec_flush_ics',
				ics_id: ics_id
			};
			// remove the feed from the database
			$.getJSON( ajaxurl, data,
				function( response ) {
					if( response.error ) {
						// tell the user there is an error
						alert( response.message );
					} else {
						$button.fadeOut();
					}
					$button.siblings( '.ajax-loading' ).css( 'visibility', 'hidden' );
				}
			);
		});

		/**
		 * Click event handler for Update events button
		 * that imports events from that feed by sending the feed_id via ajax
		 */
		$( '.ai1ec_update_ics' ).live( 'click', function() {
			// store clicked button for later use
			var $button = $( this );
			// disable the update button
			$button.attr( 'disabled', true );
			// get the selected feed id
			var ics_id = $button.siblings( '.ai1ec_feed_id' ).val();
			$button.siblings( '.ajax-loading' ).css( 'visibility', 'visible' );
			// create the data to send
			var data = {
				action: 'ai1ec_update_ics',
				ics_id: ics_id
			};
			// remove the feed from the database
			$.getJSON( ajaxurl, data,
				function( response ) {
					if( response.error ) {
						// tell the user there is an error
						alert( response.message );
					} else {
						$button.siblings( '.ai1ec_flush_ics' ).remove();
						// If events were imported, create new flush button
						if( response.count )
							$button.after(
								'<input type="button" class="button ai1ec_flush_ics" value="' +
								response.flush_label + '" />' );
					}
					$button
						.attr( 'disabled', false )
						.siblings( '.ajax-loading' ).css( 'visibility', 'hidden' );
				}
			);
		});

		/**
		 * isUrl checks to see if the passed parameter is a valid url
		 * and returns true on access and false on failure
		 *
		 * @param String s String to validate
		 *
		 * @return boolean True if the string is a valid url, false otherwise
		 */
		function isUrl( s ) {
			var regexp = /(http|https|webcal):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
			return regexp.test(s);
		};
	}
});
