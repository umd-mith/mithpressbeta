<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>
<div class="my_meta_control">
 	
	<h4>Files</h4>
    <label><span>Add project files here (whitepapers, documentation, etc.)</span></label>
 
	<p><a href="#" class="dodelete-docs button remove-all">Remove All</a></p>
 	
    <br clear="all" />
	
	<?php while($mb->have_fields_and_multi('docs', array('length' => 1, 'limit' => 10))): ?>
	<?php $mb->the_group_open(); ?>
		<a href="#" class="dodelete button remove">Remove</a>
 
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('doc-n'. $mb->get_the_index())->setInsertButtonLabel('Insert'); ?>
 
		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>
 
		<?php $mb->the_field('title'); ?>
		<label for="<?php $mb->the_name(); ?>">Title <span>Title of link to file</span></label>
		<p><input type="text" id="<?php $mb->the_name(); ?>" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/></p>
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
	
    <br clear="all" />
 	
    <p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-docs button add-file">Add Another File</a></p>
	
    <br clear="all" />


	<h4>Images</h4>
    <label><span>Add screenshots or other project images here.</span></label>
 
	<p><a href="#" class="dodelete-docs button remove-all">Remove All</a></p>
 
    <br clear="all" />

	<?php while($mb->have_fields_and_multi('imgs', array('length' => 1, 'limit' => 10))): ?>
	<?php $mb->the_group_open(); ?>
 
		<a href="#" class="dodelete button remove">Remove</a>
 
		<?php $mb->the_field('imgurl'); ?>
		<?php $wpalchemy_media_access->setGroupName('img-n'. $mb->get_the_index())->setInsertButtonLabel('Insert')->setTab('gallery'); ?>

		<p>
			<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
			<?php echo $wpalchemy_media_access->getButton(); ?>
		</p>
  
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
    <br clear="all" />

	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-docs button add-file">Add AnotherImage</a></p>
    
    <br clear="all" />

</div>