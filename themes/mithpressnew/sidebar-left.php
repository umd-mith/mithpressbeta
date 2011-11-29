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
		'menu_class' => 'links',
		'depth' => '1'
	) ); 
} elseif (is_tree('54') || 'project' == get_post_type() || is_singular('project')) {
	wp_nav_menu( array( 
		'theme_location' => 'research-menu', 
		'container_id' => 'sub-links',
		'menu_class' => 'links',
		'depth' => '1'
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

global $post; $thispage = $post->ID; // grabs the current post id from global and then assigns it to thispage ?>
	<?php $pagekids = get_pages("depth=1&child_of=".$thispage."&sort_column=menu_order"); 
	// gets a list of page that are sub pages of the current page and assigns then to pagekids ?>
    
	<?php if ($pagekids) { // if there are any values stored in pagekids and therefore the current page has subpages ?>
        <ul id="sub-links">
            <?php wp_list_pages("depth=1&title_li=&sort_column=menu_order&child_of=".$thispage); 
			// display the sub pages of the current page only ?>
        </ul>
    <?php } elseif ( $post->post_parent )
		$children = wp_list_pages("depth=1&title_li=&child_of=".$post->post_parent."&echo=0"); 
		if ( $children ) { // if there are no sub pages for the current page ?>
        	<ul id="sub-links"><?php echo $children; ?></ul>
	<?php } 
} ?>

</nav>