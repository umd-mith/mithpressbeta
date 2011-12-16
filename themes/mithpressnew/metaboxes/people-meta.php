<div class="my_meta_control">

	<label>Title</label>
	<p>
		<input type="text" name="<?php $mb->the_name('stafftitle'); ?>" value="<?php $mb->the_value('stafftitle'); ?>"/>
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
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
    </p>

	<label>Twitter Handle</label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>(optional)</span>
    </p>

	<label>Website/Blog <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('website');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span><strong>without</strong> "http://"</span>
    </p> 
    
	<label>Blog URL <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('blogcat');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Enter URL of MITH-related blog category page</span>
    </p>

	<label>Blog RSS Feed <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('blogrss');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>include "http://"</span>
    </p>
<br clear="all" />  
</div>
<div class="my_meta_control internal">
  
	<label>Internal Use<span> used for sorting, will not appear on live site</span></label>
	<p class="narrow">
		<input type="text" name="<?php $mb->the_name('fname'); ?>" value="<?php $mb->the_value('fname'); ?>"/>
		<span>First</span>
    </p>
	<p class="narrow">
		<input type="text" name="<?php $mb->the_name('lname'); ?>" value="<?php $mb->the_value('lname'); ?>"/>
        <span>Last</span>
    </p>
	<p>
		<input type="text" name="<?php $mb->the_name('pplsort'); ?>" value="<?php $mb->the_value('pplsort'); ?>"/>
		<span>Sort Order Number</span>
    </p>
<br clear="all" />
</div>
