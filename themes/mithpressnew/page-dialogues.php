<?php
/*
Template Name: Dialogues
* display dialogues information and brief list of most recent dialogues
*/
?>
<?php get_header(); ?>
<div id="page-container">
		<div id="primary" class="width-limit">
		<!--start subnav -->
		<?php get_sidebar('left'); ?>
		<!--end subnav / start digital dialogues page content-->

		<div id="content" role="main" class="span-16 last">
			<?php if (function_exists('mithpress_breadcrumbs')) mithpress_breadcrumbs(); ?>
        	<div id="articles">
                        
			<?php the_post(); ?>
			<?php if ( has_post_thumbnail() ) { // check if the post has a Post Thumbnail assigned to it.
            echo '<div class="entry-image">';
                the_post_thumbnail();
            echo '</div>';
            } ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            
            </article>
            <!-- /post-<?php the_ID(); ?> -->

			<?php global $wp_query;
				query_posts( array(
					'post_type' => 'podcast',
					'posts_per_page' => '3',
				) );
            ?>
  			<?php if ( have_posts() ) : ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class('span-narrow'); ?>>
                <header class="entry-header prepend-top">
                    <h1 class="entry-title append-bottom prepend-top">Recent Dialogues</a></h1>
                </header>
                <!-- /entry-header-->
            
				<ul id="recent-dialogues">
				<?php while ( have_posts() ) : the_post(); 
				  global $podcast_mb; 
				  $podcast_mb->the_meta(); ?>
                	<li>
                    	<a href="<?php the_permalink(); ?>" >
                            <span class="pods-date"><?php the_date( 'F j, Y' ); ?></span>
                            <span class="pods-speaker"><?php $podcast_mb->the_value('speaker'); ?>
                            <?php $stitle = $podcast_mb->get_the_value('speakertitle');
                            if ( $stitle != '') { ?>, <span class="pods-stitle"><?php echo $stitle ?></span><?php } ?>
                            </span> 
                            <span class="pods-title"><?php the_title(); ?></span>
						</a>
                    </li>    

				<?php endwhile; ?>
                </ul>
			</article>
            <!-- /post-<?php the_ID(); ?> -->
			<?php endif; ?>
            </div>
            <!-- /articles -->
		<?php get_sidebar('ddialogue'); ?>
		<!-- /sidebar -->
        	</div>
                    
		</div>
<!-- /content -->
	</div>
<!--end #primary/post -->    
<div class="clear"></div>
</div>
<!-- /page / start footer -->

<?php get_footer(); ?>