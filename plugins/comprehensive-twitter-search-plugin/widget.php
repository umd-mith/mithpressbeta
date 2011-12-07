<?php
/*
Copyright (C) 2011  Alexander Zagniotov

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>. 
*/

if ( !function_exists( 'add_action' ) ) {
	echo "Hi there!  I'm just a plugin, not much I can do when called directly.";
	exit;
}



class ComprehensiveTwitterSearch_Widget extends WP_Widget {

	var $maindesc = "A highly configurable and comprehensive Twitter search plugin that installs as a widget. The widget will display up to 30 tweets containing your search term. Some of the cool widget settings allow you to display only the top popular tweets in real time. Apart from the usual search, widget also supports Twitter's advanced search operators. Widget comes with variety of options that let you style it to fit your blog theme.";
	
	var $classname = "twitter-search-color-picker";

	function ComprehensiveTwitterSearch_Widget() {


		$widget_ops = array('classname' => 'comprehensivetwittersearch_widget', 'description' => __( $this->maindesc, 'kalisto') );
		$this->WP_Widget('comprehensivetwittersearch', __('AZ :: Twitter Search', 'kalisto'), $widget_ops);
		
		if ( is_active_widget(false, false, $this->id_base) ){
			add_action( 'wp_print_scripts', array(&$this, 'add_script') );
		}
	}


	function add_script(){
		wp_register_script('twitter-api-js', CTS_PLUGIN_JS.'/twitter.api.js', false, false, false);
		wp_enqueue_script( 'twitter-api-js');
	}

	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Tweets', 'kalisto') : $instance['title'], $instance, $this->id_base);

		$search = $instance['search'];
		$rpp = empty($instance['rpp']) ? 30 : $instance['rpp'];
		$interval = empty($instance['interval']) ? 6 : $instance['interval'];
		$width = empty($instance['width']) ? 'auto' : $instance['width'];
        $widgetTitle = empty($instance['widgetTitle']) ? '' : $instance['widgetTitle'];
        $subject = empty($instance['subject']) ? '' : $instance['subject'];
		$height = empty($instance['height']) ? 300 : $instance['height'];
		$footer = $instance['footer'];
		$shellbackground = empty($instance['shellbackground']) ? "#ffffff" : $instance['shellbackground'];
		$shellcolor = empty($instance['shellcolor']) ? "#999999" : $instance['shellcolor'];
		$tweetsbackgroundcolor = empty($instance['tweetsbackgroundcolor']) ? "#999999" : $instance['tweetsbackgroundcolor'];
		$tweetscolor =  empty($instance['tweetscolor']) ? "#444444" : $instance['tweetscolor'];
		$tweetslinkscolor = empty($instance['tweetslinkscolor']) ? "#1986b5" : $instance['tweetslinkscolor'];
		$avatars = empty($instance['avatars']) ? 'false' : $instance['avatars'];
		$hashtags = empty($instance['hashtags']) ? 'true' : $instance['hashtags'];
        $toptweets = empty($instance['toptweets']) ? 'true' : $instance['toptweets'];
		$timestamp = empty($instance['timestamp']) ? 'true' : $instance['timestamp'];
		$live = empty($instance['live']) ? 'true' : $instance['live'];
		$loop = empty($instance['loop']) ? 'true' : $instance['loop'];
		$dateformat = empty($instance['dateformat']) ? "relative" : $instance['dateformat'];
		
		echo $before_widget;

		if ( $title) {
			echo $before_title . $title . $after_title;
		}

	?>
			<script type="text/javascript">

					new TWTR.Widget({
						version: 2,
						type: 'search',
                        search: '<?php echo $search; ?>',
						rpp: <?php echo $rpp; ?>,
						interval: <?php echo $interval; ?>000,
                        title: '<?php echo $widgetTitle; ?>',
                        subject: '<?php echo $subject; ?>',
						width: '<?php echo $width; ?>',
						height: <?php echo $height; ?>,
						footer: '<?php echo $footer; ?>',

						theme: {
							shell: {
								background: '<?php echo $shellbackground; ?>',
								color: '<?php echo $shellcolor; ?>'
									},
							tweets: {
								background: '<?php echo $tweetsbackgroundcolor; ?>',
								color: '<?php echo $tweetscolor; ?>',
								links: '<?php echo $tweetslinkscolor; ?>'
									}
								},
						features: {
							avatars: <?php echo $avatars; ?>, // defaults to false for profile widget, but true for search & faves widget
							hashtags: <?php echo $hashtags; ?>,
                            toptweets: <?php echo $toptweets; ?>,
							timestamp: <?php echo $timestamp; ?>,
							fullscreen: false, // ignores width and height and just goes full screen
							scrollbar: false,
							live: <?php echo $live; ?>,
							loop: <?php echo $loop; ?>,
							behavior: 'default',
							dateformat: '<?php echo $dateformat; ?>' // defaults to relative/absolute (eg: 3 minutes ago)
					}}).render().start();
			
