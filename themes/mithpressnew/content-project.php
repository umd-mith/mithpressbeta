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
		<div class="project-thumb">

        </div>
	</div><!-- .entry-content -->
    <br clear="all" />
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->