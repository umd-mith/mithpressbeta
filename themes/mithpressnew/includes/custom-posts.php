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

/* Podcast Columns */
/*-------------------------------------------------------------------------------------------*/

add_action('manage_podcast_posts_custom_column', 'manage_podcast_columns');
add_filter('manage_edit-podcast_columns', 'edit_podcast_columns');

 
function edit_podcast_columns($columns) //this function display the columns headings
{
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Title",
		"speaker" => "Speaker",
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
			case "speaker":
				$custom = get_post_custom();
				echo $custom["speaker"][0];
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
        'edit_item' => _x( 'Edit Person', 'people' ),
        'new_item' => _x( 'New Person', 'people' ),
        'view_item' => _x( 'View Person', 'people' ),
        'search_items' => _x( 'Search People', 'people' ),
        'not_found' => _x( 'No people found', 'people' ),
        'not_found_in_trash' => _x( 'No people found in Trash', 'people' ),
        'menu_name' => _x( 'People', 'people' ),
    );

    $args = array( 
        'labels' => $peoplelabels,
        'hierarchical' => false,
        
        'supports' => array( 'featured image', 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'tags' ),
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
		
		'taxonomies' => array('post_tag'),
		
    );

    register_post_type( 'people', $args );
}




/* People Categories */
/*-------------------------------------------------------------------------------------------*/
add_action( 'init', 'register_taxonomy_staffgroup' );

function register_taxonomy_staffgroup() {

    $labels = array( 
        'name' => _x( 'Staff Groups', 'staff group' ),
        'singular_name' => _x( 'Staff Group', 'staff group' ),
        'search_items' => _x( 'Search Staff Groups', 'staff group' ),
        'popular_items' => _x( 'Popular Staff Groups', 'staff group' ),
        'all_items' => _x( 'All Staff Groups', 'staff group' ),
        'parent_item' => _x( 'Parent Staff Group', 'staff group' ),
        'parent_item_colon' => _x( 'Parent Staff Group:', 'staff group' ),
        'edit_item' => _x( 'Edit Staff Group', 'staff group' ),
        'update_item' => _x( 'Update Staff Group', 'staff group' ),
        'add_new_item' => _x( 'Add New Staff Group', 'staff group' ),
        'new_item_name' => _x( 'New Staff Group Name', 'staff group' ),
        'separate_items_with_commas' => _x( 'Separate staff groups with commas', 'staff group' ),
        'add_or_remove_items' => _x( 'Add or remove staff groups', 'staff group' ),
        'choose_from_most_used' => _x( 'Choose from the most used staff groups', 'staff group' ),
        'menu_name' => _x( 'Staff Groups', 'staff group' ),
    );

    $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => false,
        'show_ui' => true,
        'show_tagcloud' => false,
        'hierarchical' => true,

        'rewrite' => true,
        'query_var' => true,
		/*'capabilities' => array (
            'manage_terms' => 'manage-options', //by default only admin
            'edit_terms' => 'manage-options',
            'delete_terms' => 'manage-options',
            'assign_terms' => 'edit-posts'  // 'edit-posts' option = administrator', 'editor', 'author', 'contributor'
            )
*/
    );

    register_taxonomy( 'staffgroup', array('people'), $args );
}

/* People Columns */
/*-------------------------------------------------------------------------------------------*/
 
add_filter( 'manage_edit-people_columns', 'edit_people_columns' ) ;
add_action( 'manage_people_posts_custom_column', 'manage_people_columns', 10, 2 );

function edit_people_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Name' ),
		'staffgroup' => __( 'Staff Group' ),
	);

	return $columns;
}
 

function manage_people_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		case 'title' :

			/* Get the post meta. */
			$title = get_post_meta( $post_id, 'title', true );

			/* If no title is found, output a default message. */
			if ( empty( $title ) )
				echo __( 'n/a' );

			else
				printf( $title );

			break;

		/* If displaying the 'staffgroup' column. */
		case 'staffgroup' :

			/* Get the staffgroups for the post. */
			$terms = get_the_terms( $post_id, 'staffgroup' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'staffgroup' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'staffgroup', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'not assigned' );
			}

			break;

		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
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
	'staffgroup' => 'staffgroup',
    'speaker'  => 'speaker',
	'project_date' =>	'project_date',
	'project_status' =>  'project_status',
  );
}

add_filter( "manage_edit-podcast_sortable_columns", "sortable_columns" );
add_filter( "manage_edit-project_sortable_columns", "sortable_columns" );
add_filter( "manage_edit-people_sortable_columns", "sortable_columns" );

?>