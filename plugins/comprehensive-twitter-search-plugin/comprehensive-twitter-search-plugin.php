<?php

/*
Plugin Name: Comprehensive Twitter Search Widget
Plugin URI: http://initbinder.com/plugins
Description: A highly configurable and comprehensive Twitter search plugin that installs as a widget. The widget will display up to 30 tweets containing your search term. Some of the cool widget settings allow you to display only the top popular tweets in real time. Apart from the usual search, widget also supports Twitter's advanced search operators. Widget comes with variety of options that let you style it to fit your blog theme. In order to provide better user experience when configuring the widget, cute colour picker was included for colour selections.
Version: 1.0.1
Author: Alexander Zagniotov
Author URI: http://initbinder.com
License: GPLv2
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}



define('CTS_VERSION', '1.0.1');
define('CTS_PLUGIN_URI', plugin_dir_url( __FILE__ ));
define('CTS_PLUGIN_ASSETS_URI', CTS_PLUGIN_URI.'assets');
define('CTS_PLUGIN_CSS', CTS_PLUGIN_ASSETS_URI . '/css');
define('CTS_PLUGIN_JS', CTS_PLUGIN_ASSETS_URI . '/js');

require_once (dirname(__FILE__) . '/widget.php');

function az_twitter_search_admin_add_style()  {
	wp_enqueue_script('miniColors-script', CTS_PLUGIN_JS. '/miniColors/jquery.miniColors.js', array('jquery'), CTS_VERSION, true);
	wp_enqueue_script('compr-twitter-search', CTS_PLUGIN_JS. '/comprehensive-twitter-search-plugin.js', array('miniColors-script'), false, true);

}

function az_twitter_search_admin_add_script()  {
	wp_enqueue_style('miniColors-style', CTS_PLUGIN_CSS . '/miniColors/jquery.miniColors.css', false, CTS_VERSION, "screen");
}


add_action('admin_init', 'az_twitter_search_admin_add_style');
add_action('admin_init', 'az_twitter_search_admin_add_script');
add_action('widgets_init', create_function('', 'return register_widget("ComprehensiveTwitterSearch_Widget");'));

?>
