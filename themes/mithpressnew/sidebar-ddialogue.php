<div id="sidebar" class="ddialogue widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); 

    global $podcast2_mb;
	$podcast2_mb->the_meta();

?>
    <aside id="podcast-downloads" class="widget widget_downloads">
        <h3><?php _e( 'Available Downloads', 'mithpress' ); ?></h3>
        <p class="podcast-files">
			<?php $video = $podcast2_mb->get_the_value('vidurl');
			if ( $video != '') { ?>
            <a href="<?php echo $video ?>" rel="nofollow" class="pod-vid">Video</a>
            <?php } 
			$ppt = $podcast2_mb->get_the_value('ppturl');
			if ( $ppt != '') { ?>
            <a href="<?php echo $ppt ?>" rel="nofollow" class="pod-ppt">Powerpoint</a>
            <?php } 
			$keynote = $podcast2_mb->get_the_value('keyurl');
			if ( $keynote != '') { ?>
            <a href="<?php echo $keynote ?>" rel="nofollow" class="pod-key">Keynote</a>
            <?php } 
			$slides = $podcast2_mb->get_the_value('slideurl');
			if ( $slides != '') { ?>
            <a href="<?php echo $slides ?>" rel="nofollow" class="pod-sld">Slides Only</a>
            <?php } 
			$audio = $podcast2_mb->get_the_value('audurl');
			if ( $audio != '') { ?>
            <a href="<?php echo $audio ?>" rel="nofollow" class="pod-aud">Audio Only</a>
            <?php } ?>
            
        </p>
    </aside>

</div>