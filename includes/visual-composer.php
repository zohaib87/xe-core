<?php 
/**
 * Functions that require WPBakery Builder.
 *
 * @package Xe Core
 */

/**
 * Set shortcodes directory.
 */
vc_set_shortcodes_templates_dir( plugin_dir_path(__DIR__) . '/shortcodes' );

/**
 * Set Visual Composer as theme.
 */
function _xe_core_vc_set_as_theme() {

    vc_set_as_theme();

}
add_action( 'vc_before_init', '_xe_core_vc_set_as_theme' );

/**
 * Page builder for theme defined post types by default.
 */
vc_set_default_editor_post_types( array(
    'page', 'xe-tabs'
) );

/**
 * Add new params to vc_row
 */
vc_add_params('vc_row', array(

	array(
		'type' 			=> 'dropdown',
		'heading' 		=> __( 'Container', 'xe-core' ),
		'description' 	=> __( 'Row Stretch will override this option.', 'xe-core' ),
		'class' 		=> '',
		'param_name' 	=> 'row_container',
		'value' => array(
			__('No Container', 'xe-core' ) => 'container-none',	
			__('Normal Container', 'xe-core' ) => 'container',
			__('Fluid Container', 'xe-core' ) => 'container-fluid',
		),
		'std' 			=> 'container-none',
		'weight' 		=> 1
	),

	array(
		'type' 			=> 'dropdown',
		'heading' 		=> __( 'Background Attachment', 'xe-core' ),
		'description' 	=> __( '', 'xe-core' ),
		'param_name' 	=> 'row_attachment',
		'group' 		=> __( 'Background Options', 'xe-core' ),
		'value' 		=> array(
			__( 'Fixed', 'xe-core' ) 	=> 'fixed',
			__( 'Scroll', 'xe-core' ) 	=> 'scroll',
		),
		'std' 			=> 'fixed'
	),

	array(
		'type' 			=> 'textfield',
		'class' 		=> '',
		'heading' 		=> __( 'Background Scroll Ratio', 'xe-core' ),
		'description' 	=> __( 'Enter scroll ration for background image. e.g: 0.2', 'xe-core' ),
		'param_name' 	=> 'row_ratio',
		'group' 		=> __( 'Background Options', 'xe-core' ),
		'value' 		=> __( '', 'xe-core' ),
		'dependency' 	=> array(
			'element' => 'row_attachment',
			'value' => 'scroll',
		),
	),

	array(
		'type' 			=> 'colorpicker',
		'class' 		=> '',
		'heading' 		=> __( 'Background Overlay Color', 'xe-core' ),
		'description' 	=> __( 'Choose color for background overlay.', 'xe-core' ),
		'param_name' 	=> 'row_overlay',
		'group' 		=> __( 'Background Options', 'xe-core' ),
		'value' 		=> '', 
	),

	array(
		'type' 			=> 'textfield',
		'edit_field_class' => 'vc_col-xs-12 xe-hidden',
		'heading' 		=> __( 'Unique Class', 'xe-core' ),
		'description' 	=> __( 'Unique class name to target and style this element specifically. Please don\'t remove this class unless you know what you are doing.', 'xe-core' ),
		'param_name' 	=> 'row_uniq',
		'value' 		=> uniqid('xe-'),
	),

));

/**
 * Remove elements
 */
if ( class_exists('WooCommerce') ) {

	vc_remove_element('product');
	vc_remove_element('products');
	vc_remove_element('add_to_cart');
	vc_remove_element('add_to_cart_url');
	vc_remove_element('product_page');

}

/**
 * Auto require all custom shortcodes.
 */
_xe_core_auto_load_files( plugin_dir_path(__DIR__) . '/shortcodes/xe-*.php' );