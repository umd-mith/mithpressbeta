<?php
/**
 * @package MITHdb
 * @author Greg Lord
 * @version 0.1.0
 */
/*
Plugin Name: MITHdb
Plugin URI: http://zengrove.com/mithdb
Description: Administrative application for the Maryland Institute for Technology in the Humanities.
Author: Greg Lord
Version: 0.1.0
Author URI: http://zengrove.com
*/

// This just echoes the chosen line, we'll position it later
function mithQuickMenu() {
}

// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'mithQuickMenu');

add_action('admin_head', 'loadMithCss');
function loadMithCss () {
	echo '<link type="text/css" rel="stylesheet" href="' . get_bloginfo('wpurl') . '/wp-content/plugins/mithdb/css/mithdb_admin.css" />' . "\n";
}

function mith_statusText($status) {
	switch ($status) {
		case "a": 
			echo "Active";
			break;
		case "r":
			echo "Archived";
			break;
		case "d":
			echo "In Development";
			break;
		default:
			echo "- Select Status -";
			break;
		break;
	}
}



// Hook for adding admin menus
add_action('admin_menu', 'mth_add_pages');

// action function for above hook
function mth_add_pages() {
    // Add a new submenu under Options:
    add_options_page('TestPlug Options', 'MITHdb Options', 'administrator', 'testoptions', 'mth_options_page');

    // Add a new submenu under Manage:
    //add_management_page('TestPlug Manage', 'TestPlug Manage', 'administrator', 'testmanage', 'mth_manage_page');

    // Add a new top-level menu (ill-advised):
    add_menu_page('MITHdb', 'MITHdb', 'administrator', 'mth-top-level-handle', 'mth_toplevel_page');

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mth-top-level-handle', 'MITH Staff', 'MITH Staff', 'administrator', 'mith_staff', 'mth_page_staff');    
    	add_submenu_page('mth_page_staff', 'MITH New Staff', 'MITH New Staff', 'administrator', 'mith_staff_new', 'mth_staff_new');
    	add_submenu_page('mth_page_staff', 'MITH Edit Staff', 'MITH Edit Staff', 'administrator', 'mith_staff_edit', 'mth_staff_edit');
    	add_submenu_page('mth_page_staff', 'MITH Delete Staff', 'MITH Delete Staff', 'administrator', 'mith_staff_delete', 'mth_staff_delete');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('mth-top-level-handle', 'MITH Projects', 'MITH Projects', 'administrator', 'mith_projects', 'mth_page_projects');
    	$page1 = add_submenu_page('mth_page_projects', 'MITH New Project', 'MITH New Project', 'administrator', 'mith_project_new', 'mth_project_new');
    	$page2 = add_submenu_page('mth_page_projects', 'MITH Edit Project', 'MITH Edit Project', 'administrator', 'mith_project_edit', 'mth_project_edit');
    	add_submenu_page('mth_page_projects', 'MITH Delete Project', 'MITH Delete Project', 'administrator', 'mith_project_delete', 'mth_project_delete');
    	$page3 = add_submenu_page('mth_page_projects', 'MITH Project Staff', 'MITH Project Staff', 'administrator', 'mith_project_staff', 'mth_project_staff');
    		add_action('admin_print_scripts-' . $page1, 'my_plugin_admin_styles');
    		add_action('admin_print_scripts-' . $page2, 'my_plugin_admin_styles');
    		add_action('admin_print_scripts-' . $page3, 'my_plugin_admin_styles');

    
	// Add a submenu to the custom top-level menu:
    add_submenu_page('mth-top-level-handle', 'MITH Podcast', 'MITH Podcast', 'administrator', 'mith_podcast', 'mth_page_podcast');
    	add_submenu_page('mth_page_podcast', 'MITH New Podcast', 'MITH New Podcast', 'administrator', 'mith_podcast_new', 'mth_podcast_new');
    	add_submenu_page('mth_page_podcast', 'MITH Edit Podcast', 'MITH Edit Podcast', 'administrator', 'mith_podcast_edit', 'mth_podcast_edit');
    	add_submenu_page('mth_page_podcast', 'MITH Delete Podcast', 'MITH Delete Podcast', 'administrator', 'mith_podcast_delete', 'mth_podcast_delete');
    	

    // Add a second submenu to the custom top-level menu:
    //add_submenu_page('mth-top-level-handle', 'MITH Partners', 'MITH Partners', 'administrator', 'mith_partners', 'mth_page_partners');
    
	$page_front = add_submenu_page('mth-top-level-handle', 'MITH Front Page', 'MITH Front Page', 'administrator', 'mith_frontpage', 'mth_frontpage');
    		add_action('admin_print_scripts-' . $page_front, 'my_plugin_admin_styles');
    
}

