<?php
/**
 * The template for displaying content in the single-project.php template ONLY (not page-research.php) 
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">
		<div class="project-desc"><?php the_content(); ?></div>
        
		<?php // start project images
			$thumbnail = get_post_meta($post->ID, 'project-thumb', true); 
			if ($thumbnail) : ?>
        <aside id="project-thumb" class="widget">
			<h3><?php _e( 'Project Images', 'mithpress' ); ?></h3>
        	<p><a href="<?php the_permalink() ?>" rel="bookmark">
            	<img class="thumb" src="<?php echo $thumbnail ?>" alt="<?php the_title() ?>" />
            </a>
            </p>
        </aside>
        <?php endif ?>

		<?php // start project participants
			$project_people = get_post_meta($post->ID, 'project-people', true); 
            if ($project_people) : ?> 
        <aside id="project-thumb" class="widget">
			<h3><?php _e( 'Project Participants', 'mithpress' ); ?></h3>
            <ul>
            	<li></li>
            </ul>        
        </aside>
        <?php endif ?>

        <div class="project-people"></div>
        <div class="project-links"></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mithpress' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->