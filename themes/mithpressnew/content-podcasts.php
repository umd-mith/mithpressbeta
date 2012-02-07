<?php
/**
 * The template for displaying podcasts in the archive-podcast.php template
 *
**/
    global $podcast_mb;
	$podcast_mb->the_meta();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header-->

	<div class="entry-content">
		<div id="podcast-info" class="excerpt append-bottom prepend-top clear">
			<?php the_post_thumbnail( 'med-thumbnail' ); ?>
			<span class="pods-speaker"><?php $podcast_mb->the_value('speaker'); ?>
			<?php $stitle = $podcast_mb->get_the_value('speakertitle');
			if ( $stitle != '') { ?>, <span class="pods-stitle"><?php echo $stitle ?></span><?php } ?>
            </span> 
        	<span class="pods-affiliation"><?php $podcast_mb->the_value('affiliation'); ?></span>
			<span class="pods-date"><?php the_date( 'F j, Y' ); ?></span>
        </div>
        <!-- /podcast-info -->
        
        <div id="abstract">
			<?php custom_excerpt(30); ?>
        </div>
        <!-- /abstract -->
	</div>
    <!-- /entry-content -->
    <br clear="all" />

</article><!-- /post-<?php the_ID(); ?> -->