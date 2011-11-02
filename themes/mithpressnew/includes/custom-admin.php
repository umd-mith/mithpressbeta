<?php 

// ****** ADMIN FUNCTIONS ********* //

/* Rewrite Guest Author’s Name with Custom Fields */
//Now every time there is a guest post, simply add the custom field guest-author.

    add_filter( 'the_author', 'guest_author_name' );
    add_filter( 'get_the_author_display_name', 'guest_author_name' );

    function guest_author_name( $name ) {
    global $post;

    $author = get_post_meta( $post->ID, 'guest-author', true );

    if ( $author )
    $name = $author;

    return $name;
    }

// Custom default gravatar image 
 add_filter( 'avatar_defaults', 'newgravatar' );

    function newgravatar ($avatar_defaults) {
    $myavatar = get_bloginfo('template_directory') . '/images/gravatar.gif';
    $avatar_defaults[$myavatar] = "WPBeginner";
    return $avatar_defaults;
    }


// CUSTOM ADMIN MENU LINK FOR ALL SETTINGS
   function all_settings_link() {
    add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
   }
   add_action('admin_menu', 'all_settings_link');

// REMOVE THE WORDPRESS UPDATE NOTIFICATION FOR ALL USERS EXCEPT SYSADMIN
       global $user_login;
       get_currentuserinfo();
       if (!current_user_can('update_plugins')) { // checks to see if current user can update plugins 
        add_action( 'init', create_function( '$a', "remove_action( 'init', 'wp_version_check' );" ), 2 );
        add_filter( 'pre_option_update_core', create_function( '$a', "return null;" ) );
       }
// CUSTOM ADMIN LOGIN HEADER LOGO
   function my_custom_login_logo() {
    echo '<style type="text/css"> h1 a { background-image:url('.get_bloginfo('template_directory').'/images/your-logo-image.png) !important; } </style>';
   }
   add_action('login_head', 'my_custom_login_logo');


// CUSTOM ADMIN LOGIN HEADER LINK & ALT TEXT
   function change_wp_login_url() {
    echo bloginfo('url');  // OR ECHO YOUR OWN URL
   }
   function change_wp_login_title() {
    echo get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
   }
   add_filter('login_headerurl', 'change_wp_login_url');
   add_filter('login_headertitle', 'change_wp_login_title');
   
// MAKE CUSTOM POST TYPES SEARCHABLE
function searchAll( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'site','plugin', 'theme','person' )); } 
 return $query;
}
add_filter( 'the_search_query', 'searchAll' );


// CUSTOM USER PROFILE FIELDS
   function my_custom_userfields( $contactmethods ) {

    // ADD CONTACT CUSTOM FIELDS
    $contactmethods['contact_phone_office']     = 'Office Phone';
    $contactmethods['contact_phone_mobile']     = 'Mobile Phone';
    $contactmethods['contact_office_fax']       = 'Office Fax';

    // ADD ADDRESS CUSTOM FIELDS
    $contactmethods['address_line_1']       = 'Address Line 1';
    $contactmethods['address_line_2']       = 'Address Line 2 (optional)';
    $contactmethods['address_city']         = 'City';
    $contactmethods['address_state']        = 'State';
    $contactmethods['address_zipcode']      = 'Zipcode';
    return $contactmethods;
   }
   add_filter('user_contactmethods','my_custom_userfields',10,1);

// OUTPUT WHICH TEMPLATE A PAGE/POST IS USING IN THE HEADER
add_action('wp_head', 'show_template');
function show_template() {
    global $template;
    print_r($template);
}


// ENABLE SHORTCODES IN WIDGETS 
if ( !is_admin() ){
    add_filter('widget_text', 'do_shortcode', 11);
}


?>