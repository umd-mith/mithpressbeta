<?php

if ($_POST['submit'] && ($_POST['hidden_value'] == "y")) {

	if (isset($_POST['mth_p_id'])) {
	
		$wpdb->update(
			'wp_mth_project',
			array( 
				'mth_p_name' => $_POST['mth_p_name'],
				'mth_p_tagline' => $_POST['mth_p_tagline'],
				'mth_p_desc_short' => $_POST['mth_p_desc_short'],
				'mth_p_desc_long' => $_POST['mth_p_desc_long'],
				'mth_p_desc_quote' => $_POST['mth_p_desc_quote'],
				'mth_p_url' => $_POST['mth_p_url'],
				'mth_p_icon' => $_POST['mth_p_icon'],
				'mth_p_banner' => $_POST['mth_p_banner'],
				'mth_p_start' => $_POST['mth_p_start'],
				'mth_p_end' => $_POST['mth_p_end'],
				'mth_p_launch' => $_POST['mth_p_launch'],
				'mth_p_status' => $_POST['mth_p_status'],
				'mth_p_type' => $_POST['mth_p_type'],
				'mth_p_platform' => $_POST['mth_p_platform'],
				'mth_p_license' => $_POST['mth_p_license'],
				'mth_p_stafflist' => $_POST['mth_p_stafflist'],
				'mth_p_related' => $_POST['mth_p_related'],
				'mth_p_contact' => $_POST['mth_p_contact'],
				'mth_p_email' => $_POST['mth_p_email']
			),
			array ( 'mth_p_id' => $_POST['mth_p_id'] )
		);
	
		echo "<div class=\"updated\"><p><strong>Project updates saved.</strong></p></div>\n";
	
	} elseif (isset($_POST['new'])) {

		$wpdb->query( 
			$wpdb->prepare( "
				INSERT INTO wp_mth_project (
					mth_p_id,
					mth_p_name,
					mth_p_tagline,
					mth_p_desc_short,
					mth_p_desc_long,
					mth_p_desc_quote,
					mth_p_url,
					mth_p_icon,
					mth_p_banner,
					mth_p_start,
					mth_p_end,
					mth_p_launch,
					mth_p_status,
					mth_p_type,
					mth_p_platform,
					mth_p_license,
					mth_p_stafflist,
					mth_p_related,
					mth_p_contact,
					mth_p_email
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
					%s,
					%s,
					%s,
					%s,
					%s,
					%s,
					%s
				)", 
        			$_POST['mth_p_name'], 
        			$_POST['mth_p_tagline'],
        			$_POST['mth_p_desc_short'],
        			$_POST['mth_p_desc_long'],
        			$_POST['mth_p_desc_long'],
        			$_POST['mth_p_url'],
        			$_POST['mth_p_icon'],
        			$_POST['mth_p_banner'],
        			$_POST['mth_p_start'],
        			$_POST['mth_p_end'],
        			$_POST['mth_p_launch'],
        			$_POST['mth_p_status'],
        			$_POST['mth_p_type'],
        			$_POST['mth_p_platform'],
        			$_POST['mth_p_license'],
        			$_POST['mth_p_stafflist'],
        			$_POST['mth_p_related'],
        			$_POST['mth_p_contact'],
        			$_POST['mth_p_email']
        	) 
        );

		
		echo "<div class=\"updated\"><p><strong>Project added.</strong></p></div>\n";
		
	} elseif (isset($_POST['confirm_delete'])) {
		
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM wp_mth_project WHERE mth_p_id = '{$_POST['confirm_delete']}'"
			)
		);
		
		//mth_page_projects();
		echo "<div class=\"updated\"><p><strong>Project deleted.</strong></p></div>\n";
		echo "<p class=\"submit\">
		<a href=\"?page=mith_projects\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Return to Project List\" /></a></p>";		
		return;
		
	}

}
    
?>

<form name="form1" method="post" action="">
    
<?php

