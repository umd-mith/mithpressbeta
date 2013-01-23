<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>
<div class="my_meta_control">

<!-- PROJECT FILES -->
 	
    <label>Files <span>Add project files here (whitepapers, documentation, etc.)</span></label>
 
	<div class="remove-all-button"><a href="#" class="dodelete-fileuploads button remove-all">Remove All</a></div>
 	
    <br clear="all" />
	
	<?php while($mb->have_fields_and_multi('fileuploads', array('length' => 1, 'limit' => 10))): ?>
	<?php $mb->the_group_open(); ?>

		<?php $mb->the_field('fileurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('fileupload'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>
 
		<?php $mb->the_field('filetitle'); ?>
		<label for="<?php $mb->the_name(); ?>">Title <span>Title of link to file</span></label>
		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>

        <div class="remove-button"><a href="#" class="dodelete button remove">Remove File</a></div>

	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
	
    <br clear="all" />
 	
    <div class="add-another-button"><a href="#" class="uploadopy-fileuploads button add-file">Add Another File</a></div>
	
    <br clear="all" />

<!-- PROJECT IMAGES -->

    <label>Images <span>Add screenshots or other project images here.</span></label>
 	<div class="remove-all-button"><a href="#" class="dodelete-imguploads button remove-all">Remove All</a></div>
 
    <br clear="all" />

	<?php while($mb->have_fields_and_multi('imguploads', array('length' => 1, 'limit' => 10))): ?>
	<?php $mb->the_group_open(); ?>
  
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('imgupload'. $mb->get_the_index())->setInsertButtonLabel('Insert')->setTab('gallery'); ?>

		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>

		<div class="remove-button"><a href="#" class="dodelete button remove">Remove</a></div>
  
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
    <br clear="all" />

	<div class="add-another-button"><a href="#" class="uploadopy-imguploads button add-file">Add Another Image</a></div>
    
    <br clear="all" />

</div>