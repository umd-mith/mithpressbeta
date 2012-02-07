<nav id="subnav" class="span-5 append-1">
<h3 class="assistive-text"><?php _e( 'Secondary menu', 'mithpress' ); ?></h3>
    <h1 class="append-bottom">People</h1>
<div id="img-links">
	<ul id="menu-people">
<?php 
	global $people_mb;
	$people_mb->the_meta();
	$args = array(
		'post_type' => 'people',
		'meta_key' => $people_mb->get_the_name('lname'),
		'orderby' => 'meta_value',
		'order' => 'ASC',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'staffgroup',
				'field' => 'slug',
				'terms' => array( 'archive' ),
				'operator' => 'NOT IN'
			)
		)
	);
	query_posts( $args );

	if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li class="item"><a href="<?php the_permalink(); ?>" rel="alternate" title="Profile of <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'mini-thumbnail' ); ?></a></li>

<?php endwhile; ?>
<?php endif; wp_reset_query(); ?>
	</ul>
</div>
</nav>