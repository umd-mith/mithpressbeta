<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 */

get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
<!--start subnav -->
<?php if ( is_post_type_archive('people') ) { 
	get_sidebar('left-people'); }
	else {
	get_sidebar( 'left' ); 	
	} 
?>
<!-- end subnav sidebar / start archive content -->
			<div id="content" role="main" class="archive span-16 last">
			
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>

			<?php if ( have_posts() ) : ?>

                <header class="page-header">
                    <h1 class="page-title append-bottom prepend-top">
						<?php if ( is_day() ) : ?>
							<?php printf( __( 'Daily Archives: %s', 'mithpress' ), '<span>' . get_the_date() . '</span>' ); ?>
						<?php elseif ( is_month() ) : ?>
							<?php printf( __( 'Monthly Archives: %s', 'mithpress' ), '<span>' . get_the_date( 'F Y' ) . '</span>' ); ?>
						<?php elseif ( is_year() ) : ?>
							<?php printf( __( 'Yearly Archives: %s', 'mithpress' ), '<span>' . get_the_date( 'Y' ) . '</span>' ); ?>
                        <?php elseif ( is_post_type_archive() ) : ?>
                        	<?php post_type_archive_title(); _e(' Archive', 'mithpress' ); ?>
						<?php else : ?>
							<?php _e( 'Blog Archives', 'mithpress' ); ?>
						<?php endif; ?>
					</h1>
				</header>


				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

				<?php mithpress_content_nav( 'nav-below' ); ?>

			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="page-header">
						<h1 class="page-title append-bottom prepend-top"><?php _e( 'Nothing Found', 'mithpress' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="page-content">
						<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'mithpress' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

        </div>
<!-- end #content -->
	</div>
<div class="clear"></div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>