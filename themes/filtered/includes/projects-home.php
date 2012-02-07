<?php $ttrust_featured_on_home = ttrust_get_option('ttrust_featured_on_home'); ?>	
<?php if($ttrust_featured_on_home) : //show only featured projects ?>
	
	<?php $skills_nav = array(); ?>
	<?php query_posts( 'post_type=projects&posts_per_page=200&meta_key=_ttrust_home_featured_value&meta_value=true' ); ?>
	
	<?php  while (have_posts()) : the_post(); ?>	   			    
		<?php 				
		$s = "";
		$skills = get_the_terms( $post->ID, 'skill');
		if ($skills) {
		   foreach ($skills as $skill) {
			  if (isset($skills_nav[$skill->term_id])) {
			  	continue;
			  }
			  $skills_nav[$skill->term_id] = $skill;		      		  		
		   }		   
		}		

		?>
	<?php endwhile; ?>	
	
	<ul id="filterNav" class="clearfix">				
		<li class="segment-0 selected"><a href="#" data-value="all">All</a></li>
		<?php
		$j=1;		  
		  foreach ($skills_nav as $skill) {
		  	$a = '<li class="segment-'.$j.'"><a href="#" data-value="skill-'.$skill->slug.'">';
			$a .= $skill->name;					
			$a .= '</a></li>';
			echo $a;
			echo "\n";
			$j++;
		  }
		 ?>								
	</ul>
	
	<?php  include( TEMPLATEPATH . '/includes/project-grid.php'); ?>		
		
<?php else: //show all projects ?>
	
	<?php query_posts( 'post_type=projects&posts_per_page=200' ); ?>
			
	<ul id="filterNav" class="clearfix">				
		<li class="segment-0 selected"><a href="#" data-value="all">All</a></li>
		<?php
		$j=1;
		  $categories = get_categories('taxonomy=skill');
		  foreach ($categories as $category) {
		  	$a = '<li class="segment-'.$j.'"><a href="#" data-value="skill-'.$category->slug.'">';
			$a .= $category->cat_name;					
			$a .= '</a></li>';
			echo $a;
			echo "\n";
			$j++;
		  }
		 ?>								
	</ul>	
	
	<?php  include( TEMPLATEPATH . '/includes/project-grid.php'); ?>
		
<?php endif; ?>
	
