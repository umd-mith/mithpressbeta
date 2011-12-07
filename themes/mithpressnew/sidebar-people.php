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
</div>
</div><!-- #secondary .widget-area -->