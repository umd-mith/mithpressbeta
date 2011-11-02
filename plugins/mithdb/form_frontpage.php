<?php

	// variables for the field and option names 
    $opt_name = 'mth_slideshow';
    $hidden_field_name = 'mth_submit_hidden';
    $data_field_name = 'mth_slideshow';

	if( $_POST[ $hidden_field_name ] == 'y' ) {
	
		/*echo "<pre>\n";
		print_r($_POST);
		echo "</pre>\n";*/
	
		// Read their posted value
		$opt_val = $_POST[ $data_field_name ];
		
		// Save the posted value in the database
		update_option( $opt_name, $opt_val );
		
?>
	<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
	<?php
	
		}

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
    $slides = array();
    parse_str(stripslashes($opt_val), $slides);
    
    //echo $slides['text_3'];

?>

<?php
	
	//$slides = array();
	//parse_str("banner_1=slideshow_1.png&icon_1=icon_digitaldialogues.png&title_1=%3Csmall%3EMITH's+Speaker+Series%3C%2Fsmall%3E%3Cbr+%2F%3ETuesdays+at+MITH%2C%3Cbr+%2F%3E12%3A30+-+1%3A45pm&text_1=Digital+Dialogues+is+MITH's+signature+events+program.+Held+almost+every+week+while+the+academic+semesters+are+in+session%2C+and+(almost)+always+on+the+same+day+and+time--Tuesdays%2C+12%3A30-1%3A45--+Digital+Dialogues+is+an+occasion+for+discussion%2C+presentation%2C+and+intellectual+exchange+that+you+can+build+into+your+weekly+schedule.&banner_2=slideshow_2.png&icon_2=icon_sqa.png&title_2=%3Csmall%3EMITH's+Research%3C%2Fsmall%3E%3Cbr+%2F%3EThe+Shakespeare+Quartos+Archive&text_2=The+Shakespeare+Quartos+Archive+expands+the+British+Library's+%22Shakespeare+in+Quarto%22+website+into+an+online+collection+reproducing+at+least+one+copy+of+every+edition+of+William+Shakespeare's+plays+printed+in+quarto+before+the+theatres+closed+in+1642.&banner_3=slideshow_3.png&icon_3=icon_digitaldialogues.png&title_3=%3Csmall%3EMITH's+Speaker+Series%3C%2Fsmall%3E%3Cbr+%2F%3ETuesdays+at+MITH%2C%3Cbr+%2F%3E12%3A30+-+1%3A45pm&text_3=Digital+Dialogues+is+MITH's+signature+events+program.+Held+almost+every+week+while+the+academic+semesters+are+in+session%2C+and+(almost)+always+on+the+same+day+and+time--Tuesdays%2C+12%3A30-1%3A45--+Digital+Dialogues+is+an+occasion+for+discussion%2C+presentation%2C+and+intellectual+exchange+that+you+can+build+into+your+weekly+schedule.&hidden_value=y",$slides);
	
?>

<form name="frontpage" id="frontpage" method="post">


<h4>Slideshow Options</h4>
<p style="width: 600px">This section allows you to update the front-page slideshow with up to five rotating images and text blocks.  You can drag and drop the individual &quot;slide&quot; blocks below to rearrange existing slides.</p>

<script type="text/javascript">
	jQuery(function() {
		jQuery("#slide_sort").sortable({
			update : function () {
				var order = jQuery('#slide_sort').sortable('serialize');
				//jQuery('#testorder').html(order);
				//showValues();
				var slide_order = document.getElementById("slide_order");
				slide_order.value = order;
				//jQuery("#info").load("process-sortable.php?"+order); 
    		}
		});
		jQuery("#slide_sortable").disableSelection();
	});
	
	jQuery(document).ready(function(){
    
		function showValues() {
			var mth_slideshow = document.getElementById("mth_slideshow");
			mth_slideshow.value = "";
			var str = jQuery("form").serialize();
			//jQuery("#results").text(str);
			mth_slideshow.value = str;
		}
		jQuery(":checkbox, :radio, :text").click(showValues);
		jQuery(":text, :textarea").keyup(showValues);
		//showValues();
	});
</script>

<p id="testorder"></p>
<p><tt id="results"></tt></p>

<ul id="slide_sort">
	<li id="s_1">
		<fieldset>
			<legend>Slide</legend>
				<table class="form mithadmin">
					<tr>
						<td class="label"><label for="banner_1">Banner Filename</label></td>
						<td><input type="text" name="banner_1" value="<?= stripslashes($slides['banner_1']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="icon_1">Icon Filename</label></td>
						<td><input type="text" name="icon_1" value="<?= stripslashes($slides['icon_1']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="title_1">Title</label></td>
						<td><input type="text" name="title_1" value="<?= stripslashes($slides['title_1']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="text_1">Textbox<br /><small>(Approx. 30 words)</small></label></td>
						<td><textarea name="text_1" <?= $disabled ?>><?= stripslashes($slides['text_1']) ?></textarea></td>
					</tr>
				</table>
			</legend>
		</fieldset>
	</li>
	<li id="s_2">
		<fieldset>
			<legend>Slide</legend>
				<table class="form mithadmin">
					<tr>
						<td class="label"><label for="banner_2">Banner Filename</label></td>
						<td><input type="text" name="banner_2" value="<?= stripslashes($slides['banner_2']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="icon_2">Icon Filename</label></td>
						<td><input type="text" name="icon_2" value="<?= stripslashes($slides['icon_2']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="title_2">Title</label></td>
						<td><input type="text" name="title_2" value="<?= stripslashes($slides['title_2']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="text_2">Textbox<br /><small>(Approx. 30 words)</small></label></td>
						<td><textarea name="text_2" <?= $disabled ?>><?= stripslashes($slides['text_2']) ?></textarea></td>
					</tr>
				</table>
			</legend>
		</fieldset>
	</li>
	<li id="s_3">
		<fieldset>
			<legend>Slide</legend>
				<table class="form mithadmin">
					<tr>
						<td class="label"><label for="banner_3">Banner Filename</label></td>
						<td><input type="text" name="banner_3" value="<?= stripslashes($slides['banner_3']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="icon_3">Icon Filename</label></td>
						<td><input type="text" name="icon_3" value="<?= stripslashes($slides['icon_3']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="title_3">Title</label></td>
						<td><input type="text" name="title_3" value="<?= stripslashes($slides['title_3']) ?>" <?= $disabled ?>/></td>
					</tr>
					<tr>
						<td class="label"><label for="text_3">Textbox<br /><small>(Approx. 30 words)</small></label></td>
						<td><textarea name="text_3" <?= $disabled ?>><?= stripslashes($slides['text_3']) ?></textarea></td>
					</tr>
				</table>
			</legend>
		</fieldset>
	</li>
</ul>

<input type="hidden" name="mth_submit_hidden" value="y" />
<input type="hidden" name="slide_order" value="" />
<input type="hidden" name="mth_slideshow" id="mth_slideshow" value="<?php echo stripslashes($opt_val) ?>" />
<p class="submit"><a href="?page=mth-top-level-handle">&laquo; Cancel and Return to MITHdb</a> &nbsp; <input type="submit" name="submit" value="Save Front Page Details" /></p>

</form>