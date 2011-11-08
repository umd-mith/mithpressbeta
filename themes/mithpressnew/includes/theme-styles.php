<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Add Styles
- Remove Styles
- Add Scripts

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Add and Remove Styles */
/*-----------------------------------------------------------------------------------*/

add_action('wp_print_styles', 'mithpress_add_styles');
add_action('wp_head', 'mithpress_add_styles', 5); // hook my_google_webfont() into wp_head()

function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

add_action('admin_print_styles-post.php', 'my_admin_styles');

// ADD Calendar Styles

function mithpress_add_styles() {
    wp_register_style('event-sng', get_bloginfo('template_directory').'/css/events-event.css', array(), '', 'screen, print'); 
	wp_enqueue_style('event-sng'); 
	wp_enqueue_style('event-gen', get_bloginfo('template_directory').'/css/events-general.css', array(), '', 'screen, print');
    wp_enqueue_style('event-gen');
	wp_enqueue_style('event-cal', get_bloginfo('template_directory').'/css/events-calendar.css', array(), '', 'screen, print');
    wp_enqueue_style('event-cal');
}



// REMOVE Styles 

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'ai1ec-general' );
	wp_deregister_style( 'ai1ec-event' );
	wp_deregister_style( 'ai1ec-calendar' );
}

/*-----------------------------------------------------------------------------------*/
/* Add Scripts */
/*-----------------------------------------------------------------------------------*/

function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('metascripts', get_bloginfo('template_directory').'/js/meta-box-scripts.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('metascripts');
}

add_action('admin_print_scripts-post.php', 'my_admin_scripts');
?>