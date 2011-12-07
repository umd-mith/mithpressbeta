<h4>Documents</h4>
 
<a style="float:right; margin:0 10px;" href="#" class="dodelete-links button remove-all">Remove All</a>
 
<p>Add links by entering in a title in the first field and the URL in the second. Add a new link by clicking the "Add Link" button.</p>
 
<?php while($mb->have_fields_and_multi('links')): ?>
<?php $mb->the_group_open(); ?>
 
	<?php $mb->the_field('title'); ?>
	<label>Title and URL</label>
	<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
 
	<?php $mb->the_field('url'); ?>
	<p><input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
 
        <p class="remove-button">
            <a href="#" class="dodelete button remove">Remove Link</a>
        </p>
	<br clear="all" />                 
<?php $mb->the_group_close(); ?>
<?php endwhile; ?>
 
    <p class="add-another-link"><a href="#" class="docopy-links button add-another">Add Link</a></p>
<br clear="all" />