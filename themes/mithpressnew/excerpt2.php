<?php 


/* Code that preserves HTML formating to the automatically generated Excerpt */
/* Also modifies the default excerpt_length and excerpt_more filters. */
/* Code tested on WordPress Version 3.3 */
function custom_excerpt($excerpt_length=50, $echo = true) {
	  	global $post;
	  	$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
		$raw_excerpt = $text;
	
	$text = '';
		//Retrieve the post content.
		$text = get_the_content('');
	 
		//Delete all shortcode tags from the content.
		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);
	 
		$allowed_tags = '<p>,<em>,<i>,<b>,<strong>,<a>,<ul>,<li>,<ol>,<blockquote>,<code>'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
		$text = strip_tags($text, $allowed_tags);
		/*if ( is_post_type_archive('podcast') ) { 
		$excerpt_word_count = 30; 
		} elseif ( 'podcast' == get_post_type() ) { 
		$excerpt_word_count = 20;
		} elseif (is_page_template('content.php') || is_home() || is_category() ) { 
		$excerpt_word_count = 170;
		} elseif (is_page_template('content-home-right.php') || is_front_page() && !is_home()) { 
		$excerpt_word_count = 75;
		} else {
		$excerpt_word_count = 50; 
		}
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count); */
	 
		$excerpt_end = '. . . '; /*** MODIFY THIS. change the excerpt ending to something else.***/
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
	 
		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more . mithpress_continue_reading_link();
		} else {
			$text = implode(' ', $words);
		}
		if($echo)
			echo apply_filters('the_content', $text);
		else
			return $text;

	$content = close_tags( apply_filters('wp_trim_excerpt', $text, $raw_excerpt) );
	
}

remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_excerpt');

function get_my_excerpt($excerpt_length = 55, $echo = false) {
 return custom_excerpt($excerpt_length, $echo);
}
