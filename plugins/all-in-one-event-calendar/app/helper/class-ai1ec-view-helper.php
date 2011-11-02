<?php
//
//  class-ai1ec-view-helper.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_View_Helper class
 *
 * @package Helpers
 * @author The Seed Studio
 **/
class Ai1ec_View_Helper {
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;

	/**
	 * Constructor
	 *
	 * Default constructor
	 **/
	private function __construct() { }

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return object
	 **/
	static function get_instance() {
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * display function
	 *
	 * Display the view specified by file $file and passed arguments $args.
	 *
	 * @param string $file
	 * @param array $args
	 *
	 * @return void
	 **/
	function display( $file = false, $args = array() ) {
		if( ! $file || empty( $file ) ) {
			throw new Ai1ec_File_Not_Provided( "You need to specify a view file." );
		}

		$file = AI1EC_VIEW_PATH . "/" . $file;

		if( ! file_exists( $file ) ) {
			throw new Ai1ec_File_Not_Found( "The specified view file doesn't exist." );
		} else {
			extract( $args );
			require( $file );
		}
	}

	/**
	 * display_css function
	 *
	 * Renders the given stylesheet inline. If stylesheet has already been
	 * displayed once before with the same set of $args, does not display
	 * it again.
	 *
	 * @param string $file
	 * @param array $args
	 *
	 * @return void
	 **/
	function display_css( $file = false, $args = array() ) {
		static $displayed = array();
		static $num = 0;

		if( ! $file || empty( $file ) ) {
			throw new Ai1ec_File_Not_Provided( 'You need to specify a css file.' );
		}

		$file = AI1EC_CSS_PATH . "/" . $file;

		if( $displayed[$file] === $args )	// Skip if already displayed
			return;

		if( ! file_exists( $file ) ) {
			throw new Ai1ec_File_Not_Found( "The specified css file doesn't exist." );
		} else {
			$displayed[$file] = $args;	// Flag that we've displayed this file with these args

			extract( $args );
			echo '<style type="text/css">';
			require( $file );
			echo '</style>';
		}
	}

	/**
	 * display_js function
	 *
	 * Renders the given script inline. If script has already been displayed
	 * once before with the same set of $args, does not display it again.
	 *
	 * @param string $file
	 * @param array $args
	 *
	 * @return void
	 **/
	function display_js( $file = false, $args = array() ) {
		static $displayed = array();

		if( ! $file || empty( $file ) ) {
			throw new Ai1ec_File_Not_Provided( "You need to specify a js file." );
		}

		$file = AI1EC_JS_PATH . "/" . $file;

		if( $displayed[$file] === $args)	// Skip if already displayed
			return;

		if( ! file_exists( $file ) ) {
			throw new Ai1ec_File_Not_Found( "The specified js file doesn't exist." );
		} else {
			$displayed[$file] = $args;	// Flag that we've displayed this file with these args

			extract( $args );
			echo '<script type="text/javascript" charset="utf-8">';
			echo '/* <![CDATA[ */';
			require( $file );
			echo '/* ]]> */';
			echo '</script>';
		}
	}

	/**
	 * get_view function
	 *
	 * Return the output of a view as a string rather than output to response.
	 *
	 * @param string $file
	 * @param array $args
	 *
	 * @return void
	 **/
	function get_view( $file = false, $args = array() ) {
		ob_start();
		$this->display( $file, $args );
		return ob_get_clean();
	}

	/**
	 * json_response function
	 *
	 * Utility for properly outputting JSON data as an AJAX response.
	 *
	 * @param array $data
	 *
	 * @return void
	 **/
	function json_response( $data ) {
		header( 'Cache-Control: no-cache, must-revalidate' );
		header( 'Pragma: no-cache' );
		header( 'Content-type: application/json' );

		// Output JSON-encoded result and quit
		echo json_encode( $data );
		exit;
	}

}
// END class
