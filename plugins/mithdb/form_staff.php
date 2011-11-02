<?php

if ($_POST['submit'] && ($_POST['hidden_value'] == "y")) {

	if (isset($_POST['mth_s_id'])) {
		$wpdb->update(
			'wp_mth_staff',
			array( 
				'mth_s_last' => $_POST['mth_s_last'],
				'mth_s_first' => $_POST['mth_s_first'],
				'mth_s_middle' => $_POST['mth_s_middle'],
				'mth_s_title' => $_POST['mth_s_title'],
				'mth_s_bio' => $_POST['mth_s_bio'],
				'mth_s_img' => $_POST['mth_s_img'],
				'mth_s_status' => $_POST['mth_s_status'],
				'mth_s_group' => $_POST['mth_s_group'],
				'mth_s_order' => $_POST['mth_s_order'],
				'mth_s_email' => $_POST['mth_s_email'],
				'mth_s_url' => $_POST['mth_s_url'],
				'mth_s_im' => $_POST['mth_s_im'],
				'mth_s_twitter' => $_POST['mth_s_twitter']
			),
			array ( 'mth_s_id' => $_POST['mth_s_id'] )
		);
	
		echo "<div class=\"updated\"><p><strong>Staff updates saved.</strong></p></div>\n";
	
	} elseif (isset($_POST['new'])) {

		$wpdb->query( 
			$wpdb->prepare( "
				INSERT INTO wp_mth_staff (
					mth_s_id,
					mth_s_last,
					mth_s_first,
					mth_s_middle,
					mth_s_title,
					mth_s_bio,
					mth_s_img,
					mth_s_status,
					mth_s_group,
					mth_s_order,
					mth_s_email,
					mth_s_url,
					mth_s_im,
					mth_s_twitter
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
					%s,
					%s,
					%s
				)", 
        			$_POST['mth_s_last'], 
        			$_POST['mth_s_first'],
        			$_POST['mth_s_middle'],
        			$_POST['mth_s_title'],
        			$_POST['mth_s_bio'],
        			$_POST['mth_s_img'],
        			$_POST['mth_s_status'],
        			$_POST['mth_s_group'],
					$_POST['mth_s_order'],
        			$_POST['mth_s_email'],
        			$_POST['mth_s_url'],
        			$_POST['mth_s_im'],
        			$_POST['mth_s_twitter']
        	) 
        );

		
		echo "<div class=\"updated\"><p><strong>Staff entry added.</strong></p></div>\n";
		
	} elseif (isset($_POST['confirm_delete'])) {
		
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM wp_mth_staff WHERE mth_s_id = '{$_POST['confirm_delete']}'"
			)
		);
		
		echo "<div class=\"updated\"><p><strong>Staff entry deleted.</strong></p></div>\n";
		echo "<p class=\"submit\">
		<a href=\"?page=mith_staff\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Return to Staff List\" /></a></p>";		
		return;
		
	}

}
    
?>

<form name="form1" method="post" action="">
    
<?php

// Get the member info from the GET id
$member = $wpdb->get_row( $wpdb->prepare("SELECT * FROM wp_mth_staff WHERE mth_s_id = '{$_GET['id']}'" ), ARRAY_A);

// If we're NOT deleting...
if ($_GET['page'] != "mith_staff_delete") {
	
	// ... and we DO have a GET id
	if ($_GET['id']) {
	
		// Generate the hidden key for our update query
		echo "<input type=\"hidden\" name=\"mth_s_id\" value=\"".$_GET['id']."\" />\n";
	
	// ... if not, 
	} else {
		
		// Feed our form the "new" hidden key
		echo "<input type=\"hidden\" name=\"new\" value=\"1\" />\n";
	
	}
}

$disabled = "";
if ($_GET['page'] == "mith_staff_delete") {
	$disabled = "disabled";
	
	// Warning message
	echo "<div class=\"error\"><p><strong>Are you sure you want to delete the following entry?</strong> Please note that editing is disabled on the following form.</p></div>";
	
	// Delete/Edit/Cancel bar
	echo "	
	<p class=\"submit\">
	<a href=\"?page=mith_staff\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Cancel and Return to Staff List\" /></a>
	
	<a href=\"?page=mith_staff_edit&id={$_GET['id']}\" class=\"link_button\"><input type=\"button\" name=\"edit\" value=\"Edit this Entry\" /></a>	
	
	<input type=\"submit\" name=\"submit\" value=\"Delete this Entry\" /></a>
	</p>\n";
	
	// Deletion confirmation key
	echo "<input type=\"hidden\" name=\"confirm_delete\" value=\"{$_GET['id']}\" />";
	
}

