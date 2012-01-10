<?php
/**
 * The template for displaying content in the page-research.php template
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
        <div id="project-info" class="append-bottom prepend-top">
		<a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail( 'horiz-thumbnail' ); ?></a>
        
        </div>
	</div><!-- .entry-content -->

</article><!-- end post-<?php the_ID(); ?> -->