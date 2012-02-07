<?php
/**
* Dynamic To Top Class
*
* @package 	Dynamic To Top
* @author 	Matt Varone
*/

if ( ! class_exists( 'MV_Dynamic_To_Top' ) )
{	
	
	class MV_Dynamic_To_Top
	{
		public $options;
		private $defaults = array( 
			'speed' => 1000, 
			'distance' => 200, 
			'easing' => 'in-out', 
			'position' => 'bottom-right', 
			'padding_top_bottom' => '21', 
			'padding_left_right' => '20', 
			'font_size' => '1', 
			'text_color' => '#fff', 
			'bold' => '0', 
			'text_shadow' => '0', 
			'shadow_color' => '#111', 	
			'background_color' => '#272727', 
			'border_color' => '#000', 
			'border_width' => '1', 
			'radius' => '9', 
			'shadow' => '1', 
			'inset' => '1', 
			'text' => '0', 
			'margin'=> 20, 
			'text_version' => '0', 
		 );

		/** 
		* Dynamic To Top 
		* 
		* Construct class. calls for options and assets.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		*
		*/
		
		function __construct() {			
			// Get options.
			$this->get_options();
			
			// Enqueue CSS and JS.
			$this->enqueue_assets();
		}
		
		/** 
		* Get Options 
		* 
		* Sets and parses the db options with the default values.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		*/
		
		function get_options() {
			$this->options = wp_parse_args( get_option( 'dynamic_to_top' ), $this->defaults );
		}
		
		/** 
		* Enqueue Assets 
		* 
		* Adds JS and CSS assets actions.
		* Checks if its needed to prevent on mobile browsers. 
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		*/
		
		function enqueue_assets() {
			if ( $this->is_checked( 'prevent_on_mobile' ) ) {
				if ( $this->is_mobile() )
					return;
			}
			
			add_action( 'wp_enqueue_scripts', array( &$this,'enqueue_style' ) );
			add_action( 'wp_enqueue_scripts', array( &$this,'enqueue_script' ) );			
		}
		
		/** 
		* Enqueue Style
		* 
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		*/
		
		function enqueue_style() {
			wp_enqueue_style( 'dynamic-to-top', MV_DYNAMIC_TO_TOP_URL . '/css/dynamic-to-top-css.php', false, MV_DYNAMIC_TO_TOP_VERSION,'all' );
		}
		
		/** 
		* Enqueue Script
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		*/
		
		function enqueue_script() {
			wp_register_script( 'jquery-easing', MV_DYNAMIC_TO_TOP_URL . '/js/libs/jquery.easing.js', array( 'jquery' ), '1.3', true );
			$env = ( WP_DEBUG ) ? 'dev' : 'min';
			wp_enqueue_script( 'dynamic-to-top', MV_DYNAMIC_TO_TOP_URL . '/js/dynamic.to.top.' . $env . '.js', array( 'jquery-easing' ), MV_DYNAMIC_TO_TOP_VERSION, true );	
			
			$params = array( 
				'text'		=> $this->options['text'],
				'version'	=> $this->options['text_version'],
				'min'		=> $this->options['distance'],
				'speed'		=> $this->options['speed'],
				'easing'	=> $this->get_easing_type(),
				'margin'	=> $this->options['margin'],
			 );
			
			$params = apply_filters( 'mv_dynamic_to_top_js_params', $params );
			
			wp_localize_script( 'dynamic-to-top', 'mv_dynamic_to_top', $params );		
		}
		
		/** 
		* Get CSS
		*
		* Returns CSS declarations.
		* Checks for transient CSS or generates and sets a new one. 
		* 
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @return string $css CSS Declarations.
		*/
		
		function get_css( $css = "" ) {
			$css = get_transient( 'dynamic_to_top_transient_css' );
		
			if ( ! $css ) {
				$css = $this->minify( $this->generate_custom_css() );
				set_transient( 'dynamic_to_top_transient_css', $css, 60*60*24*90 );
			}
			
			$css = apply_filters( 'mv_dynamic_to_top_css', $css );
		
			return $css;
		}
		
		
		/** 
		* Generate Custom CSS 
		* 
		* Returns Dynamic To Top custom CSS styles.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @return string $css CSS declarations.
		*/
		
		function generate_custom_css( $css = "" ) {
						
			$css .= "/* Dynamic To Top Plugin ver. ".MV_DYNAMIC_TO_TOP_VERSION." - http://www.mattvarone.com */\n\n";
						
			$css .= "body { position:relative; }
			
			#dynamic-to-top {
				display:none;
				overflow:hidden;
				width:auto;
				z-index:90;
				position:fixed;
				".$this->get_position()."
								
				font-family: sans-serif;
				font-size:".$this->options['font_size']."em;
				color:".$this->options['text_color'].";
				text-decoration:none;\n";

			if ( $this->is_checked( 'text_shadow' ) )
				$css .= "text-shadow:0 1px 0 ".$this->options['shadow_color'].";\n";

			if ( $this->is_checked( 'bold' ) )
				$css .="font-weight:bold;\n";
									
			$css.= "padding:".$this->options['padding_top_bottom']."px ".$this->options['padding_left_right']."px;
				border:".$this->options['border_width']."px solid ".$this->options['border_color'].";
				background:".$this->options['background_color'].";
								
				-webkit-background-origin:border;
				-moz-background-origin:border;
				-icab-background-origin:border;
				-khtml-background-origin:border;
				-o-background-origin:border;
				background-origin:border;
				
				-webkit-background-clip:padding-box;
				-moz-background-clip:padding-box;
				-icab-background-clip:padding-box;
				-khtml-background-clip:padding-box;
				-o-background-clip:padding-box;
				background-clip:padding-box;\n";
			
			$box_shadow = "";

			if ( $this->is_checked( 'shadow' ) ) 
				$box_shadow .= "0 1px 3px rgba( 0,0,0,0.4 )";

			if ( $this->is_checked( 'inset' ) ) {	
				if ( $box_shadow != "" ) $box_shadow = $box_shadow.",";
				$box_shadow .= "inset 0 0 0 1px rgba( 0,0,0,0.2 ), inset 0 1px 0 rgba( 255,255,255,.4 ),inset 0 10px 10px rgba( 255,255,255,.1 )";
			}

			if ( strlen( $box_shadow ) > 1 )
				$css .= "-webkit-box-shadow:".$box_shadow.";
					-ms-box-shadow:".$box_shadow.";
					-moz-box-shadow:".$box_shadow.";
					-o-box-shadow:".$box_shadow.";
					-khtml-box-shadow:".$box_shadow.";
					-icab-box-shadow:".$box_shadow.";
					 box-shadow:".$box_shadow.";\n\n";

			$css .= "-webkit-border-radius: ".$this->options['radius']."px;
					-moz-border-radius: ".$this->options['radius']."px;
					-icab-border-radius: ".$this->options['radius']."px;
					-khtml-border-radius: ".$this->options['radius']."px;
					border-radius: ".$this->options['radius']."px;\n}\n\n";
						
			$css .= "#dynamic-to-top:hover {
				background: ".$this->get_ligther_hex( $this->options['background_color'] ).";
				background: ".$this->options['background_color']." -webkit-gradient( linear, 0% 0%, 0% 100%, from( rgba( 255,255,255,.2 ) ),to( rgba( 0,0,0,0 ) ) );
				background: ".$this->options['background_color']." -webkit-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -khtml-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -moz-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -o-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -ms-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -icab-linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']."  linear-gradient( top, rgba( 255,255,255,.2 ), rgba( 0,0,0,0 ) );
				cursor:pointer;
			}
			
			#dynamic-to-top:active {
				background: ".$this->options['background_color'].";
				background: ".$this->options['background_color']." -webkit-gradient( linear, 0% 0%, 0% 100%, from( rgba( 0,0,0,.3 ) ), to( rgba( 0,0,0,0 ) ) );
				background: ".$this->options['background_color']." -webkit-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -moz-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -khtml-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -o-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -ms-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." -icab-linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );
				background: ".$this->options['background_color']." linear-gradient( top, rgba( 0,0,0,.1 ), rgba( 0,0,0,0 ) );								
			}

			#dynamic-to-top,#dynamic-to-top:active,
			#dynamic-to-top:focus,#dynamic-to-top:hover
			{
				outline:none
			}

			#dynamic-to-top span {
				display:block;
				overflow:hidden;
				width:14px;
				height:12px;
				background:url( " . MV_DYNAMIC_TO_TOP_URL . "/css/images/up.png ) no-repeat center center;
			}";
	
			return $css;
		}
				
		/** 
		* Get Easing Type 
		* 
		* Returns the easing type function name.
		* Used on the JS script. Old values support for backwards compatibility.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @return string $easing Name of easing function.
		*/
				
		function get_easing_type( $easing = "linear" ) {
			switch ( $this->options['easing'] )
			{
				case ( $this->options['easing'] == 'Bounce' || $this->options['easing'] == 'bounce' ):
					$easing = "easeOutBounce";
				break;
				
				case ( $this->options['easing'] == 'Elastic' || $this->options['easing'] == 'elastic' ):
					$easing = "easeInElastic";
				break;
				
				case ( $this->options['easing'] == 'In' || $this->options['easing'] == 'in' ):
					$easing = "easeInExpo";
				break;
				
				case ( $this->options['easing'] == 'In Out' || $this->options['easing'] == 'in-out' ):
					$easing = "easeInOutExpo";
				break;
				
				case ( $this->options['easing'] == 'Out' || $this->options['easing'] == 'out' ):
					$easing = "easeOutExpo";
				break;
			}
			return $easing;
		}
		
		/** 
		* Get Position 
		* 
		* Returns CSS properties for the selected position.
		* Used on the CSS style. Old values support for backwards compatibility.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @return string $position Properties of the position selected.
		*/
		
		function get_position( $position = "" ) {	
			switch ( $this->options['position'] )
			{
				case ( $this->options['position'] == 'Bottom Right' || $this->options['position'] == 'bottom-right' ):
					$position = "bottom:".$this->options['margin']."px;right:".$this->options['margin']."px;top:auto;left:auto;";
				break;
				
				case ( $this->options['position'] == 'Bottom Left' || $this->options['position'] == 'bottom-left' ):
					$position = "bottom:".$this->options['margin']."px;left:".$this->options['margin']."px;top:auto;right:auto;";
				break;
				
				case ( $this->options['position'] == 'Top Right' || $this->options['position'] == 'top-right' ):
					$position = "top:".$this->options['margin']."px;right:".$this->options['margin']."px;bottom:auto;left:auto;";
				break;
				
				case ( $this->options['position'] == 'Top Left' || $this->options['position'] == 'top-left' ):
					$position = "top:".$this->options['margin']."px;left:".$this->options['margin']."px;bottom:auto;right:auto;";
				break;
			}

			return $position;
		}
		
		/** 
		* Is Checked 
		* 
		* Conditional method to validate checked options.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @param string $option Option name.
		* @return boolean
		*/
		
		function is_checked( $option = "" ) {
			if ( $option == "" )
				return false;
			
			if ( ! isset( $this->options[$option] ) )
				return false;
			
			// Old values support for backwards compatibility.
			if ( $this->options[$option] == '1' || $this->options[$option] == 'yes' || $this->options[$option] == 'Yes' )
				return true;
			else
				return false;
		}
			
		/** 
		* Is Mobile 
		* 
		* Checks if the browser is mobile.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @author Reverb Studios
		* @link http://www.reverbstudios.ie/
		* @return boolean.
		*/		
			
		function is_mobile() {

			if( isset( $_SERVER["HTTP_X_WAP_PROFILE"] ) )
				return true;

			if( preg_match( "/wap\.|\.wap/i",$_SERVER["HTTP_ACCEPT"] ) )
				return true;

			if( isset( $_SERVER["HTTP_USER_AGENT"] ) ) {
				$user_agents = array( 
					"midp", "j2me", "iphone","avantg", "docomo", "novarra", "palmos", 
					"palmsource", "240x320", "opwv", "chtml", "pda", "windows\ ce", "mmp\/", 
					"blackberry", "mib\/", "symbian", "wireless", "nokia", "hand", "mobi", 
					"phone", "cdm", "up\.b", "audio", "SIE\-", "SEC\-", "samsung", "HTC", 
					"mot\-", "mitsu", "sagem", "sony", "alcatel", "lg", "erics", "vx", "NEC", 
					"philips", "mmm", "xx", "panasonic", "sharp", "wap", "sch", "rover", 
					"pocket", "benq", "java", "pt", "pg", "vox", "amoi", "bird", "compal", 
					"kg", "voda", "sany", "kdd", "dbt", "sendo", "sgh", "gradi", "jb", "\d\d\di", "moto" );
					
				foreach( $user_agents as $user_string ) {
					if( preg_match( "/" . $user_string . "/i", $_SERVER["HTTP_USER_AGENT"] ) ) 
						return true;
				}
			}
			
			do_action( 'mv_dynamic_to_top_check_mobile' );

			return false;
		}
		
		/** 
		* Get Lighter Hex 
		* 
		* Returns a lighter version of an Hex color.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @author Justin French
		* @link http://justinfrench.com/
		* @return boolean.
		*/
		
		function get_ligther_hex( $hex,$factor = 30 ) {
	
			$new_hex = '#'; 
			
			if ( strlen( $hex ) == 7 ) {
				$base['R'] = hexdec( $hex{0}.$hex{1} ); 
				$base['G'] = hexdec( $hex{2}.$hex{3} ); 
				$base['B'] = hexdec( $hex{4}.$hex{5} ); 
			} else {
				$base['R'] = hexdec( $hex{0}.$hex{0} ); 
				$base['G'] = hexdec( $hex{1}.$hex{1} ); 
				$base['B'] = hexdec( $hex{2}.$hex{2} );
			}
			foreach ( $base as $k=>$v ) { 
				$amount = 255 - $v; 
				$amount = $amount / 100; 
				$amount = round( $amount * $factor ); 
				$new_decimal = $v + $amount; 

				$new_hex_component = dechex( $new_decimal ); 
				
				if( strlen( $new_hex_component ) < 2 ) 
				$new_hex_component = "0" . $new_hex_component;
			        
				$new_hex .= $new_hex_component; 
			}
			
			$new_hex = apply_filters( 'mv_dynamic_to_top_new_hex', $new_hex );
			
			return $new_hex;
		}

		/** 
		* 
		* Simple Minify CSS 
		* 
		* Minifies CSS.
		*
		* @package Dynamic To Top
		* @subpackage Main Class
		* @since 3.0
		* @author Karthik Viswanathan
		* @link http://www.lateralcode.com/css-minifier/
		* @return string.
		*/
				
		function minify( $css ) {
			$css = preg_replace( '#\s+#', ' ', $css );
			$css = preg_replace( '#/\*.*?\*/#s', '', $css );
			$css = str_replace( array( '; ', ': ', ' {', '{ ', ', ', '} ', ';}' ), array( ';', ':', '{', '{', ',', '}', '}' ), $css );
			return trim( $css );
		}
		
	
	}
	
	/*
	|--------------------------------------------------------------------------
	| DYNAMIC TO TOP CLASS INITIALIZE
	|--------------------------------------------------------------------------
	*/

	if ( ! function_exists( 'mv_dynamic_to_top_init' ) ) {

		/** 
		* Initializes the main Dynamic to top class.
		*
		* @package Dynamic To Top
		* @since 3.0
		*
		*/

		function mv_dynamic_to_top_init() {
			global $OBJ_dynamic_to_top;
			$OBJ_dynamic_to_top = new MV_Dynamic_To_Top();
		}

		add_action( 'init', 'mv_dynamic_to_top_init' );
	}
}