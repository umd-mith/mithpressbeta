jQuery( document ).ready( function( $ ) {

	// =====================================
	// = Calendar CSS selector replacement =
	// =====================================

	if( ai1ec_calendar.selector != undefined && ai1ec_calendar.selector != '' &&
	    $( ai1ec_calendar.selector ).length == 1 )
	{
		// Try to find an <h#> element containing the title
		var $title = $( ":header:contains(" + ai1ec_calendar.title + "):first" );
		// If none found, create one
		if( ! $title.length ) {
			$title = $( '<h1 class="page-title"></h1>' );
			$title.text( ai1ec_calendar.title ); // Do it this way to automatically generate HTML entities
		}

		var $calendar = $( '#ai1ec-container' )
			.detach()
			.before( $title );

		$( ai1ec_calendar.selector )
			.empty()
			.append( $calendar )
			.hide()
			.css( 'visibility', 'visible' )
			.fadeIn( 'fast' );
	}

	// =================================
	// = General script initialization =
	// =================================

	// Variable storing currently displayed view
	var current_hash = '';
	// An array caching the IDs of all event posts in the currently active view
	var post_ids;

	// Check whether appropriate classes have been added to <body> (some themes
	// don't respect the WP body_class() function). If not, add them, or our app
	// won't function properly.
	var classes = $('body').attr( 'class' );
	if( classes == undefined ) classes = '';
	if( classes.match( /\s?\bai1ec-[\w-]+\b/ ) == null ) {
		// Add action body class(es)
		classes += ' ' + ai1ec_calendar.body_class;
		$('body').attr( 'class', classes );
	}

	/**
	 * Function used to update view if user has clicked back/forward in the
	 * browser.
	 */
	function check_hash() {
		var live_hash = document.location.hash;
		var default_hash = convertEntities( ai1ec_calendar.default_hash );
		// If current_hash doesn't match live hash, and the document's live hash
		// isn't empty, or if it is, the current_hash isn't equivalent to empty
		// (i.e., default hash), the page needs to be updated.
		if( current_hash != live_hash &&
		    ( live_hash != '' || current_hash != default_hash ) ) {
			// If hash is empty, resort to original requested action
			var hash = live_hash;
			if( ! hash )
				hash = default_hash;
			load_view( hash );
		}
	}

	// Monitor browser navigation between different URL #hash values
	setInterval( check_hash, 300 );

	/**
	 * Load a calendar view represented by the given hash value.
	 */
	function load_view( hash ) {

		// Reveal loader behind view
		$('#ai1ec-calendar-view-loading').fadeIn( 'fast' );
		$('#ai1ec-calendar-view').fadeTo( 'fast', 0.3,
			// After loader is visible, fetch new content
			function() {
				var query = hash.substring( 1 );

				// Fetch AJAX result
				$.getJSON( ai1ec_calendar.ajaxurl, query, function( data )
					{
						// Replace action body class with new one
						var classes = $('body').attr( 'class' );
						classes = classes.replace( /\s?\bai1ec-[\w-]+\b/g, '' );
						classes += ' ' + data.body_class;
						$('body').attr( 'class', classes );

						// Animate vertical height of container between HTML replacement
						var $container = $('#ai1ec-calendar-view-container');
						$container.height( $container.height() );
						var new_height =
							$('#ai1ec-calendar-view')
								.html( data.html )
								.height();
						$container.animate( { height: new_height }, { complete: function() {
							// Restore height to automatic upon animation completion for
							// proper page layout.
							$container.height( 'auto' );
						} } );

						// Hide loader
						$('#ai1ec-calendar-view-loading').fadeOut( 'fast' );
						$('#ai1ec-calendar-view').fadeTo( 'fast', 1.0 );

						// Do any general view initialization after loading
						initialize_view();
					}
				);
			} );

		// Update stored hash
		current_hash = hash;
	}

	// Register navigation click handlers
	$('a.ai1ec-load-view').live( 'click', function() {
		// Load requested view
		load_view( $(this).attr( 'href' ) );
	} );

	// *** Month view ***

	/**
	 * Callback for mouseenter event on .ai1ec-event element
	 */
	function show_popup() {
		var $popup = $(this).prev();

		// If not already done, position popup so that it does not exceed
		// right/left bounds of container.
		if( ! $popup.data( 'ai1ec_offset' ) ) {
			// Keep popup hidden but positionable
			$popup.css( 'visibility', 'hidden' ).show();

			var $container = $('#ai1ec-calendar-view-container');
			var popup_width = $popup.width();
			var popup_offset = $popup.offset();
			var container_offset = $container.offset();
			var container_x2 = container_offset.left + $container.width();

			// Respect right-side bounds
			if( popup_offset.left + popup_width > container_x2 )
				$popup.offset( { left: container_x2 - popup_width, top: popup_offset.top } );
			// Respect leflt-side bounds
			if( $( '.ai1ec-event-summary', $popup ).offset().left < container_offset.left )
				$popup.addClass( 'ai1ec-shifted-right' );

			// Restore popup to 'display: none'
			$popup.hide().css( 'visibility', 'visible' );
			// Flag the object so we don't calculate twice.
			$popup.data( 'ai1ec_offset', true );
		}

		// Display popup
		$popup
			.fadeIn( 100, function() {
				// Special case - check if the mouse cursor is still in the pop-up.
				if( ! $(this).data( 'ai1ec_mouseinside' ) )
					$(this).each( hide_popup );
			} );
	}
	function hide_popup() {
		$(this)
			.fadeOut( 100, function() { $(this).parent().css( { zIndex: 'auto' } ); } )
			.data( 'ai1ec_mouseinside', false );
	}

	// Register popup hover handlers for month view
	$('.ai1ec-month-view .ai1ec-event')
		.live( 'mouseenter', show_popup );
	$('.ai1ec-month-view .ai1ec-event-popup')
		.live( 'mouseleave', hide_popup )
		.live( 'mousemove', function() {
			// Track whether popup contains mouse cursor
			$(this).data( 'ai1ec_mouseinside', true );
		} );
	// Hide any popups that were visible when the window lost focus
	if( $('.ai1ec-month-view').length ) {
		$(window).blur( function() {
			$('.ai1ec-event-popup:visible').each( hide_popup );
		} );
	}

	// *** Agenda view ***

	/**
	 * Callbacks for event expansion, collapse.
	 */
	function expand_event() {
		$( this )	// ...-click block
			.hide()
			.parent() // event block
				.addClass( 'ai1ec-expanded' )
				.end()
			.prev()	// summary block
				.show()
				.find( '.ai1ec-event-description' ) // description block
					.hide()
					.slideDown( 'fast' );
	}
	function collapse_event() {
		$(this) // inner ...-click block
			.next() // description block
			.slideUp( 'fast', function() {
				$(this).parent() // summary block
					.parent() // event block
						.removeClass( 'ai1ec-expanded' )
						.end()
					.hide() // summary block again
						.next() // original ...-click block
						.show();
				}
			);
	}

	// Register click handlers for event title
	$('.ai1ec-agenda-view .ai1ec-event > .ai1ec-event-click')
		.live( 'click', expand_event );
	$('.ai1ec-agenda-view .ai1ec-event-summary > .ai1ec-event-click')
		.live( 'click', collapse_event );

	// Register click handlers for expand/collapse all buttons
	$('.ai1ec-action-agenda #ai1ec-expand-all').live( 'click', function() {
		$('.ai1ec-event > .ai1ec-event-click:visible').click();
	} );
	$('.ai1ec-action-agenda #ai1ec-collapse-all').live( 'click', function() {
		$('.ai1ec-event-summary > .ai1ec-event-click:visible').click();
	} );

	// *** All views ***

	/**
	 * Category/tag filters
	 */

	element_selector(
			'.ai1ec-category-filter-selector li',
			'ai1ec-selected',
			'ai1ec-categories',
			'#ai1ec-selected-categories' );
	element_selector(
			'.ai1ec-tag-filter-selector li',
			'ai1ec-selected',
			'ai1ec-tags',
			'#ai1ec-selected-tags' );

	// Category/tag filtering actions
	
	/**
	 * Checks if the element has visibile events
	 */
	function has_visible_events( el ) {
		var ret = false;
		$( el ).find( 'ol.ai1ec-date-events li.ai1ec-event' ).each( function() {
			if( $( this ).css( 'display' ) != 'none' ) ret = true;
		});
		return ret;
	}

	/**
	 * Applies the active category/tag filters to the current view.
	 * (Shows/hides events as necessary.)
	 */
	function apply_filters()
	{
		// Submit the selected term IDs via AJAX and filter the visible list of
		// post IDs. Only include filter selectors that have a selection.
		var selected_ids = new Array();

		selected_cats =
			$('.ai1ec-filters-container .ai1ec-dropdown.ai1ec-selected + #ai1ec-selected-categories').val();
		if( selected_cats ) {
			selected_ids.push( selected_cats );
			selected_cats = '&ai1ec_cat_ids=' + selected_cats;
		} else {
			selected_cats = '';
		}

		selected_tags =
			$('.ai1ec-filters-container .ai1ec-dropdown.ai1ec-selected + #ai1ec-selected-tags').val();
		if( selected_tags ) {
			selected_ids.push( selected_tags );
			selected_tags = '&ai1ec_tag_ids=' + selected_tags;
		} else {
			selected_tags = '';
		}

		selected_ids = selected_ids.join();

		// Modify export URL
		var export_url;
		if( selected_ids.length ) {
			export_url = convertEntities( ai1ec_calendar.export_url ) + selected_cats + selected_tags;
			$( '.ai1ec-subscribe-filtered' ).fadeIn( 'fast' );
		} else {
			export_url = convertEntities( ai1ec_calendar.export_url );
			$( '.ai1ec-subscribe-filtered' ).fadeOut( 'fast' );
		}
		$( '.ai1ec-subscribe' ).attr( 'href', export_url );
		$( '.ai1ec-subscribe-google' ).attr( 'href',
				'http://www.google.com/calendar/render?cid=' + escape( export_url.replace( 'webcal://', 'http://' ) ) );

		var query = {
			'action': 'ai1ec_term_filter',
			'ai1ec_post_ids': post_ids,
			'ai1ec_term_ids': selected_ids
		};

		// Delay loading animation so that it doesn't appear if the AJAX turnover
		// is quick enough
		var $loading = $('#ai1ec-calendar-view-loading')
			.delay( 500 )
			.fadeIn( 'fast' );
		var $view = $('#ai1ec-calendar-view')
			.delay( 500 )
			.fadeTo( 'fast', 0.3 );

		$.getJSON( ai1ec_calendar.ajaxurl, query, function( data )
			{
				// Cancel loading animation or fade out if faded in.
				$loading.clearQueue().fadeOut( 'fast' );
				$view.clearQueue().fadeTo( 'fast', 1.0 );

				// Fade in events that should be displayed (or leave them visible)
				var jq_selector = new Array();	// Build our jQuery selector string
				$.each( data.matching_ids, function( i, val ) {
					jq_selector.push( '.ai1ec-event-id-' + val );
				} );
				$( jq_selector.join() ).css( 'display', 'block' );

				// Fade out events that should be hidden (or leave them hidden)
				jq_selector = new Array();
				$.each( data.unmatching_ids, function( i, val ) {
					jq_selector.push( '.ai1ec-event-id-' + val );
				} );
				$( jq_selector.join() ).css( 'display', 'none' );
				$( 'ol.ai1ec-agenda-view > li.ai1ec-date' ).each( function() {
					if( has_visible_events( $( this ) ) ) $( this ).slideDown( 'fast' );
					else 																	$( this ).slideUp( 'fast' );
				});
			}
		);
	}

	/**
	 * Updates the filter dropdowns and clear button based on whether filters
	 * are selected.
	 */
	function update_filter_selectors() {
		// Highlight this dropdown as "selected" if and only if any of its terms
		// have been selected.
		$( '.ai1ec-filter-selector-container' ).each( function() {
			if( $( 'li.ai1ec-selected', this ).length ) {
				$( '.ai1ec-dropdown', this ).addClass( 'ai1ec-selected' );
			} else {
				$( '.ai1ec-dropdown', this ).removeClass( 'ai1ec-selected' );
			}
		} );

		if( $('.ai1ec-filters-container .ai1ec-selected').length )
			$('.ai1ec-clear-filters').fadeIn( 'fast' );
		else
			$('.ai1ec-clear-filters').fadeOut( 'fast' );

		apply_filters();
	}

	$('.ai1ec-filter-selector li').click( update_filter_selectors );

	$('.ai1ec-clear-filters').click( function() {
		$('.ai1ec-filter-selector-container li').removeClass( 'ai1ec-selected' );
		update_filter_selectors();
	} );

	/**
	 * function initialize_view
	 *
	 * General initialization function to execute whenever any view is loaded
	 * (this is also called at the end of load_view()).
	 */
	function initialize_view()
	{
		// Cache the current list of post IDs
		post_ids = new Array();
		$( '.ai1ec-post-id' ).each( function() {
			post_ids.push( this.value );
		} );
		post_ids = post_ids.join();	// Store IDs as comma-separated values

		// ===========================
		// = Pop up the active event =
		// ===========================
		if( $( '.ai1ec-active-event:first' ).length ) {
			// Pop up any active event in month view
			$( '.ai1ec-month-view .ai1ec-active-event:first' ).each( function() {
				$(this)
					.each( show_popup )
					.prev() // .ai1ec-popup
						.data( 'ai1ec_mouseinside', true ); // To keep pop-up from vanishing
			} );
			// Expand any active event in agenda view
			$( '.ai1ec-agenda-view .ai1ec-active-event:first > .ai1ec-event-click' ).each( expand_event );
			// Bring the active event into focus
			$.scrollTo( '.ai1ec-active-event:first', 1000,
				{
					offset: {
						left: 0,
						top: -window.innerHeight / 2 + 100
					}
				}
			);
		}

		// Apply category/tag filters if any; hide all events by default, then fade
		// in filtered ones.
		if( $('.ai1ec-dropdown.ai1ec-selected').length ) {
			$('.ai1ec-month-view .ai1ec-event-container, .ai1ec-agenda-view .ai1ec-event').hide();
			apply_filters();
		}
	}

	// If there are preselected tag/cat IDs, update the filter UI
	if( $('#ai1ec-selected-categories').val() != '' ||
			$('#ai1ec-selected-tags').val() != '' )
		update_filter_selectors();
	initialize_view();

} );