			</script>
		
	<?php	
		echo $after_widget;

	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);

        $instance['widgetTitle'] = strip_tags($new_instance['widgetTitle']);

        $instance['subject'] = strip_tags($new_instance['subject']);

		$instance['search'] = strip_tags($new_instance['search']);
		$instance['rpp'] = strip_tags($new_instance['rpp']);
		$instance['interval'] = strip_tags($new_instance['interval']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['height'] = strip_tags($new_instance['height']);
		$instance['footer'] = strip_tags($new_instance['footer']);

		$instance['shellbackground'] = strip_tags($new_instance['shellbackground']);
		$instance['shellcolor'] = strip_tags($new_instance['shellcolor']);
		$instance['tweetsbackgroundcolor'] = strip_tags($new_instance['tweetsbackgroundcolor']);
		$instance['tweetscolor'] = strip_tags($new_instance['tweetscolor']);
		$instance['tweetslinkscolor'] = strip_tags($new_instance['tweetslinkscolor']);

		$instance['avatars'] = strip_tags($new_instance['avatars']);

        $instance['toptweets'] = strip_tags($new_instance['toptweets']);
		$instance['hashtags'] = strip_tags($new_instance['hashtags']);
		$instance['timestamp'] = strip_tags($new_instance['timestamp']);
		$instance['live'] = strip_tags($new_instance['live']);
		$instance['loop'] = strip_tags($new_instance['loop']);
		$instance['dateformat'] = strip_tags($new_instance['dateformat']);

		return $instance;
	}

	function form( $instance ) {
		//Defaults

		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$subject = isset($instance['subject']) ? esc_attr($instance['subject']) : '';
        $search = isset($instance['search']) ? esc_attr($instance['search']) : '';
        $widgetTitle = isset($instance['widgetTitle']) ? esc_attr($instance['widgetTitle']) : '';

		$rpp = isset($instance['rpp']) ? esc_attr($instance['rpp']) : '30';
		$rppOptions = array("5" => "5", "10" => "10", "15" => "15", "30" => "30");

		$interval = isset($instance['interval']) ? esc_attr($instance['interval']) : '5';
		$intervalOptions = array("5" => "5", "10" => "10", "15" => "15");

		$width = isset($instance['width']) ? esc_attr($instance['width']) : 'auto';
		$height = isset($instance['height']) ? esc_attr($instance['height']) : '300';
		$footer = isset($instance['footer']) ? esc_attr($instance['footer']) : '';

		$booleanOptions = array("true" => "true", "false" => "false");
		$avatars = isset($instance['avatars']) ? esc_attr($instance['avatars']) : 'false';
		$hashtags = isset($instance['hashtags']) ? esc_attr($instance['hashtags']) : 'true';
        $toptweets = isset($instance['toptweets']) ? esc_attr($instance['toptweets']) : 'true';
		$live = isset($instance['live']) ? esc_attr($instance['live']) : 'true';
		$loop = isset($instance['loop']) ? esc_attr($instance['loop']) : 'true';
		$timestamp = isset($instance['timestamp']) ? esc_attr($instance['timestamp']) : 'true';

		$dateformat = isset($instance['dateformat']) ? esc_attr($instance['dateformat']) : 'relative';

		
		$shellbackground = isset($instance['shellbackground']) ? esc_attr($instance['shellbackground']) : '';
		$shellcolor = isset($instance['shellcolor']) ? esc_attr($instance['shellcolor']) : '';
		$tweetsbackgroundcolor = isset($instance['tweetsbackgroundcolor']) ? esc_attr($instance['tweetsbackgroundcolor']) : '';
		$tweetscolor = isset($instance['tweetscolor']) ? esc_attr($instance['tweetscolor']) : '';
		$tweetslinkscolor = isset($instance['tweetslinkscolor']) ? esc_attr($instance['tweetslinkscolor']) : '';


	?>
			<div id="<?php echo $this->classname; ?>-container-<?php echo $this->id; ?>">

			<?php echo $this->create_widget_input('title', $title, 'Title'); ?>
			<?php echo $this->create_widget_input('search', $search, 'Search query'); ?>
			
            <p>
			    <?php _e("For more information about Twitter search queries, please consult the following page <a href='http://search.twitter.com/operators' target='_blank'>Twitter's Search Operators</a>.", 'kalisto');?>
		    </p>

			<?php echo $this->create_widget_input('widgetTitle', $widgetTitle, 'Widget title'); ?>
			<?php echo $this->create_widget_input('subject', $subject, 'Search subject'); ?>
			<?php echo $this->create_widget_colorpicker_input('shellbackground', $shellbackground, 'Shell background'); ?>
			<?php echo $this->create_widget_colorpicker_input('shellcolor', $shellcolor, 'Shell font color'); ?>
			<?php echo $this->create_widget_colorpicker_input('tweetsbackgroundcolor', $tweetsbackgroundcolor, 'Tweet background'); ?>
           	<?php echo $this->create_widget_colorpicker_input('tweetscolor', $tweetscolor, 'Tweet font color'); ?>
			<?php echo $this->create_widget_colorpicker_input('tweetslinkscolor', $tweetslinkscolor, 'Tweet link color'); ?>
			<?php echo $this->create_widget_select('rpp', $rpp, 'Tweets to load', $rppOptions); ?>
			<?php echo $this->create_widget_select('interval', $interval, 'Refresh interval', $intervalOptions); ?>
			<?php echo $this->create_widget_input('width', $width, 'Width (Deafult "auto")'); ?>
			<?php echo $this->create_widget_input('height', $height, 'Height (Deafult "300")'); ?>
			<?php echo $this->create_widget_input('footer', $footer, 'Footer text'); ?>
			<?php echo $this->create_widget_select('avatars', $avatars, 'Show tweet avatar', $booleanOptions); ?>      
			<?php echo $this->create_widget_select('toptweets', $toptweets, 'Show toptweets', $booleanOptions); ?>      
			<?php echo $this->create_widget_select('hashtags', $hashtags, 'Show hashtags', $booleanOptions); ?>      
    		<?php echo $this->create_widget_select('live', $live, 'Show live tweets', $booleanOptions); ?>
    		<?php echo $this->create_widget_select('loop', $loop, 'Loop over tweets', $booleanOptions); ?>
            <?php echo $this->create_widget_select('timestamp', $timestamp, 'Display timestamp', $booleanOptions); ?>
            <?php echo $this->create_widget_select('dateformat', $dateformat, 'Dateformat', array("relative" => "relative", "absolute" => "absolute")); ?>
            
        </div>
		
<?php
		
	}
	
	function create_widget_select($field_name, $field, $field_desc, $options) {
		?>
		
	 		<p>
	        	<label for="<?php echo $this->get_field_id($field_name); ?>"><?php _e($field_desc.':', 'kalisto'); ?></label>
	    		<select id="<?php echo $this->get_field_id($field_name); ?>" style="float: right;" name="<?php echo $this->get_field_name($field_name); ?>">
	      		<?php echo $this->create_options($options, $field); ?>
	         	</select>
	    	</p>
		
		<?php
	}
	
	function create_options( $options, $so ){
		$r = '';
		foreach ($options as $label => $value){
			$r .= '<option value="'.$value.'"';
			if($value == $so){
				$r .= ' selected="selected"';
			}
			$r .= '>&nbsp;'.$label.'&nbsp;</option>';
		}
		return $r;
	}

	function create_widget_input($field_name, $field, $field_desc) {
		?>
		
		 <p>
		 	<label for="<?php echo $this->get_field_id($field_name); ?>"><?php _e($field_desc.':', 'kalisto'); ?></label>
	     	<input class="widefat" id="<?php echo $this->get_field_id($field_name); ?>" name="<?php echo $this->get_field_name($field_name); ?>" type="text" value="<?php echo $field; ?>" />
	     </p>
		
		<?php
	}
	
	function create_widget_colorpicker_input($field_name, $field, $field_desc) {
		?>
		
		 <p>
		 	<label for="<?php echo $this->get_field_id($field_name); ?>"><?php _e($field_desc.':', 'kalisto'); ?></label>
	     	<input class="widefat <?php echo $this->classname; ?>" id="<?php echo $this->get_field_id($field_name); ?>" name="<?php echo $this->get_field_name($field_name); ?>" type="text" style="width: 33%; float: right;" value="<?php echo $field; ?>" />
	     </p>
		
		<?php
	}

}


?>
