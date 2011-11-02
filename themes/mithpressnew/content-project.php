<?php
/**
 * The template for displaying content in the single-project.php and page-research.php templates
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">
		<?php 
			$thumbnail = get_post_meta(get_the_ID(), 'project-thumb', true);
		?>
		<div class="project-thumb"><img src="<?php echo $thumbnail; ?>" class="pthumb" border="0" alt="project thumb" /></div>
        <div class="pods-date"><?php echo $talkdate; ?></div>
		<!--<div class="pods-desc"><?php the_content(); ?></div>-->
        <div class="pods-media"></div>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->