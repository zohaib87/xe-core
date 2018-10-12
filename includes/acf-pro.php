<?php 
/**
 * Advanced Custom Fields Pro functions and extensions.
 *
 * @package Xe Core
 */

/**
 * Local json manager.
 */
require plugin_dir_path(__FILE__) . '/acf-local-json-manager.php';

/**
 * Saving data in json.
 */
function _xe_core_acf_json_save_point( $path ) {

	$folders['Xe Core'] = plugin_dir_path(__DIR__) . '/acf-pro-json';
	return $folders;
    
}
add_filter('aljm_save_json', '_xe_core_acf_json_save_point');

/**
 * Loading data from json
 */
function _xe_core_acf_json_load_point( $paths ) {

	unset($paths[0]);
	$paths[] = plugin_dir_path(__DIR__) . '/acf-pro-json';
	return $paths;
    
}
add_filter('acf/settings/load_json', '_xe_core_acf_json_load_point');

/**
 * Hide ACF field group menu item
 */
// add_filter('acf/settings/show_admin', '__return_false');

/**
 * Load Extensions.
 */
_xe_core_auto_load_files( plugin_dir_path(__DIR__) . '/extensions/acf-pro/acf-*.php');