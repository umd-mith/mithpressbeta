<div class="my_meta_control">
<!-- PROJECT INFO -->

	<label>Website/Blog</label>
	<p>
    	<?php $mb->the_field('website');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Enter official website/blog for project (if applicable). All other project links should be added below. Format: <strong>without</strong> "http://"</span>
    </p> 
    
	<label>Contact Person</label>
	<p>
    	<?php $mb->the_field('contactname');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Name</span>
    </p>
    <p>
    	<?php $mb->the_field('contactemail');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Email Address</span>
    </p>

	<label>Launch Date</label>
	<p>
    	<?php $mb->the_field('launchdate');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter official date of project launch. Format: November 11, 2011</span>
    </p>

	<label>Twitter Account <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter twitter handle if project has its own Twitter account.</span>
    </p>

	<label>Twitter Hashtag <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('hashtag');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter hashtag for project (optional).</span>
    </p>

<!-- PROJECT STAFF -->

    <label>Project Staff 
    <span>(current Staff associated with the project)</span></label>	 
    
    <div class="remove-all-button"><a href="#" class="dodelete-staff button remove-all">Remove All</a></div>
     
    <p>Add staff to project by selecting them from the dropdown. Add addtional staff by clicking the "Add Staff" button.</p> 

    <br clear="all" />

    <?php while($mb->have_fields_and_multi('staff')): ?>
    <?php $mb->the_group_open(); 
        $selected = ' selected="selected"'; 
        $mb->the_field('projectstaff'); 
	?>
        <select name="<?php $mb->the_name(); ?>" id="project-staff">
            <option value=""></option>
            <option value="test_name"<?php if ($metabox->get_the_value() == 'test_name') echo $selected; ?>>test_name</option>
            <option value="test_name2"<?php if ($metabox->get_the_value() == 'test_name2') echo $selected; ?>>test_name2</option>
        </select>
        
        <div class="remove-button"><a href="#" class="dodelete button remove">Remove Person</a></div>
        
        <br clear="all" />                 
    
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
     
        <div class="add-another-link"><a href="#" class="docopy-staff button add-another">Add Staff</a></div>

    <br clear="all" /> 
</div>