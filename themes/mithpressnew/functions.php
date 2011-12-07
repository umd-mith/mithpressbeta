<?php

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace('\\','/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content'))); 

// Set path to theme specific functions
$functions_path = TEMPLATEPATH . '/functions/';
$includes_path = TEMPLATEPATH . '/includes/';
$scripts_path = TEMPLATEPATH . '/js/';
//$content_path = TEMPLATEPATH . '/content/';

require_once ($includes_path . 'theme-functions.php'); 		// Custom theme functions
require_once ($includes_path . 'theme-widgets.php');		// Theme widgets
require_once ($includes_path . 'theme-comments.php');		// Comments & Pingbacks, etc
require_once ($includes_path . 'theme-styles.php');			// Theme styles
require_once ($includes_path . 'theme-options.php');		
require_once ($includes_path . 'theme-posts.php');		
require_once ($includes_path . 'breadcrumbs.php');			// Breadcrumbs function

include_once 'metaboxes/setup.php';
include_once 'metaboxes/full-spec.php';
//include_once 'metaboxes/simple-spec.php';
//include_once 'metaboxes/checkbox-spec.php';
//include_once 'metaboxes/radio-spec.php';
//include_once 'metaboxes/select-spec.php';

require_once ($includes_path . 'custom-posts.php');			// Defines Custom Post Types


// ONLY DISPLAY POST META IF IT EXISTS
function get_custom_field_data($key, $echo = false) {
	global $post;
	$value = get_post_meta($post->ID, $key, true);
	if($echo == false) {
		return $value;
	} else {
		echo $value;
	}
}





// OUTPUT WHICH TEMPLATE A PAGE/POST IS USING IN THE HEADER
add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    print_r($template);
}


?>