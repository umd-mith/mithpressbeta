<?php
/**
 * The template for displaying content in the single.php template
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><?php the_title(); ?></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php mithpress_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header>
    <!-- end entry-header-->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mithpress' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
    
	</footer><!-- .entry-meta -->
</article><!-- end post-<?php the_ID(); ?> -->