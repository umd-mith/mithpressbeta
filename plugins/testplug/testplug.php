<?php
/**
 * @package TestPlug
 * @author Greg Lord
 * @version 0.1.0
 */
/*
Plugin Name: TestPlug
Plugin URI: http://zengrove.com/testplug
Description: You can't even begin to believe how awesome this plugin is.  Get ready for absolutely everything you know about the word "Test" appearing at the bottom of your pages to change.
Author: Greg Lord
Version: 0.1.0
Author URI: http://zengrove.com
*/

// This just echoes the chosen line, we'll position it later
function testPlug() {
	echo "<p id='testplug'>Test.</p>";
}

// Now we set that function up to execute when the admin_footer action is called
add_action('admin_footer', 'testPlug');



/*
// BROKEN-ISH
// The below adds an administrative menu at the admin_menu hook
add_action('admin_menu', 'my_plugin_menu');

function my_plugin_menu() {
  add_options_page('TestPlug Options', 'TestPlug', '10', 'basename(__FILE__)', 'array(&$this, "method")');
}

function my_plugin_options() {
  echo '<div class="wrap">';
  echo '<p>Here is where the form would go if I actually had options.</p>';
  echo '</div>';
}
*/

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Options:
    add_options_page('TestPlug Options', 'TestPlug Options', 'administrator', 'testoptions', 'mt_options_page');

    // Add a new submenu under Manage:
    add_management_page('TestPlug Manage', 'TestPlug Manage', 'administrator', 'testmanage', 'mt_manage_page');

    // Add a new top-level menu (ill-advised):
    add_menu_page('TestPlug Toplevel', 'TestPlug Toplevel', 'administrator', 'mt-top-level-handle', 'mt_toplevel_page');

    // Add a submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', 'Test Sublevel', 'Test Sublevel', 'administrator', 'sub-page', 'mt_sublevel_page');

    // Add a second submenu to the custom top-level menu:
    add_submenu_page('mt-top-level-handle', 'Test Sublevel 2', 'Test Sublevel 2', 'administrator', 'sub-page2', 'mt_sublevel_page2');
}

/*// mt_options_page() displays the page content for the Test Options submenu
function mt_options_page() {
    echo "<h2>TestPlug Options</h2>";
}*/

// mt_manage_page() displays the page content for the Test Manage submenu
function mt_manage_page() {
    echo "<h2>TestPlug Manage</h2>";
}


// mt_sublevel_page() displays the page content for the first submenu
// of the custom Test Toplevel menu
function mt_sublevel_page() {
    echo "<h2>TestPlug Sublevel</h2>";
}

// mt_sublevel_page2() displays the page content for the second submenu
// of the custom Test Toplevel menu
function mt_sublevel_page2() {
    echo "<h2>TestPlug Sublevel 2</h2>";
}



// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
function mt_toplevel_page() {

	require_once('form.php');

}


// mt_options_page() displays the page content for the Test Options submenu
function mt_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_favorite_food';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'mt_favorite_food';

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
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'Menu Test Plugin Options', 'mt_trans_domain' ) . "</h2>";

    // options form
    
    ?>

<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Favorite Color:", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="20">
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p>

</form>
</div>

<?php
 
}



?>
