<?php

$project_mb = new WPAlchemy_MetaBox(array(
	'id' => '_project_details',
	'title' => 'Project Details',
	'types' => array('project'), 
	'context' => 'normal', 
	'priority' => 'high', 
	'template' => get_stylesheet_directory() . '/metaboxes/project-meta.php'
));

$project2_mb = new WPAlchemy_MetaBox(array(
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
	'mode' => WPALCHEMY_MODE_EXTRACT,
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta.php'
	
));

$people2_mb = new WPAlchemy_MetaBox(array(
	'id' => '_people_links',
	'title' => 'Links',
	'types' => array('people'),
	'template' => get_stylesheet_directory() . '/metaboxes/people-meta-links.php'
));

$podcast_mb = new WPAlchemy_MetaBox(array(
	'id' => '_podcast_info',
	'title' => 'Podcast Details',
	'types' => array('podcast'), 
	'template' => get_stylesheet_directory() . '/metaboxes/podcast-meta.php',
	'priority' => 'high'
));

$podcast2_mb = new WPAlchemy_MetaBox(array(
	'id' => '_podcast_files',
	'title' => 'Podcast Files',
	'types' => array('podcast'), 
	'template' => get_stylesheet_directory() . '/metaboxes/podcast-meta-uploads.php'
));

/* eof */