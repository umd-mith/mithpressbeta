<?php 
/**
 * The template for displaying content in the single-project.php and page-research.php templates
 *
**/

 
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<h1 class="entry-title append-bottom prepend-top"><a href="<?php the_permalink(); ?>" ><?php the_title(); ?></a></h1>
	</header>
    <!-- /entry-header -->

	<div class="entry-content">

<!-- get the personal -->
	<?php 
    global $people_mb;
    // get the meta data for the current post
	$people_mb->the_meta();
    echo get_post_meta(get_the_ID(),'title',TRUE);?>
	<div id="personal-info">
    	<span class="title"><?php $people_mb->the_value('title'); ?></span>
		<?php if ($people_mb->the_value('email') != '') {
			echo '<span class="email">';
			echo $people_mb->the_value('email');
			echo '</span>';
		} if ($people_mb->the_value('phone') != '') {
			echo '<span class="phone">';
			echo $people_mb->the_value('phone');
			echo '</span>';
		} ?>	
    </div>
    <div id="bio">
        <?php the_content(); ?>
    </div>

	<?php
	if ($people_mb->the_meta() != '') {
    echo '<div id="links" class="column left">';
    echo '<ul>';
        while($people_mb->have_fields('links'))
    {
		echo '<li><a href="';
		$people_mb->the_value('url');
		echo '" target="_blank">';
		$people_mb->the_value('title');
		echo'</a></li>';
    } 
    echo '</ul>';
    echo '</div>'; } ?>  
    
    </div><!-- .entry-content -->

</article>
<!-- #post-<?php the_ID(); ?> -->