<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>
<div class="my_meta_control">

<!-- PROJECT IMAGES -->

    <label>Images <span>Add screenshots or other project images here.</span></label>
 
	<p><a href="#" class="dodelete-images button">Remove All</a></p>
 
	<?php while($mb->have_fields_and_multi('images')): ?>
	<?php $mb->the_group_open(); ?>
  
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Add')->setTab('type'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image')); ?>
		</p>
		
		<?php $mb->the_field('imgalt');?>
 		<label for="<?php $mb->the_name(); ?>">Alt Text</label>
 		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

        <a href="#" class="dodelete button">Remove</a>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-images button">Add</a></p>
 
    <br clear="all" />

<!-- PROJECT FILES -->
 	
    <label>Files <span>Add project files here (whitepapers, documentation, etc.)</span></label>
 
	<p><a href="#" class="dodelete-files button">Remove All</a></p>
 
	<?php while($mb->have_fields_and_multi('files')): ?>
	<?php $mb->the_group_open(); ?>
  
		<?php $mb->the_field('fileurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('file-n'. $mb->get_the_index())->setInsertButtonLabel('Add')->setTab('type'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>

		<?php $mb->the_field('title'); ?>
		<label for="<?php $mb->the_name(); ?>">Title <span>Title of link to file</span></label>
		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

 		<a href="#" class="dodelete button">Remove</a>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-files button">Add</a></p>
 
    <br clear="all" />

</div>