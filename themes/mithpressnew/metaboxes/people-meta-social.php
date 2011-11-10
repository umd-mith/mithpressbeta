<div class="my_meta_control">
	<p>
    	The fields in this section are completely optional. Enter whichever social media accounts you would like have appear on your bio page.
    </p>

	<label>Social Media Links</label><br/>

	<?php $soclinks = array('Twitter','Google+','Other'); ?>

	<?php foreach ($soclinks as $i => $soclinks): ?>
		<?php $mb->the_field('r_social'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $client; ?>"<?php $mb->the_radio_state($client); ?>/> <?php echo $client; ?><br/>
	<?php endforeach; ?>


  
	<label>Twitter</label> 
	<p>
		<input type="text" name="<?php $metabox->the_name('name'); ?>" value="<?php $metabox->the_value('soc-twitter'); ?>"/>
		<span>Enter your twitter handle without the @</span>
	</p>
 
	<label>Google+</label>
	<p>
		<input type="text" name="<?php $metabox->the_name('name'); ?>" value="<?php $metabox->the_value('name'); ?>"/>
    </p>
</div>