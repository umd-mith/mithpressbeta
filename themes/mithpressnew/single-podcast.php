<?php get_header(); ?>

<div id="page-container">
		<div id="primary" class="width-limit">
			<!--start subnav -->
			<?php get_sidebar('left'); ?>
			<!--end subnav / start single content-->
	
    		<div id="content" role="main" class="span-16 last">
            
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
        	
            <div id="articles">				
           		<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'podcast' ); ?>
	
				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>
			</div>
            
            <!-- start sidebar -->
			<?php get_sidebar('podcast'); ?>
			<!-- end sidebar -->
		</div>
<!-- end #content -->
	</div>
<!--end #primary/post -->    
<div class="clear"></div>
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>