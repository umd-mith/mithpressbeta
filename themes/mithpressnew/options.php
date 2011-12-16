<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$test_array = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
	
	// Multicheck Array
	$multicheck_array = array("one" => "French Toast", "two" => "Pancake", "three" => "Omelette", "four" => "Crepe", "five" => "Waffle");
	
	// Multicheck Defaults
	$multicheck_defaults = array("one" => "1","five" => "1");
	
	// Background Defaults
	
	$background_defaults = array('color' => '', 'image' => '', 'repeat' => 'repeat','position' => 'top center','attachment'=>'scroll');
	
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
		
	$options[] = array( "name" => "Homepage Slides",
						"type" => "heading");
												
	//slide one
	
	$options[] = array( "name" => "Slide One",
						"desc" => "Title for first slide.",
						"id" => "slide_title_one",
						"std" => "Enter slide title here",
						"type" => "text");

	$options[] = array( "desc" => "Upload the image for the first slide.",
						"id" => "slide_upload_one",
						"type" => "upload");
						
	$options[] = array( "desc" => "Insert text for first slide",
						"id" => "slide_text_one",
						"std" => "",
						"type" => "textarea"); 

	//slide two 

	$options[] = array( "name" => "Slide Two",
						"desc" => "Title for second slide.",
						"id" => "slide_title_two",
						"std" => "Enter slide title here",
						"type" => "text");
	
	$options[] = array( "desc" => "Upload the image for the second slide.",
						"id" => "slide_upload_two",
						"type" => "upload");
	
	$options[] = array( "desc" => "Insert text for second slide",
						"id" => "slide_text_two",
						"std" => "",
						"type" => "textarea"); 

	//slide three 

	$options[] = array( "name" => "Slide Three",
						"desc" => "Title for third slide.",
						"id" => "slide_title_three",
						"std" => "Enter slide title here",
						"type" => "text");
	
	$options[] = array( "desc" => "Upload the image for the third slide.",
						"id" => "slide_upload_three",
						"type" => "upload");
	
	$options[] = array( "desc" => "Insert text for third slide",
						"id" => "slide_text_three",
						"std" => "",
						"type" => "textarea"); 

	//slide four 

	$options[] = array( "name" => "Slide Four",
						"desc" => "Title for fourth slide.",
						"id" => "slide_title_four",
						"std" => "Enter slide title here",
						"type" => "text");
	
	$options[] = array( "desc" => "Upload the image for the fourth slide.",
						"id" => "slide_upload_four",
						"type" => "upload");
	
	$options[] = array( "desc" => "Insert text for fourth slide",
						"id" => "slide_text_four",
						"std" => "",
						"type" => "textarea"); 
	
	return $options;
}