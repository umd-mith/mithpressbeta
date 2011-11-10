<div class="my_meta_control">
  
	<label>Title</label>
	<p>
		<input type="text" name="<?php $mb->the_name('title'); ?>" value="<?php $mb->the_value('title'); ?>"/>
		<span>Enter your full official staff title</span>
    </p>

	<label>Email</label>
	<p>
    	<?php $mb->the_field('email');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Will be protected against spam</span>
    </p>

	<label>Phone</label>
	<p>
    	<?php $mb->the_field('phone');?>
		<input type="text" name="<?php $mb->the_name('phone'); ?>" value="<?php $mb->the_value('phone'); ?>"/>
		<span></span>
    </p>
</div>