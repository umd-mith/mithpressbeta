<?php
/**
 * The template used for displaying page content in page.php
**/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
	echo '<div class="entry-image">';
        the_post_thumbnail();
	echo '</div>';
	} ?>

	<header class="entry-header">
		<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	</header>
    <!-- /entry-header -->
	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mithpress' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div>
    <!-- /entry-content -->
    
	<footer class="entry-meta">
		<?php edit_post_link( __( 'Edit', 'mithpress' ), '<span class="edit-link">', '</span>' ); ?>
	</footer>
    <!-- /entry-meta -->

</article>
<!-- #post-<?php the_ID(); ?> -->