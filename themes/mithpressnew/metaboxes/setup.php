<?php

include_once WP_CONTENT_DIR . '/wpalchemy/MetaBox.php';
 
include_once WP_CONTENT_DIR . '/wpalchemy/MediaAccess.php';

// global styles for the meta boxes
if (is_admin()) wp_enqueue_style('wpalchemy-metabox', get_stylesheet_directory_uri() . '/metaboxes/meta.css');

$wpalchemy_media_access = NEW WPAlchemy_MediaAccess();

/* eof */