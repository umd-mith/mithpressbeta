<?php
/**
 * The template for displaying content in the single.php template
 *
**/

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">
<?php 

// usually needed
global $podcast_mb;
 
// get the meta data for the current post
$meta = $podcast_mb->the_meta();
print_r($meta);

?>
        
        
        </div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mithpress' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->