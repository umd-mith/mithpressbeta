<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Post Thumbnail 
- Nav Menus
- Misc
- Admin Functions 

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Thumbnail Support */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-thumbnails', array('page','post','people','project','podcast' ) );

function mithpress_thumbnails() {
	//update_option('thumbnail_size_w', 290);
    //update_option('thumbnail_size_h', 290);
	//add_image_size( 'featured-image', 640, 130 ); 
    add_image_size( 'mini-thumbnail', 50, 50, true );
	add_image_size( 'med-thumbnail', 130, 130, true ); // staff/person photo size
	//add_image_size( 'horiz-header', 410, 185, false ); // project detail header	
	add_image_size( 'horiz-thumbnail', 200, 90, false ); // project icon
    add_image_size( 'slide', 640, 290, true );
}
add_action( 'init', 'mithpress_thumbnails' );


/*-----------------------------------------------------------------------------------*/
/* Add Image Sizes to Media Uploader */
/*-----------------------------------------------------------------------------------*/

/**
 * Filter callback to add image sizes to Media Uploader
 *
 * WP 3.3 beta adds a new filter 'image_size_names_choose' to
 * the list of image sizes which are displayed in the Media Uploader
 * after an image has been uploaded.
 *
 * See image_size_input_fields() in wp-admin/includes/media.php
 * 
 * Tested with WP 3.3 beta 1
 *
 * @uses get_intermediate_image_sizes()
 *
 * @param $sizes, array of default image sizes (associative array)
 * @return $new_sizes, array of all image sizes (associative array)
 */
function sgr_display_image_size_names_muploader( $sizes ) {
	
	$new_sizes = array();
	
	$added_sizes = get_intermediate_image_sizes();
	
	// $added_sizes is an indexed array, therefore need to convert it
	// to associative array, using $value for $key and $value
	foreach( $added_sizes as $key => $value) {
		$new_sizes[$value] = $value;
	}
	
	// This preserves the labels in $sizes, and merges the two arrays
	$new_sizes = array_merge( $new_sizes, $sizes );
	
	return $new_sizes;
}
add_filter('image_size_names_choose', 'sgr_display_image_size_names_muploader', 11, 1);

/*-----------------------------------------------------------------------------------*/
/* Remove Standard Image Sizes */
/*-----------------------------------------------------------------------------------*/
/**
 * Remove standard image sizes so that these sizes are not
 * created during the Media Upload process
 *
 * Tested with WP 3.2.1
 *
 * Hooked to intermediate_image_sizes_advanced filter
 * See wp_generate_attachment_metadata( $attachment_id, $file ) in wp-admin/includes/image.php
 *
 * @param $sizes, array of default and added image sizes
 * @return $sizes, modified array of image sizes
 * @author Ade Walker http://www.studiograsshopper.ch
 */
function sgr_filter_image_sizes( $sizes) {
		
	unset( $sizes['thumbnail']);
	unset( $sizes['medium']);
	unset( $sizes['large']);
	
	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'sgr_filter_image_sizes');

// Remove Title Attribute from Featured Image

add_filter('post_thumbnail_html', 'remove_feat_img_title');
function remove_feat_img_title($img) {
    $img = preg_replace('/title=\"(.*?)\"/','',$img);
    return $img;
}

function modify_post_mime_types($post_mime_types) {
    $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
    return $post_mime_types;
}
add_filter('post_mime_types', 'modify_post_mime_types');

/*-----------------------------------------------------------------------------------*/
/* Nav Menus Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
		register_nav_menus( array( 
		'main-menu' => __( 'Main Menu' ), 
		'about-menu' => __( 'About Menu' ),
		'research-menu' => __( 'Research Menu' ),
		//'community-menu' => __( 'Community Menu' ),
		'staff-menu' => __( 'Staff Menu' ),
		'digital-dialogues-menu' => __( 'Digital Dialogues Menu'),
		'footer-textlinks' => __( 'Footer Text Links ' ),
		'footer-menu' => __( 'Footer Menu' )
	)
  );
}     


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


/*-----------------------------------------------------------------------------------*/
/* Misc */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );


/*-----------------------------------------------------------------------------------*/
/* WooTabs - Latest Posts */
/*-----------------------------------------------------------------------------------
if (!function_exists('woo_tabs_latest')) {
	function woo_tabs_latest( $posts = 5, $size = 35 ) {
		global $post;
		$latest = get_posts('showposts='. $posts .'&orderby=post_date&order=desc');
		foreach($latest as $post) :
			setup_postdata($post);
	?>
	<li>
		<?php if ($size <> 0) woo_image('height='.$size.'&width='.$size.'&class=thumbnail&single=true'); ?>
		<a title="<?php the_title(); ?>" href="<?php the_permalink() ?>"><?php the_title(); ?></a>
		<span class="meta"><?php the_time( get_option( 'date_format' ) ); ?></span>
		<div class="fix"></div>
	</li>
	<?php endforeach; 
	}
}*/

/*-----------------------------------------------------------------------------------*/
/* Misc Admin */
/*-----------------------------------------------------------------------------------*/

// More Sorting Options for the Media Library 

add_filter('post_mime_types', 'add_post_mime_type');
function add_post_mime_type( $post_mime_types ) {
    //$post_mime_types['application'] = array(__('Doc'), __('Manage Doc'), _n_noop('Doc <span class="count">(%s)</span>', 'Doc <span class="count">(%s)</span>'));
    $post_mime_types['application/pdf'] = array(__('PDF'), __('Manage PDF'), _n_noop('PDF <span class="count">(%s)</span>', 'PDF <span class="count">(%s)</span>'));
    $post_mime_types['application/msword'] = array(__('DOC'), __('Manage DOC'), _n_noop('DOC <span class="count">(%s)</span>', 'DOC <span class="count">(%s)</span>'));
    return $post_mime_types;
}


