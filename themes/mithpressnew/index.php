<?php
/**
 * The main template file.
**/

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!-- start blog content -->
			<div id="content" role="main" class="span-16 last">

            <?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
		
            <div id="posts">
			<?php if ( have_posts() ) : ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', get_post_format() ); ?>

				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'mithpress' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'mithpress' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>
            </div>

		<!--end blog content / start sidebar -->
		<?php get_sidebar('blog'); ?>
		<!--end sidebar-->
		</div><!-- end content-->
	</div><!--end #primary/blog -->    

<div class="clear"></div>

</div><!-- end page / start footer -->

<?php get_footer(); ?>