// mth_manage_page() displays the page content for the Test Manage submenu
function mth_manage_page() {
    echo "<h2>TestPlug Manage</h2>";
}


// Staff Main
function mth_page_staff() {
	global $wpdb;
    echo "<h2>MITH Staff Administration</h2>";
    
    $members_current = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'current' ORDER BY mth_s_last ASC", ARRAY_A);
	$members_former = $wpdb->get_results("SELECT * FROM wp_mth_staff WHERE mth_s_status = 'former' ORDER BY mth_s_last ASC", ARRAY_A);
    
	echo "<p class=\"submit\"><a class=\"link_button\" href=\"?page=mith_staff_new\"><input type=\"submit\" name=\"Submit\" value=\"Add New Staff Member\" /></a> &nbsp; <a class=\"link_button\" href=\"?page=mith_project_staff\"><input type=\"submit\" name=\"Submit\" value=\"Assign Staff to Projects\" /></a></p>";
    
    echo "<div style='float: left; margin-right: 50px'>\n";
    echo "<h4>Current Staff</h4>\n";
    echo "<table style='width: 350px' class=\"mithadmin\">";
    foreach ($members_current as $member) {
    	echo "<tr><td style='border-bottom: 1px solid #ddd; padding: 5px'>";
    	echo $member['mth_s_last'].", ".$member['mth_s_first'];
    	echo "</td>";
    	$id = $member['mth_s_id'];
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_staff_edit&id=$id'>Edit</a></td>";
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_staff_delete&id=$id'>Delete</a></td>";
    	echo "</tr>\n";
    }    
    echo "</table>\n";
    echo "</div>\n";

    echo "<div style='float: left; margin-right: 50px'>\n"; 
    echo "<h4>Former Staff</h4>\n";
    echo "<table style='width: 350px' class=\"mithadmin\">";
    foreach ($members_former as $member) {
    	echo "<tr><td style='border-bottom: 1px solid #ddd; padding: 5px'>";
    	echo $member['mth_s_last'].", ".$member['mth_s_first'];
    	echo "</td>";
    	$id = $member['mth_s_id'];
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_staff_edit&id=$id'>Edit</a></td>";
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_staff_delete&id=$id'>Delete</a></td>";
    	echo "</tr>\n";
    }    
    echo "</table>\n";
    echo "</div>\n";
    
    echo "<div style='clear: both'></div>\n";
    
}
// Staff Administration
function mth_staff_new() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Add Staff Member</h2>";
	require_once('form_staff.php');
    
}
function mth_staff_edit() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Edit Staff Member</h2>";
	require_once('form_staff.php');
    
}
function mth_staff_delete() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Staff - Delete Staff Member</h2>";
	require_once('form_staff.php');
    
}


