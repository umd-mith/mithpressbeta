<?php
	
// This template displays all of our individual show data in the sidebar.
// It's marked-up in hCalendar format, so fuck-around with caution.
// See http://microformats.org/wiki/hcalendar for specs

//	If you're curious what all variables are available in the $showdata array,
//	have a look at the docs: http://gigpress.com/docs/

?>

<li class="vevent <?php echo $class; ?>">
	<span class="gigpress-sidebar-date">
		<abbr class="dtstart" title="<?php echo $showdata['iso_date']; ?>"><?php echo $showdata['date']; ?></abbr>
		<?php if($showdata['end_date']) : ?>
			 - <abbr class="dtend" title="<?php echo $showdata['iso_end_date']; ?>"><?php echo $showdata['end_date']; ?></abbr>
		<?php endif; ?>
	</span>
	<span class="summary">
	<?php if($group_artists || $artist || $total_artists == 1) :
		// We don't need to show the artist name if we're grouping by artist,
		//	or if we''re only showing a single artist,
		// but we still need the text there for the hCalendar ?>
		<span class="hide"><?php endif;
		// start hiding ?>
		
        <span class="gigpress-sidebar-artist"><?php echo $showdata['artist']; ?></span> 
		<?php if($group_artists || $artist || $total_artists == 1) : // See above ?></span>
		<?php endif; // end hiding ?>

		<?php if($showdata['notes']) : ?>
			<span class="gigpress-info-item"><?php echo $showdata['notes']; ?></span>
		<?php endif; ?>
	</span> 
	<?php if($showdata['ticket_link']) : ?>
		<span class="gigpress-sidebar-status"><?php echo $showdata['ticket_link']; ?></span>
	<?php endif; ?>
</li>
