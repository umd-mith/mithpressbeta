<div class="my_meta_control">

    <div class="remove-all-button"><a href="#" class="dodelete-dates button remove-all">Remove All</a></div>
     
    <p>Add dates span by entering start and end dates in the appropriate fields. Enter the title carried by the staff member for each date span. Add a new date span by clicking the "Add Dates" button.</p>
     
    <?php while($mb->have_fields_and_multi('dates')): ?>
    <?php $mb->the_group_open(); ?>
     	
        <?php $mb->the_field('dates-title'); ?>
        <div class="dates-span">
        <p><label>Title</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
        </div>

        <?php $mb->the_field('dates-start'); ?>
        <div class="dates-span">
        <p><label>Began</label>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
     	</div>
        
        <?php $mb->the_field('dates-end'); ?>
        <div class="dates-span">
        <p><label>Ended</label>
        <input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
     	</div>
        
		<div class="remove-button"><a href="#" class="dodelete button remove">Remove Dates</a></div>
    
        <br clear="all" />                 
    
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
     
    <div class="add-another-link"><a href="#" class="docopy-dates button add-another">Add Dates</a></div>
    
    <br clear="all" />

</div>