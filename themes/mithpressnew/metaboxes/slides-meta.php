<?php 
/*-------------the metabox template --------------------------------*/
/*
* for my JS to work it is necessary that my markup is always the same
* at least for div .slide_preview
*/

<div class="my_meta_control">

	<a href="#" class="deleteall dodelete-artworks button"><span class="icon delete"></span><?php _e('Remove All');?></a>

 
	<?php while($mb->have_fields_and_multi('artworks')): ?>
	<?php $mb->the_group_open(); ?>
	     
	<a href="#" class="dodelete icon close" title="<?php _e('Remove');?>"><?php _e('Remove');?></a>

	<h3 class="slide handle"><?php _e('Artwork #')?><span class="count"><?php echo ($mb->get_the_index() +1 );?></span></h3>

	  <div class="meta_inside clearfix">	
	  
	  <div class="slide_preview wide">
		<div class="preview_wrap">
		
		<?php $mb->the_field('image_src'); ?>
		
		<img class="preview" src="<?php if($mb->get_the_value()){$mb->the_value();}else { echo WPALCHEMY . '/images/default_preview.png';}?>" alt="<?php $mb->the_name();?> Preview" />
		</div>
		
		<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="image_src" />
		<?php $mb->the_field('image_id'); ?>
		<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="image_id" />
		<?php $mb->the_field('image_alt'); ?>
		<input type="hidden" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>" class="image_alt" />
		
		<?php if($mb->get_the_value('image_src') != "") {$icon = "change"; $button_text = __('Change Image'); $hide = '';} else { $icon = "upload"; $button_text = __('Upload Image'); $hide='hide';} ?>
	
		<button class="upload_image_button button" type="button"><span class="icon <?php echo $icon;?>"></span><?php echo $button_text;?></button>
		<button class="delete_image_button button <?php echo $hide;?>" type="button"><span class="icon delete"></span><?php _e('Remove Image')?></button>
		
	  </div>
	  
	   </div><!--.meta_inside-->

 
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
	

	<p style="margin-bottom:15px; padding-top:5px;"><a href="#" class="docopy-artworks button"><span class="icon add"></span><?php _e('Add Artwork');?></a></p>	
	
	<p class="meta-save"><button type="submit" class="button-primary" name="save"><?php _e('Update');?></button></p>


</div><!-- .my_meta_control -->