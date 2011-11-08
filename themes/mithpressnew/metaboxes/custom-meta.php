<?php 

// the name of the instantiated class object
global $wpalchemy_media_access;

?>

<div class="my_meta_control metabox">
 
	<?php $mb->the_field('imgurl'); ?>
	<?php $wpalchemy_media_access->setGroupName('nn')->setInsertButtonLabel('Insert'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(); ?>
	</p>
 
	<?php $mb->the_field('imgurl2'); ?>
	<?php $wpalchemy_media_access->setGroupName('nn2')->setInsertButtonLabel('Insert This')->setTab('gallery'); ?>
 
	<p>
		<?php echo $wpalchemy_media_access->getField(array('name' => $mb->get_the_name(), 'value' => $mb->get_the_value())); ?>
		<?php echo $wpalchemy_media_access->getButton(array('label' => 'Add Image From Library')); ?>
	</p>
 
</div>