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
		<!--end subnav / start podcast page content-->

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

					<?php get_template_part( 'content', 'ddialogues'); ?>

				<?php endwhile; ?>
				
                <nav id="nav-page">
                    <h3 class="assistive-text"><?php _e( 'Page navigation', 'mithpress' ); ?></h3>
                    <span class="nav-previous"><span class="meta-nav"></span><?php next_posts_link('Older', 0); ?></span>
                    <span class="nav-next"><span class="meta-nav"></span><?php previous_posts_link('Newer', 0) ?></span>
                </nav>

			<?php endif; ?>
        	</div>
		<!-- start sidebar -->
		<?php get_sidebar('ddialogue'); ?>
		<!-- end sidebar -->
                    
		</div>
<!-- end #content -->
	</div>
<!--end #primary/post -->    
<div class="clear"></div>
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>