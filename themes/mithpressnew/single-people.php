<?php get_header(); ?>

<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
		  <?php get_sidebar('left'); ?>
<!--end sidebar / start single content-->
			<div id="content" role="main" class="span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
			
			<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'person' ); ?>
	
				<?php endwhile; // end of the loop. ?>

<!-- start sidebar -->
		<?php get_sidebar('people'); ?>
<!-- end sidebar -->
		</div>
<!-- end #content -->
	</div>
<!--end #primary/post -->    
<div class="clear"></div>
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>