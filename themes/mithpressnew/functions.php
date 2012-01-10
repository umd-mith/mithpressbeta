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
//require_once ($includes_path . 'theme-options.php');		
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





/* OUTPUT WHICH TEMPLATE A PAGE/POST IS USING IN THE HEADER
add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    print_r($template);
}
*/

if ( !function_exists( 'optionsframework_init' ) ) {


/*-----------------------------------------------------------------------------------*/
/* Options Framework Theme
/*-----------------------------------------------------------------------------------*/

/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/admin/');
}

require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}

/* 
 * This is an example of how to add custom scripts to the options panel.
 * This one shows/hides the an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>

<?php
}

/* 
 * Turns off the default options panel from Twenty Eleven
 */
 
add_action('after_setup_theme','remove_twentyeleven_options', 100);

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}
?>