// Get the project info from the GET id
$project = $wpdb->get_row( $wpdb->prepare("SELECT * FROM wp_mth_project WHERE mth_p_id = '{$_GET['id']}'" ), ARRAY_A);

// If we're NOT deleting...
if ($_GET['page'] != "mith_project_delete") {
	
	// ... and we DO have a GET id
	if ($_GET['id']) {
	
		// Generate the hidden key for our update query
		echo "<input type=\"hidden\" name=\"mth_p_id\" value=\"".$_GET['id']."\" />\n";
	
	// ... if not, 
	} else {
		
		// Feed our form the "new" hidden key
		echo "<input type=\"hidden\" name=\"new\" value=\"1\" />\n";
	
	}
}

$disabled = "";
if ($_GET['page'] == "mith_project_delete") {
	$disabled = "disabled";
	
	// Warning message
	echo "<div class=\"error\"><p><strong>Are you sure you want to delete the following entry?</strong> Please note that editing is disabled on the following form.</p></div>";
	
	// Delete/Edit/Cancel bar
	echo "	
	<p class=\"submit\">
	<a href=\"?page=mith_projects\" class=\"link_button\"><input type=\"button\" value=\"&laquo; Cancel and Return to Project List\" /></a>
	
	<a href=\"?page=mith_project_edit&id={$_GET['id']}\" class=\"link_button\"><input type=\"button\" name=\"edit\" value=\"Edit this Project\" /></a>	
	
	<input type=\"submit\" name=\"submit\" value=\"Delete this Project\" /></a>
	</p>\n";
	
	// Deletion confirmation key
	echo "<input type=\"hidden\" name=\"confirm_delete\" value=\"{$_GET['id']}\" />";
	
}

?>

<input type="hidden" name="hidden_value" value="y" />

