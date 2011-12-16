<div id="slider">

<!-- BEGIN SLIDER -->
<div id="featured"> 

<!-- Slide 1-->
<?php if ( of_get_option('slide_upload_one') ) { ?>
<img src="<?php echo of_get_option('slide_upload_one'); ?>" data-caption="#Caption1" />
<?php } ?>

<?php if ( of_get_option('slide_upload_two') ) { ?>
<img src="<?php echo of_get_option('slide_upload_two'); ?>" data-caption="#Caption2" />
<?php } ?>

<?php if ( of_get_option('slide_upload_three') ) { ?>
<img src="<?php echo of_get_option('slide_upload_three'); ?>" data-caption="#Caption3" />
<?php } ?>

<?php if ( of_get_option('slide_upload_four') ) { ?>
<img src="<?php echo of_get_option('slide_upload_four'); ?>" data-caption="#Caption4" />
<?php } ?>

</div>

<!-- Captions -->
<?php 
// caption 1
if ( of_get_option('slide_text_one') ) { ?>
<span class="orbit-caption" id="Caption1">
	<h2><?php echo of_get_option('slide_title_one', 'no entry'); ?></h2>
	<div class="slide_txt"><?php echo of_get_option('slide_text_one', 'no entry' ); ?></div>
</span>
<?php } 

// caption 2
if ( of_get_option('slide_text_two') ) { ?>
<span class="orbit-caption" id="Caption2">
	<h2><?php echo of_get_option('slide_title_two', 'no entry'); ?></h2>
	<div class="slide_txt"><?php echo of_get_option('slide_text_two', 'no entry' ); ?></div>
</span>
<?php } ?>



<!-- END SLIDER -->
</div>