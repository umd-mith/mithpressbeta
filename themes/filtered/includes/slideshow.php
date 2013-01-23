<?php
query_posts( array(
	'ignore_sticky_posts' => 1,
    'meta_key' => '_ttrust_in_slideshow_value',
	'meta_value' => 'true',
    'posts_per_page' => 20,
    'post_type' => array(
		'page',
		'projects'		
	)
));
?>

<?php if(have_posts()) :?>
<div id="slideshow" class="clearfix">	
	<div id="slider" class="clearfix">			
		
		<?php $i = 1; while (have_posts()) : the_post(); ?>			
		<?php $style = ""; ?>
		<?php if($i > 1) $style = "display: none;"; ?> 
			<?php $deactivate_links = ttrust_get_option('ttrust_slide_deactivate_links'); ?>
			<?php $slideLink = get_permalink(); ?>
			<?php $slide_img = get_post_meta($post->ID, "_ttrust_slideshow_img_value", true); ?>
			<?php if($deactivate_links) : ?>
				<img src="<?php echo $slide_img; ?>" alt="<?php the_title(); ?>" />	    		
			<?php else :?>							
				<a href="<?php the_permalink() ?>" rel="bookmark" ><img src="<?php echo $slide_img; ?>" alt="<?php the_title(); ?>" /></a>		    		
			<?php endif; ?>
							
		<?php $i++; endwhile; ?>
		<?php wp_reset_query();?>		
		
	</div>	
</div>
<?php endif; ?>	