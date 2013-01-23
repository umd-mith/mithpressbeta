<?php
/**
 * The template for displaying content in the single.php template
 *
**/
    global $podcast_mb;
	$podcast_mb->the_meta();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<div id="podcast-info" class="excerpt append-bottom prepend-top clear">
			<span class="pods-date"><?php the_date( 'F j, Y' ); ?></span>
			<span class="pods-speaker"><?php $podcast_mb->the_value('speaker'); ?>
			<?php $stitle = $podcast_mb->get_the_value('speakertitle');
			if ( $stitle != '') { ?>, <span class="pods-stitle"><?php echo $stitle ?></span><?php } ?>
            </span> 
            <span class="pods-title"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></span>
        </div>
        <!-- /podcast-info -->
	</div>
    <!-- /entry-content -->
    <br clear="all" />

</article><!-- /post-<?php the_ID(); ?> -->