<?php
/**
 * The default template for displaying content
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <div class="entry-meta span-5 append-1">

        <div class="author-avatar">
            <?php $author_email = get_the_author_meta('user_email'); ?>
            <?php echo get_avatar( $author_email, 55, get_bloginfo('template_url').'/images/no-avatar.png' ); ?>
        </div><!-- /author-avatar -->

        <div class="meta-line post-author"><?php the_author(); ?></div>

        <div class="meta-line post_date"><?php the_time('F j, Y') ?></div>

        <div class="meta-line post-categories">
            <?php the_category(' <span>, </span> '); ?>
        </div>
        
		<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="meta-line">', '</div>' ); ?>
                
        <div class="meta-line post-comments">
            <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('')); ?>
        </div>
    </div>
    <!-- /entry-meta -->
	<div class="post-wrap">
	<header class="entry-header">
		<h1 class="entry-title append-bottom"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'mithpress' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header -->


	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
    <div class="entry-summary">
        <?php custom_excerpt(170); ?>
    </div>
    <!-- /.entry-summary / search -->
    <?php endif; ?>

    <div class="entry-content excerpt">
        <?php custom_excerpt(170); ?>
    </div>
    <!-- /entry-content -->
    </div>
    <!-- /post-wrap -->

	</article>
    <!-- /post-<?php the_ID(); ?> -->
