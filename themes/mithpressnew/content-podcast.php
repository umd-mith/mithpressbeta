<?php
/**
 * The template for displaying content in the single.php template
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">
		<?php 
			$speaker = get_post_meta(get_the_ID(), 'pods-speaker', true);
			$affiliation = get_post_meta(get_the_ID(), 'pods-affiliation', true);
			$talkdate = get_post_meta(get_the_ID(), 'pods-date', true);
		?>
		<div class="pods-speaker"><?php echo $speaker; ?>, <span class="pods-affiliation"><?php echo $affiliation; ?></span></div>
        <div class="pods-date"><?php echo $talkdate; ?></div>
		<div class="pods-desc"><?php the_content(); ?></div>
        <div class="pods-media"></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', 'mithpress' ) . '</span>', 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->