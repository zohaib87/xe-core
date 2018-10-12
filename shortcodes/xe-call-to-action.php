<?php 
/**
 * Call To Action element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Call_To_Action extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'call_to_action_fields') );
		add_shortcode( 'call_to_action', array($this, 'call_to_action_shortcode') );

	}

	public function call_to_action_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Call To Action', 'xe-core' ),
			'description' => __( 'Catch visitors attention with CTA block', 'xe-core' ),
			'base' 		=> 'call_to_action',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(
							
				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Text', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cta_text',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Button Text', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cta_btn_text',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Button Link', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cta_btn_link',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Button Size', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cta_btn_size',
					'value' 		=> array(
						__( 'Large', 'xe-core' )  => 'btn-lg',
						__( 'Medium', 'xe-core' ) => 'btn-md',
						__( 'Small', 'xe-core' ) => 'btn-sm',
						__( 'Extra Small', 'xe-core' ) => 'btn-xs',
					),
					'std'			=> 'btn-md'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Link Target', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cta_btn_target',
					'value' 		=> array(
						__( 'Default', 'xe-core' )  => '_self',
						__( 'Open in New Tab', 'xe-core' ) => '_blank',
					),
					'std'			=> '_self'
				),

				$xe_core->css_animation('cta_animation'),
				$xe_core->anim_duration('cta_duration'),
				$xe_core->anim_delay('cta_delay'),

		        $xe_core->extra_class('cta_class'),
				$xe_core->uniq_class('cta_uniq'),

				$xe_core->design_options('cta_css')

			),

		) );

	}

	public function call_to_action_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'call_to_action', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($cta_css);

		$cta_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $cta_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($cta_animation, $cta_duration, $cta_delay);
		$classes = $xe_core->classes( array($cta_uniq, $cta_class, $cta_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */

		$output = '';

		return $output;

	}

}
new Xe_Core_Call_To_Action();