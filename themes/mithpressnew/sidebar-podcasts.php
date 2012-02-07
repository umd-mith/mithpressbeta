<div id="sidebar" class="podcasts widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php // displayed on podcasts archive/listing page 
	
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); 

    global $podcast2_mb;
	$podcast2_mb->the_meta();

?>
</div>