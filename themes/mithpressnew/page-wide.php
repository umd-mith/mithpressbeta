<?php
/*
Template Name: 2-Column (Wide)
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">

		<?php get_sidebar('left'); ?>
		<!-- /subnav -->
			<div id="content" role="main" class="span-16 wide last">

                <?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

				<?php the_post(); ?>
				
				<?php get_template_part( 'content', 'page' ); ?>

			</div>
			<!-- /page content-->
		</div>
		<!-- /primary -->
</div>
<!-- /page -->

<?php get_footer(); ?>