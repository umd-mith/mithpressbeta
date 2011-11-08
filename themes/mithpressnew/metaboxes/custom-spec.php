<?php
$custom_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'title' => 'My Custom Meta',
	'types' => array('project', 'podcast'), 
	'template' => get_stylesheet_directory() . '/metaboxes/custom-meta.php',
));
?>