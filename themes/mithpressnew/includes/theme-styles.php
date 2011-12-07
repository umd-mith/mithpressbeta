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

//add_action('wp_print_styles', 'mithpress_add_styles');
//add_action('wp_head', 'mithpress_add_styles', 5); 

function my_admin_styles() {
	wp_enqueue_style('thickbox');
	wp_register_style('admin-styles', get_bloginfo('template_directory').'/css/admin-styles.css', array(), '', 'screen');
	wp_enqueue_style('admin-styles');
}

add_action('admin_print_styles', 'my_admin_styles');

// ADD Calendar Styles

/*function mithpress_add_styles() {
    wp_register_style('event-sng', get_bloginfo('template_directory').'/css/events-event.css', array(), '', 'screen, print'); 
	wp_enqueue_style('event-sng'); 
	wp_register_style('event-gen', get_bloginfo('template_directory').'/css/events-general.css', array(), '', 'screen, print');
    wp_enqueue_style('event-gen');
	wp_register_style('event-cal', get_bloginfo('template_directory').'/css/events-calendar.css', array(), '', 'screen, print');
    wp_enqueue_style('event-cal');
}

*/

// REMOVE Styles 

add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

function my_deregister_styles() {
	wp_deregister_style( 'ai1ec-general' );
	wp_deregister_style( 'ai1ec-event' );
	wp_deregister_style( 'ai1ec-calendar' );
}
/*-----------------------------------------------------------------------------------*/
/* Load Admin Styles Based if Custom Post Type */
/*-----------------------------------------------------------------------------------*/

/*
add_action('admin_init','load_admin_styles');

// Custom Icons for Custom Post Types
function load_admin_styles() {
	global $pagenow, $typenow;
	if (empty($typenow) && !empty($_GET['post'])) {
	  $post = get_post($_GET['post']);
	  $typenow = $post->post_type;
	}
	if (is_admin() && $pagenow=='post-new.php' OR $pagenow=='post.php' && $typenow=='project') {
      $ss_url = get_bloginfo('template_directory');
	  wp_enqueue_style( 'admin-project', "{$ss_url}/css/admin-project.css");
    }
}
*/

if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    update_option( 'posts_per_page', 12 );
    update_option( 'paging_mode', 'default' );
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