// List Category ID in Quick Actions

add_filter( "tag_row_actions", 'add_cat_id_to_quick_edit', 10, 2 );
function add_cat_id_to_quick_edit( $actions, $tag ) {
    $actions['cat_id'] = 'ID: '.$tag->term_id;
    return $actions;
}

// Easier Access to Media File from Media Library
/* will add a link to the �row actions� for the File URL (as opposed the the attachment URL you�ll get with the �view� link)*/

add_filter ('media_row_actions','add_direct_link', 10, 3 );
function add_direct_link( $actions, $post, $detached ) {
    $actions['file_url'] = '<a href="' . wp_get_attachment_url($post->ID) . '">Actual File</a>';
    return $actions;
}


// Remove Dashboard Widgets

add_action( 'wp_dashboard_setup', 'remove_wp_dashboard_widgets' );

function remove_wp_dashboard_widgets() {

	//Plugins
    wp_unregister_sidebar_widget( 'dashboard_plugins' );
    remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
 
    //Right Now
    //wp_unregister_sidebar_widget( 'dashboard_right_now' );
    //remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
 
    //Recent Comments
    //wp_unregister_sidebar_widget( 'dashboard_recent_comments' );
    //remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
 
    //Incoming Links
    //wp_unregister_sidebar_widget( 'dashboard_incoming_links' );
    //remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
 
    //WordPress Blog
    wp_unregister_sidebar_widget( 'dashboard_primary' );
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
 
    //Other WordPress News
    wp_unregister_sidebar_widget( 'dashboard_secondary' );
    remove_meta_box('dashboard_secondary', 'dashboard', 'side');
 
    //Quick Press
    //wp_unregister_sidebar_widget( 'dashboard_quick_press' );
    //remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
 
    //Recent Drafts
    //wp_unregister_sidebar_widget( 'dashboard_recent_drafts' );
    //remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
}

// WP ALCHEMY 
function my_admin_print_footer_scripts() { 	?>

<script type="text/javascript">

/* <![CDATA[ */

		
			jQuery(document).ready(function($) {

				
			/*
			 * Upload function
			 */
			 
			 
			var form_src, form_alt, form_id, button, tbframe_interval;
			

			$('.my_meta_control').delegate('.upload_image_button','click', function() { 
				form_src = $(this).prevAll('input.image_src');
				form_alt = $(this).prevAll('input.image_alt');
				form_id = $(this).prevAll('input.image_id');
								
				button = $(this);
				
				tbframe_interval = setInterval(function() {
					//change button text
					$('#TB_iframeContent').contents().find('.savesend .button').val('Use This Image');
					//remove url, alignment and size fields- auto set to null, none and full respectively
					$('#TB_iframeContent').contents().find('.url').hide().find('input').val('');
					$('#TB_iframeContent').contents().find('.align').hide().find('input:radio').filter('[value="none"]').attr('checked', true);
					$('#TB_iframeContent').contents().find('.image-size').hide().find('input:radio').filter('[value="full"]').attr('checked', true);
				}, 2000);
				tb_show('', 'media-upload.php?type=image&tab=library&TB_iframe=true');
				//tb_show('', 'media-upload.php?type=image&TB_iframe=true');
				return false;
			});

			window.original_send_to_editor = window.send_to_editor;
			window.send_to_editor = function(html){
				clearInterval(tbframe_interval);
				if (form_src) {
				
					//if image links somewhere then the img node will be a child of the returned html
					if ( $(html).children().length > 0)	{ 
						src = $('img',html).attr('src');
						imgclass = $('img',html).attr('class');
						alt = $('img',html).attr('alt');
						href = $('a',html).attr('href');
					} else { //img node IS the returned html
						src = $(html).attr('src');
						imgclass = $(html).attr('class');
						alt = $(html).attr('alt');
					}
					
					if(typeof imgclass != 'undefined') {
					var imageID = imgclass.match(/([0-9]+)/i);
						imageID = (imageID && imageID[1]) ? imageID[1] : '' ;
					}
						
					var url = src ? src : href ;
								
					form_src.val(url);
					form_alt.val(alt);
					form_id.val(imageID);
					form_src.prevAll('.preview_wrap').children('img').attr('src',url).fadeIn();
					button.html('<span class="icon change"></span><?php _e('Change Image');?>').next('.delete_image_button').fadeIn();
					tb_remove();
					form_src = ''; //reset form_src to null so original works
				} else {
					window.original_send_to_editor(html);
				}
			};

			
			/*
			 * Remove Function
			 */
			 
		
			$('.my_meta_control').delegate('.delete_image_button','click', function() {
				form_src = $(this).prevAll('input.image_src').val('');
				form_alt = $(this).prevAll('input.image_alt').val('');
				form_id = $(this).prevAll('input.image_id').val('');
				
				var img = form_src.prevAll('.preview_wrap').children('img');
				
				if( img.hasClass('photo')){
					img.attr('src','<?php echo WPALCHEMY; ?>/images/default_photo.png').fadeIn();
				} else {
					img.attr('src','<?php echo WPALCHEMY; ?>/images/default_preview.png').fadeIn();
				}
				
				$(this).prev().html('<span class="icon upload"></span><?php _e('Upload Image');?>');
				$(this).fadeOut();
				return false;
			});
			
			$('.slide_preview').each(function(){
				var src = $(this).find('.image_src').val();
				if(src) { $(this).find('.delete_image_button').show(); } else { $(this).find('.delete_image_button').hide(); }
			});
	
			
			}); //end doc ready

	
			
		/* ]]> */</script><?php
	}
//only load on pages and posts!
add_action('admin_footer-post.php','my_admin_print_footer_scripts',99);


?>