<?php
/**
 * The template for displaying content in the single.php template
 *
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <div class="entry-meta span-5 append-1">

        <div class="author-avatar">
            <?php $author_email = get_the_author_meta('user_email'); ?>
            <?php echo get_avatar( $author_email, 55, get_bloginfo('template_url').'/images/no-avatar.png' ); ?>
        </div>
        
        <div class="meta-line post-author"><a href="<?php bloginfo('url'); ?>/people/<?php the_author_meta( 'user_nicename'); ?>"><?php the_author(); ?></a></div>

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
		<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	</header>
    <!-- /entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
    </div>
    <!-- /entry-content -->
	<div id="sharing">
    	<div class="gp-link share-button"><g:plusone size="small" href="<?php the_permalink(); ?>"></g:plusone>
        </div>
        <div class="tw-link share-button">
        <a href="https://twitter.com/share" class="twitter-share-button" data-via="UMD_MITH" data-text="<?php the_title(); ?>" data-url="<?php the_permalink(); ?>">Tweet</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";
		fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
        <div class="fb-like share-button" data-href="http://mith-beta.umd.edu/" href="<?php echo get_permalink($post->ID); ?>" data-send="true" data-layout="button_count" data-width="140" data-show-faces="false" data-font="arial">
        </div>        
    </div>
	<!-- /sharing -->
	<?php //get_template_part( 'content', 'share' ); ?>
    
    </div>
    <!-- /post-wrap -->
    
    <br clear="all" />

</article><!-- /post-<?php the_ID(); ?> -->