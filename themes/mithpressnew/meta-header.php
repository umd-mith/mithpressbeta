<div id="meta-column" class="span-5 append-1">
  <div class="author">
    <?php $author_email = get_the_author_meta('user_email'); ?>
    <?php echo get_avatar( $author_email, 55, get_bloginfo('template_url').'/images/no-avatar.png' ); ?>
  </div>
  <div class="meta-line post-author"><?php the_author(); ?></div>
  <div class="meta-line post_date"><?php the_time('F j, Y') ?></div>
  <div class="meta-line post-categories"><?php the_category(', ') ?></div>
  <!--<div class="meta-line posttags"><?php /*?><?php the_tags('Tags: ', ', ', '<br />'); ?><?php */?></div>-->
  <div class="meta-line post-comments"><?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments'), '', __('')); ?></div>
</div>
