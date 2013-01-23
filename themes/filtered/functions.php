<?php

// Load utility functions
require_once (TEMPLATEPATH . '/admin/utilities.php');
  
// Load main options panel file  
require_once (TEMPLATEPATH . '/admin/options.php');

// Enable translation
// Translations can be put in the /languages/ directory
load_theme_textdomain( 'themetrust', TEMPLATEPATH . '/languages' );

// Widgets
require_once (TEMPLATEPATH . '/admin/widgets.php');



//////////////////////////////////////////////////////////////
// Get Options
/////////////////////////////////////////////////////////////
	
function ttrust_get_option($key) {	
	global $ttrust_options;	
	$ttrust_options = get_option('ttrust_options');
	
	$ttrust_defaults = array(				
		'ttrust_slideshow_speed' => 5,
		'ttrust_slideshow_enabled' => false,
		'ttrust_background' => 'bkgGrid',
		'ttrust_footer_color' => 'dark',
		'ttrust_projects_layout' => 'threeColumn',
		'ttrust_slideshow_effect' => 'fade',
		'ttrust_slide_deactivate_links' => false,
		'ttrust_posts_on_home' => false,
		'ttrust_featured_on_home' => false					
	);
	
	foreach($ttrust_defaults as $k=>$v) {		
		if (!isset($ttrust_options[$k])  || $ttrust_options[$k] == NULL)
			$ttrust_options[$k] = $ttrust_defaults[$k];
	}	
	
	$ttrust_options['ttrust_logo'] = get_option('ttrust_logo');		
	
	
	if($key == 'all'){
		return $ttrust_options;
	}else{
		if(isset($ttrust_options[$key])){
			return $ttrust_options[$key];
		}else{
			return NULL;
		}
	}
}  



//////////////////////////////////////////////////////////////
// Theme Header
/////////////////////////////////////////////////////////////
	
add_action('wp_enqueue_scripts', 'ttrust_scripts');

function ttrust_scripts() {

	wp_enqueue_script('jquery');
	
	wp_enqueue_script('superfish', get_bloginfo('template_url').'/scripts/superfish/superfish.js', array('jquery'), '1.4.8', true);
	wp_enqueue_script('supersubs', get_bloginfo('template_url').'/scripts/superfish/supersubs.js', array('jquery'), '1.4.8', true);
	wp_enqueue_style('superfish', get_bloginfo('template_url').'/scripts/superfish/superfish.css', false, '1.4.8', 'all' );
	
	if(is_front_page()) :
		wp_enqueue_script('slideshow', get_bloginfo('template_url').'/scripts/slideshow/jquery.nivo.slider.pack.js', array('jquery'), '2.4', true);
		wp_enqueue_style('slideshow', get_bloginfo('template_url').'/scripts/slideshow/nivo-slider.css', false, '2.4', 'all' );
		wp_enqueue_style('slideshow_custom', get_bloginfo('template_url').'/scripts/slideshow/custom-nivo-slider.css', false, '1.4.8', 'all' );
	endif;
	
	if(is_active_widget(false,'','ttrust_flickr')) :	
    	wp_enqueue_script('flickrfeed', get_bloginfo('template_url').'/scripts/jflickrfeed.js', array('jquery'), '0.8', true);
	endif;
	
	if(is_active_widget(false,'','ttrust_twitter')) :	
    	wp_enqueue_script('jquery_twitter', get_bloginfo('template_url').'/scripts/jquery.twitter.js', array('jquery'), '1.5', true);
	endif;

	wp_enqueue_script('fancybox', get_bloginfo('template_url').'/scripts/fancybox/jquery.fancybox-1.3.4.pack.js', array('jquery'), '1.3.4', true);
	wp_enqueue_style('fancybox', get_bloginfo('template_url').'/scripts/fancybox/jquery.fancybox-1.3.4.css', false, '1.3.4', 'all' );
	
	wp_enqueue_script('quicksand', get_bloginfo('template_url').'/scripts/quicksand.js', array('jquery'), '1.2.2', true);
	wp_enqueue_script('project_filter', get_bloginfo('template_url').'/scripts/project_filter.js', array('jquery'), '1.0', true);
	
	wp_enqueue_script('theme_trust', get_bloginfo('template_url').'/scripts/theme_trust.js', array('jquery'), '1.0', true);		

}

