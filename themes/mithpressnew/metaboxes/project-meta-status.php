<div class="my_meta_control side">
 
	<label>Status <span>Select the current status of the project:</span></label>

	<?php $clients = array('Active','Archive','In Development','Unknown'); ?>

	<?php foreach ($clients as $i => $client): ?>
		<?php $mb->the_field('r_ex2'); ?>
		<input type="radio" name="<?php $mb->the_name(); ?>" value="<?php echo $client; ?>"<?php $mb->the_radio_state($client); ?>/> <?php echo $client; ?><br/>
	<?php endforeach; ?>

</div>

<div class="my_meta_control side"> 

	<label>Type <span>Select all that apply. Workshops and events will show up under Community page.</span></label>
	
	<?php $items = array('Project', 'Workshop', 'Event'); ?>

	<?php while ($mb->have_fields('cb_type', count($items))): ?>
	
		<?php $item = $items[$mb->get_the_index()]; ?>

		<input type="checkbox" name="<?php $mb->the_name(); ?>" value="<?php echo $item; ?>"<?php $mb->the_checkbox_state($item); ?>/> <?php echo $item; ?><br/>

	<?php endwhile; ?>


</div>