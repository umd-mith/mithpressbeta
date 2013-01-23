<?php get_header(); ?>

<div id="page-container">
		<div id="primary" class="width-limit">
		<!-- start single post content-->
			<div id="content" role="main" class="span-16 first">
            
				<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
				
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'single' ); ?>

                <nav id="nav-single" class="span-narrow">
                    <h3 class="assistive-text"><?php _e( 'Post navigation', 'mithpress' ); ?></h3>
                    <span class="nav-previous">
						<?php previous_post_link( '%link', __( '<span class="meta-nav"></span> Previous', 'mithpress' ) ); ?>
                    </span>
                    <span class="nav-next">
						<?php next_post_link( '%link', __( 'Next <span class="meta-nav"></span>', 'mithpress' ) ); ?>
                    </span>
                </nav>
                <!-- /nav-single -->

					<?php comments_template( '', true ); ?>

				<?php endwhile; // end of the loop. ?>

    	</div><!-- /content -->
        
        <!-- start sidebar -->
        <?php get_sidebar('blog'); ?>
        <!-- /sidebar -->
        
	</div>
<!--end #primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>