<table class="form mithadmin">
	<tr>
		<td class="label"><label for="mth_p_id">Project Name</label></td>
		<td><input type="text" name="mth_p_name" value="<?= stripslashes($project['mth_p_name']) ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_tagline">Project Tagline</label></td>
		<td><input type="text" name="mth_p_tagline" value="<?= stripslashes($project['mth_p_tagline']) ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_desc_short">Description (Short)</label></td>
		<td><textarea name="mth_p_desc_short" <?= $disabled ?>><?= stripslashes($project['mth_p_desc_short']) ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_desc_long">Description (Long)</label></td>
		<td><textarea name="mth_p_desc_long" <?= $disabled ?>><?= stripslashes($project['mth_p_desc_long']) ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_desc_quote">Description (Quote)</label></td>
		<td><textarea name="mth_p_desc_quote" <?= $disabled ?>><?= stripslashes($project['mth_p_desc_quote']) ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_url">Project URL</label></td>
		<td><input type="text" name="mth_p_url" value="<?= $project['mth_p_url'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_icon">Icon File</label></td>
		<td><input type="text" name="mth_p_icon" value="<?= $project['mth_p_icon'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_banner">Project Page Image</label></td>
		<td><input type="text" name="mth_p_banner" value="<?= $project['mth_p_banner'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_start">Start Date</label></td>
		<td><input type="text" name="mth_p_start" value="<?= $project['mth_p_start'] ?>" <?= $disabled ?>/> <small>(YYYY-MM-DD)</small></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_end">End Date</label></td>
		<td><input type="text" name="mth_p_end" value="<?= $project['mth_p_end'] ?>" <?= $disabled ?>/> <small>(YYYY-MM-DD)</small></td>
	</tr>	
	<tr>
		<td class="label"><label for="mth_p_launch">Launch Date</label></td>
		<td><input type="text" name="mth_p_launch" value="<?= $project['mth_p_launch'] ?>" <?= $disabled ?>/> <small>(YYYY-MM-DD)</small></td>
	</tr>	
	<tr>
		<td class="label"><label for="mth_p_status">Project Status</label></td>
		<td>
			<select name="mth_p_status" <?= $disabled ?>>
				<?php if ($project['mth_p_status'] != null): ?>
				<option value="<?= $project['mth_p_status'] ?>"><?php mith_StatusText($project['mth_p_status']) ?></option>
				<?php else: ?>
				<option value="-">- Select Status -</option>
				<?php endif; ?>
				<option disabled>---------------</option>
				<option value="a">Active</option>
				<option value="r">Archived</option>
				<option value="d">In Development</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_type">Project Type</label></td>
		<td>
			<select name="mth_p_type" <?= $disabled ?>>
				<?php if ($project['mth_p_type'] != null): ?>
				<option value="<?= $project['mth_p_type'] ?>"><?= ucFirst($project['mth_p_type']) ?></option>
				<?php else: ?>
				<option value="-">- Select Type -</option>
				<?php endif; ?>
				<option disabled>---------------</option>
				<option value="project">Project</option>
				<option value="event">Event</option>
			</select>
		</td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_platform">Platform</label></td>
		<td><textarea name="mth_p_platform" <?= $disabled ?>><?= $project['mth_p_platform'] ?></textarea></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_license">Project License</label></td>
		<td><input type="text" name="mth_p_license" value="<?= $project['mth_p_license'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_contact">Contact Name</label></td>
		<td><input type="text" name="mth_p_contact" value="<?= $project['mth_p_contact'] ?>" <?= $disabled ?>/></td>
	</tr>
	<tr>
		<td class="label"><label for="mth_p_email">Contact Email</label></td>
		<td><input type="text" name="mth_p_email" value="<?= $project['mth_p_email'] ?>" <?= $disabled ?>/></td>
	</tr>
	
	<tr>
		<td class="label"><label for="mth_p_s">Participating Staff</label></td>
		<td>
			<div id="sortDrop" class="sortGroup" style="float: left; margin-right: 10px">
				<?php
				
					if ($project['mth_p_stafflist']) {
					
						$stafflist = array();
						$staff1 = explode("&",$project['mth_p_stafflist']);
						foreach ($staff1 as $staff) {
							$staff2 = explode("=",$staff);
							$stafflist[] = $staff2[1];
						}
						$stafflist = implode(",",$stafflist);
						//print_r($stafflist);
						$members = $wpdb->get_results( $wpdb->prepare("SELECT mth_s_id,mth_s_last,mth_s_first FROM wp_mth_staff WHERE mth_s_id IN ($stafflist) ORDER BY FIELD(mth_s_id, $stafflist)" ), ARRAY_A);
						foreach ($members as $member) {
							//print_r($member);
							echo "<li class=\"staff_members\" id=\"s_{$member['mth_s_id']}\">{$member['mth_s_last']}, {$member['mth_s_first']}</li>";
						}
					
					}
				
				?>
				<p><small><strong>Drop names here.</strong> (Project pages will show staff in this order)</small></p>
			</div>
			
			<?php 
				if ($_GET['page'] != "mith_project_delete") :
			?>
			
			<input type="button" id="showHideStaff" value="Show/Hide Staff List" style="width: 120px; font-size: 10px; font-weight: bold" />
			<input type="hidden" id="mth_p_stafflist" name="mth_p_stafflist" value="<?= $project['mth_p_stafflist'] ?>" />
			<br /><small>(Click to add names)</small>
			
			<?php
				endif;
			?>
			
			
			<div id="staff_window" style="display: none; clear: both; padding-top: 5px;">
				<ul id="sortGrab" class="sortGroup">

				<?php
					$members = $wpdb->get_results("SELECT mth_s_id,mth_s_last,mth_s_first FROM wp_mth_staff ORDER BY mth_s_last ASC", ARRAY_A);
					foreach ($members as $member) {
				?>
	
					<li class="staff_members" id="s_<?= $member['mth_s_id'] ?>">
						<?= $member['mth_s_last'].", ".$member['mth_s_first'] ?>
					</li>

				<?php    
					}
				?>			
	
				</ul>
			</div>
	
			
		</td>
	</tr>	
	<tr>
		<td class="label"><label for="mth_p_s">Related Projects</label></td>
		<td>
			<div id="relatedDrop" class="relatedGroup" style="float: left; margin-right: 10px">
				<?php
				
					if ($project['mth_p_related']) {
					
						$relatedlist = array();
						$related1 = explode("&",$project['mth_p_related']);
						foreach ($related1 as $related) {
							$related2 = explode("=",$related);
							$relatedlist[] = $related2[1];
						}
						$relatedlist = implode(",",$relatedlist);
						//print_r($stafflist);
						$relateds = $wpdb->get_results( $wpdb->prepare("SELECT mth_p_id,mth_p_name FROM wp_mth_project WHERE mth_p_id IN ($relatedlist) ORDER BY FIELD(mth_p_id, $relatedlist)" ), ARRAY_A);
						foreach ($relateds as $related) {
							//print_r($member);
							echo "<li class=\"staff_members\" id=\"r_{$related['mth_p_id']}\">".stripslashes(substr($related['mth_p_name'], 0, 18)."...")."</li>";
						}
					
					}
				
				?>
				<p><small><strong>Drop related projects here.</strong> (Project pages will show related projects in this order)</small></p>
			</div>
			
			<?php 
				if ($_GET['page'] != "mith_project_delete") :
			?>
			
			<input type="button" id="showHideRelated" value="Show/Hide Projects" style="width: 120px; font-size: 10px; font-weight: bold" />
			<input type="hidden" id="mth_p_related" name="mth_p_related" value="<?= $project['mth_p_related'] ?>" />
			<br /><small>(Click to add projects)</small>
			
			<?php
				endif;
			?>
			
			<div id="related_window" style="display: none; clear: left; padding-top: 5px">
				<ul id="relatedGrab" class="relatedGroup">
			
				<?php
					$relateds = $wpdb->get_results("SELECT mth_p_id,mth_p_name FROM wp_mth_project ORDER BY mth_p_name ASC", ARRAY_A);
					foreach ($relateds as $related) {
				?>
			
					<li class="staff_members" id="r_<?= $related['mth_p_id'] ?>">
						<?= stripslashes(substr($related['mth_p_name'], 0, 18)."...") ?>
					</li>
			
				<?php    
					}
				?>			
			
				</ul>
			</div>

		</td>
	</tr>
	
