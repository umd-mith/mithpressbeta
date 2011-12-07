<div class="my_meta_control side">
 
	<p>Select the current status of the project:</p>
	<label></label>

	<?php $clients = array('Active','Archive','In Development','Unknown'); ?>

	<?php foreach ($clients as $i => $client): ?>
		<?php $mb->the_field('r_ex2'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $client; ?>"<?php $mb->the_radio_state($client); ?>/> <?php echo $client; ?><br/>
	<?php endforeach; ?>

</div>