add_action('wp_head','ttrust_theme_head');

function ttrust_theme_head() { ?>
<meta name="generator" content="<?php global $ttrust_theme, $ttrust_version; echo $ttrust_theme.' '.$ttrust_version; ?>" />

<style type="text/css" media="screen">

<?php if(ttrust_get_option('ttrust_color_link')) : ?>
	#filterNav li.selected a {background: #<?php echo(ttrust_get_option('ttrust_color_link')); ?>;}
	a, #mainNav li.current a, #mainNav li.current-menu-item a, #mainNav li.current-cat a, #mainNav li.current_page_item a, #mainNav li.current_page_parent a, #mainNav li.current-post-parent a {color: #<?php echo(ttrust_get_option('ttrust_color_link')); ?>;}
	#mainNav li.current:hover a, #mainNav li.current-cat:hover a, #mainNav li.current_page_item:hover a, #mainNav li.current-menu-item:hover a, #mainNav li.current-post-ancestor:hover a, #mainNav li.current_page_parent:hover a {color: #<?php echo(ttrust_get_option('ttrust_color_link')); ?>;}
<?php endif; ?>
<?php if(ttrust_get_option('ttrust_color_link_hover')) : ?>a:hover {color: #<?php echo(ttrust_get_option('ttrust_color_link_hover')); ?>;}<?php endif; ?>
<?php if(ttrust_get_option('ttrust_color_btn')) : ?>.button, #searchsubmit, input[type="submit"] {background-color: #<?php echo(ttrust_get_option('ttrust_color_btn')); ?> !important;}<?php endif; ?>
<?php if(ttrust_get_option('ttrust_color_btn_hover')) : ?>.button:hover, #searchsubmit:hover, input[type="submit"]:hover {background-color: #<?php echo(ttrust_get_option('ttrust_color_btn_hover')); ?> !important;}<?php endif; ?>
<?php echo(ttrust_get_option('ttrust_custom_css')); ?>
</style>

<!--[if IE]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie.css" type="text/css" media="screen" />
<![endif]-->
<!--[if IE 7]>
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/ie7.css" type="text/css" media="screen" />
<![endif]-->

<?php echo "\n".ttrust_get_option('ttrust_analytics')."\n"; ?>

<?php }


//////////////////////////////////////////////////////////////
// Custom Background Support
/////////////////////////////////////////////////////////////

if(function_exists('add_custom_background')) add_custom_background();


//////////////////////////////////////////////////////////////
// Body Class
/////////////////////////////////////////////////////////////

function ttrust_body_classes($classes) {	
	
	$classes[] = ttrust_get_option('ttrust_background');	
	return $classes;
}
add_filter('body_class','ttrust_body_classes');




//////////////////////////////////////////////////////////////
// Theme Footer
/////////////////////////////////////////////////////////////

add_action('wp_footer','ttrust_footer');

function ttrust_footer() {
	if(is_front_page()) include(TEMPLATEPATH . '/scripts/slideshow/slideshow.php');
	echo "\n";	
}


//////////////////////////////////////////////////////////////
// Remove
/////////////////////////////////////////////////////////////

// #more from more-link
function ttrust_remove($content) {
	global $id;
	return str_replace('#more-'.$id.'"', '"', $content);
}
add_filter('the_content', 'ttrust_remove');


//////////////////////////////////////////////////////////////
// Custom Excerpt
/////////////////////////////////////////////////////////////

function excerpt_ellipsis($text) {
	return str_replace('[...]', '...', $text);
}
add_filter('the_excerpt', 'excerpt_ellipsis');



//////////////////////////////////////////////////////////////
// Pagination Styles
/////////////////////////////////////////////////////////////

add_action( 'wp_print_styles', 'ttrust_deregister_styles', 100 );
function ttrust_deregister_styles() {
	wp_deregister_style( 'wp-pagenavi' );
}
remove_action('wp_head', 'pagenavi_css');
remove_action('wp_print_styles', 'pagenavi_stylesheets');


//////////////////////////////////////////////////////////////
// Navigation Menus
/////////////////////////////////////////////////////////////

add_theme_support('menus');
register_nav_menu('main', 'Main Navigation Menu');

function default_nav() {
	require_once (TEMPLATEPATH . '/includes/default_nav.php');
}


//////////////////////////////////////////////////////////////
// Custom Background
/////////////////////////////////////////////////////////////

add_custom_background();


//////////////////////////////////////////////////////////////
// Feature Images (Post Thumbnails)
/////////////////////////////////////////////////////////////

add_theme_support('post-thumbnails');

set_post_thumbnail_size(100, 100, true);
add_image_size('ttrust_small', 110, 110, true);
add_image_size('ttrust_fourColumn', 205, 125, true);
add_image_size('ttrust_threeColumn', 280, 170, true);



//////////////////////////////////////////////////////////////
// Button Shortcode
/////////////////////////////////////////////////////////////

function ttrust_button($a) {
	extract(shortcode_atts(array(
		'label' 	=> 'Button Text',
		'id' 	=> '1',
		'url'	=> '',
		'target' => '_parent',		
		'size'	=> '',
		'ptag'	=> false
	), $a));
	
	$link = $url ? $url : get_permalink($id);	
	
	if($ptag) :
		return  wpautop('<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>');
	else :
		return '<a href="'.$link.'" target="'.$target.'" class="button '.$size.'">'.$label.'</a>';
	endif;
	
}

add_shortcode('button', 'ttrust_button');


//////////////////////////////////////////////////////////////
// Custom More Link
/////////////////////////////////////////////////////////////

function more_link() {
	global $post;	
	$more_link = '<p class="moreLink"><a href="'.get_permalink().'" title="'.get_the_title().'">';
	$more_link .= '<span>Read More</span>';
	$more_link .= '</a></p>';
	echo $more_link;	
}


//////////////////////////////////////////////////////////////
// Custom Post Types and Custom Taxonamies
/////////////////////////////////////////////////////////////

add_action( 'init', 'create_post_types' );

function create_post_types() {
	
	$labels = array(
		'name' => __( 'Projects' ),
		'singular_name' => __( 'Project' ),
		'add_new' => __( 'Add New' ),
		'add_new_item' => __( 'Add New Project' ),
		'edit' => __( 'Edit' ),
		'edit_item' => __( 'Edit Project' ),
		'new_item' => __( 'New Project' ),
		'view' => __( 'View Project' ),
		'view_item' => __( 'View Project' ),
		'search_items' => __( 'Search Projects' ),
		'not_found' => __( 'No projects found' ),
		'not_found_in_trash' => __( 'No projects found in Trash' ),
		'parent' => __( 'Parent Project' ),
	);
	
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,		
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title', 'editor', 'thumbnail', 'comments', 'revisions')
	); 	
	
	register_post_type( 'projects' , $args );
	flush_rewrite_rules( false );
}



