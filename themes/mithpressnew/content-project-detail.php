<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
    global $project_mb;
	$project_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! has_post_thumbnail() ) { ?>
	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
	</header>
	<?php } ?>
    
	<div class="entry-content">

		<div class="project-desc">
        	<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'full', array('class' => 'append-bottom') ); endif; ?>
            <?php the_content(); ?>
        </div>
		<!-- /project-desc -->
		<?php	
		global $projectuploads_mb;
		$projectuploads_mb->the_meta();
		
        $i = 0;
		while ($projectuploads_mb->have_fields('images')) { ?>
		<?php 
        if($i == 0) { 
		?>
        <div class="project-gallery">
            <h2 class="column-title">Gallery</h2>
            <ul id="project-images">
		<?php } // endif ?>
        <?php  // loop a set of field groups
			$i++;
            $img = $projectuploads_mb->get_the_value('imgurl'); 
			$alt = $projectuploads_mb->get_the_value('imgalt'); ?> 
				<li <?php if( $i%4 == 0 ) { ?> class="last" <?php } ?>><a href="<?php echo $img ?>" rel="lightbox-gallery"><img class="project-image" src="<?php echo $img ?>" alt="<?php echo $alt ?>" /></a></li>
        <?php 
		// End while loop
		} 
        if($i > 0) { ?>
            </ul>
        </div>
        <!-- /project-gallery -->
		<?php } ?>
		
		<?php 
        global $project_mb;
        $project_mb->the_meta();
        $i = 0;
		while($project_mb->have_fields('links')) { ?>
        
		<?php 
		if($i == 0) { ?>
        <div id="info-staff" class="column left">
       	<h2 class="column-title">Participating MITH Staff</h2>
        	<ul>
		<?php } // endif ?>
        <?php  // loop a set of field groups
				$staffname = $project_mb->get_the_value('projectstaff'); 
				echo '<li><a href="' . get_permalink($staffname) . '">' . get_the_title($staffname) . '</a></li>';
		$i++;
		// End while loop
		} 
        if($i > 0) { ?>
            </ul>
        </div>
        <!-- /project-staff -->
		<?php } ?>

	<?php 
	global $projectlinks_mb;
	$projectlinks_mb->the_meta();
        $i = 0;
	while($projectlinks_mb->have_fields('links')) {
	?>
	<?php 
    if($i == 0) { ?>
        <div id="info-links" class="column left">
        <h2 class="column-title">Links</h2>
            <ul>
    <?php } ?>
            <?php  // loop a set of field groups
            
                $url = $projectlinks_mb->get_the_value('url');
                $title = $projectlinks_mb->get_the_value('title');
                echo '<li><a href="' . $url . '" target="_blank" rel="nofollow">';
                echo $title . '</a></li>';
            ?>
        <?php
             $i++;
             // End while loop
             } 
         if($i > 0) { ?>
            </ul>
        </div>
	<?php } ?>    <!-- /info-links --> 
    
			

	</div><!-- /entry-content -->
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article><!-- /post-<?php the_ID(); ?> -->