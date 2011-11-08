<nav id="subnav" class="span-5 append-1">
<h3 class="assistive-text"><?php _e( 'Secondary menu', 'mithpress' ); ?></h3>
  <h1 class="append-bottom">
<?php $post_type = get_post_type( $post->ID );
	  $obj = get_post_type_object( $post->post_type);
	if ('podcast' == get_post_type() || 'project' == get_post_type() ) { 
	echo $obj->labels->singular_name;
    //} elseif ( is_tree('127') || is_tree('54'))  {
	//echo $obj->labels->singular_name;
	} else { 
		$parent_title = get_the_title($post->post_parent);
		echo $parent_title;
	} ?>
  </h1>
<?php if (is_tree('2')) {
	wp_nav_menu( array( 
		'theme_location' => 'about-menu', 
		'container_id' => 'sub-links',
		'menu_class' => 'links'
	) ); 
} elseif (is_tree('54') || 'project' == get_post_type() || is_singular('project')) {
	wp_nav_menu( array( 
		'theme_location' => 'research-menu', 
		'container_id' => 'sub-links',
		'menu_class' => 'links'
	) ); 
} elseif (is_tree('127') || 'podcast' == get_post_type() || is_singular('podcast')) {
	wp_nav_menu( array( 
		'theme_location' => 'digital-dialogues-menu', 
		'container_id' => 'sub-links',
		'menu_class' => 'links'
	) ); 
} elseif (is_page('555')) { 
	wp_nav_menu( array( 
		'theme_location' => 'staff-menu', 
		'container_id' => 'sub-links',
		'menu_class' => 'links'
	) ); 
} else  {

$output = wp_list_pages('echo=0&depth=1&title_li=<h2 class="append-bottom"></h2>' );
if (is_page( )) {
  $page = $post->ID;
  if ($post->post_parent) {
    $page = $post->post_parent;
  }
  $children=wp_list_pages( 'echo=0&child_of=' . $page . '&title_li=' );
  if ($children) {
    $output = wp_list_pages ('echo=0&child_of=' . $page . '&title_li=');
  }
} ?>
<ul id="sub-links"><?php echo $output; ?></ul>
<?php } ?>
</nav>