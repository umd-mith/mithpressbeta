<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>
 
<div class="my_meta_control metabox">
 
	<label>Video File</label>
	<?php $mb->the_field('vidurl'); ?>
	<?php $wpalchemy_media_access->setGroupName('video')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('video' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>

	<label>Powerpoint File</label>
	<?php $mb->the_field('ppturl'); ?>
	<?php $wpalchemy_media_access->setGroupName('ppt')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('ppt' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>
 
	<label>Keynote File</label>
	<?php $mb->the_field('keyurl'); ?>
	<?php $wpalchemy_media_access->setGroupName('keynote')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('keynote' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>
    
	<label>Slides Only File</label>
	<?php $mb->the_field('slideurl'); ?>
	<?php $wpalchemy_media_access->setGroupName('slides')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('slides' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>

	<label>Audio Only File</label>
	<?php $mb->the_field('audurl'); ?>
	<?php $wpalchemy_media_access->setGroupName('audio')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('audio' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>

    <br clear="all" />

</div>