<?php
/**
 * The template for displaying Podcasts Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
        <!--start subnav -->
        <?php get_sidebar('left'); ?>
        <!-- end subnav sidebar / start archive content -->
			<div id="content" role="main" class="archive span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

			<?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title append-bottom prepend-top">
						<?php post_type_archive_title(); ?>
					</h1>
				</header>


				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); 
				    global $people_mb;
					$podcast_mb->the_meta();
				?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                    <header class="entry-header">
                        <h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
                    </header>
                    <!-- end entry-header-->
                    
                    <div class="entry-content">
                        <div id="podcast-info" class="append-bottom prepend-top clear">
                            <?php the_post_thumbnail( 'med-thumbnail' ); ?>
                            <span class="pods-speaker"><?php echo $podcast_mb->the_value('speaker'); ?></span> 
                            <span class="pods-affiliation"><?php echo $podcast_mb->the_value('affiliation'); ?></span>
                            <span class="pods-date"><?php the_date( 'F j, Y' ); ?></span>
                        </div>
						<div class="abstract">
                            <?php the_excerpt(); ?>
                        </div>
                            <!-- end abstract -->
                        </div>
                        <!-- end podcast-info -->
                    </div>
                    <!-- end entry-content -->
                    <br clear="all" />
                    <?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>
                    
                </article>
            
				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>

			<?php endif; ?>

        </div>
        <!-- end #content -->
	</div>
<div class="clear"></div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>