<?php
/*
Template Name: 3-Column
*/
?>

<?php get_header(); ?>
<div id="page-container">
<div id="page" class="width-limit">
<!--start left sidebar-->
	<?php get_sidebar('left'); ?>
<!--end sidebar / start page content-->
    <div id="content" class="span-10">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2 class="append-bottom prepend-top"><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit', '<p>[ ', ' ]</p>'); ?>
    </div>
<!--end page content / start right sidebar -->
	<?php get_sidebar('right'); ?>
<!--end sidebar-->
</div>
<div class="clear"></div>
</div>
<!-- /page / start footer -->
<?php get_footer(); ?>