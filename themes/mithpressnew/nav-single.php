<?php

/**
 * Get either the current, previous or next post in an unordered list structure.
 * @param String $post_position The post position: "previous" = previous post, "next" = next post, "current" = current post.
 * @param Bool $showpermalink Show or hide the permalink in the post title (typically used only for the previous and next posts)
 * @param Array $classes An array of classes to be applied to the unordered list
 * @return string The previous or next post formatted in an unordered list that can be styled
 */
function getPostNavigation( $post_position = 'previous', $showpermalink = false, $classes = array() )
{
try
{
$objPost;
$classes[] = 'post-navi';
switch( $post_position )
{
case 'next' :
$objPost = get_adjacent_post( false, '', false );
$classes[] = 'next-post';
break;
case 'current' :
global $post;
$objPost = $post;
$classes[] = 'current-post';
break;
case 'previous' :
default:
$objPost = get_adjacent_post( false, '',true );
$classes[] = 'prev-post';
break;
}

if( empty( $objPost ) ) return;

// The title with additional formatting applied
// TODO: Apply your own formatting, truncation, etc.
$title        = htmlentities( $title );

// An HTML safe string to be used with the tooltip
$tooltip    = ( $post_position != 'current' ) ? "View Post: &quot;" . $title . "&quot;" : "&quot;" . $title . "&quot;";

// Standard elements, heading, permalink, and excerpt
$heading    = ( $post_position != 'current' ) ? '<a href="' . get_permalink( $objPost->ID ) . '" title="' . $tooltip . '">' . $title . '</a>' : $title;
$permalink    = '<a href="' . get_permalink( $objPost->ID ) . '" title="' . $tooltip . '">Read More</a>';
$excerpt     = trim( strip_tags( $objPost->post_content ) ) ;

// The formatted output
$output     = "<div class=\"" . implode(' ', $classes) . "\">\r\n";
$output    .= "<span class=\"post-navi-heading\">{$heading}</span>\r\n";
$output    .= "<span class=\"post-navi-excerpt\">{$excerpt}</span>\r\n";
$output    .= ( $showpermalink == true ) ? "<li class=\"post-navi-permalink\">{$permalink}</li>\r\n" : '';
$output    .= "</ul>\r\n";
}
catch( Exception $err )
{
throw new Exception( $err->getMessage() );
}

return $output;
}

?>