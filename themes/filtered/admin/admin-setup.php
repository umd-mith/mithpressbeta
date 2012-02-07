<?php

define('ADMIN_PATH', get_bloginfo('template_url') .'/admin/');

//////////////////////////////////////////////////////////////
// ThemeTrust - Admin Head
////////////////////////////////////////////////////////////

if(isset($_REQUEST['page']) && $_REQUEST['page']=='ttrust-options') :

	add_action( 'admin_init', 'ttrust_admin_head' );
	
	function ttrust_admin_head() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );	
		wp_register_script('ttrust-cookie', ADMIN_PATH .'admin-cookie.js', array('jquery'));
		wp_enqueue_script('ttrust-cookie');			
		wp_register_script('ttrust-ajax-upload', ADMIN_PATH .'scripts/ajaxupload.js', array('jquery'));
		wp_enqueue_script('ttrust-ajax-upload');
		wp_register_script('ttrust-color-picker', ADMIN_PATH .'scripts/colorpicker/js/colorpicker.js', array('jquery'));
		wp_enqueue_script('ttrust-color-picker');			
		wp_register_script('ttrust-jquery-ui', ADMIN_PATH .'scripts/jquery-ui/js/jquery-ui-1.8.1.custom.min.js', array('jquery'));
		wp_enqueue_script('ttrust-jquery-ui');
		wp_register_script('ttrust-admin-jquery', ADMIN_PATH .'admin-jquery.js', array('jquery'));
		wp_enqueue_script('ttrust-admin-jquery');		
		wp_enqueue_style('ttrust-ui-lightness', ADMIN_PATH .'scripts/jquery-ui/css/ui-lightness/jquery-ui-1.8.1.custom.css', false, "1.0", "all");
		wp_enqueue_style('ttrust-options', ADMIN_PATH .'style.css', false, "1.0", "all");
		wp_enqueue_style('ttrust-color-picker', ADMIN_PATH .'scripts/colorpicker/css/colorpicker.css', false, "1.0", "all");		
	}

endif;



//////////////////////////////////////////////////////////////
// ThemeTrust - Admin Main Menu 
////////////////////////////////////////////////////////////

add_action('admin_menu', 'ttrust_create_menu');

function ttrust_create_menu() {

	global $ttrust_theme_name;
	add_menu_page($ttrust_theme_name.' Theme Settings', $ttrust_theme_name, 'administrator', 'ttrust-options', 'ttrust_options_page', ADMIN_PATH .'images/themetrust_menu_icon.png', 61);
		
}

?>