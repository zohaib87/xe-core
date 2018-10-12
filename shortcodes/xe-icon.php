<?php 
/**
 * Icon element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Icon extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'icon_fields') );
		add_shortcode( 'icon', array($this, 'icon_shortcode') );

	}

	public function icon_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Icon', 'xe-core' ),
			'description' => __( 'Icon with title, subtitle and text', 'xe-core' ),
			'base' 		=> 'icon',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				$xe_core->icon_selector('icon_selector'),
				$xe_core->fontawesome('icon_fontawesome', 'icon_selector'),
				$xe_core->ionicons('icon_ionicons', 'icon_selector'),
							
				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'icon_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'class' 		=> '',
					'heading' 		=> __( 'Subtitle', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'icon_subtitle',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textarea',
					'class' 		=> '',
					'heading' 		=> __( 'Content', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'icon_content',
					'value' 		=> __( '', 'xe-core' ),
				),

				$xe_core->css_animation('icon_animation'),
				$xe_core->anim_duration('icon_duration'),
				$xe_core->anim_delay('icon_delay'),

		        $xe_core->extra_class('icon_class'),
				$xe_core->uniq_class('icon_uniq'),

				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Icon Style',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'icon_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Icon Style 1',  'xe-core'  ) => '1',
						__( 'Icon Style 2',  'xe-core'  ) => '2',
						__( 'Icon Style 3',  'xe-core'  ) => '3',
					),
					'std'			=> '1'
				),

				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Icon Size',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'icon_size',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Normal',  'xe-core'  ) => '30',
						__( 'Large',  'xe-core'  ) 	=> '50',
					),
					'std'			=> '30'
				),

				$xe_core->design_options('icon_css')

			),

		) );

	}

	public function icon_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'icon', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($icon_css);

		$icon_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $icon_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$icon = $xe_core->icon_class($icon_selector, $icon_fontawesome, $icon_ionicons);
		$anim = $xe_core->animation($icon_uniq, $icon_animation, $icon_duration, $icon_delay);
		$classes = $xe_core->classes( array($icon_class, $icon_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $icon_title
	     * @var $icon_subtitle
	     * @var $icon_content
	     * @var $classes
	     * @var $icon [< Icon class name >]
	     * @var $attributes
	     */

		$output = '
		<div class="about-row '.esc_attr($classes).'" '.$attributes.'>
			<div class="about-icon"> 
				<i class="'.esc_attr($icon).' highlight"></i> 
				<i class="'.esc_attr($icon).' back-icon"></i> 
			</div>
			<div class="about-info">
				<h4>'.esc_html($icon_title).'
					<br>
					<small>'.esc_html($icon_subtitle).'</small>
				</h4>
				<p class="about-description">'.esc_html($icon_content).'</p>
			</div>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Icon();