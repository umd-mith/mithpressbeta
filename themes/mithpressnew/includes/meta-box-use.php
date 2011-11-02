<?php
/**
 * Registering meta boxes
 *
 * In this file, I'll show you how to extend the class to add more field type (in this case, the 'taxonomy' type)
 * All the definitions of meta boxes are listed below with comments, please read them carefully.
 * Note that each validation method of the Validation Class MUST return value instead of boolean as before
 *
 * You also should read the changelog to know what has been changed
 *
 * For more information, please visit: http://www.deluxeblogtips.com/2010/04/how-to-create-meta-box-wordpress-post.html
 *
 */

/********************* BEGIN EXTENDING CLASS ***********************/

/**
 * Extend RW_Meta_Box class
 * Add field type: 'taxonomy'
 */
class RW_Meta_Box_Taxonomy extends RW_Meta_Box {
	
	function add_missed_values() {
		parent::add_missed_values();
		
		// add 'multiple' option to taxonomy field with checkbox_list type
		foreach ($this->_meta_box['fields'] as $key => $field) {
			if ('taxonomy' == $field['type'] && 'checkbox_list' == $field['options']['type']) {
				$this->_meta_box['fields'][$key]['multiple'] = true;
			}
		}
	}
	
	// show taxonomy list
	function show_field_taxonomy($field, $meta) {
		global $post;
		
		if (!is_array($meta)) $meta = (array) $meta;
		
		$this->show_field_begin($field, $meta);
		
		$options = $field['options'];
		$terms = get_terms($options['taxonomy'], $options['args']);
		
		// checkbox_list
		if ('checkbox_list' == $options['type']) {
			foreach ($terms as $term) {
				echo "<input type='checkbox' name='{$field['id']}[]' value='$term->slug'" . checked(in_array($term->slug, $meta), true, false) . " /> $term->name<br/>";
			}
		}
		// select
		else {
			echo "<select name='{$field['id']}" . ($field['multiple'] ? "[]' multiple='multiple' style='height:auto'" : "'") . ">";
		
			foreach ($terms as $term) {
				echo "<option value='$term->slug'" . selected(in_array($term->slug, $meta), true, false) . ">$term->name</option>";
			}
			echo "</select>";
		}
		
		$this->show_field_end($field, $meta);
	}
}

/********************* END EXTENDING CLASS ***********************/

/********************* BEGIN DEFINITION OF META BOXES ***********************/

// prefix of meta keys, optional
// use underscore (_) at the beginning to make keys hidden, for example $prefix = '_mbox_';
// you also can make prefix empty to disable it
$prefix = '';

$meta_boxes = array();

/*-------------------------------------------------------------------------------------------*/
/* Project Meta Boxes */
/*-------------------------------------------------------------------------------------------*/

/* Project Status Meta Box */
/*-------------------------------------------------------------------------------------------*/

$meta_boxes[] = array(
	'id' => 'status',
	'title' => 'Project Status',
	'pages' => array('project'),
	'context' => 'side',
	'priority' => 'low',

	'fields' => array(
		array(
			'name' => 'Project Status',
			'id' => $prefix . 'project-status',
			'type' => 'radio',						// radio box
			'options' => array(						// array of key => value pairs for radio options
				'active' => 'Active<br />',
				'archive' => 'Archive<br />',
				'development' => 'In Development',
			),
			'std' => 'm',
		)
	)
);

/* Project Detail Meta Box */
/*-------------------------------------------------------------------------------------------*/

$meta_boxes[] = array(
	'id' => 'projectdetails',
	'title' => 'Project Details',
	'pages' => array('project'),
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Website',
			'desc' => '<span class="desc">enter the project website url, including http://</span>',
			'id' => $prefix . 'project-website',
			'type' => 'text',
			'style' => 'width: 100px'				// custom style for field, added in v3.1
		),
		array(
			'name' => 'Launch Date',
			'id' => $prefix . 'project-launchdate',
			'type' => 'date',						// date
			'format' => 'MM d, yy'					// date format, default yy-mm-dd. Optional. See more formats here: http://goo.gl/po8vf
		),
		array(
			'name' => 'Files',
			'desc' => '<span class="desc">upload any associated project files (white papers, pdfs, etc.)</span>',
			'id' => $prefix . 'project-files',
			'type' => 'file'						// file upload
		),
		array(
			'name' => 'Thumbnails',
			'desc' => '<span class="desc">main project thumbnail image</span>',
			'id' => $prefix . 'project-thumb',
			'type' => 'image'						// image upload
		),
		array(
			'name' => 'Screenshots',
			'desc' => '<span class="desc">screenshots of project website or other associated images</span>',
			'id' => $prefix . 'project-screenshot',
			'type' => 'image'						// image upload
		), 
		array(
			'name' => 'Staff',
			'id' => $prefix . 'mithstaff',
			'type' => 'select',					// taxonomy
			'options' => array()					// arguments to query taxonomy, see http://goo.gl/795Vm
			),
			'multiple' => true,						// select multiple values, optional. Default is false.		
			'desc' => 'Choose One Category'
		),
		array(
			'name' => 'Where do you live?',
			'id' => $prefix . 'place',
			'type' => 'select',						// select box
			'options' => array(						// array of key => value pairs for select box
				'usa' => 'USA',
				'vn' => 'Vietnam'
			),
			'multiple' => true,						// select multiple values, optional. Default is false.
			'std' => array('vn'),					// default value, can be string (single value) or array (for both single and multiple values)
			'desc' => 'Select the current place, not in the past'
		),
);