// Prepare plain-text "Group" listing for <select> dropdown
if ($member['mth_s_group']):
	$group = "";
	switch ($member['mth_s_group']) {
		case "d":
			$group = "Directors";
			break;
		case "f":
			$group = "Fellows";
			break;
		case "s":
			$group = "Staff";
			break;
    case "r":
      $group = "Research Associates";
      break;
		case "p":
			$group = "Program Associates";
			break;
		case "b":
			$group = "Finance and Administration";
			break;
		break;
	}
endif;

?>

<input type="hidden" name="hidden_value" value="y" />

<table class="form mithadmin">
	<tr>
		<td class="label">
			<label for="mth_p_id">Staff Member Name 
			<br /><small>(First / Middle / Last)</small></label>
		</td>
		<td>
			<input type="text" name="mth_s_first" value="<?= stripslashes($member['mth_s_first']) ?>" <?= $disabled ?>/>
			<br />
			<input type="text" name="mth_s_middle" value="<?= stripslashes($member['mth_s_middle']) ?>" <?= $disabled ?>/>
			<small>(Optional)</small>
			<br />
			<input type="text" name="mth_s_last" value="<?= stripslashes($member['mth_s_last']) ?>" <?= $disabled ?>/>
		</td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_tagline">Staff Member Title</label></td>
		<td><input type="text" name="mth_s_title" value="<?= stripslashes($member['mth_s_title']) ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_bio">Brief Biography</label></td>
		<td><textarea name="mth_s_bio" <?= $disabled ?>><?= stripslashes($member['mth_s_bio']) ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_img">Staff Image</label></td>
		<td><input type="text" name="mth_s_img" value="<?= $member['mth_s_img'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_status">Status</label></td>
		<td>
			<select name="mth_s_status" <?= $disabled ?>>
				<?php if ($member['mth_s_status'] != null): ?>
				<option value="<?= $member['mth_s_status'] ?>"><?= ucFirst($member['mth_s_status']) ?></option>
				<?php else: ?>
				<option value="-">- Select Status -</option>
				<?php endif; ?>
				<option disabled>---------------</option>
				<option value="current">Current</option>
				<option value="former">Former</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_group">Staff Group</label></td>
		<td>
			<select name="mth_s_group" <?= $disabled ?>>
				<?php if ($member['mth_s_group'] != null): ?>
				<option value="<?= $member['mth_s_group'] ?>"><?= $group ?></option>
				<?php else: ?>
				<option value="-">- Select Group -</option>
				<?php endif; ?>
				<option disabled>--------------------</option>
				<option value="d">Directors</option>
				<option value="b">Finance and Administration</option>
				<option value="s">Staff</option>
				<option value="f">Fellows</option>
				<option value="r">Research Associates</option>
				<option value="p">Program Associates</option>
			</select>
			<small>(You may specify the order of this group's members with the number below)</small>
		</td>
	</tr>	
	<tr>
		<td class="label"><label for="mth_s_order">Order Within Group</label></td>
		<td><input type="text" name="mth_s_order" value="<?= $member['mth_s_order'] ?>" <?= $disabled ?>/> <small>0->9 = First->Last <br />Default (9) = Sort Alphabetically</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_email">Email Address</label></td>
		<td><input type="text" name="mth_s_email" value="<?= $member['mth_s_email'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_url">Homepage URL</label></td>
		<td><input type="text" name="mth_s_url" value="<?= $member['mth_s_url'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_im">IM Username</label></td>
		<td><input type="text" name="mth_s_im" value="<?= $member['mth_s_im'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_s_twitter">Twitter Name</label></td>
		<td><input type="text" name="mth_s_twitter" value="<?= $member['mth_s_twitter'] ?>" <?= $disabled ?>/> <small>(Optional)</small></td>
	</tr>
</table>

<?php 
	if ($_GET['page'] != "mith_staff_delete") :
?>

<p class="submit"><a href="?page=mith_staff">&laquo; Cancel and Return to Staff List</a> &nbsp; <input type="submit" name="submit" value="Save Staff Entry Details" /></p>

<?php
	endif;
?>
</form>