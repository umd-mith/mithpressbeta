<div class="my_meta_control">
  
	<label>Speaker</label> 
	<p>
		<?php $mb->the_field('speaker'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Speaker's full name and title (i.e. PhD, etc.)</span>
	</p>

	<label>Affiliation</label> 
	<p>
		<?php $mb->the_field('affiliation'); ?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter speaker's affiliation</span>
	</p>

	<label>Twitter Handle</label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>(optional) will show up next to speaker photo below date on single podcast page</span>
    </p>
 
</div>
