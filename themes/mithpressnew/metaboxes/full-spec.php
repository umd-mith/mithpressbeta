<?php

$project_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_details',
	'title' => 'Project Details',
	'types' => array('project'), 
	'context' => 'normal', 
	'priority' => 'high', 
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta.php'
));

$project_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_status',
	'title' => 'Project Status',
	'types' => array('project'), 
	'context' => 'side', 
	'priority' => 'default', 
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta-status.php'
));

$people_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_info',
	'title' => 'Personal Information',
	'types' => array('people'), 
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta.php'
));

$people_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_links',
	'title' => 'Links',
	'types' => array('people'),
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta-links.php'
));

/* eof */

?>