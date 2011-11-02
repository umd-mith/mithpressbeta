<?php

if ($_POST['submit'] && ($_POST['hidden_value'] == "y")) {

	if (isset($_POST['mth_dd_id'])) {	
		
		$wpdb->update(
			'wp_mth_podcast',
			array( 
				'mth_dd_title' => $_POST['mth_dd_title'],
				'mth_dd_speaker' => $_POST['mth_dd_speaker'],
				'mth_dd_affiliation' => $_POST['mth_dd_affiliation'],
				'mth_dd_date' => $_POST['mth_dd_date'],
				'mth_dd_desc' => $_POST['mth_dd_desc'],
				'mth_dd_audio' => $_POST['mth_dd_audio'],
				'mth_dd_slides' => $_POST['mth_dd_slides'],
				'mth_dd_url' => $_POST['mth_dd_url'],
				'mth_dd_duration' => $_POST['mth_dd_duration'],
				'mth_dd_length' => $_POST['mth_dd_length'],
				'mth_dd_tags' => $_POST['mth_dd_tags']
			),
			array ( 'mth_dd_id' => $_POST['mth_dd_id'] )
		);
	
		echo "<div class=\"updated\"><p><strong>Podcast updates saved.</strong></p></div>\n";
		echo "<div class=\"updated\"><p><strong>";
		require_once('rss_regen.php');
		echo "</strong></p></div>\n";
	
	} elseif (isset($_POST['new'])) {

		$wpdb->query( 
			$wpdb->prepare( "
				INSERT INTO wp_mth_podcast (
					mth_dd_id,
					mth_dd_title,
					mth_dd_speaker,
					mth_dd_affiliation,
					mth_dd_date,
					mth_dd_desc,
					mth_dd_audio,
					mth_dd_slides,
					mth_dd_url,
					mth_dd_duration,
					mth_dd_length,
					mth_dd_tags
				) VALUES ( 
					'', 
					%s, 
					%s,
					%s,
					%s,
					%s,
					%s,
					%s,
					%s,
					%s,
					%s,
					%s
				)", 
        			$_POST['mth_dd_title'], 
        			$_POST['mth_dd_speaker'],
        			$_POST['mth_dd_affiliation'],
        			$_POST['mth_dd_date'],
        			$_POST['mth_dd_desc'],
        			$_POST['mth_dd_audio'],
        			$_POST['mth_dd_slides'],
        			$_POST['mth_dd_url'],
        			$_POST['mth_dd_duration'],
        			$_POST['mth_dd_length'],
        			$_POST['mth_dd_tags']
        	) 
        );

		
		echo "<div class=\"updated\"><p><strong>Podcast entry added.</strong></p></div>\n";
		
		include_once('./rss_regen.php');
		
	} elseif (isset($_POST['confirm_delete'])) {
		
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM wp_mth_podcast WHERE mth_dd_id = '{$_POST['confirm_delete']}'"
			)
		);
		
		//mth_page_projects();
		echo "<div class=\"updated\"><p><strong>Podcast entry deleted.</strong></p></div>\n";
		echo "<p class=\"submit\">
		<a href=\"?page=mith_podcast\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Return to Podcast List\" /></a></p>";		
		return;
		
	}

}
    
?>

<form name="form1" method="post" action="">
    
<?php

// Get the project info from the GET id
$podcast = $wpdb->get_row( $wpdb->prepare("SELECT * FROM wp_mth_podcast WHERE mth_dd_id = '{$_GET['id']}'" ), ARRAY_A);

// If we're NOT deleting...
if ($_GET['page'] != "mith_podcast_delete") {
	
	// ... and we DO have a GET id
	if ($_GET['id']) {
	
		// Generate the hidden key for our update query
		echo "<input type=\"hidden\" name=\"mth_dd_id\" value=\"".$_GET['id']."\" />\n";
	
	// ... if not, 
	} else {
		
		// Feed our form the "new" hidden key
		echo "<input type=\"hidden\" name=\"new\" value=\"1\" />\n";
	
	}
}

