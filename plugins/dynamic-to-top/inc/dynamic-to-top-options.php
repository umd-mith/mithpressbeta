<?php
/**
* Dynamic To Top Options
*
* @package 		Dynamic To Top
* @subpackage 	Options
* @author 		Matt Varone
*/

add_action( 'admin_menu', 'mv_dynamic_to_top_create_options_page' );
add_action( 'admin_init', 'mv_dynamic_to_top_register_and_build_fields' );

if ( ! function_exists( 'mv_dynamic_to_top_create_options_page' ) )
{
	
	/** 
	* Create Options Page 
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_create_options_page() {
		// Create Options Page
		add_theme_page( __( 'Dynamic To Top Options', 'dynamic-to-top' ), __( 'To Top', 'dynamic-to-top' ), 'manage_options', __FILE__, 'mv_dynamic_to_top_options_page' );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_register_and_build_fields' ) )
{
	
	/** 
	* Register and Build Fields
	*
	* Register fields and sections.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_register_and_build_fields() {
		register_setting( 'dynamic_to_top', 'dynamic_to_top', 'mv_dynamic_to_top_save_settings' );

		add_settings_section( 'settings_section', __( 'Behavior', 'dynamic-to-top' ), '__return_true', __FILE__ );
		add_settings_section( 'appearance_section', __( 'Appearance', 'dynamic-to-top' ), 'mv_dynamic_to_top_appearance_section', __FILE__ );

		add_settings_field( 'speed', __( 'Scroll time', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_scroll_time', __FILE__, 'settings_section' );
		add_settings_field( 'distance', __( 'Fade-in distance', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_distance', __FILE__, 'settings_section' );
		add_settings_field( 'easing', __( 'Easing', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_easing', __FILE__, 'settings_section' );
		add_settings_field( 'position', __( 'Position', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_position', __FILE__, 'settings_section' );
		add_settings_field( 'prevent_on_mobile', __( 'Prevent on mobile', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_prevent_on_mobile', __FILE__, 'settings_section' );
			
		add_settings_field( 'text_version', __( 'Text version', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_text_version', __FILE__, 'appearance_section' );
		add_settings_field( 'text', __( 'Button text', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_text', __FILE__, 'appearance_section' );
		add_settings_field( 'padding_top_bottom', __( 'Top/bottom padding', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_padding_top_bottom', __FILE__, 'appearance_section' );
		add_settings_field( 'padding_left_right', __( 'Sides padding', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_padding_left_right', __FILE__, 'appearance_section' );
		add_settings_field( 'font_size', __( 'Font size', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_font_size', __FILE__, 'appearance_section' );
		add_settings_field( 'text_color', __( 'Text color', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_text_color', __FILE__, 'appearance_section' );
		add_settings_field( 'bold', __( 'Bold Text', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_bold', __FILE__, 'appearance_section' );		
		add_settings_field( 'text_shadow', __( 'Text shadow', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_text_shadow', __FILE__, 'appearance_section' );		
		add_settings_field( 'shadow_color', __( 'Text shadow color', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_text_shadow_color', __FILE__, 'appearance_section' );		
		add_settings_field( 'background_color', __( 'Background color', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_background_color', __FILE__, 'appearance_section' );
		add_settings_field( 'border_color', __( 'Border color', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_border_color', __FILE__, 'appearance_section' );
		add_settings_field( 'border_width', __( 'Border width', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_border_width', __FILE__, 'appearance_section' );
		add_settings_field( 'radius', __( 'Border radius', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_border_radius', __FILE__, 'appearance_section' );
		add_settings_field( 'inset', __( 'Inset highlighting', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_inset', __FILE__, 'appearance_section' );		
		add_settings_field( 'shadow', __( 'Shadow', 'dynamic-to-top' ), 'mv_dynamic_to_top_field_shadow', __FILE__, 'appearance_section' );

	}
}

/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP OPTIONS PAGE
|--------------------------------------------------------------------------
*/

if ( ! function_exists( 'mv_dynamic_to_top_options_page' ) )
{
	/** 
	* Options Page
	*
	* Options page layout.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_options_page() {
	?>
	<div class="wrap"> 
		<?php screen_icon(); ?> 
		<h2><?php _e( 'Dynamic To Top Options', 'dynamic-to-top' ); ?></h2> 
		
		<p><?php _e( 'Welcome to the <strong>Dynamic To Top</strong> plugin settings. Click <a href="http://www.mattvarone.com/featured-content/dynamic-to-top/" target="_blank">here</a> to learn more about this plugin.', 'dynamic-to-top' ); ?></p>
		

		<form method="post" action="options.php" enctype="multipart/form-data">
			<?php settings_fields( 'dynamic_to_top' ); ?>
			<?php do_settings_sections( __FILE__ ); ?>

		       <p class="submit">
		          <input name="Submit" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'dynamic-to-top' ); ?>" />
		       </p>
		
			<p><small><?php _e( '<strong>Dynamic To Top</strong> plugin brought to you by', 'dynamic-to-top' ); ?> <a href="http://www.mattvarone.com" title="Matt Varone" target="_blank"><strong>Matt Varone</strong></a> | <a href="http://www.mattvarone.com/donate" title="Tea for Matt!" target="_blank"><strong><?php _e( 'Donate', 'dynamic-to-top' ); ?></strong></a> &hearts;.</small></p>
		
		</form>
	</div>
	<?php
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_appearance_section' ) ) {
	function mv_dynamic_to_top_appearance_section() {
		echo '<div id="dynamic-to-top-preview"><div id="dynamic-to-top-button"><span id="dtt-text"></span><span id="dtt-image"></span></div></div>';
		echo '<p class="ddt-bg-colors"><small>'.__( 'Preview over', 'dynamic-to-top' ).' <a href="#" title="black">'.__( 'black', 'dynamic-to-top' ).'</a>, <a href="#" title="lightgrey">'.__( 'grey', 'dynamic-to-top' ).'</a> or <a href="#" title="white">'.__( 'white', 'dynamic-to-top' ).'</a>.</small></p>';
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_save_settings' ) ) {
	function mv_dynamic_to_top_save_settings( $options ) {
		delete_transient( 'dynamic_to_top_transient_css' );
		delete_transient( 'dynamic_to_top_transient_js' );
		
		if ( ! isset($options['prevent_on_mobile']))
		$options['prevent_on_mobile'] = "0";
		
		if ( ! isset($options['text_version']))
		$options['text_version'] = "0";
		
		if ( ! isset($options['inset']))
		$options['inset'] = "0";
		
		if ( ! isset($options['shadow']))
		$options['shadow'] = "0";
		
		if ( ! isset($options['bold']))
		$options['bold'] = "0";
		
		if ( ! isset($options['text_shadow']))
		$options['text_shadow'] = "0";
		
		return $options;
	}
}

/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP OPTIONS PAGE ASSETS
|--------------------------------------------------------------------------
*/

if ( ! function_exists( 'mv_dynamic_to_top_styles' ) ) {
	/** 
	* Options page enqueue style.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_styles() {		
		if ( mv_dynamic_to_top_is_page_options() ) {
			wp_enqueue_style( 'farbtastic' );
			wp_enqueue_style( 'dynamic-to-top-jquery-ui', MV_DYNAMIC_TO_TOP_URL.'/css/dynamic-to-top-jquery-ui.css', array(), '1.8.13' );
			wp_enqueue_style( 'dynamic-to-top-admin', MV_DYNAMIC_TO_TOP_URL.'/css/dynamic-to-top-admin.css', array( 'dynamic-to-top-jquery-ui' ), MV_DYNAMIC_TO_TOP_VERSION );
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'mv_dynamic_to_top_styles' );
}

if ( ! function_exists( 'mv_dynamic_to_top_scripts' ) ) {
	
	/** 
	* Options page enqueue script.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_scripts() {
		if ( mv_dynamic_to_top_is_page_options() ) {
			if ( version_compare( get_bloginfo( 'version' ),'3.2.9.9','<' ) ) {
				wp_enqueue_script( 'jquery-ui-widget', MV_DYNAMIC_TO_TOP_URL.'/js/libs/jquery.ui.widget.js', array( 'jquery-ui-core' ), '1.8.14' );
				wp_enqueue_script( 'jquery-ui-mouse', MV_DYNAMIC_TO_TOP_URL.'/js/libs/jquery.ui.mouse.js', array( 'jquery-ui-widget' ), '1.8.14' );
				wp_enqueue_script( 'jquery-ui-slider', MV_DYNAMIC_TO_TOP_URL.'/js/libs/jquery.ui.slider.js', array( 'jquery-ui-mouse' ), '1.8.14' );
			}
			wp_enqueue_script( 'dynamic-to-top-settings', MV_DYNAMIC_TO_TOP_URL.'/js/dynamic.to.top.settings.js', array( 'jquery-ui-slider', 'farbtastic' ), '1.0', true );
		}
	}
	
	add_action( 'admin_enqueue_scripts', 'mv_dynamic_to_top_scripts' );
}

if ( ! function_exists( 'mv_dynamic_to_top_is_page_options' ) ) {
	
	/** 
	* Is dynamic to top page options?
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	* @return 		boolean 
	*
	*/
	
	function mv_dynamic_to_top_is_page_options()
	{
		global $pagenow;
		
		if ( function_exists( 'get_current_screen' ) ) {
			$screen = get_current_screen();
			
			if ( isset( $screen->base ) && $screen->base == 'appearance_page_' . MV_DYNAMIC_TO_TOP_FOLDER . '/inc/dynamic-to-top-options' )
				return true;
			else
				return false;
		} 
		else {
			$pages = array( 'themes.php' );

			if ( in_array( $pagenow, $pages ) && isset( $_GET['page'] ) && $_GET['page'] == MV_DYNAMIC_TO_TOP_FOLDER . '/inc/dynamic-to-top-options.php' )
			return true;
		}
		
		return false;
	}
}

/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP OPTIONS PAGE FIELDS
|--------------------------------------------------------------------------
*/

//	COLOR PICKERS ///////////////////////// 

if ( ! function_exists( 'mv_dynamic_to_top_field_border_color' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_border_color() {
		echo mv_dynamic_to_top_do_textfield_color( 'border_color', '#000', __( 'Color for the button border.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_background_color' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_background_color() {
		echo mv_dynamic_to_top_do_textfield_color( 'background_color', '#111', __( 'Background color for the button.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_text_color' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_text_color() {
		echo mv_dynamic_to_top_do_textfield_color( 'text_color', '#fff', __( 'Button text color.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_text_shadow_color' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_text_shadow_color() {
		echo mv_dynamic_to_top_do_textfield_color( 'shadow_color', '#333', __( 'Text shadow color.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_box_shadow_color' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_box_shadow_color() {
		echo mv_dynamic_to_top_do_textfield_color( 'box_shadow_color', '#333', __( 'Text shadow color.', 'dynamic-to-top' ) );
	}
}

// SELECT BOX ///////////////////////// 

if ( ! function_exists( 'mv_dynamic_to_top_field_easing' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_easing() {
		$options = array( 
			'linear' => __( 'Linear', 'dynamic-to-top' ), 
			'in' => __( 'In', 'dynamic-to-top' ),
			'out' => __( 'Out', 'dynamic-to-top' ),
			'in-out' => __( 'In Out', 'dynamic-to-top' ),
			'bounce' => __( 'Bounce', 'dynamic-to-top' ),
			'elastic' => __( 'Elastic', 'dynamic-to-top' )
		);
		
		echo mv_dynamic_to_top_do_select( 'easing', $options, 'in', __( '<a href="http://gsgd.co.uk/sandbox/jquery/easing" title="Easing type">Easing type</a> used to scroll the page up.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_position' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_position() {
		$options = array( 
			'top-left' => __( 'Top Left', 'dynamic-to-top' ), 
			'top-right' => __( 'Top Right', 'dynamic-to-top' ),  
			'bottom-left' => __( 'Bottom Left', 'dynamic-to-top' ),  
			'bottom-right' => __( 'Bottom Right', 'dynamic-to-top' ),  
		);
		
		echo mv_dynamic_to_top_do_select( 'position', $options, 'bottom-right', __( 'Button position.', 'dynamic-to-top' ) );
	}
}

// SLIDER UI ///////////////////////// 

if ( ! function_exists( 'mv_dynamic_to_top_field_scroll_time' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_scroll_time() {
		echo mv_dynamic_to_top_do_slider( 'speed', 1100, __( 'Time it takes for the page to scroll up. Less for faster. ( <span id="speed-val"></span> Milliseconds )', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_font_size' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_font_size() {
		echo mv_dynamic_to_top_do_slider( 'font_size', 1, __( 'Button text size. ( <span id="font-size-val"></span> Em/s )', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_padding_top_bottom' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_padding_top_bottom() {
		echo mv_dynamic_to_top_do_slider( 'padding_top_bottom', 21, __( 'Spacing on Top and Bottom. ( <span id="padding-top-bottom-val"></span>px )', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_padding_left_right' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_padding_left_right() {
		echo mv_dynamic_to_top_do_slider( 'padding_left_right', 19, __( 'Spacing on Left and Right. ( <span id="padding-left-right-val"></span>px )', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_border_width' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_border_width() {
		echo mv_dynamic_to_top_do_slider( 'border_width', '1', __( 'Button border width', 'dynamic-to-top' ).' <span id="border-val"></span>px.' );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_border_radius' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_border_radius() {
		echo mv_dynamic_to_top_do_slider( 'radius', '9', __( 'Button border radius', 'dynamic-to-top' ).' <span id="radius-val"></span>px.' );
	}
}

// TEXTFIELDS ///////////////////////// 

if ( ! function_exists( 'mv_dynamic_to_top_field_distance' ) ) {

	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/

	function mv_dynamic_to_top_field_distance() {
		echo mv_dynamic_to_top_do_textfield( 'distance', 300, __( 'Distance from top to show the button. ( Pixels )', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_text' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_text() {
		echo mv_dynamic_to_top_do_textfield( 'text', __( 'To Top', 'dynamic-to-top' ), __( 'Text displayed on the button.', 'dynamic-to-top' ), 'regular-text' );
	}
}

// CHECKBOXES ///////////////////////// 

if ( ! function_exists( 'mv_dynamic_to_top_field_prevent_on_mobile' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_prevent_on_mobile() {
		echo mv_dynamic_to_top_do_checkbox( 'prevent_on_mobile', __( 'Yes', 'dynamic-to-top' ), false, __( 'Disable the button on mobile browsers.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_text_version' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_text_version() {
		echo mv_dynamic_to_top_do_checkbox( 'text_version', __( 'Yes', 'dynamic-to-top' ), false, __( 'Show a text version instead of the arrow up icon.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_inset' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_inset() {
		echo mv_dynamic_to_top_do_checkbox( 'inset', __( 'Yes', 'dynamic-to-top' ), true, __( 'Add CSS3 inset-highlight.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_shadow' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_shadow() {
		echo mv_dynamic_to_top_do_checkbox( 'shadow', __( 'Yes', 'dynamic-to-top' ), true, __( 'Add a CSS3 shadow.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_weight' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_bold() {
		echo mv_dynamic_to_top_do_checkbox( 'bold', __( 'Yes', 'dynamic-to-top' ), true, __( 'Make the text bold.', 'dynamic-to-top' ) );
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_field_text_shadow' ) ) {
	
	/** 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_field_text_shadow() {
		echo mv_dynamic_to_top_do_checkbox( 'text_shadow', __( 'Yes', 'dynamic-to-top' ), true, __( 'Add a subtle text shadow.', 'dynamic-to-top' ) );
	}
}
/*
|--------------------------------------------------------------------------
| DYNAMIC TO TOP OPTION FIELDS HELPERS
|--------------------------------------------------------------------------
*/

if ( ! function_exists( 'mv_dynamic_to_top_do_checkbox' ) ) {
	
	/** 
	* Do Checkbox
	*
	* Generates a checkbox.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_do_checkbox( $meta, $label="Yes", $checked=false, $desc="" )
	{

		$options_db = get_option( 'dynamic_to_top' );
		
		if ( isset( $options_db[$meta] ) ) {
			// Old values support for backwards compatibility.
			if ( $options_db[$meta] == "1" || $options_db[$meta] == 'yes' || $options_db[$meta] == 'Yes' )
				$c = 'checked="checked"';
			else
				$c = '';
		} else {
			if ( $checked == true )
				$c = 'checked="checked"';
			else
				$c = '';
		}	
		
	   	if ( $desc != "" )
		$desc = '<div class="desc">'.$desc.'</div>';
		
		$sanitized_meta_title = str_replace( '_', '-', sanitize_title( $meta ) );

		return '<input type="checkbox" name="dynamic_to_top['.$meta.']" value="1" '.$c.' id="checkbox-'.$sanitized_meta_title.'" /> '.$label.$desc;	
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_do_textfield' ) ) {
	
	/** 
	* Do Textfield
	*
	* Generates a Textfield.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_do_textfield( $meta, $value="", $desc="", $class="" )
	{

		$options_db = get_option( 'dynamic_to_top' );

		if ( isset( $options_db[$meta] ) ) 
		$value = $options_db[$meta]; 
		
	   	if ( $desc != "" )
		$desc = '<div class="desc">'.$desc.'</div>';
		
		if ( $class != "" )
		$class = 'class="'.$class.'"';
		
		$sanitized_meta_title = str_replace( '_', '-', sanitize_title( $meta ) );
		
		return '<input type="text" id="text-'.$sanitized_meta_title.'" name="dynamic_to_top['.$meta.']" '.$class.' value="'.$value.'" /> '.$desc;	
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_do_select' ) ) {
	
	/** 
	* Do Select Box
	*
	* Generate a select box.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_do_select( $meta, $options=array(), $value="", $desc="" )
	{

		$options_out  = "";
		
		$options_db = get_option( 'dynamic_to_top' );
		
		if ( isset( $options_db[$meta] ) )
		$value = $options_db[$meta];
		
		$value = sanitize_title( $value );

		foreach ( $options as $option => $label ) 
		{
			$selected = "";
			
			$option_slug = sanitize_title( $option );
			
			if ( $value == $option_slug )
			$selected = 'selected="selected"'; 
			
			$options_out .= '<option name="'.sanitize_title( $option ).'" '.$selected.' >'.$label.'</option>';
		}
		
	   	if ( $desc != "" )
		$desc = '<div class="desc">'.$desc.'</div>';
		
		$sanitized_meta_title = str_replace( '_', '-', sanitize_title( $meta ) );

	   return '<select name="dynamic_to_top['.$meta.']" id="select-'.$sanitized_meta_title.'"> '.$options_out.'</select>'.$desc;	
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_do_textfield_color' ) ) {
	
	/** 
	* Do Textfield Color
	*
	* Generates a Textfield with Farbtastic.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_do_textfield_color( $meta, $value="", $desc="", $class="" )
	{

		$options_db = get_option( 'dynamic_to_top' );

		if ( isset( $options_db[$meta] ) ) 
		$value = $options_db[$meta]; 
		
	   	if ( $desc != "" )
		$desc = '<div class="desc">'.$desc.'</div>';
		
		if ( $class != "" ) 
		$class .= " ";
		
		$class = 'class="'.$class.'colorvalue"';
		
		$sanitized_meta_title = str_replace( '_', '-', sanitize_title( $meta ) );

		$out  = '<input type="text" name="dynamic_to_top['.$meta.']" id="farbtastic-'.$sanitized_meta_title.'" '.$class.' value="'.$value.'" />';
		$out .= '<a class="picker hide-if-no-js" href="#" data-closed="'.__( 'close', 'dynamic-to-top' ).'" data-open="'.__( 'select a color', 'dynamic-to-top' ).'">'.__( 'select a color', 'dynamic-to-top' ).'</a>';
		$out .= '<div id="farbtastic-picker-'.$sanitized_meta_title.'" class="dtt-farbtastic"></div>';
		$out .= $desc;
		
		return $out;
	}
}

if ( ! function_exists( 'mv_dynamic_to_top_do_slider' ) ) {
	
	/** 
	* Do Textfield Color
	*
	* Generates a Textfield with a slider.
	* 
	* @package 		Dynamic To Top
	* @subpackage 	Options
	* @since 		3.0
	*
	*/
	
	function mv_dynamic_to_top_do_slider( $meta, $value="", $desc="", $class="" )
	{

		$options_db = get_option( 'dynamic_to_top' );

		if ( isset( $options_db[$meta] ) ) 
		$value = $options_db[$meta]; 
		
	   	if ( $desc != "" )
		$desc = '<div class="desc">'.$desc.'</div>';
		
		if ( $class != "" ) 
		$class .= " ";
		
		$class = 'class="'.$class.'colorvalue"';
		
		$sanitized_meta_title = str_replace( '_', '-', sanitize_title( $meta ) );

	   return '<div id="slider-picker-'.$sanitized_meta_title.'" class="dtt-slider"></div><input type="text" name="dynamic_to_top['.$meta.']" id="slider-'.$sanitized_meta_title.'" '.$class.' value="'.$value.'" />'.$desc;	
	}
}