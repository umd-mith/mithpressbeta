<?php

/*-------------------------------------------------------------------------------------------*/
/* Project Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_project' );

function register_cpt_project() {

    $projectlabels = array( 
        'name' => _x( 'Projects', 'project' ),
        'singular_name' => _x( 'Project', 'project' ),
        'add_new' => _x( 'Add New Project', 'project' ),
        'add_new_item' => _x( 'Add New Project', 'project' ),
        'edit_item' => _x( 'Edit Project', 'project' ),
        'new_item' => _x( 'New Project', 'project' ),
        'view_item' => _x( 'View Project', 'project' ),
        'search_items' => _x( 'Search Projects', 'project' ),
        'not_found' => _x( 'No projects found', 'project' ),
        'not_found_in_trash' => _x( 'No projects found in Trash', 'project' ),
        'menu_name' => _x( 'Projects', 'project' ),
    );

    $args = array( 
        'labels' => $projectlabels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'taxonomies' => array( 'categories', 'tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,		
		
        'exclude_from_search' => false,
        'has_archive' => true,
        'can_export' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('category', 'post_tag'),
		
    );

    register_post_type( 'project', $args );
}

/* New Project Tag Taxonomy
add_action( 'init', 'register_taxonomy_project_tags' );

function register_taxonomy_project_tags() {

    $labels = array( 
        'name' => _x( 'Project Tags', 'project tags' ),
        'singular_name' => _x( 'Project Tags', 'project tags' ),
        'search_items' => _x( 'Search Project Tags', 'project tags' ),
        'popular_items' => _x( 'Popular Project Tags', 'project tags' ),
        'all_items' => _x( 'All Project Tags', 'project tags' ),
        'parent_item' => _x( 'Parent Project Tags', 'project tags' ),
        'parent_item_colon' => _x( 'Parent Project Tags:', 'project tags' ),
        'edit_item' => _x( 'Edit Project Tag', 'project tags' ),
        'update_item' => _x( 'Update Project Tag', 'project tags' ),
        'add_new_item' => _x( 'Add New Project Tag', 'project tags' ),
        'new_item_name' => _x( 'New Project Tag Name', 'project tags' ),
        'separate_items_with_commas' => _x( 'Separate project tags with commas', 'project tags' ),
        'add_or_remove_items' => _x( 'Add or remove project tag', 'project tags' ),
        'choose_from_most_used' => _x( 'Choose from the most used project tags', 'project tags' ),
        'menu_name' => _x( 'Project Tags', 'project tags' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'project_tags', array('project'), $args );
}
*/

/* Project Columns */
/*-------------------------------------------------------------------------------------------*/
add_filter( 'manage_edit-project_columns', 'edit_project_columns' ) ;

function edit_project_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Project Title' ),
		'project_status' => __( 'Status' ),
		'project_date' => __( 'Launch Date' ),
		'tags' => __( 'Tags' ),
		// 'categories' => __( 'Categories' ),
		'id' => __('ID'),
	);

	return $columns;
}

// Add to admin_init function
add_action('manage_project_posts_custom_column', 'manage_project_columns', 10, 2);

function manage_project_columns( $column, $post_id ) {
	{
	global $post;
		global $post;
		switch ($column)
		{
			case "id":
				echo $post->ID;
				break;
			case "project_status":
				$custom = get_post_custom();
				$custom_field = $custom['project-status'];
					foreach ( $custom_field as $key => $value )
				echo $value ;
				//$custom = get_post_custom();
				//echo $custom["project_status"][0];
				break;
			case "project_date":
				$custom = get_post_custom();
				echo $custom["project-launchdate"][0];
				break;
		}
	
	}

} 


/*-------------------------------------------------------------------------------------------*/
/* Podcast Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_podcast' );

function register_cpt_podcast() {

    $labels = array( 
        'name' => _x( 'Podcasts', 'podcast' ),
        'singular_name' => _x( 'Podcast', 'podcast' ),
        'add_new' => _x( 'Add New Podcast', 'podcast' ),
        'add_new_item' => _x( 'Add New Podcast', 'podcast' ),
        'edit_item' => _x( 'Edit Podcast', 'podcast' ),
        'new_item' => _x( 'New Podcast', 'podcast' ),
        'view_item' => _x( 'View Podcast', 'podcast' ),
        'search_items' => _x( 'Search Podcasts', 'podcast' ),
        'not_found' => _x( 'No podcasts found', 'podcast' ),
        'not_found_in_trash' => _x( 'No podcasts found in Trash', 'podcast' ),
        'menu_name' => _x( 'Podcasts', 'podcast' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions' ),
        'taxonomies' => array( 'podcast_categories', 'podcast_tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('category', 'post_tag')
    );

    register_post_type( 'podcast', $args );
}

/* New Podcast Tag Taxonomy
add_action( 'init', 'register_taxonomy_podcast_tags' );

function register_taxonomy_podcast_tags() {

    $labels = array( 
        'name' => _x( 'Podcast Tags', 'podcast tags' ),
        'singular_name' => _x( 'Podcast Tags', 'podcast tags' ),
        'search_items' => _x( 'Search Podcast Tags', 'podcast tags' ),
        'popular_items' => _x( 'Popular Podcast Tags', 'podcast tags' ),
        'all_items' => _x( 'All Podcast Tags', 'podcast tags' ),
        'parent_item' => _x( 'Parent Podcast Tags', 'podcast tags' ),
        'parent_item_colon' => _x( 'Parent Podcast Tags:', 'podcast tags' ),
        'edit_item' => _x( 'Edit Podcast Tag', 'podcast tags' ),
        'update_item' => _x( 'Update Podcast Tag', 'podcast tags' ),
        'add_new_item' => _x( 'Add New Podcast Tag', 'podcast tags' ),
        'new_item_name' => _x( 'New Podcast Tag Name', 'podcast tags' ),
        'separate_items_with_commas' => _x( 'Separate podcast tags with commas', 'podcast tags' ),
        'add_or_remove_items' => _x( 'Add or remove podcast tag', 'podcast tags' ),
        'choose_from_most_used' => _x( 'Choose from the most used podcast tags', 'podcast tags' ),
        'menu_name' => _x( 'Podcast Tags', 'podcast tags' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'hierarchical' => false,

        'rewrite' => true,
        'query_var' => true
    );

    register_taxonomy( 'podcast_tags', array('podcast'), $args );


}
*/