add_action( 'init', 'create_taxonomies' );
function create_taxonomies() {
	$labels = array(
    	'name' => __( 'Skills' ),
    	'singular_name' => __( 'Skill' ),
    	'search_items' =>  __( 'Search Skills' ),
    	'all_items' => __( 'All Skills' ),
    	'parent_item' => __( 'Parent Skill' ),
    	'parent_item_colon' => __( 'Parent Skill:' ),
    	'edit_item' => __( 'Edit Skill' ),
    	'update_item' => __( 'Update Skill' ),
    	'add_new_item' => __( 'Add New Skill' ),
    	'new_item_name' => __( 'New Skill Name' )
  	); 	

  	register_taxonomy('skill','projects',array(
    	'hierarchical' => false,
    	'labels' => $labels
  	));
	flush_rewrite_rules( false );
}


// List custom post type taxonomies

function ttrust_get_terms( $id = '' ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $post_taxonomies = array();
    $post_type = get_post_type( $id );
    $taxonomies = get_object_taxonomies( $post_type , 'names' );

    foreach ( $taxonomies as $taxonomy ) {
      $term_links = array();
      $terms = get_the_terms( $id, $taxonomy );

      if ( is_wp_error( $terms ) )
        return $terms;

      if ( $terms ) {
        foreach ( $terms as $term ) {
          $link = get_term_link( $term, $taxonomy );
          if ( is_wp_error( $link ) )
            return $link;
          $term_links[] = '<li><span>' . $term->name . '</span></li>';
        }
      }

      $term_links = apply_filters( "term_links-$taxonomy" , $term_links );
      $post_terms[$taxonomy] = $term_links;
    }
    return $post_terms;
  } else {
    return false;
  }
}

