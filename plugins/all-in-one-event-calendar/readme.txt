=== All-in-One Event Calendar ===
Contributors: theseed, hubrik, vtowel, yani.iliev
Donate link: http://theseedstudio.com/software/all-in-one-event-calendar-wordpress/
Tags: calendar, event, events, ics, ics calendar, ical-feed, ics feed, wordpress ics importer, wordpress ical importer, upcoming events, todo, notes, journal, freebusy, availability, web calendar, web events, webcal, google calendar, ical, iCalendar, all-in-one, ai1ec, google calendar sync, ical sync, events sync, holiday calendar, calendar 2011, events 2011, widget, events widget, upcoming events widget, calendar widget, agenda widget
Requires at least: 3.1.3
Tested up to: 3.2.1
Stable tag: 1.0.9

An event calendar system with month and agenda views, upcoming events widget, color-coded categories, recurrence, and import/export of .ics feeds.

== Description ==

Welcome to the All-in-One Event Calendar Plugin, a new way to list your events in WordPress and easily share them with the rest of the world.

Our new calendar system combines a clean visual design, solid architectural patterns and rigorous testing with a powerful set of features to create the most advanced calendar system available for WordPress and one of the most powerful website calendar systems in the world. Best of all: it’s completely free.

= Calendar Features For Users =

This plugin has many features we hope will prove useful to users, including:

* Recurring* events
* Filtering by event category or tag
* Easy sharing with Google Calendar, Apple iCal, MS Outlook and any other system that accepts iCalendar (.ics) feeds
* Embedded Google Maps
* Color-coded events based on category
* Event-registration ready
* Month and agenda views
* Upcoming Events widget
* Links to filtered calendar views

(* Limited recurrence patterns available in first release. Full support to come in the next release.)

= Features for Website and Blog Owners =

* Import other calendars automatically to display in your calendar
* Categorize and tag imported calendar feeds automatically
* Events from [The Events Calendar](http://wordpress.org/extend/plugins/the-events-calendar/) plugin can also be easily imported

Importing and exporting iCalendar (.ics) feeds is one of the strongest features of the All-in-One Event Calendar system. Enter an event on one site and you can have it appear automatically in another website's calendar. You can even send events from a specific category or tag (or combination of categories and tags).

Why is this cool? It allows event creators to create one event and have it displayed on a few or thousands of calendars with no extra work. And it also allows calendar owners to populate their calendar from other calendar feeds without having to go through the hassle of creating new events. For example, a soccer league can send its game schedule to a community sports calendar, which, in turn, can send only featured games (from all the sports leagues it aggragates) to a community calendar, which features sports as just one category.

= Additional Features =

The All-in-One Event Calendar Plugin also has a few features that will prove useful for website and blog owners:

* Each event is SEO-optimized
* Each event links to the original calendar
* Your calendar can be embedded into a WordPress page without needing to create template files or modify the theme

[Check out the DEMO »](http://demo.theseedstudio.com/calendar/)

[Track the development process »](http://trac.the-seed.ca/roadmap)

[Bug reports (only for registered users) »](http://trac.the-seed.ca/newticket)

[Get Premium Support »](http://theseedstudio.com/get-supported-2/) from [The Seed Studio »](http://theseedstudio.com/)

== Changelog ==
= Version 1.0.9 =
* Fixed a problem with timezone dropdown list

= Version 1.0.8 =
* Added better if not full localization support [#25](http://trac.the-seed.ca/ticket/25) [#23](http://trac.the-seed.ca/ticket/23) [#10](http://trac.the-seed.ca/ticket/10) - thank you josjo
* Added qTranslate support and output to post data using WordPress filters [#1](http://trac.the-seed.ca/ticket/1)
* Added uninstall support [#7](http://trac.the-seed.ca/ticket/7)
* Added 24h time in time pickers [#26](http://trac.the-seed.ca/ticket/26) - thank you josjo
* Fixed an issue when event duration time is decremented in single (detailed) view [#2](http://trac.the-seed.ca/ticket/2)
* Fixed an issue with times for ics imported events [#6](http://trac.the-seed.ca/ticket/6)
* Better timezone control [#27](http://trac.the-seed.ca/ticket/27)
* Fixed the category filter in agenda view [#12](http://trac.the-seed.ca/ticket/12)
* Fixed event date being set to null when using quick edit [#16](http://trac.the-seed.ca/ticket/16)
* Fixed a bug in time pickers [#17](http://trac.the-seed.ca/ticket/17) - thank you josjo
* Deprecated function split() is removed [#8](http://trac.the-seed.ca/ticket/8)

= Version 1.0.7 =
* Fixed issue with some MySQL version
* Added better localization support - thank you josjo
* Added layout/formatting improvements
* Fixed issues when re-importing ics feeds

= Version 1.0.6 =
* Fixed issue with importing of iCalendar feeds that define time zone per-property (e.g., Yahoo! Calendar feeds)
* Fixed numerous theme-related layout/formatting issues
* Fixed issue with all-day events after daylight savings time showing in duplicate
* Fixed issue where private events would not show at all in the front-end
* Fixed duplicate import issue with certain feeds that do not uniquely identify events (e.g., ESPN)
* Added option to General Settings for inputting dates in US format
* Added option to General Settings for excluding events from search results
* Added error messages for iCalendar feed validation
* Improved support for multiple locales

= Version 1.0.5 =
* Added agenda-like Upcoming Events widget
* Added tooltips to category color squares
* Fixed Firefox-specific JavaScript errors and layout bugs
* Added useful links to plugins list page
* Fixed bug where feed frequency setting wasn't being updated
* Made iCalendar subscription buttons optional

= Version 1.0.4 =
* Improved layout of buttons around map in single event view
* Set Content-Type to `text/calendar` for exported iCalendar feeds
* Added Donate button to Settings screen

= Version 1.0.3 =
* Changed plugin name from `All-in-One Events Calendar` to `All-in-One Event Calendar`
* **Important notice:** When upgrading to version `1.0.3` you must reactivate the plugin.

= Version 1.0.2 =
* Fixed the URL for settings page that is displayed in the notice

= Version 1.0.1 =
* Fixed bug where calendar appears on every page before it's been configured
* Displayed appropriate setup notice when user lacks administrator capabilities

= Version 1.0 =
* Initial release

== Installation ==

1. Upload `all-in-one-event-calendar` to the `/wp-content/plugins/` directory.
2. Activate the plugin through the **Plugins** menu item in the WordPress Dashboard.
3. Once the plugin is activated, follow the instructions in the notice to configure it.

**Important notice:** When upgrading from version `1.0.2` or below you must reactivate the plugin.

= For advanced users: =

To place the calendar in a DOM/HTML element besides the default page content container without modifying the theme:

1. Navigate to **Events** > **Settings** in the WordPress Dashboard.
2. Enter a CSS or jQuery-style selector of the target element in the **Contain calendar in this DOM element** field.
3. Click **Update Settings**.

== Screenshots ==

1. Add new event - part 1
2. Add new event - part 2
3. Event categories
4. Event categories with color picker
5. Front-end: Month view of calendar
6. Front-end: Month view of calendar with mouse cursor hovering over event
7. Front-end: Month view of calendar with active category filter
8. Front-end: Month view of calendar with active tag filter
9. Front-end: Agenda view of calendar
10. Settings page
11. Upcoming Events widget
12. Upcoming Events widget - configuration options

== Upgrade Notice ==

= 1.0.3 =
When upgrading to from below `1.0.3` you must reactivate the plugin.
