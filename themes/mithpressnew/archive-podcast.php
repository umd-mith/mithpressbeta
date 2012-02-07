<?php
/**
 * The template for displaying Podcasts Archive page.
*/

 get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
		<?php get_sidebar('left'); ?>
		<!--end subnav / start digital dialogues page content-->

        <!-- /subnav sidebar / start archive content -->
        <div id="content" role="main" class="archive span-16 last">
        
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

        	<div id="articles">

			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'podcast',
					'posts_per_page' => '5',
					'paged' => get_query_var('paged')
				) );
            
				if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title append-bottom">
						<?php post_type_archive_title(); ?>
					</h1>
				</header>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'podcasts'); ?>

				<?php endwhile; ?>
				
                <nav id="nav-page">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                    <span class="nav-previous"><span class="meta-nav"></span><?php next_posts_link('Older', 0); ?></span>
                    <span class="nav-next"><span class="meta-nav"></span><?php previous_posts_link('Newer', 0) ?></span>
                </nav>

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