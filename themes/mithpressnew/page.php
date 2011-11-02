<?php
/*
Template Name: 2-Column
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
		  <?php get_sidebar('left'); ?>
<!-- end subnav sidebar / start page content -->
			<div id="content" role="main" class="span-16 last">

                <?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

				<?php the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>

			</div>
<!--end page content-->
		</div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>