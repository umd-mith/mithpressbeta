<?php
    /*echo "<h2>TestPlug Will Rock Your Face</h2>";
    echo "<p>Do you believe that TestPlug will rock your face?</p>\n";
    echo "Yes<input type=\"radio\" name=\"rock\" value=\"yes\" />";
    echo " &nbsp; No<input type=\"radio\" name=\"rock\" value=\"no\" />\n";
    echo "<br /><input type=\"submit\" value=\"Submit\" />\n";*/
    
    
    // variables for the field and option names 
    $opt_name = 'mt_rock';
    $hidden_field_name = 'mt_submit_hidden';
    $data_field_name = 'mt_rock';

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
	
		echo "<h2>OMGOMGOMG: " . __( 'Menu Test Plugin Options', 'mt_trans_domain' ) . "</h2>";
	
		// options form
		
		?>
	
	<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	
	<h4>This is TestPlug.  It will pretty much rock your face.</h4>
	
	<p>Do you believe that TestPlug will rock your face?</p>
	Yes <input type="radio" name="<?php echo $data_field_name; ?>" value="Y" <?php if($opt_val == "Y") echo " checked"; ?> />	&nbsp; 
	No <input type="radio" name="<?php echo $data_field_name; ?>" value="N" <?php if($opt_val == "N") echo " checked"; ?> />
	</p>	
	
	<p><?php echo ($opt_val == "Y") ? "<p>Good.  'Cause it will." : "<p><em>WHAT?</em></p>"; ?></p>
	
	<p class="submit">
	<input type="submit" name="Submit" value="Update Options" />
	</p>
	
	</form>
	</div>