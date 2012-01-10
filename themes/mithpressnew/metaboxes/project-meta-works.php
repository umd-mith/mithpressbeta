<div class="my_meta_control">
 
<a style="float:right; margin:0 10px;" href="#" class="dodelete-links button remove-all">Remove All</a>
 
<label>Project Staff<span>(current Staff associated with the project)</span></label>	

<p>Add staff to project by selecting them from the dropdown. Add addtional staff by clicking the "Add Staff" button.</p> 
<?php while($mb->have_fields_and_multi('links')): ?>
<?php $mb->the_group_open(); ?>
<?php 
	$selected = ' selected="selected"'; 
	$mb->the_field('projectstaff'); ?>
    
	<select name="<?php $mb->the_name(); ?>" id="project-staff">
    	<option value=""></option>
		<option value="test_name"<?php if ($metabox->get_the_value() == 'test_name') echo $selected; ?>>test_name</option>
		<option value="test_name2"<?php if ($metabox->get_the_value() == 'test_name2') echo $selected; ?>>test_name2</option>
    </select>

        <p class="remove-button">
                    <a href="#" class="dodelete button remove">Remove Link</a>
        </p>
	<br clear="all" />                 
<?php $mb->the_group_close(); ?>
<?php endwhile; ?>
 
    <p class="add-another-link"><a href="#" class="docopy-links button add-another">Add Link</a></p>



</div>