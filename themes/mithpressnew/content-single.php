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
    <!-- end entry-meta -->
        
	<header class="entry-header">
		<h1 class="entry-title append-bottom"><?php the_title(); ?></h1>
	</header>
    <!-- end entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
        
        <div class="dd_post_share">
        <div class="dd_buttons">
            <div class="dd_button twitter-share">
               <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
            </div>
            <div class="dd_button facebook-share"><!-- Uses the iframe on legacy IEs. -->
               <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=92&amp;action=like&amp;colorscheme=light" scrolling="no" frameborder="0" allowTransparency="true" style="border:none; overflow:hidden; width:92px; height:21px;"></iframe>
            </div>
            <div class="dd_button digg-share">
               <script type="text/javascript">
               (function() {
               var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
               s.type = 'text/javascript';
               s.async = true;
               s.src = 'http://widgets.digg.com/buttons.js';
               s1.parentNode.insertBefore(s, s1);
               })();
               </script>
            
               <a class="DiggThisButton DiggCompact"></a>
            </div>
            <div class="dd_button stumble-share">
            <script src="http://www.stumbleupon.com/hostedbadge.php?s=2"></script>
            </div>
            <div class="dd_button gplus-share">
			<!-- Place this tag where you want the +1 button to render -->
            <g:plusone size="small"></g:plusone>
            
            <!-- Place this render call where appropriate -->
            <script type="text/javascript">
              (function() {
                var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
                po.src = 'https://apis.google.com/js/plusone.js';
                var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
              })();
            </script>
           </div>
        </div>
	</div>
	<!-- end dd_post_share -->
        
    </div>
    <!-- end entry-content -->
    
    <br clear="all" />
	<?php edit_post_link( __( 'Edit', 'mithpress' ), '<div class="edit-link">', '</div>' ); ?>

</article><!-- end post-<?php the_ID(); ?> -->