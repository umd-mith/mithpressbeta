<?php $i=1; $c=0;?>
<ul id="projects" class="image-grid">			
<?php  while (have_posts()) : the_post(); ?>
    <?php $c++; ?>			    
	<?php 				
	$s = "";
	$skills = get_the_terms( $post->ID, 'skill');
	if ($skills) {
	   foreach ($skills as $skill) {
	      $s .= 'skill-'.$skill->slug . " ";				
	   }
	}

	?>
	<li class="project small clearfix <?php echo " ". $s; ?>" data-id="<?php echo $i; ?>">						
		<a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_post_thumbnail('ttrust_threeColumn', array('class' => 'thumb', 'alt' => ''.get_the_title().'', 'title' => ''.get_the_title().'')); ?></a>			    	
		<h1><a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a></h1>																								
 	</li>				

<?php $i++; endwhile; ?>
</ul>