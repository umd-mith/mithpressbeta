<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>
<div class="my_meta_control">
 
	<p><a href="#" class="dodelete-docs button">Remove All</a></p>
 
	<?php while($mb->have_fields_and_multi('docs')): ?>
	<?php $mb->the_group_open(); ?>
 
		<a href="#" class="dodelete button">Remove</a>
 
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>
 
		<?php $mb->the_field('title'); ?>
		<label for="<?php $mb->the_name(); ?>">Title</label>
		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
 
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-docs button">Add Another File</a></p>
 
</div>