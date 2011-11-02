<div id="slider">

<!-- BEGIN SLIDER -->
<div id="featured"> 
<?php $box1=get_page(get_option('mithpress_slide1'));
	  $box2=get_page(get_option('mithpress_slide2'));
	  $box3=get_page(get_option('mithpress_slide3')); 
	  $box4=get_page(get_option('mithpress_slide4')); 
?>

<!-- Slide 1-->
<?php 
$slide1img = get_post_thumbnail_id($box1->ID); ?>
<img src="<?php echo wp_get_attachment_url($slide1img); ?>" data-caption="#Caption1">
<!-- Slide 2 -->
<?php if ( get_option( 'mithpress_slide2' ) != null) { 
$slide2img = get_post_thumbnail_id($box2->ID); ?>
<img src="<?php echo wp_get_attachment_url($slide2img); ?>" data-caption="#Caption2">
<?php } ?>
<!-- Slide 3 -->
<?php if ( get_option( 'mithpress_slide3' ) != null) { 
$slide3img = get_post_thumbnail_id($box3->ID); ?>
<img src="<?php echo wp_get_attachment_url($slide3img); ?>" data-caption="#Caption3">
<?php } ?>
<!-- Slide 4 -->
<?php if ( get_option( 'mithpress_slide4' ) != null) { 
$slide4img = get_post_thumbnail_id($box4->ID); ?>
<img src="<?php echo wp_get_attachment_url($slide4img); ?>" data-caption="#Caption4">
<?php } ?>

</div>

<!-- Captions -->
<?php 
// caption 1
if ( get_option( 'mithpress_slide1' ) != null) { ?>
<span class="orbit-caption" id="Caption1">
    <?php if ( get_option( 'mithpress_slide1_img' ) != null) { ?> 
    	<img src="<?php echo get_option('mithpress_slide1_img'); ?>" border="0" class="caption-img" /><?php } ?>
	<h2><?php echo $box1->post_title ?></h2>
	<?php echo apply_filters('the_content', $box1->post_content);?>
	<a href="<?php echo get_option('mithpress_slide1_linkurl')?>" class="readmore"><?php echo get_option('mithpress_slide1_linktxt'); ?></a>
</span>
<?php }
// caption 2
if ( get_option( 'mithpress_slide2' ) != null) { ?>
<span class="orbit-caption" id="Caption2">
    <?php if ( get_option( 'mithpress_slide2_img' ) != null) { ?> 
    	<img src="<?php echo get_option('mithpress_slide2_img'); ?>" border="0" class="caption-img" /><?php } ?>
	<h2><?php echo $box2->post_title ?></h2>
	<?php echo apply_filters('the_content', $box2->post_content);?>
	<a href="<?php echo get_option('mithpress_slide2_linkurl')?>" class="readmore"><?php echo get_option('mithpress_slide2_linktxt'); ?></a>
</span>
<?php } 
// caption 3
if ( get_option( 'mithpress_slide3' ) != null) { ?>
<span class="orbit-caption" id="Caption3">
    <?php if ( get_option( 'mithpress_slide3_img' ) != null) { ?> 
    	<img src="<?php echo get_option('mithpress_slide3_img'); ?>" border="0" class="caption-img" /><?php } ?>
	<h2><?php echo $box3->post_title ?></h2>
	<?php echo apply_filters('the_content', $box3->post_content);?>
	<a href="<?php echo get_option('mithpress_slide3_linkurl')?>" class="readmore"><?php echo get_option('mithpress_slide3_linktxt'); ?></a>
</span>
<?php } 
// caption 4
if ( get_option( 'mithpress_slide4' ) != null) { ?>
<span class="orbit-caption" id="Caption4">
    <?php if ( get_option( 'mithpress_slide4_img' ) != null) { ?> 
    	<img src="<?php echo get_option('mithpress_slide4_img'); ?>" border="0" class="caption-img" /><?php } ?>
	<h2><?php echo $box4->post_title ?></h2>
	<?php echo apply_filters('the_content', $box4->post_content);?>
	<a href="<?php echo get_option('mithpress_slide4_linkurl')?>" class="readmore"><?php echo get_option('mithpress_slide4_linktxt'); ?></a>
</span>
<?php } ?>



<!-- END SLIDER -->
</div>