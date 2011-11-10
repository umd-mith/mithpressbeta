<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Custom Post Type Support
- Reading and Excerpts

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Custom Post Type Support */
/*-----------------------------------------------------------------------------------*/

/*add_filter( 'pre_get_posts', 'my_get_posts' );

function my_get_posts( $query ) {

	if ( is_home() && false == $query->query_vars['suppress_filters'] )
		$query->set( 'post_type', array( 'post', 'page', 'project', 'podcast', 'attachment' ) );

	return $query;
}*/

add_theme_support( 'post-formats', array( 'aside', /*'link', 'gallery', 'status', 'quote', 'image',*/ 'podcast', 'project', 'people' ) );


/*-----------------------------------------------------------------------------------*/
/* Reading & Excerpts */
/*-----------------------------------------------------------------------------------*/


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

?>