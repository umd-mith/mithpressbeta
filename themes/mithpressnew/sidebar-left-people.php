<nav id="subnav" class="span-5 append-1">
<h3 class="assistive-text"><?php _e( 'Secondary menu', 'mithpress' ); ?></h3>
    <h1 class="append-bottom">Staff</h1>
<div id="img-links">
	<ul id="menu-people">
	<?php global $wp_query;
        query_posts( array(
            'post_type' => 'people',
        ) );
	if (have_posts()) : while (have_posts()) : the_post(); ?>
		<li class="item"><a href="<?php the_permalink(); ?>" rel="alternate" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'mini-thumbnail' ); ?></a></li>

<?php endwhile; else : ?>
<?php endif; wp_reset_query(); ?>
	</ul>
</div>
</nav>