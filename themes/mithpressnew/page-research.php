<?php
/*
Template Name: Research
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

			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'project',
					//'showposts' => 5,
				) );
            ?>
  			<?php if ( have_posts() ) : ?>

				<?php mithpress_content_nav( 'nav-above' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'project'); ?>

				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>
            
			<?php endif; ?>

			</div>
<!-- end page content -->
		</div>
<div class="clear"></div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>