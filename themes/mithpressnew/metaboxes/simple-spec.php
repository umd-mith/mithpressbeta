<?php

$custom_metabox = $simple_mb = new WPAlchemy_MetaBox(array
(
	'id' => '_custom_meta',
	'types' => array('project', 'psst', 'people'), 
	'title' => 'My Custom Meta',
	'template' => get_stylesheet_directory() . '/metaboxes/simple-meta.php',
));

/* eof */