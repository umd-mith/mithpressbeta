<div class="my_meta_control">
<!-- PROJECT INFO -->

	<label>Website/Blog</label>
	<p>
    	<?php $mb->the_field('website');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Enter official website/blog for project (if applicable). All other project links should be added below. Format: <strong>without</strong> "http://"</span>
    </p> 
    
	<label>Contact Person</label>
	<p>
    	<?php $mb->the_field('contactname');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Name</span>
    </p>
    <p>
    	<?php $mb->the_field('contactemail');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
        <span>Email Address</span>
    </p>

	<label>Launch Date</label>
	<p>
    	<?php $mb->the_field('launchdate');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter official date of project launch. Format: November 11, 2011</span>
    </p>

	<label>Twitter Account <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('twitter');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter twitter handle if project has its own Twitter account.</span>
    </p>

	<label>Twitter Hashtag <span>(optional)</span></label>
	<p>
    	<?php $mb->the_field('hashtag');?>
		<input type="text" name="<?php $mb->the_name(); ?>" value="<?php $mb->the_value(); ?>"/>
		<span>Enter hashtag for project (optional).</span>
    </p>
    <br clear="all" /> 
</div>

<!-- PROJECT STAFF -->
<div class="my_meta_control">
 
	<a style="float:right; margin:0 10px;" href="#" class="dodelete-links button remove-all">Remove All</a>
	 
	<label>Project Staff<span>(current Staff associated with the project)</span></label>	

	<p>Add staff to project by selecting them from the dropdown. Add addtional staff by clicking the "Add Staff" button.</p> 

	<?php

		$people_query_args = array(
			'post_type' => 'people',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',
			'tax_query' => array(
				array(
					'taxonomy' => 'staffgroup',
					'field' => 'slug',
					'terms' => array( 'archive' ),
					'operator' => 'NOT IN'
				)
			)
		);

		$people_query = new WP_Query( $people_query_args );

		$staff_arr = array();

		if ( $people_query->have_posts() ) 
		{
			while ( $people_query->have_posts() )
			{
				$people_query->the_post();

				array_push( $staff_arr, array( 'id' => $post->ID , 'title' => $post->post_title, 'url' => get_permalink($post->ID) ) );
			}
		}
	?>

	<?php while($mb->have_fields_and_multi('links')): ?>
	<?php $mb->the_group_open(); ?>
	 
		<?php $mb->the_field( 'projectstaff' ); ?>
		<select name="<?php $mb->the_name(); ?>">
			<option value="">Select...</option>
			<?php foreach( $staff_arr as $staff ) { ?>
				<option value="<?php echo $staff['id']; ?>"<?php $mb->the_select_state($staff['id']); ?> name="<?php echo $staff['title']; ?>"><?php echo $staff['title']; ?></option>
			<?php } ?>
		</select>
   
		<p class="remove-button"><a href="#" class="dodelete button remove">Remove Link</a></p>

		<br clear="all" />  
		
	<?php $mb->the_group_close(); ?>
	<?php endwhile; ?>
 
    <p class="add-another-link"><a href="#" class="docopy-links button add-another">Add Link</a></p>

</div>