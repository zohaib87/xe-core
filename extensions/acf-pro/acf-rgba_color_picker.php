<?php 
/**
 * Class ACF RGBA Color Picker.
 * 
 * Its a modified version of ACF RGBA Color Picker extension.
 * 
 * @link https://wordpress.org/plugins/acf-rgba-color-picker/
 */

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;

// check if class already exists
if( !class_exists('acf_plugin_extended_color_picker') ) :

class acf_plugin_extended_color_picker {
	
	function __construct() {
		
		// vars
		$this->settings = array(
			'plugin'			=> 'ACF RGBA Color Picker',
			'this_acf_version'	=> 0,
			'min_acf_version'	=> '5.5.0',
			'version'			=> '1.0.0',
			'url'				=> plugin_dir_url( __FILE__ ),
			'path'				=> plugin_dir_path( __FILE__ ),
			'plugin_path'		=> 'https://wordpress.org/plugins/acf-rgba-color-picker/'
		);

		// include field
		add_action( 'acf/include_field_types', array($this, 'include_field_types') );
		
	}
	
	/**
	*  Include field type
	*/	
	function include_field_types() {			

		if ( class_exists('acf') ) {
			include_once('includes/acf-rgba-color-picker-v5.php');
		}

	}	
	
}
new acf_plugin_extended_color_picker();

endif; // class_exists check