// Project Main
function mth_page_projects() {
	global $wpdb;
    echo "<h2>MITH Projects Administration</h2>";
    
    $projects = $wpdb->get_results("SELECT * FROM wp_mth_project ORDER BY mth_p_name ASC", ARRAY_A);
    
    echo "<p class=\"submit\" style=\"float: left\"><a class=\"link_button\" href=\"?page=mith_project_new\"><input type=\"submit\" name=\"Submit\" value=\"Create New Project\" /></a> &nbsp; <!--<a class=\"link_button\" href=\"?page=mith_project_staff\"><input type=\"submit\" name=\"Submit\" value=\"Assign Staff to Projects\" /></a>--></p>";
    echo "<div style=\"clear:both\"></div>\n";
    
    echo "<table class=\"mithadmin\">";
    echo "
	<tr>
		<th>Project</th>
		<th>Options</th>
	</tr>\n";
    
    foreach ($projects as $project) {
    	echo "<tr><td style='border-bottom: 1px solid #ddd; padding: 5px'>";
    	echo stripslashes($project['mth_p_name']);
    	echo "</td>";
    	$id = $project['mth_p_id'];
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_project_edit&id=$id'>Edit</a></td>";
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_project_delete&id=$id'>Delete</a></td>";
    	echo "</tr>\n";
    }
	
	echo "</table>\n";
    
}
// Project Administration
function mth_project_new() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Add Project</h2>";
	require_once('form_project.php');
    
}
function mth_project_edit() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Edit Project</h2>";
	require_once('form_project.php');
    
}
function mth_project_delete() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Delete Project</h2>";
	require_once('form_project.php');
 
}
function mth_project_staff() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Projects - Assign Staff to Projects</h2>";
	require_once('form_project_staff.php');
 
}

// Podcast Main
function mth_page_podcast() {
	global $wpdb;
    echo "<h2>MITH Podcast Administration</h2>";
    
    $podcasts = $wpdb->get_results("SELECT * FROM wp_mth_podcast ORDER BY mth_dd_date DESC", ARRAY_A);
    
    echo "<p class=\"submit\"><a class=\"link_button\" href=\"?page=mith_podcast_new\"><input type=\"submit\" name=\"Submit\" value=\"Add New Podcast Entry\" /></a> &nbsp; <a class=\"link_button\" href=\"?page=mth-top-level-handle\"><input type=\"button\" name=\"Edit\" value=\"View/Edit MP3 Directories\" /></a></p>";
    
    echo "<table class=\"mithadmin\">";
    echo "
	<tr>
		<th>Date</th>
		<th>Title</th>
		<th>Options</th>
	</tr>\n";
    
    foreach ($podcasts as $podcast) {
    	echo "<tr><td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 11px'>";
    	echo $podcast['mth_dd_date'];
    	echo "</td>";
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px 20px'>";
    	echo stripslashes($podcast['mth_dd_title']);
    	echo "</td>";
    	$id = $podcast['mth_dd_id'];
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_podcast_edit&id=$id'>Edit</a></td>";
    	echo "<td style='border-bottom: 1px solid #ddd; padding: 5px; font-size: 10px'><a href='?page=mith_podcast_delete&id=$id'>Delete</a></td>";
    	echo "</tr>\n";
    }
	
	echo "</table>\n";
    
}
// Podcast Administration
function mth_podcast_new() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Podcast - Add Podcast Entry</h2>";
	require_once('form_podcast.php');
    
}
function mth_podcast_edit() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Podcast - Edit Podcast Entry</h2>";
	require_once('form_podcast.php');
    
}
function mth_podcast_delete() {
	global $wpdb;
	$wpdb->show_errors();
	
	echo "<h2>MITH Podcast - Delete Podcast Entry</h2>";
	require_once('form_podcast.php');
    
}


// Front Page Main
function mth_frontpage() {	
	echo "<h2>MITH Front Page - Customization</h2>";
	require_once('form_frontpage.php');
}


// mth_toplevel_page() displays the page content for the custom Test Toplevel menu
function mth_toplevel_page() {

	require_once('form.php');

}


function my_plugin_admin_styles() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-selectable');
}


// mth_options_page() displays the page content for the Test Options submenu
function mth_options_page() {

    // variables for the field and option names 
    $opt_name = 'mth_favorite_food';
    $hidden_field_name = 'mth_submit_hidden';
    $data_field_name = 'mth_favorite_food';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mth_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Menu Test Plugin Options', 'mth_trans_domain' ) . "</h2>";

    // options form
    
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Favorite Color:", 'mth_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mth_trans_domain' ) ?>" />
</p>

</form>
</div>

<?php
}