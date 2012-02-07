<?php get_header(); ?>
	<div id="pageHead">
		<h1>
		<?php global $post; if(have_posts()) : ?>		
		    <?php
			$category = get_the_category();
			$cat_parent_id = $category[0]->category_parent;			
			if($cat_parent_id) :
				echo get_cat_name($cat_parent_id);
			else :			
				echo $category[0]->cat_name;
			endif;
			?>		    
		<?php endif; ?>
		</h1>
	</div>
	<div id="main" class="page clearfix">			 
	<div id="content" class="twoThird clearfix">
		<?php while (have_posts()) : the_post(); ?>
			    
		<div <?php post_class(); ?>>													
			<h1><a href="<?php the_permalink() ?>" rel="bookmark" ><?php the_title(); ?></a></h1>
			<div class="meta clearfix">						
				<?php _e('Posted by', 'themetrust'); ?> <?php the_author_posts_link(); ?> <?php _e('on', 'themetrust'); ?> <?php the_time( 'M j, Y' ) ?> <?php _e('in', 'themetrust'); ?> <?php the_category(', ') ?> | <a href="<?php comments_link(); ?>"><?php comments_number(__('No Comments', 'themetrust'), __('One Comment', 'themetrust'), __('% Comments', 'themetrust')); ?></a>
			</div>
			<?php edit_post_link(__('Edit Post', 'themetrust'), '<p>', '</p>'); ?>	
			<?php the_content(); ?>																							
		</div>				
		<?php comments_template('', true); ?>
			
		<?php endwhile; ?>					    	
	</div>
		
	<?php get_sidebar(); ?>					
	</div>
<?php get_footer(); ?>
