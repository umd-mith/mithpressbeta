<?php
/*
 * The template for displaying Research Archive page.
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
		  <?php get_sidebar('left'); ?>
<!--end sidebar / start research page content-->
			<div id="content" role="main" class="span-16 last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
			<div id="projects">
			<?php 
			$args = array(
				'post_type' => 'project',
				'posts_per_page' => -1
				);
			$posts = new WP_Query( $args ); ?>
			<?php 
			$i = 0; // set up a counter so we know which post we're currently showing
			$counter_class = ''; // set up a variable to hold an extra CSS class
			if ( $posts -> have_posts() ) : 
			while ( $posts -> have_posts() ) : $posts->the_post(); 
			$i++; // increment the counter
                if( $i % 3 != 0) { 
                $counter_class = ''; // we're on a middle post
                } else {
                $counter_class = 'last'; }
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>
                
                    <div class="entry-content">
                        <div id="project-info" class="append-bottom">
                        <a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail( 'horiz-thumbnail') ); ?></a>
                        
                        </div>
                    </div><!-- /entry-content -->
                
                </article><!-- /post-<?php the_ID(); ?> -->
                
				<?php endwhile; ?>
            
			<?php endif; ?>
			</div>
			</div>
<!-- /page content -->
		</div>
<div class="clear"></div>
<!-- /primary -->
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>