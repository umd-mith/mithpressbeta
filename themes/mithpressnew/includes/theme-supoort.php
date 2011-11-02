<?php
/*-----------------------------------------------------------------------------------

TABLE OF CONTENTS

- Basic Sidebar Widgets
- Recent Posts Widget

-----------------------------------------------------------------------------------*/

/*-----------------------------------------------------------------------------------*/
/* Thumbnail Support */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'post-thumbnails' );

function mithpress_thumbnails() {
	//update_option('thumbnail_size_w', 290);
    //update_option('thumbnail_size_h', 290);
    add_image_size( 'mini-thumbnail', 50, 50, true );
    add_image_size( 'slide', 640, 290, true );

}
add_action( 'init', 'mithpress_thumbnails' );


/*-----------------------------------------------------------------------------------*/
/* Nav Menus Support */
/*-----------------------------------------------------------------------------------*/

if ( function_exists('wp_nav_menu') ) {
	add_theme_support( 'nav-menus' );
		register_nav_menus( array( 
		'main-menu' => __( 'Main Menu' ), 
		'about-menu' => __( 'About Menu' ),
		'research-menu' => __( 'Research Menu' ),
		'community-menu' => __( 'Community Menu' ),
		'staff-menu' => __( 'Staff Menu' ),
		'footer-menu' => __( 'Footer Menu' ),
		'digital-dialogues-menu' => __( 'Digital Dialogues Menu'),
		'footer-textlinks' => __( 'Footer Text Links ' )
	)
  );
}     

/*-----------------------------------------------------------------------------------*/
/* Misc */
/*-----------------------------------------------------------------------------------*/

add_theme_support( 'automatic-feed-links' );



?>