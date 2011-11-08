<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">
		<?php 
			$people = get_post_meta(get_the_ID(), 'project-people', true);
			$links = get_post_meta(get_the_ID(), 'project-links', true);
			$date = get_post_meta(get_the_ID(), 'project-launchdate', true);
			$screenshot = get_post_meta($post->ID, 'project-screenshot', true); 
	?>
		<div class="project-desc"><?php the_content(); ?></div>
        
        <!-- #project details -->
        <aside id="project-details" class="widget">
			<h3><?php _e( 'Project Details', 'mithpress' ); ?></h3>
			<p>Launch Date: <span><?php echo $date; ?></span></p>
            <p></p>
        </aside>
        <!-- /#project details -->
        
		<?php // start project images
			if ($screenshot) : ?>
        <aside id="project-screenshot" class="widget">
			<h3><?php _e( 'Project Images', 'mithpress' ); ?></h3>
        	<p><a href="<?php the_permalink() ?>" rel="bookmark">
            	<img class="thumb" src="<?php echo $screenshot; ?>" alt="<?php the_title() ?>" />
            </a>
            </p>
        </aside>
        <?php endif ?>

		<?php // start project participants
            if ($people) : ?> 
        <aside id="project-people" class="widget">
			<h3><?php _e( 'Project Participants', 'mithpress' ); ?></h3>
            <?php //foreach statement needs to go here ?>
            <?php echo $people; ?>
            <ul>
            	<li></li>
            </ul>        
        </aside>
        <?php endif ?>

	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->