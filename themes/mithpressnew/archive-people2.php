<?php
/**
 * The template for displaying People Archive page.
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
        <!--start subnav -->
        <?php get_sidebar('left-people'); ?>
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
					$people_mb->the_meta();

				?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                
                    <div class="entry-content">
                        <div id="person" class="append-bottom prepend-top">
                        	
                            <a href="<?php the_permalink(); ?>" rel="alternate" title="Permanent Link to <?php the_title_attribute(); ?>">
							<?php the_post_thumbnail( 'mini-thumbnail' ); ?>
                            </a>
                            
                            <span class="info-name"><?php the_title(); ?></span>
                            
                            <span class="info-title"><?php $people_mb->the_value('title'); ?></span>
                        
                        </div><!-- /#person-->
                    </div><!-- .entry-content -->
                
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