/*-------------------------------------------------------------------------------------------*/
/* Podcast Meta Boxes */
/*-------------------------------------------------------------------------------------------*/

$meta_boxes[] = array(
	'id' => 'podcastdetails',
	'title' => 'Podcast Details',
	'pages' => array('podcast'),
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Speaker',
			'desc' => 'enter speaker name',
			'id' => $prefix . 'pods-speaker',
			'type' => 'text'
		),
		array(
			'name' => 'Affiliation',
			'desc' => 'enter university, organization, company or other affliation here',
			'id' => $prefix . 'pods-affiliation',
			'type' => 'text'
		),
		array(
			'name' => 'Date',
			'desc' => 'date of talk',
			'id' => $prefix . 'pods-date',
			'type' => 'date',						// date
			'format' => 'MM d, yy'					// date format, default yy-mm-dd. Optional. See more formats here: http://goo.gl/po8vf
		),
		array(
			'name' => 'Keynote',
			'desc' => 'upload keynote file for talk',
			'id' => $prefix . 'pods-keynote',
			'type' => 'file'						// file upload
		),
		array(
			'name' => 'Slides',
			'desc' => 'upload powerpoint/slides file for talk',
			'id' => $prefix . 'pods-slides',
			'type' => 'file'						// file upload
		),
		array(
			'name' => 'Files',
			'desc' => 'upload files for talk',
			'id' => $prefix . 'pods-files',
			'type' => 'file'						// file upload
		),
		array(
			'name' => 'Speaker Photo',
			'desc' => 'upload speaker headshot',
			'id' => $prefix . 'pods-speaker-photo',
			'type' => 'image'						// image upload
		)
	)
);

/*-------------------------------------------------------------------------------------------*/
/* People Meta Boxes */
/*-------------------------------------------------------------------------------------------*/

$meta_boxes[] = array(
	'id' => 'personal',							
	'title' => 'Personal Information',			
	'pages' => array('people'),					
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional
	'priority' => 'high',						// order of meta box: high (default), low; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Full name',					// field name
			'desc' => 'Format: First Last',			// field description, optional
			'id' => $prefix . 'fname',				// field id, i.e. the meta key
			'type' => 'text',
		),
		array(
			'name' => 'Title',					// field name
			'desc' => 'Enter you full staff title',			// field description, optional
			'id' => $prefix . 'stitle',				// field id, i.e. the meta key
			'type' => 'text',
		),
		array(
			'name' => 'Email Address',					// field name
			'desc' => 'Format: name@domain.com',			// field description, optional
			'id' => $prefix . 'email',				// field id, i.e. the meta key
			'type' => 'text',
		),
		array(
			'name' => 'Office Phone',			// checkbox
			'id' => $prefix . 'ophone',
			'type' => 'text',
			'desc' => 'Enter your main/office phone number here'
		)
	)
);

$meta_boxes[] = array(
	'id' => 'social',							
	'title' => 'Social Media LInks',			
	'pages' => array('people'),					
	'context' => 'normal',						// where the meta box appear: normal (default), advanced, side; optional

	'fields' => array(							// list of meta fields
		array(
			'name' => 'Twitter Handle',										// field name
			'desc' => 'Enter just the part that comes after the @',			// field description, optional
			'id' => $prefix . 'twitter',									// field id, i.e. the meta key
			'type' => 'text',
		),
		array(
			'name' => 'Flickr Handle',
			'desc' => '(optional) enter your flickr username',
			'id' => $prefix . 'flickr',	
			'type' => 'text',
		),
		array(
			'name' => 'Google Plus',			
			'id' => $prefix . 'googlep',
			'type' => 'text',
			'desc' => '(option) enter your Google+ username'
		),
		array(
			'name' => 'Website Links',			
			'id' => $prefix . 'wlinks',
			'type' => 'text',
			'desc' => '(optional) enter a personal or professional site URL (link to your blog, portfolio page, or online CV)'
		)
	)
);


foreach ($meta_boxes as $meta_box) {
	new RW_Meta_Box_Taxonomy($meta_box);
}

/********************* END DEFINITION OF META BOXES ***********************/

/********************* BEGIN VALIDATION ***********************/

/**
 * Validation class
 * Define ALL validation methods inside this class
 * Use the names of these methods in the definition of meta boxes (key 'validate_func' of each field)
 */
 
class RW_Meta_Box_Validate {
	function check_name($text) {
		if ($text == 'Anh Tran') {
			return 'He is Rilwis';
		}
		return $text;
	}
}

/********************* END VALIDATION ***********************/
?>