$disabled = "";
if ($_GET['page'] == "mith_podcast_delete") {
	$disabled = "disabled";
	
	// Warning message
	echo "<div class=\"error\"><p><strong>Are you sure you want to delete the following entry?</strong> Please note that editing is disabled on the following form.</p></div>";
	
	// Delete/Edit/Cancel bar
	echo "	
	<p class=\"submit\">
	<a href=\"?page=mith_podcast\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Cancel and Return to Podcast List\" /></a>
	
	<a href=\"?page=mith_podcast_edit&id={$_GET['id']}\" class=\"link_button\"><input type=\"button\" name=\"edit\" value=\"Edit this Podcast Entry\" /></a>	
	
	<input type=\"submit\" name=\"submit\" value=\"Delete this Podcast Entry\" /></a>
	</p>\n";
	
	// Deletion confirmation key
	echo "<input type=\"hidden\" name=\"confirm_delete\" value=\"{$_GET['id']}\" />";
	
}

?>

<input type="hidden" name="hidden_value" value="y" />

<table class="form mithadmin">
	<tr>
		<td class="label"><label for="mth_dd_id">Title</label></td>
		<td><input type="text" name="mth_dd_title" value="<?= stripslashes($podcast['mth_dd_title']) ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_speaker">Speaker</label></td>
		<td><input type="text" name="mth_dd_speaker" value="<?= stripslashes($podcast['mth_dd_speaker']) ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_affiliation">Affiliation</label></td>
		<td>
			<input type="text" name="mth_dd_affiliation" value="<?= stripslashes($podcast['mth_dd_affiliation']) ?>" <?= $disabled ?>/> <small>(Optional)</small>
		</td>
	</tr>	
	<tr>
		<td class="label"><label for="mth_dd_date">Date</label></td>
		<td>
			<input type="text" name="mth_dd_date" value="<?= stripslashes($podcast['mth_dd_date']) ?>" <?= $disabled ?>/> <small>(YYYY-MM-DD)</small>
		</td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_desc">Description</label></td>
		<td><textarea name="mth_dd_desc" <?= $disabled ?>><?= stripslashes($podcast['mth_dd_desc']) ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_audio">Audio Filename</label></td>
		<td><input type="text" name="mth_dd_audio" value="<?= $podcast['mth_dd_audio'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_slides">Slides Filename</label></td>
		<td><input type="text" name="mth_dd_slides" value="<?= $podcast['mth_dd_slides'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_url">Related URL</label></td>
		<td><input type="text" name="mth_dd_url" value="<?= $podcast['mth_dd_url'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_duration">Duration</label></td>
		<td><input type="text" name="mth_dd_duration" value="<?= $podcast['mth_dd_duration'] ?>" <?= $disabled ?>/> <small>(HH:MM:SS)</small><br /><small>(To find this on Mac: Right click MP3 &gt; Get Info &gt; Look for &quot;More Info&quot; &gt; &quot;<strong>Duration</strong>&quot; in HH:MM:SS)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_length">Filesize</label></td>
		<td><input type="text" name="mth_dd_length" value="<?= $podcast['mth_dd_length'] ?>" <?= $disabled ?>/> <small>(in bytes)</small><br /><small>(Right click MP3 &gt; Get Info &gt; Look for &quot;General&quot; &gt; &quot;<strong>Size</strong>&quot; and enter full &quot;Bytes&quot; number <strong>without</strong> commas)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_dd_tags">Tags</label></td>
		<td><input type="text" name="mth_dd_tags" value="<?= $podcast['mth_dd_tags'] ?>" <?= $disabled ?>/> <small>(Optional)</small><br /><small>(Up to 12, separated by commas -- two of these should always be "mith, digitaldialogues")</small></td>
	</tr>
</table>

<?php 
	if ($_GET['page'] != "mith_podcast_delete") :
?>

<p class="submit"><a href="?page=mith_podcast">&laquo; Cancel and Return to Podcast List</a> &nbsp; <input type="submit" name="submit" value="Save Podcast Entry Details" /></p>

<?php
	endif;
?>
</form>