add_action('manage_podcast_posts_custom_column', 'manage_podcast_columns');
add_filter('manage_edit-podcast_columns', 'edit_podasts_columns');

 
function edit_podasts_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"pods_date" => "Date",
		"title" => "Title",
		"pods_speaker" => "Speaker",
		'id' => __('ID'),
	);
	return $columns;
}
 
function manage_podcast_columns($column)
{
	global $post;
		global $post;
		switch ($column)
		{
			case "id":
				echo $post->ID;
				break;
			case "pods_description":
				the_excerpt();
				break;
			case "pods_speaker":
				$custom = get_post_custom();
				echo $custom["pods-speaker"][0];
				break;
			case "pods_date":
				$custom = get_post_custom();
				echo $custom["pods-date"][0];
				break;
		}
	
	}
	

/*-------------------------------------------------------------------------------------------*/
/* People Post Type */
/*-------------------------------------------------------------------------------------------*/

add_action( 'init', 'register_cpt_people' );

function register_cpt_people() {

    $peoplelabels = array( 
        'name' => _x( 'People', 'people' ),
        'singular_name' => _x( 'People', 'people' ),
        'add_new' => _x( 'Add New Person', 'people' ),
        'add_new_item' => _x( 'Add New Person', 'people' ),
        'edit_item' => _x( 'Edit People', 'people' ),
        'new_item' => _x( 'New Person', 'people' ),
        'view_item' => _x( 'View People', 'people' ),
        'search_items' => _x( 'Search People', 'people' ),
        'not_found' => _x( 'No people found', 'people' ),
        'not_found_in_trash' => _x( 'No people found in Trash', 'people' ),
        'menu_name' => _x( 'People', 'people' ),
    );

    $args = array( 
        'labels' => $peoplelabels,
        'hierarchical' => false,
        
        'supports' => array( 'featured image', 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'categories', 'tags' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        
        'show_in_nav_menus' => false,
        'publicly_queryable' => true,
        'query_var' => true,
        'rewrite' => true,		
		
        'exclude_from_search' => false,
        'has_archive' => true,
        'can_export' => true,
        'capability_type' => 'post',
		
		'taxonomies' => array('category', 'post_tag'),
		
    );

    register_post_type( 'people', $args );
}

/*-------------------------------------------------------------------------------------------*/
/* Meta Box Title Changes */
/*-------------------------------------------------------------------------------------------*/

add_filter('gettext', 'admin_custom_rewrites', 10, 4);

function admin_custom_rewrites($translation, $text, $domain) {
	global $post;
        if ( ! isset( $post->post_type ) ) {
            return $translation;
        }
	$translations = &get_translations_for_domain($domain);
	$translation_array = array();
 
	switch ($post->post_type) {
		case 'people': 
			$translation_array = array(
				'Enter title here' => 'Enter full name here',
				'Featured Image' => 'Bio Picture',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'podcast': 
			$translation_array = array(
				'Enter title here' => 'Enter talk title here',
				'Featured Image' => 'Speaker Photo',
				'Set featured image' => 'Assign image'
			);
			break;
		case 'project': 
			$translation_array = array(
				'Enter title here' => 'Enter project title here',
				'Featured Image' => 'Project Thumbnail',
				'Set featured image' => 'Assign image'
			);
			break;
	}
 
	if (array_key_exists($text, $translation_array)) {
		return $translations->translate($translation_array[$text]);
	}
	return $translation;
}



/*-------------------------------------------------------------------------------------------*/
/* Create Sortable Columns */
/*-------------------------------------------------------------------------------------------*/
function sortable_columns() {
  return array(
    'pods_speaker'  => 'pods_speaker',
    'pods_date' 	=> 'pods_date',
	'project_date' =>	'project_date',
	'project_status' =>  'project_status',
  );
}

add_filter( "manage_edit-podcast_sortable_columns", "sortable_columns" );
add_filter( "manage_edit-project_sortable_columns", "sortable_columns" );

?>