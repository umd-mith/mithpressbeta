<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
    global $project_mb;
	$project_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
	</header>

	<div class="entry-content">
		<!-- Project Description -->
		<div class="project-desc">
        	<?php // the_post_thumbnail( 'horiz-thumbnail' ); ?>
            <?php the_content(); ?>
        </div>
        
        <div class="project-gallery">
            <h2 class="column-title">Gallery</h2>
            <ul id="project-images">
                <?php	
				global $projectuploads_mb;
                $projectuploads_mb->the_meta();
    
                while ($projectuploads_mb->have_fields('images')) {
					$img = $projectuploads_mb->get_the_value('imgurl'); 
					$alt = $projectuploads_mb->get_the_value('imgalt'); ?> 
				<li><a href="<?php echo $img ?>" rel="lightbox-gallery"><img class="project-image" src="<?php echo $img ?>" alt="<?php echo $alt ?>" /></a></li>
                <?php } ?>
			</ul>

        </div>
		
        <!-- Project Staff -->
	<?php 
    global $project_mb;
	global $people_mb;
	$project_mb->the_meta();

	if ($project_mb->have_fields('links')) { ?>
	<div id="info-staff" class="column left">
       	<h2 class="column-title">Participating MITH Staff</h2>
        	<ul><?php  // loop a set of field groups

		$people_query_args = array(
			'post_type' => 'people',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC',							
		);

		$people_query = new WP_Query( $people_query_args );

		$staff_arr = array();

		if ( $people_query->have_posts() ) 
		{
            while($project_mb->have_fields('links'))  &&  ( $people_query->have_posts() )
			{
				$people_query->the_post();
				$staffname = $project_mb->get_the_value('projectstaff'); 


				array_push( $staff_arr, array( 'id' => $staffname , 'title' => $post->post_title ) );
			}
		} ?>
        
		<?php foreach( $staff_arr as $staff ) { ?>
        	<li><?php echo $staff['title']; ?>"></li>
		<?php } ?>
            </ul>
        </div> 
    <?php } ?>
		
    <!-- Project Links -->
	<?php 				
	global $projectlinks_mb;
	$projectlinks_mb->the_meta();

	if ($projectlinks_mb->have_fields('links')) { ?>

        <div id="info-links" class="column left">
       	<h2 class="column-title">Links</h2>
        	<ul>        
			<?php  // loop a set of field groups
            while($projectlinks_mb->have_fields('links')) {
                $url = $projectlinks_mb->get_the_value('url');
                $title = $projectlinks_mb->get_the_value('title');
                echo '<li><a href="' . $url . '" target="_blank" rel="nofollow">';
                echo $title . '</a></li>';
            } ?>
        	</ul>
        </div><!-- /info-links --> 
    <?php } ?>
			

	</div><!-- /entry-content -->
    <br clear="all" />

	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article><!-- /post-<?php the_ID(); ?> -->