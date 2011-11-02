<div id="sidebar" class="blog widget-area span-5 prepend-1 append-bottom last" role="complementary">
  <!-- Recent Posts-->
    <!-- RSS -->
  <div class="widget widget_getconnected">
  	<div class="widget-body clear">
  		<div class="getconnected_rss">
  			<a href="<?php echo ( get_option('feedburner_url') )? get_option('feedburner_url') : get_bloginfo('rss2_url'); ?>">&nbsp;</a>
			<?php echo (get_option('feedburner_url') && function_exists('feedcount'))? feedcount( get_option('feedburner_url') ) : ''; ?>
  		</div>
  	</div>
  </div>
  <!-- /RSS -->

  <div class="widget widget_recentposts">
  	<h3>Recent Posts</h3><div class="widget-body clear">
            <?php
                global $post;
                if (get_option('rpthumb_qty')) $rpthumb_qty = get_option('rpthumb_qty'); else $rpthumb_qty = 3;
                $q_args = array(
                    'numberposts' => $rpthumb_qty,
                );
                $rpthumb_posts = get_posts($q_args);
                foreach ( $rpthumb_posts as $post ) :
                    setup_postdata($post);
            ?>
                <a href="<?php the_permalink(); ?>" class="rpthumb clear">
                    <?php if ( has_post_thumbnail() && !get_option('rpthumb_thumb') ) {
                        the_post_thumbnail('mini-thumbnail');
                        $offset = 'style="padding-left: 65px;"';
                    }
                    ?>
                    <span class="rpthumb-title"><?php the_title(); ?></span>
                    <span class="rpthumb-date"><?php the_time(__('M j, Y')) ?></span>
                </a>
            <?php endforeach; ?>
    </div>
  </div>
  
  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Blog Sidebar') ); ?>

</div>