<?php
/*
Template Name: Dialogues
* display list of most recent dialogues
*/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">

		<?php get_sidebar('left'); ?>
		<!-- /subnav -->

		<div id="content" role="main" class="span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
            
        	<div id="articles">

			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'podcast',
					'posts_per_page' => '5',
					'paged' => get_query_var('paged')
				) );
            ?>
  			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'podcasts'); ?>

				<?php endwhile; ?>
                
				<?php if (get_option('paging_mode') == 'default') : ?>
                    <nav id="nav-page" class="span-narrow">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                        <span class="nav-previous"><span class="meta-nav"></span><?php next_posts_link(__('Older'), 0); ?></span>
                        <span class="nav-next"><span class="meta-nav"></span><?php previous_posts_link(__('Newer'), 0); ?></span>
                    <?php if (function_exists('wp_pagenavi')) wp_pagenavi(); ?>
                    </nav>
                    <?php else : ?>
                    <nav id="nav-page" class="span-narrow">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                        <span class="nav-next"><span class="meta-nav"></span><?php next_posts_link(__('LOAD MORE')); ?></span>
                    </nav>
                <?php endif; ?>				

			<?php endif; ?>
        	</div>
            <!-- /articles -->
		<?php get_sidebar('podcasts'); ?>
		<!-- /sidebar -->
                    
		</div>
        <!-- /content -->
	</div>
    <!--/primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>