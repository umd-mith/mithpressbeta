<?php
/**
 * The template for displaying content for single podcasts
 *
**/
    global $podcast_mb;
	$podcast_mb->the_meta();

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
	</header>
    <!-- end entry-header-->

	<div class="entry-content">
		<div id="podcast-info" class="append-bottom prepend-top clear">
			<?php the_post_thumbnail( 'med-thumbnail' ); ?>
			<span class="pods-speaker"><?php $podcast_mb->the_value('speaker'); ?>
			<?php $stitle = $podcast_mb->get_the_value('speakertitle');
			if ( $stitle != '') { ?>, <span class="pods-stitle"><?php echo $stitle ?></span><?php } ?>
            </span> 
        	<span class="pods-affiliation"><?php $podcast_mb->the_value('affiliation'); ?></span>
			<span class="pods-date"><?php the_date( 'F j, Y' ); ?></span>
		<?php $twitter = $podcast_mb->get_the_value('twitter');
			if ( $twitter != '') { ?>
            <span class="pods-twitter"><a href="http://www.twitter.com/#!/<?php echo $twitter ?>" rel="nofollow" target="_blank">@<?php echo $twitter ?></a></span>
        <?php } ?>
            </div>
        <!-- end podcast-info -->
        
        <div id="abstract">
			<?php the_content(); ?>
        </div>
        <!-- end abstract -->
	</div>
    <!-- end entry-content -->
    <br clear="all" />
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article><!-- end post-<?php the_ID(); ?> -->