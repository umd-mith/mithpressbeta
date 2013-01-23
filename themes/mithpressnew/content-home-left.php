<?php
/**
 * The template used for displaying left column content on the home page page-home.php
**/
?>
<?php
	$i++; // increment the counter
	if( $i % 2 != 0) { 
	$counter_class = 'odd'; // we're on an odd post
	} else {
	$counter_class = 'even'; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>

	<div class="entry-content">
        <div id="project-info" class="append-bottom prepend-top">
		<a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('full'); ?></a>
        
        </div>
	</div><!-- /entry-content -->

</article><!-- /post-<?php the_ID(); ?> -->
<!-- /left-column -->