<?php
/**
 * Plugin Name: Xe Core
 * Description: Adds custom post types, taxonomies, fields and WPBakery Page Builder elements.
 * Version: 	1.0.0
 * Author: 		Muhammad Zohaib - XeCreators
 * Author URI: 	http://www.xecreators.pk
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: xe-core
 */

if ( !defined('ABSPATH') ) exit; // Exit if accessed directly

/**
 * Translate plugin
 */
function _xe_core_load_textdomain() {

	load_plugin_textdomain( 'xe-core', false, dirname( plugin_basename(__FILE__) ) . '/languages/' );

} 
add_action('plugins_loaded', '_xe_core_load_textdomain');

/**
 * Enqueue scripts and styles for front end.
 */
function _xe_core_scripts() { 

	/**
	 * Styles
	 */
	wp_enqueue_style( 'animate', plugin_dir_url(__FILE__) . 'assets/css/animate.css' );
	wp_enqueue_style( 'xe-core-main', plugin_dir_url(__FILE__) . 'assets/css/main.css' );

	/**
	 * Scripts
	 */
    wp_enqueue_script( 'wow', plugin_dir_url(__FILE__) . 'assets/js/wow.min.js', array('jquery'), '20151215', true );
    wp_enqueue_script( 'waypoints', plugin_dir_url(__FILE__) . 'assets/js/jquery.waypoints.min.js', array('jquery'), '20151215', true );
    wp_enqueue_script( 'counterup', plugin_dir_url(__FILE__) . 'assets/js/jquery.counterup.min.js', array('waypoints'), '20151215', true );
    wp_enqueue_script( 'xe-core-main', plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), '20151215', true );

}
add_action('wp_enqueue_scripts', '_xe_core_scripts');

/**
 * Auto load files from a directory.
 */
function _xe_core_auto_load_files($path) {

	$files = glob($path);

	foreach ($files as $file) {

		if ($file == 'index.php') continue;
		
	    require($file); 

	}

}

/**
 * Add image sizes for thumbnails.
 */
function _xe_core_add_image_size() {

    add_image_size('xe-core-member');
	add_image_size('xe-core-testimonial');

}
add_action( 'init', '_xe_core_add_image_size' );

/**
 * Functions and definitions.
 */
require plugin_dir_path(__FILE__) . '/includes/functions.php';

/**
 * Adding custom post types.
 */
require plugin_dir_path(__FILE__) . '/includes/class-custom-post-types.php';

/**
 * Adding custom taxonomies.
 */
require plugin_dir_path(__FILE__) . '/includes/class-custom-taxonomies.php';

/**
 * Check if all plugins loaded are loaded.
 */
function _xe_core_plugins_loaded() {

	/**
	 * Functions that require Advanced Custom Fields Pro.
	 */
	if ( class_exists('acf') ) {
		require plugin_dir_path(__FILE__) . '/includes/acf-pro.php';
	}

	/**
	 * Functions that require Visual Composer.
	 */ 
	if ( class_exists('Vc_Manager') ) {
		require plugin_dir_path(__FILE__) . '/includes/visual-composer.php';
	}

}
add_action('plugins_loaded', '_xe_core_plugins_loaded');