function ttrust_get_terms_list( $id = '' , $echo = true ) {
  global $post;

  if ( empty( $id ) )
    $id = $post->ID;

  if ( !empty( $id ) ) {
    $my_terms = ttrust_get_terms( $id );
    if ( $my_terms ) {
      $my_taxonomies = array();
      foreach ( $my_terms as $taxonomy => $terms ) {
        $my_taxonomy = get_taxonomy( $taxonomy );
        if ( !empty( $terms ) ) $my_taxonomies[] = implode( $terms);
      }

      if ( !empty( $my_taxonomies ) ) {
        $output = '<ul class="skillList clearfix">' . "\n";
        foreach ( $my_taxonomies as $my_taxonomy ) {
          $output .= $my_taxonomy . "\n";
        }
        $output .= '</ul>' . "\n";
      }

      if ( $echo )
        echo $output;
      else
        return $output;
    } else {
      return;
    }
  } else {
    return false;
  }
}



//////////////////////////////////////////////////////////////
// Meta Box
/////////////////////////////////////////////////////////////

$prefix = "_ttrust_";

$project_details = array(
	
		"notes" => array(
    	"type" => "textarea",
		"name" => $prefix."notes",
    	"std" => "",
    	"title" => __('Notes','themetrust'),
    	"description" => __('Enter a description about the project.','themetrust')),

		"url" => array(
    	"type" => "textfield",
		"name" => $prefix."url",
    	"std" => "",
    	"title" => __('URL','themetrust'),
    	"description" => __('Enter the URL of your project.','themetrust')),

		"url_label" => array(
		"type" => "textfield",
		"name" => $prefix."url_label",
		"std" => "",
		"title" => __('URL Label','themetrust'),
		"description" => __('Enter a label for the URL.','themetrust')),
		
		"in_slideshow" => array(
    	"type" => "checkbox",
		"name" => $prefix."home_featured",
    	"std" => "",
    	"title" => __('Feature on Home Page','themetrust'),
    	"description" => __('Display this project on the home page.','themetrust'))
);

$slideshow_options = array(
	
		"in_slideshow" => array(
    	"type" => "checkbox",
		"name" => $prefix."in_slideshow",
    	"std" => "",
    	"title" => __('Include in Slideshow','themetrust'),
    	"description" => __('Display this project in the home page slideshow.','themetrust')),

		"slideshow_img" => array(
    	"type" => "textfield",
		"name" => $prefix."slideshow_img",
    	"std" => "",
    	"title" => __('Slideshow Image','themetrust'),
    	"description" => __('Enter the full URL of an image to be displayed in the home page slideshow. (Recommended dimensions: 960px x 350px)','themetrust'))
);

$portfolio_options = array(
	
		"notes" => array(
    	"type" => "textarea",
		"name" => $prefix."page_skills",
    	"std" => "",
    	"title" => __('Skills','themetrust'),
    	"description" => __('For use with the Portfolio page template. <br/><br/>Enter the names of the skills (separated by commas) you want shown on this page. If left blank, all skills will be used.','themetrust'))
);

$meta_box_groups = array($project_details, $slideshow_options, $portfolio_options);

function new_meta_box($post, $metabox) {	
	
	$meta_boxes_inputs = $metabox['args']['inputs'];

	foreach($meta_boxes_inputs as $meta_box) {
	
		$meta_box_value = get_post_meta($post->ID, $meta_box['name'].'_value', true);
		if($meta_box_value == "") $meta_box_value = $meta_box['std'];
		
		echo'<div class="meta-field">';
		
		echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
		
		echo'<p><strong>'.$meta_box['title'].'</strong></p>';
		
		if(isset($meta_box['type']) && $meta_box['type'] == 'checkbox') {
		
			if($meta_box_value == 'true') {
				$checked = "checked=\"checked\"";
			} elseif($meta_box['std'] == "true") {	
					$checked = "checked=\"checked\"";	
			} else {
					$checked = "";
			}
		
			echo'<p class="clearfix"><input type="checkbox" class="meta-radio" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value" value="true" '.$checked.' /> ';		
			echo'<label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';		
		
		} elseif(isset($meta_box['type']) && $meta_box['type'] == 'textarea')  {			
			
			echo'<textarea rows="4" style="width:98%" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value">'.$meta_box_value.'</textarea><br />';			
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';			
		
		} else {
			
			echo'<input style="width:70%"type="text" name="'.$meta_box['name'].'_value" id="'.$meta_box['name'].'_value" value="'.$meta_box_value.'" /><br />';		
			echo'<p><label for="'.$meta_box['name'].'_value">'.$meta_box['description'].'</label></p><br />';			
		
		}
		
		echo'</div>';
		
	} // end foreach
		
	echo'<br style="clear:both" />';
	
} // end meta boxes

