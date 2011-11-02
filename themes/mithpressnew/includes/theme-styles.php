<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Add / Remove Styles

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Add and Remove Styles */
/*-----------------------------------------------------------------------------------*/

add_action('wp_print_styles', 'mithpress_add_styles');
add_action('wp_head', 'mithpress_add_styles', 5); // hook my_google_webfont() into wp_head()

function mithpress_add_styles() {
    wp_register_style('event-sng', get_bloginfo('template_directory').'/css/events-event.css', array(), '', 'screen, print'); 
	wp_enqueue_style('event-sng'); 
	wp_enqueue_style('event-gen', get_bloginfo('template_directory').'/css/events-general.css', array(), '', 'screen, print');
    wp_enqueue_style('event-gen');
	wp_enqueue_style('event-cal', get_bloginfo('template_directory').'/css/events-calendar.css', array(), '', 'screen, print');
    wp_enqueue_style('event-cal');
}

//add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );
add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'ai1ec-general' );
	wp_deregister_style( 'ai1ec-event' );
	wp_deregister_style( 'ai1ec-calendar' );
}
