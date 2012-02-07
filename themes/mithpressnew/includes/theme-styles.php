<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Add Styles
- Remove Styles
- Add Scripts

-----------------------------------------------------------------------------------*/

//////////////////////////////////////////////////////////////
/* Add and Remove Styles */
//////////////////////////////////////////////////////////////

add_action('wp_enqueue_scripts', 'mithpress_scripts');

function mithpress_scripts() {
	
	if( !is_admin()) : 
		wp_deregister_script('jquery');
		wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"), array(), '1.7.1', false);
		wp_enqueue_script('jquery');
	endif;

	if (is_front_page()) :
		wp_enqueue_script('slideshow', get_bloginfo('template_url').'/js/jquery.orbit-1.2.3.min.js', array('jquery'), '1.2.3', true );
		wp_enqueue_style('slideshow', get_bloginfo('template_url').'/css/orbit.css', false, '1.2.3', 'screen, projection' );
	endif;
	

	wp_enqueue_script('functions', get_bloginfo('template_url').'/js/functions.js', array(), false, true);
	
	wp_enqueue_script('superfish', get_bloginfo('template_url').'/js/superfish.js', array('jquery'), '1.4.8', true);
	wp_enqueue_script('supersubs', get_bloginfo('template_url').'/js/supersubs.js', array('jquery'), '0.2', true);
	wp_enqueue_style('superfish', get_bloginfo('template_url').'/css/superfish.css', false, '1.4.8', 'all' );

	if ('project' == get_post_type() ) : 
		wp_enqueue_script('lightbox', get_bloginfo('template_url').'/js/slimbox2.js', array('jquery'), '2.04', true );
		wp_enqueue_style('lightbox', get_bloginfo('template_url').'/css/slimbox2.css', false, 'screen, projection' );
	endif;

	if ('people' == get_post_type() ) : 
		wp_enqueue_script('grayscale', get_bloginfo('template_url').'/js/grayscale.js', array(), false, true);
		wp_enqueue_style('grayscale', get_bloginfo('template_url').'/css/grayscale.css', false, 'screen, projection' );
	endif;
}

add_action('wp_head','mithpress_theme_head');

function mithpress_theme_head() { ?>
<meta name="generator" content="<?php global $ttrust_theme, $ttrust_version; echo $ttrust_theme.' '.$ttrust_version; ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />

<!--[if lt IE 7]>
<script defer type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/pngfix.js"></script>
<![endif]-->
<!--[if lt IE 9]>
<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/html5.js"></script>
<![endif]-->

<?php }


//////////////////////////////////////////////////////////////
/* Load Admin Styles  */
//////////////////////////////////////////////////////////////
function my_admin_styles() {
	wp_enqueue_style('thickbox');
	wp_register_style('admin-styles', get_bloginfo('template_directory').'/css/admin-styles.css', array(), '', 'screen');
	wp_enqueue_style('admin-styles');
}

add_action('admin_print_styles', 'my_admin_styles');


if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
    update_option( 'posts_per_page', 12 );
    update_option( 'paging_mode', 'default' );
}

//////////////////////////////////////////////////////////////
/* Add Admin Scripts */
//////////////////////////////////////////////////////////////

function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('metascripts', get_bloginfo('template_directory').'/js/meta-box-scripts.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('metascripts');
}

add_action('admin_print_scripts-post.php', 'my_admin_scripts');
?>