function create_meta_box() {	
	global $project_details, $slideshow_options, $portfolio_options;	
	
	if ( function_exists('add_meta_box') ) {
		add_meta_box( 'new-meta-boxes-details', __('Project Details','themetrust'), 'new_meta_box', 'projects', 'normal', 'high', array('inputs'=>$project_details) );	
		add_meta_box( 'new-meta-boxes-slideshow', __('Slideshow Options','themetrust'), 'new_meta_box', 'projects', 'normal', 'high', array('inputs'=>$slideshow_options) );
		add_meta_box( 'new-meta-boxes-portfolio', __('Portfolio Options','themetrust'), 'new_meta_box', 'page', 'side', 'low', array('inputs'=>$portfolio_options) );
		add_meta_box( 'new-meta-boxes-slideshow', __('Slideshow Options','themetrust'), 'new_meta_box', 'page', 'normal', 'high', array('inputs'=>$slideshow_options) );	
	}
}



function save_postdata( $post_id ) {
	global $post, $new_meta_boxes, $project_details, $slideshow_options, $meta_box_groups;

	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
    	return $post_id;
	}

	if( defined('DOING_AJAX') && DOING_AJAX ) { //Prevents the metaboxes from being overwritten while quick editing.
		return $post_id;
	}

	if( ereg('/\edit\.php', $_SERVER['REQUEST_URI']) ) { //Detects if the save action is coming from a quick edit/batch edit.
		return $post_id;
	}

	foreach($meta_box_groups as $group) {
		foreach($group as $meta_box) {

			// Verify
			if(isset($_POST[$meta_box['name'].'_noncename'])){
				if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
					return $post_id;
				}
			}

			if ( isset($_POST['post_type']) && 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post_id ))
					return $post_id;
			} else {
				if ( !current_user_can( 'edit_post', $post_id ))
					return $post_id;
			}

			$data = "";
			if(isset($_POST[$meta_box['name'].'_value'])){
				$data = $_POST[$meta_box['name'].'_value'];
			}


			if(get_post_meta($post_id, $meta_box['name'].'_value') == "") 
				add_post_meta($post_id, $meta_box['name'].'_value', $data, true);
			elseif($data != get_post_meta($post_id, $meta_box['name'].'_value', true))
				update_post_meta($post_id, $meta_box['name'].'_value', $data);
			elseif($data == "" || $data == $meta_box['std'] )
				delete_post_meta($post_id, $meta_box['name'].'_value', get_post_meta($post_id, $meta_box['name'].'_value', true));
	
		} // end foreach
	} // end foreach
} // end save_postdata

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');



//////////////////////////////////////////////////////////////
// Comments
/////////////////////////////////////////////////////////////

function ttrust_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>		
	<li id="li-comment-<?php comment_ID() ?>">		
		
		<div class="comment <?php echo get_comment_type(); ?>" id="comment-<?php comment_ID() ?>">						
			
			<?php echo get_avatar($comment,'60',get_bloginfo('template_url').'/images/default_avatar.png'); ?>			
   	   			
   	   		<h5><?php comment_author_link(); ?></h5>
			<span class="date"><?php comment_date(); ?></span>
				
			<?php if ($comment->comment_approved == '0') : ?>
				<p><span class="message"><?php _e('Your comment is awaiting moderation.', 'themetrust'); ?></span></p>
			<?php endif; ?>
				
			<?php comment_text() ?>				
				
			<?php
			if(get_comment_type() != "trackback")
				comment_reply_link(array_merge( $args, array('add_below' => 'comment','reply_text' => '<span>'. __('Reply', 'themetrust') .'</span>', 'login_text' => '<span>'. __('Log in to reply', 'themetrust') .'</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'])))
			
			?>
				
		</div><!-- end comment -->
			
<?php
}

function ttrust_pings($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
		<li class="comment" id="comment-<?php comment_ID() ?>"><?php comment_author_link(); ?> - <?php comment_excerpt(); ?>
<?php
}
?>