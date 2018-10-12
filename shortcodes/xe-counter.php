<?php 
/**
 * Counter element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Counter extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'counter_fields') );
		add_shortcode( 'counter', array($this, 'counter_shortcode') );

	}

	public function counter_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Counter', 'xe-core' ),
			'description' => __( 'A counter up from zero', 'xe-core' ),
			'base' 		=> 'counter',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'ct_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Count', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'ct_count',
					'value' 		=> __( '', 'xe-core' ),
				),

				$xe_core->css_animation('ct_animation'),
				$xe_core->anim_duration('ct_duration'),
				$xe_core->anim_delay('ct_delay'),

		        $xe_core->extra_class('ct_class'),
				$xe_core->uniq_class('ct_uniq'),

				$xe_core->design_options('ct_css')

			)

		) );

	}

	public function counter_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'counter', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($ct_css);

		$ct_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $ct_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($ct_animation, $ct_duration, $ct_delay);
		$classes = $xe_core->classes( array($ct_uniq, $ct_class, $ct_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */

		$output = '
		<div class="'.esc_attr($classes).'" '.$attributes.'>
			<span class="count">'.esc_html($ct_count).'</span>
			<p>'.esc_html($ct_title).'</p>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Counter();