<?php 
/**
 * The template for displaying content in the single-people.php templates
 *
**/

 
?>
<?php 
    global $people_mb;
    // get the meta data for the current post
	$people_mb->the_meta();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">

        <div id="personal-info" class="append-bottom prepend-top">
			<?php the_post_thumbnail( 'bio-image' ); ?>
        	<h1 class="entry-title"><?php the_title(); ?></h1>
            <h2 class="info-title">Staff Title</h2>
            <span class="info-email"><a href="mailto:#">email@domain.com</a></span>
            <span class="info-phone">301.123.4567</span>	
        </div><!-- /#personal-info -->
        
        <div id="bio">
            <?php the_content(); ?>
        </div><!-- /#bio -->
        
        <div id="info-links" class="column left">
        <ul>
            <li><a href="#">Link One</a></li>
            <li><a href="#">Link One</a></li>
        </ul>
        </div><!-- /#info-links --> 
        
	</div><!-- .entry-content -->

</article>
<!-- #post-<?php the_ID(); ?> -->