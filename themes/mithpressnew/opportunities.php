<?php
/**
 * @package WordPress
 * @subpackage MITH_v3
 */
/*
Template Name: Opportunities
*/
$url = get_bloginfo('url');
$breadcrumbs[] = "<a href=\"$url/blog/\">MITH Blog</a>";
$breadcrumbs[] = "Opportunities";
include (TEMPLATEPATH . "/header.php"); ?>

<div class="main">

<h2>Opportunities at MITH</h2>
<h3>Calls for involvement in the MITH Community</h3>

	<div id="content" class="narrowcolumn" role="main">

	  <?php query_posts('category_name=opportunities'); ?>

	  <?php while (have_posts()) : the_post(); ?>

			<div <?php post_class() ?> id="post-<?php the_ID(); ?>">
				<div class="post_date">
					<small class="post_month"><?php the_time('M') ?></small>
					<p class="post_day"><?php the_time('d') ?></p>
					<small class="post_year"><?php the_time('Y') ?></small>
				</div>
				<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>

				<div class="entry">
					<?php the_content('Read the rest of this entry &raquo;'); ?>
				</div>

				<div class="clear"></div>

				<p class="postmetadata">
					<small class="posttags"><?php the_tags('Tags: ', ', ', '<br />'); ?></small>
					Posted in <?php the_category(', ') ?> | <?php edit_post_link('Edit', '', ' | '); ?></p>
			</div>

 		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Older Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
		</div>

	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
