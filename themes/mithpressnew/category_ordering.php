<?php get_term( $term, $taxonomy, $output, $filter ) ?> 

<?php $peopleQuery = new WP_Query(array('post_type' => 'people', 'orderby' => 'category', 'order' => 'ASC', 'posts_per_page' => '-1')); ?>
        	<?php $prevcat = ""; ?>
			<?php if(have_posts()) { while ( $peopleQuery->have_posts() ) { $peopleQuery->the_post(); ?>
            	<?php $category = get_term( 'staffgroup' ); ?>
        		<?php $curcat = $category; ?>
        		<?php if($curcat != $prevcat) : ?>
          			<a name="section-<?php echo $curcat ?>"></a><br class="clear" /><h2><?php echo $curcat; $prevcat = $curcat; ?></h2>
        		<?php endif; ?>
        
        		<article class="professional-entry" id="entry-<?php echo $last_char ?>">

				  	<div><strong><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></strong></div>
				  	<div><?php $terms = get_the_terms( $post->ID , 'titles' ); foreach( $terms as $term ) { print $term->name; unset($term); } ?></div>
				  	<div><a href="mailto:<?php echo get_post_meta($post->ID, 'prof_email', true); ?>"><?php echo get_post_meta($post->ID, 'prof_email', true); ?></a></div>
				
				</article>
        
			<?php }} // End the loop. Whew. ?>