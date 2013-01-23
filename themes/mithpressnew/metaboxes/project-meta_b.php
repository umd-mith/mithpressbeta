<div class="my_meta_control">
 
<a style="float:right; margin:0 10px;" href="#" class="dodelete-links button remove-all">Remove All</a>
 
<label>Project Staff<span>(current Staff associated with the project)</span></label>	

<p>Add staff to project by selecting them from the dropdown. Add addtional staff by clicking the "Add Staff" button.</p> 
<?php while($mb->have_fields_and_multi('links')): ?>
<?php $mb->the_group_open(); ?>
 

<?php //create a query for all of the people posts 
	$selected = ' selected="selected"'; 
	$mb->the_field('projectstaff');
    $people_query_args = array(
		'post_type' => 'people',
		'posts_per_page' => -1,
		'orderby' => 'title',
		'order' => 'ASC',							
	);
    $people_query = new WP_Query( $people_query_args );
    if ($people_query->have_posts()) {
        echo '<select name="' . $mb->the_name() .'" id="project_staff">';
		echo '<option value=""></option>';
        //loop all posts and add them to the select dropdown
        while ($people_query->have_posts()) {
				$people_query->the_post();
				echo '<option value="' . $post->ID . '" ';
				if ($mb->get_the_value() == $post->ID) echo $selected;
            echo '>' . $post->post_title . '</option>';
            }
        }
        echo '</select>';
?>    
        <p class="remove-button">
            <a href="#" class="dodelete button remove">Remove Link</a>
        </p>
	<br clear="all" />                 
<?php $mb->the_group_close(); ?>
<?php endwhile; ?>
 
    <p class="add-another-link"><a href="#" class="docopy-links button add-another">Add Link</a></p>
</div>