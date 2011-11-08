<div class="my_meta_control">
 
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
	Cras orci lorem, bibendum in pharetra ac, luctus ut mauris.</p>
 
	<label>Project Staff<span>(Enter in each person's name)</span></label>
 
	<?php while($metabox->have_fields('authors',3)): ?>
	<p>
		<input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>
	</p>
	<?php endwhile; ?>
 
	<label>Info</label>
 
	<p>
		<!-- instead of using helper methods, you can also use array notation: name="custom_meta[info]" -->
		<input type="text" name="<?php $metabox->the_id(); ?>[info]" value="<?php if(!empty($meta['info'])) echo $meta['info']; ?>"/>
		<span>Enter in the info</span>
	</p>

	<label>Links <span>(Enter in the link title and url)</span></label>
 
	<?php while($metabox->have_fields('links', 5)): ?>
	<p>
		<?php $metabox->the_field('title'); ?>
		<input type="text" name="<?php $metabox->the_name(); ?>" value="<?php $metabox->the_value(); ?>"/>

		<input type="text" name="<?php $metabox->the_name('url'); ?>" value="<?php $metabox->the_value('url'); ?>"/>

		<br/><?php $metabox->the_field('nofollow'); ?>
		<input type="checkbox" name="<?php $metabox->the_name(); ?>" value="1"<?php if ($metabox->get_the_value()) echo ' checked="checked"'; ?>/> Use <code>nofollow</code>

		<?php $selected = ' selected="selected"'; ?>

		<br/><?php $metabox->the_field('target'); ?>
		<select name="<?php $metabox->the_name(); ?>">
		<option value=""></option>
		<option value="_self"<?php if ($metabox->get_the_value() == '_self') echo $selected; ?>>_self</option>
		<option value="_blank"<?php if ($metabox->get_the_value() == '_blank') echo $selected; ?>>_blank</option>
		<option value="_parent"<?php if ($metabox->get_the_value() == '_parent') echo $selected; ?>>_parent</option>
		<option value="_top"<?php if ($metabox->get_the_value() == '_top') echo $selected; ?>>_top</option>
		</select>
	</p>
	<?php endwhile; ?>

</div>