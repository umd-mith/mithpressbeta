<?php
    
    // variables for the field and option names 
    $opt_name = 'mth_mp3_dir_server';
    $data_field_name = 'mth_mp3_dir_server';
    
    $opt2_name = 'mth_mp3_dir_url';
    $data2_field_name = 'mth_mp3_dir_url';
    
    $opt3_name = 'mth_slides_dir_server';
    $opt4_name = 'mth_slides_dir_url';
    $data3_field_name = 'mth_slides_dir_server';
    $data4_field_name = 'mth_slides_dir_url';
    
    $hidden_field_name = 'mt_submit_hidden';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $opt2_val = get_option( $opt2_name );
    $opt3_val = get_option( $opt3_name );
    $opt4_val = get_option( $opt4_name );

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
        
        // Second pair
        $opt2_val = $_POST[ $data2_field_name ];
        update_option( $opt2_name, $opt2_val );
        
        $opt3_val = $_POST[ $data3_field_name ];
        update_option( $opt3_name, $opt3_val );
        
        $opt4_val = $_POST[ $data4_field_name ];
        update_option( $opt4_name, $opt4_val );

        // Put an options updated message on the screen

?>
	<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
	<?php
	
		}
	
		// Now display the options editing screen
	
		echo '<div class="wrap">';
	
		// header
	
		echo "<h2>" . __( 'MITHdb Plugin Administration', 'mt_trans_domain' ) . "</h2>";
	
		// options form
		
		?>
	
	
<h3>Configuration Options</h3>
	
	<form name="form1" method="post" action="">
	<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
	
	<h4>Podcast MP3 Directory<br />
	<small>(Directory to store podcast audio files. This should be a fairly permanent location to protect subscriptions.)</small></h4>
	
	<table class="form mithadmin">
		<tr>
			<td class="label">
				<label for="<?= $data_field_name ?>">Server Path</label>
			</td>
			<td>
				<input type="text" name="<?php echo $data_field_name; ?>" value="<?= $opt_val ?>" />
				<br />
				<small>(By default this is: <strong>/export/software/www/sites/mith/digitaldialogues/mp3/</strong> )</small>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="<?= $data2_field_name ?>">URL Path</label>
			</td>
			<td>
				<input type="text" name="<?php echo $data2_field_name; ?>" value="<?= $opt2_val ?>" />
				<br />
				<small>(By default this is: <strong>http://mith.umd.edu/digitaldialogues/mp3/</strong> )</small>
			</td>
		</tr>
	</table>
	
	<h4>Digital Dialogues Slides Directory<br />
	<small>(Directory to store speakers' slideshow files (Powerpoint, PDF, etc.)</small></h4>
	
	<table class="form mithadmin">
		<tr>
			<td class="label">
				<label for="<?= $data3_field_name ?>">Server Path</label>
			</td>
			<td>
				<input type="text" name="<?php echo $data3_field_name; ?>" value="<?= $opt3_val ?>" />
				<br />
				<small>(By default this is: <strong>/export/software/www/sites/mith/digitaldialogues/slides/</strong> )</small>
			</td>
		</tr>
		<tr>
			<td class="label">
				<label for="<?= $data4_field_name ?>">URL Path</label>
			</td>
			<td>
				<input type="text" name="<?php echo $data4_field_name; ?>" value="<?= $opt4_val ?>" />
				<br />
				<small>(By default this is: <strong>http://mith.umd.edu/digitaldialogues/slides/</strong> )</small>
			</td>
		</tr>
	</table>
	
	<p class="submit">
	<input type="submit" name="Submit" value="Update Options" />
	</p>
	
	</form>
	</div>