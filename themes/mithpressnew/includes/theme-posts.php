<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Post Navigation
- Post Meta
- Custom Post Type Support
- Reading and Excerpts
- Preserve Post formatting in Excerpt 
- Comments Form

-----------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------*/
/* Post Navigation */
/*-----------------------------------------------------------------------------------*/
function mithpress_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>" class="post-navigation clear">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'mithpress' ); ?></h3>
                <?php
                    $prev_post = get_adjacent_post(false, '', true);
                    $next_post = get_adjacent_post(false, '', false); ?>
                    <?php if ($prev_post) : $prev_post_url = get_permalink($prev_post->ID); $prev_post_title = $prev_post->post_title; ?>
                        <a class="post-prev" href="<?php echo $prev_post_url; ?>"><em>Previous post</em><span><?php echo $prev_post_title; ?></span></a>
                    <?php endif; ?>
                    <?php if ($next_post) : $next_post_url = get_permalink($next_post->ID); $next_post_title = $next_post->post_title; ?>
                        <a class="post-next" href="<?php echo $next_post_url; ?>"><em>Next post</em><span><?php echo $next_post_title; ?></span></a>
                    <?php endif; ?>
                <div class="line"></div>
            </div>
            
		</nav><!-- #nav-below-->
	<?php endif;
}




/*-----------------------------------------------------------------------------------*/
/* Post Meta */
/*-----------------------------------------------------------------------------------*/


/*-----------------------------------------------------------------------------------*/
/* Custom Post Type Support */
/*-----------------------------------------------------------------------------------*/


add_theme_support( 'post-formats', array( 'aside', /*'link', 'gallery', 'status', 'quote', 'image',*/ 'podcast', 'project', 'people' ) );


/*-----------------------------------------------------------------------------------*/
/* Reading & Excerpts */
/*-----------------------------------------------------------------------------------*/


/** Returns a "Continue Reading" link for excerpts  */
function mithpress_continue_reading_link() {
	return ' <a href="'. get_permalink() . '" class="readmore">' . __( 'Continue Reading', 'mithpress' ) . '</a>';
}

/** Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and mithpress_continue_reading_link().  
function mithpress_auto_excerpt_more( $more ) {
	return ' . . . ' . mithpress_continue_reading_link();
}
add_filter( 'excerpt_more', 'mithpress_auto_excerpt_more' );
*/
/** Adds a pretty "Continue Reading" link to custom post excerpts. 
function mithpress_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= mithpress_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'mithpress_custom_excerpt_more' );
*/
function next_posts_attributes(){
    return 'class="nextpostslink"';
}
add_filter('next_posts_link_attributes', 'next_posts_attributes');


/*-----------------------------------------------------------------------------------*/
/* Preserve Post formatting in Excerpt */
/*-----------------------------------------------------------------------------------*/

// Find and close unclosed xhtml tags

function close_tags($text) {

    $patt_open    = "%((?<!</)(?<=<)[\s]*[^/!>\s]+(?=>|[\s]+[^>]*[^/]>)(?!/>))%";
    $patt_close    = "%((?<=</)([^>]+)(?=>))%";

    if (preg_match_all($patt_open,$text,$matches))
    {
        $m_open = $matches[1];
        if(!empty($m_open))
        {
            preg_match_all($patt_close,$text,$matches2);
            $m_close = $matches2[1];
            if (count($m_open) > count($m_close))
            {
                $m_open = array_reverse($m_open);
                foreach ($m_close as $tag) $c_tags[$tag]++;
                foreach ($m_open as $k => $tag) 
					if ($c_tags[$tag]--<=0) $text.='</'.$tag.'>';
            }
        }
    }
    return $text;
}

//EXCERPT LENGTH 

function custom_excerpt($excerpt_length=50) {
$raw_excerpt = $text;
if ( '' == $text ) {
    //Retrieve the post content.
    $text = get_the_content('');
 
    //Delete all shortcode tags from the content.
    $text = strip_shortcodes( $text );
 
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]&gt;', $text);
 
    $allowed_tags = '<p>,<em>,<i>,<b>,<strong>,<a>,<ul>,<li>,<ol>,<blockquote>,<code>'; /*** MODIFY THIS. Add the allowed HTML tags separated by a comma.***/
    $text = strip_tags($text, $allowed_tags);
 	 
   	$excerpt_end = '. . . '; /*** MODIFY THIS. change the excerpt endind to something else.***/
   	$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);
 
    $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
    if ( count($words) > $excerpt_length ) {
        array_pop($words);
        $text = implode(' ', $words);
        $text = $text . $excerpt_more . mithpress_continue_reading_link();
    } else {
        $text = implode(' ', $words);
    }
}
$content = apply_filters('wp_trim_excerpt', $text, $raw_excerpt);
echo close_tags($content);

}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_excerpt');

?>