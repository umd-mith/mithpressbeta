<?php
/*
Template Name: Home
*/
?>
<?php get_header(); ?>
<div id="page-container" class="home-page">
		<div id="primary" class="width-limit">
			<div id="content" role="main" class="span-22 last">

			<?php get_template_part( 'slider', 'home' ); ?>
            <!-- /slideshow -->

            <div id="twitter_wrap">
				<a href="http://www.twitter.com/#!/UMD_MITH" rel="nofollow" target="_blank" class="follow">&nbsp;</a>

                <script src="http://widgets.twimg.com/j/2/widget.js"></script>
                <script>
                new TWTR.Widget({
                  version: 2,
                  type: 'profile',
                  rpp: 20,
                  interval: 30000,
                  width: '1000',
                  height: 15,
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
					hashtags: true,
					timestamp: true,
                    behavior: 'default'
                  }
                }).render().setUser('umd_mith').start();
                </script>                     
            </div>
            <!-- /twitter feed -->
		<div id="column-wrap">
			<div id="left-column">
				<header class="page-header">
					<h1 class="page-title">Research + Projects</h1>
                </header>
			<?php 
			
			$args = array(
				'post_type' => 'project',
				'posts_per_page' => -1
				);
			$posts = new WP_Query( $args ); ?>
			<?php 
			$i = 0; // set up a counter so we know which post we're currently showing
			$counter_class = 'even'; // set up a variable to hold an extra CSS class
			if ( $posts -> have_posts() ) : 
			while ( $posts -> have_posts() ) : $posts->the_post(); 
			$i++; // increment the counter
                if( $i % 2 != 0) { 
                $counter_class = 'odd'; // we're on an odd post
                } else {
                $counter_class = 'even'; }
            ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class($counter_class); ?>>
            
                <div class="entry-content">
                    <div id="project-info" class="append-bottom prepend-top">
                    <a href="<?php the_permalink(); ?>" ><?php the_post_thumbnail('full'); ?></a>
                    
                    </div>
                </div><!-- .entry-content -->
            
            </article><!-- end post-<?php the_ID(); ?> -->
    		<?php endwhile; endif; wp_reset_query(); ?>
            </div>
            <!-- /left-column -->
            
            <div id="right-column">
				<header class="page-header">
					<h1 class="page-title">Events + Community</h1>
                </header>
			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'post',
					'posts_per_page' => '2',
				) );
            ?>
  			<?php if ( have_posts() ) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'content', 'home-right'); ?>
			<?php endwhile; endif; ?>
            </div>
            <!-- /right-column -->
		</div>
        <!-- /column-wrap -->
			</div>
<!--end page content-->
		</div>
<!-- end #primary -->
</div>
<!-- end page / start footer -->

<?php get_footer(); ?>