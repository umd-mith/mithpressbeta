<div id="sidebar" class="podcast widget-area span-5 prepend-1 append-bottom last" role="complementary">

<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('podcast') ); 

    global $podcast2_mb;
	$podcast2_mb->the_meta();

?>
    <aside id="podcast-downloads" class="widget widget_downloads">
        <h3><?php _e( 'Available Downloads', 'mithpress' ); ?></h3>
        <ul class="podcast-files">
			<?php $video = $podcast2_mb->get_the_value('vidurl');
			if ( $video != '') { ?>
            <li>
            <a href="<?php echo $video ?>" rel="nofollow" class="pod-vid">Video</a>
            </li>
            <?php } 
			$ppt = $podcast2_mb->get_the_value('ppturl');
			if ( $ppt != '') { ?>
            <li>
            <a href="<?php echo $ppt ?>" rel="nofollow" class="pod-ppt">Powerpoint</a>
            </li>
            <?php } 
			$keynote = $podcast2_mb->get_the_value('keyurl');
			if ( $keynote != '') { ?>
            <li>
            <a href="<?php echo $keynote ?>" rel="nofollow" class="pod-key">Keynote</a>
            </li>
            <?php } 
			$slides = $podcast2_mb->get_the_value('slideurl');
			if ( $slides != '') { ?>
            <li>
            <a href="<?php echo $slides ?>" rel="nofollow" class="pod-sld">Slides Only</a>
            </li>
            <?php } 
			$audio = $podcast2_mb->get_the_value('audurl');
			if ( $audio != '') { ?>
            <li>
            <a href="<?php echo $audio ?>" rel="nofollow" class="pod-aud">Audio Only</a>
            </li>
            </li>
            <?php } ?>
        </ul>
    </aside>

</div>