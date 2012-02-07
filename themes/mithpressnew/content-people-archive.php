<?php 
/**
 * The template for displaying past staff 
 *
**/
    global $people_mb;
	$people_mb->the_meta();
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
		<div class="entry-content">
			<div id="person" class="append-bottom prepend-top">                        	
				<div class="person-info">
					<span class="info-name"><?php the_title(); ?></span>
					<?php 
                    global $peopledates_mb;
                    $peopledates_mb->the_meta();
                    $i = 0;
                    while($peopledates_mb->have_fields('dates')) {
                    ?>
                    <?php 
                    if($i == 0) { ?>
					<span class="info-dates">
                    <?php } ?>
                            <?php  // loop a set of field groups
                    		$start = $peopledates_mb->get_the_value('start');
							$end = $peopledates_mb->get_the_value('end');
							$title = $peopledates_mb->get_the_value('title');
							echo '<span class="span-date"><em>' . $title . '</em>, ' . $start . '&ndash;' . $end . '</span>';
                            ?>
                        <?php
                             $i++;
                             // End while loop
                             } 
                         if($i > 0) { ?>
                        </span>
                    <?php } ?>                      
				</div>
			</div><!-- /person-->
		</div><!-- /entry-content -->
	
	</article>