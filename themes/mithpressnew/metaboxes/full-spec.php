<?php
/* PROJECT Metaboxes */

$project_mb = new WPAlchemy_MetaBox(
	array(
		'id' => '_project_details',
		'title' => 'Project Details',
		'types' => array('project'), 
		'context' => 'normal', // same as above, defaults to "normal"
		'priority' => 'high', // same as above, defaults to "high"
		'template' => get_stylesheet_directory() . '/metaboxes/project-meta.php'
	),
	array(
		'id' => '_project_status',
		'title' => 'Project Status',
		'types' => array('project'), 
		'context' => 'side', 
		'priority' => 'default', 
		'template' => get_stylesheet_directory() . '/metaboxes/project-meta-side.php'
	),
	array(
	'id' => '_project_files',
	'title' => 'Project Files',
	'types' => array('project'), 
	'template' => get_stylesheet_directory() . '/metaboxes/custom-meta.php',
	)
);

/* eof */
?>