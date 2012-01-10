<div class="my_meta_control">

    <div class="remove-all-button"><a href="#" class="dodelete-links button remove-all">Remove All</a></div>
     
    <p>Can be external links, links to files, etc. Add links by entering in a title in the first field and the URL in the second. Add a new link by clicking the "Add Link" button.</p>
     
    <?php while($mb->have_fields_and_multi('links')): ?>
    <?php $mb->the_group_open(); ?>
     
        <?php $mb->the_field('title'); ?>
        <p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
     
        <?php $mb->the_field('url'); ?>
        <p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
     
		<div class="remove-button"><a href="#" class="dodelete button remove">Remove Link</a></div>
    
        <br clear="all" />                 
    
    <?php $mb->the_group_close(); ?>
    <?php endwhile; ?>
     
    <div class="add-another-link"><a href="#" class="docopy-links button add-another">Add Link</a></div>
    
    <br clear="all" />

</div>