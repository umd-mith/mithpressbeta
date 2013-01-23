<?php global $wp_query;
	query_posts( array(
		'post_type' => 'people',
		'posts_per_page' => '-1',
		'meta_key' => $people_mb->get_the_name('pplsort'),
		'orderby' => 'meta_value_num',
		'order' => 'ASC',
		'tax_query' => array(
		'relation' => 'AND',
			array(
				'taxonomy' => 'staffgroup',
				'field' => 'slug',
				'terms' => array( 'directors')
			),
			array(
				'taxonomy' => 'staffgroup',
				'field' => 'slug',
				'terms' => array( 'archive' ),
				'operator' => 'NOT IN'
			)
		)
	) );
?>				  
				  
<?php if ( have_posts() ) : ?>

	<header class="page-header">
		<h1 class="page-title append-bottom prepend-top">Directors</h1>
	</header>

	<?php while ( have_posts() ) : the_post(); 
	  global $people_mb; 
	  $people_mb->the_meta(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<div class="entry-content">
			<div id="person" class="append-bottom prepend-top">                        	
			<a href="<?php the_permalink(); ?>" rel="alternate" title="Permanent Link to <?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'mini-thumbnail' ); ?></span>
				<div class="person-info">
					<span class="info-name"><?php the_title(); ?></span>                            
					<span class="info-title"><?php $people_mb->the_value('stafftitle'); ?></span>
				</div>
			</a>

			</div><!-- /person-->
		</div><!-- /entry-content -->
	
	</article>

	<?php endwhile; ?>
<?php endif; ?>