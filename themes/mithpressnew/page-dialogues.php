<?php
/*
Template Name: Dialogues
* display list of most recent podcasts
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
		  <?php get_sidebar('left'); ?>
<!--end sidebar / start podcast page content-->

			<div id="content" role="main" class="span-16 last">

			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'podcast',
					'showposts' => 5,
				) );
            ?>
  			<?php if ( have_posts() ) : ?>

				<?php mithpress_content_nav( 'nav-above' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', 'ddialogues'); ?>

				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>
            
			<?php endif; ?>
            
<!-- start right sidebar -->
	<?php get_sidebar('ddialogue'); ?>
<!-- end sidebar -->
			</div>
<!-- end #content -->
		</div>
<div class="clear"></div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>