<?php

define('MY_WORDPRESS_FOLDER',$_SERVER['DOCUMENT_ROOT']);
define('MY_THEME_FOLDER',str_replace('\\','/',dirname(__FILE__)));
define('MY_THEME_PATH','/' . substr(MY_THEME_FOLDER,stripos(MY_THEME_FOLDER,'wp-content'))); 

// Set path to theme specific functions
$functions_path = TEMPLATEPATH . '/functions/';
$includes_path = TEMPLATEPATH . '/includes/';
//$content_path = TEMPLATEPATH . '/content/';

require_once ($includes_path . 'theme-functions.php'); 		// Custom theme functions
require_once ($includes_path . 'theme-widgets.php');		// Theme widgets
require_once ($includes_path . 'theme-comments.php');		// Comments & Pingbacks, etc
require_once ($includes_path . 'theme-styles.php');		// Theme styles
require_once ($includes_path . 'theme-options.php');
require_once ($includes_path . 'theme-posts.php');		
require_once ($includes_path . 'breadcrumbs.php');		// Breadcrumbs function


//Custom icons 

add_action('admin_init','load_admin_styles');

function load_admin_styles() {
	global $pagenow, $typenow;
	if (empty($typenow) && !empty($_GET['post'])) {
	  $post = get_post($_GET['post']);
	  $typenow = $post->post_type;
	}
	if (is_admin() && $pagenow=='post-new.php' OR $pagenow=='post.php' && $typenow=='project') {
      $ss_url = get_bloginfo('template_directory');
	  wp_enqueue_style( 'project-admin', "{$ss_url}/css/admin-project.css");
    }
}



// THEME SETUP 

require_once ( get_template_directory() . '/includes/custom-posts.php' );
require_once ( get_template_directory() . '/includes/breadcrumbs.php' );


if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    update_option( 'posts_per_page', 12 );
    update_option( 'paging_mode', 'default' );
}


// SUBPAGES 
function is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    global $post;               // load details about this page

    if ( is_page($pid) )
        return true;            // we're at the page or at a sub page

    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if( is_page() && $ancestor == $pid ) {
            return true;
        }
    }

    return false;  // we arn't at the page, and the page is not an ancestor
}




// MISC 

/** Returns a "Continue Reading" link for excerpts  */
function mithpress_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/** Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and mithpress_continue_reading_link().  */
function mithpress_auto_excerpt_more( $more ) {
	return ' . . . ' . mithpress_continue_reading_link();
}
add_filter( 'excerpt_more', 'mithpress_auto_excerpt_more' );

/** Adds a pretty "Continue Reading" link to custom post excerpts. */
function mithpress_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= mithpress_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'mithpress_custom_excerpt_more' );

function new_excerpt_length($length) {
	return 200;
}
add_filter('excerpt_length', 'new_excerpt_length');


function smart_excerpt($string, $limit) {
    $words = explode(" ",$string);
    if ( count($words) >= $limit) $dots = '...';
    echo implode(" ",array_splice($words,0,$limit)).$dots;
}

function next_posts_attributes(){
    return 'class="nextpostslink"';
}
add_filter('next_posts_link_attributes', 'next_posts_attributes');


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




/* Add custom CSS to custom post type pages 
add_action('admin_print_styles', 'custom_admin_styles', 21);

	function custom_admin_styles() {
		global $post_type; if (($_GET['post_type'] == 'project' ) || ($post_type == 'project')) :		
			echo "<link rel='stylesheet' type='text/css' href='" . get_template_directory_uri() . "/css/custom-admin.css' media='screen' />";		
		endif;

}
*/


// OUTPUT WHICH TEMPLATE A PAGE/POST IS USING IN THE HEADER
add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    print_r($template);
}


?>