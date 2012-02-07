<?php
/**
 * The template used for displaying right column content on the home page page-home.php
**/
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-meta">

        <div class="author-avatar">
            <?php $author_email = get_the_author_meta('user_email'); ?>
            <?php echo get_avatar( $author_email, 42, get_bloginfo('template_url').'/images/no-avatar.png' ); ?>
        </div><!-- #author-avatar -->

        <div class="meta-line post-author"><a href="<?php bloginfo('url'); ?>/people/<?php the_author_meta( 'user_nicename'); ?>"><?php the_author(); ?></a></div>
        <div class="meta-line post_date"><?php the_time('F j, Y') ?></div>

    </div>
    <!-- /entry-meta -->

	<header class="entry-header">
		<h1 class="entry-title append-bottom"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'mithpress' ), the_title_attribute( 'echo=0' ) ); ?>"><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header-->
	<div class="entry-content">
		<?php custom_excerpt(75); ?>
	</div>
    <!-- /entry-content -->
    <br clear="all" />
</article>
<!-- /right-column -->