</table>

<?php 
	if ($_GET['page'] != "mith_project_delete") :
?>




<script type="text/javascript">
	jQuery(function() {
		jQuery("#sortDrop, #sortGrab").sortable({
			connectWith: '.sortGroup',
			tolerance: 'intersect',
			helper: 'clone',
			update : function () {
				var order = jQuery('#sortDrop').sortable('serialize');
				var stafflist = document.getElementById("mth_p_stafflist");
				stafflist.value = order;
				//$("#info").load("process-sortable.php?"+order); 
    		} 
		}).disableSelection();

		jQuery(document).ready(function(){
			jQuery("#showHideStaff").click(function () {
				jQuery("#staff_window").toggle("fast");
			});
			jQuery("#showHideRelated").click(function () {
				jQuery("#related_window").toggle("fast");
			});
		});
		
		jQuery("#relatedDrop, #relatedGrab").sortable({
			connectWith: '.relatedGroup',
			tolerance: 'intersect',
			helper: 'clone',
			update : function () {
				var order = jQuery('#relatedDrop').sortable('serialize');
				var relatedlist = document.getElementById("mth_p_related");
				relatedlist.value = order;
				//$("#info").load("process-sortable.php?"+order); 
    		} 
		}).disableSelection();


	});
</script>
	
</div>

	







<p class="submit"><a href="?page=mith_projects">&laquo; Cancel and Return to Project List</a> &nbsp; <input type="submit" name="submit" value="Save Project Details" /></p>

<?php
	endif;
?>
</form>