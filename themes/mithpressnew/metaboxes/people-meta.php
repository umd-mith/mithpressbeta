<div class="my_meta_control">
  
	<p>
	<label>Title</label>
		<input type="text" name="<?php $mb->the_name('title'); ?>" value="<?php $mb->the_value('title'); ?>"/>
		<span>Enter your full official staff title</span>
    </p>

	<p>
	<label>Email</label>
    	<?php $mb->the_field('email');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Will be protected against spam</span>
    </p>

	<p>
	<label>Phone</label>
    	<?php $mb->the_field('phone');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
    </p>

	<p>
	<label>Twitter Handle</label>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>(optional)</span>
    </p>

	<p>
	<label>Website/Blog <span>(optional)</span></label>
    	<?php $mb->the_field('website');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span><strong>without</strong> "http://"</span>
    </p> 
    
	<p>
	<label>Blog URL <span>(optional)</span></label>
    	<?php $mb->the_field('blogcat');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Enter URL of MITH-related blog category page</span>
    </p>
	<p>
	<label>Blog RSS Feed <span>(optional)</span></label>
    	<?php $mb->the_field('blogrss');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>include "http://"</span>
    </p>
<br clear="all" />  
</div>