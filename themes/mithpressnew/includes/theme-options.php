<?php 
/*-----------------------------------------------------------------------------------*/
/* Theme Options Page */
/*-----------------------------------------------------------------------------------*/

add_action('admin_menu', 'mithpress_theme_page');

function mithpress_theme_page () {
	if ( count($_POST) > 0 && isset($_POST['mithpress_settings']) ) {
		
		$options = array ('slide1','slide2','slide3','slide4','slide1_img','slide2_img','slide3_img','slide4_img','slide1_linkurl','slide2_linkurl','slide3_linkurl','slide4_linkurl','slide1_linktxt','slide2_linktxt','slide3_linktxt','slide4_linktxt','linkedin_link','twitter_user','latest_tweet','facebook_link','slider');
		foreach ( $options as $opt ) {
			delete_option ( 'mithpress_'.$opt, $_POST[$opt] );
			add_option ( 'mithpress_'.$opt, $_POST[$opt] );	
		}			
		 
	}
	add_theme_page( 'MITHPress Theme Options', 'Theme Options', 'edit_themes', 'mithpress_theme_options', 'mithpress_settings' );
}

/*-----------------------------------------------------------------------------------*/

// Slideshow Options Page Content
function mithpress_settings() {
?>

<div class="wrap">
	<h2>Theme Options</h2>
	
<form method="post" action="">
  <fieldset class="mith-options">
	<legend>Homepage Settings</legend>
	<div class="form-table">
		<h3>Homepage Slider</h3>
        <label for="slide1" class="subheader">Slide #1</label>
		<div class="form-row">
			<span><label for="slide1_txt">Select page:</label><?php wp_dropdown_pages("name=slide1&show_option_none=".__('- Select -')."&selected=" .get_option('mithpress_slide1')); ?></span>
			<span><label for="slide1_img">Slide #1 Logo (optional)</label>
            <input name="slide1_img" type="text" id="slide1_img" value="<?php echo get_option('mithpress_slide1_img'); ?>" size="90"/></span>
			<span><?php if ( get_option( 'mithpress_slide1_img' ) != null) { ?><label for="slide1_img">Current logo:</label><img src="<?php echo get_option('mithpress_slide1_img'); ?>" /> <?php } ?></span>
          <span><label for "slide1_linkurl">Link URL:</label><input name="slide1_linkurl" type="text" id="slide1_linkurl" value="<?php echo get_option('mithpress_slide1_linkurl'); ?>" size="35" />
          <label for "slide1_linktxt">Link text:</label><input name="slide1_linktxt" type="text" id="slide1_linktxt" value="<?php echo get_option('mithpress_slide1_linktxt'); ?>" size="35" /></span>
        </div>
        <br clear="all" />
        <label for="slide2" class="subheader">Slide #2</label>
		<div class="form-row">
			<span><label for="slide2_txt">Select page:</label><?php wp_dropdown_pages("name=slide2&show_option_none=".__('- Select -')."&selected=" .get_option('mithpress_slide2')); ?></span>
			<span><label for="slide2_img">Slide #2 Logo (optional)</label>
            <input name="slide2_img" type="text" id="slide2_img" value="<?php echo get_option('mithpress_slide2_img'); ?>"/></span>
			<span><?php if ( get_option( 'mithpress_slide2_img' ) != null) { ?><label for="slide2_img">Current logo:</label><img src="<?php echo get_option('mithpress_slide2_img'); ?>" /> <?php } ?></span>
        </div>
        <br clear="all" />
        <label for="slide3" class="subheader">Slide #3</label>
		<div class="form-row">
			<span><label for="slide3_txt">Select page:</label><?php wp_dropdown_pages("name=slide3&show_option_none=".__('- Select -')."&selected=" .get_option('mithpress_slide3')); ?></span>
			<span><label for="slide3_img">Slide #3 Logo (optional)</label>
            <input name="slide3_img" type="text" id="slide3_img" value="<?php echo get_option('mithpress_slide3_img'); ?>"/></span>
			<span><?php if ( get_option( 'mithpress_slide3_img' ) != null) { ?><label for="slide3_img">Current logo:</label><img src="<?php echo get_option('mithpress_slide3_img'); ?>" /> <?php } ?></span>
        </div>
        <br clear="all" />
        <label for="slide4" class="subheader">Slide #4</label>
		<div class="form-row">
			<span><label for="slide4_txt">Select page:</label><?php wp_dropdown_pages("name=slide4&show_option_none=".__('- Select -')."&selected=" .get_option('mithpress_slide4')); ?></span>
			<span><label for="slide4_img">Slide #4 Logo (optional)</label>
            <input name="slide4_img" type="text" id="slide4_img" value="<?php echo get_option('mithpress_slide4_img'); ?>"/></span>
			<span><?php if ( get_option( 'mithpress_slide4_img' ) != null) { ?><label for="slide4_img">Current logo:</label><img src="<?php echo get_option('mithpress_slide4_img'); ?>" /> <?php } ?></span>
        </div>
        <br clear="all" />
  </fieldset>
	<p class="submit">
		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		<input type="hidden" name="mithpress_settings" value="save" style="display:none;" />
		</p>

</div>
<?php } ?>