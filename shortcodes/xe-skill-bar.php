<?php 
/**
 * Skill Bar element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Skill_Bar extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'skill_bar_fields') );
		add_shortcode( 'skill_bar', array($this, 'skill_bar_shortcode') );

	}

	public function skill_bar_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Skill Bar', 'xe-core' ),
			'description' => __( 'Animated progress bar', 'xe-core' ),
			'base' 		=> 'skill_bar',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(
							
				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'sb_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Percent', 'xe-core' ),
					'description' 	=> __( 'Don\'t add %. e.g: 80', 'xe-core' ),
					'param_name' 	=> 'sb_percent',
					'value' 		=> __( '', 'xe-core' ),
				),

		        $xe_core->extra_class('sb_class'),
				$xe_core->uniq_class('sb_uniq'),

				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Skill Bar Style', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'sb_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Skill Bar Style 1', 'xe-core' )  => '1',
						__( 'Skill Bar Style 2', 'xe-core' ) => '2',
						__( 'Skill Bar Style 3', 'xe-core' ) => '3',
					),
					'std' 			=> '1'
				),

				array(
					'type' => 'colorpicker',
					'class' => '',
					'heading' => __( 'Title Color', 'xe-core' ),
					'param_name' => 'sb_title_color',
					'group' => __( 'Styles', 'xe-core' ),
					'value' => '', 
					'description' => __( 'Choose color for title.', 'xe-core' )
				),

				$xe_core->design_options('sb_css')

			),

		) );

	}

	public function skill_bar_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes('skill_bar', $atts);
		extract($atts);

		global $xe_core;

		$xe_core->load_custom_css($sb_css);

		$sb_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $sb_css, ' ' ), $this->settings['base'], $atts );

		/* Title Color */
		$styles = !empty($sb_title_color) ? '.'.esc_attr($sb_uniq).' h6 { 
			color:' . esc_attr($sb_title_color) . ';
		}' : '';

		$classes = $xe_core->classes( array($sb_uniq, $sb_class, $sb_css, $sb_uniq) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */

		/**
		 * @var $output
		 */
		$output = '
		<div class="progress-bars '.esc_attr($classes).'" '.$attributes.'>
			<div class="progress" data-percent="'.esc_attr($sb_percent).'%">
				<div class="progress-bar progress-bar-primary">
			        <h6>'.esc_html($sb_title).'</h6>
			        <span class="progress-bar-tooltip">'.esc_html($sb_percent).'%</span> 
		        </div>
		    </div>
	    </div>
	    ';

		return $output;

	}

}
new Xe_Core_Skill_Bar();