<?php 
global $people_mb;
$people_mb->the_meta();
?>

<div id="sidebar" class="people widget-area span-5 prepend-1 append-bottom last" role="complementary">
	<?php if ( ! dynamic_sidebar( 'people-sidebar' ) ) : ?>
	<?php endif; // end sidebar widget area ?>
		<?php
        $postslug = $post->post_name;
        
        $args=array(
           'showposts' => 5,
           'author' => $postslug,
        );
        $posts=get_posts($args);
        if ($posts) {
          $author_id=$post->post_author;
          $curuser = get_userdata($author_id);
          $author_post_url=get_author_posts_url($curuser->ID); ?>
<div id="recentposts_mithblog" class="widget widget_recentposts_thumbnail"> 
	<h3>MITH Blog Posts</h3>
    <aside id="" class="widget-body clear">
            <ul id="mith-blog-feed">  
          <?php foreach($posts as $post) {
            setup_postdata($post); ?>
            <li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>" class="rpost clear">
            	<span class="rpost-title"><?php the_title(); ?></span>
                <span class="rpost-date"><?php the_time(__('M j, Y')) ?></span>
           	</a></li>
            <?php
          } // foreach($posts
        } // if ($posts ?>
            </ul>
    </aside>
</div><!-- end recentposts_mithblog -->

<?php $twit = $people_mb->get_the_value('twitter');
if ( $twit != '') { ?>

<div id="recent_tweets" class="widget widget_recent_tweets">
<h3>Recent Tweets</h3>
<aside class="widget-body clear">
<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
new TWTR.Widget({
  version: 2,
  type: 'profile',
  rpp: 10,
  interval: 10000,
  width: 190,
  height: 300,
  theme: {
    shell: {
      background: '#ffffff',
      color: '#ffffff'
    },
    tweets: {
      background: '#ffffff',
      color: '#242424',
      links: '#2e7cc6'
    }
  },
  features: {
    scrollbar: false,
    loop: true,
    live: true,
    behavior: 'default'
  }
}).render().setUser('<?php echo $twit ?>').start();
</script>
<div class="twitter-more">
	<a href="http://www.twitter.com/#!/<?php echo $twit ?>" rel="nofollow" target="_blank" class="follow">Follow</a>
</div>
</aside>
</div><!-- end recent_tweets -->
<?php } ?>

</div><!-- end sidebar -->