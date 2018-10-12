<?php 
/**
 * Heading element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Heading extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'heading_fields') );
		add_shortcode( 'heading', array($this, 'heading_shortcode') );

	}

	public function heading_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Heading', 'xe-core' ),
			'description' => __( 'Heading and sub heading', 'xe-core' ),
			'base' 		=> 'heading',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'hd_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Subtitle', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'hd_subtitle',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Type',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'hd_tag',
					'value' 		=> array(
						__( 'H1',  'xe-core'  ) => 'h1',
						__( 'H2',  'xe-core'  ) => 'h2',
						__( 'H3',  'xe-core'  ) => 'h3',
						__( 'H4',  'xe-core'  ) => 'h4',
						__( 'H5',  'xe-core'  ) => 'h5',
						__( 'H6',  'xe-core'  ) => 'h6',
					),
					'std' 			=> 'h4'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Align',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'hd_align',
					'value' 		=> array(
						__( 'Left',  'xe-core'  ) 	=> 'left',
						__( 'Center',  'xe-core'  ) => 'center',
						__( 'Right',  'xe-core'  ) 	=> 'right',
					),
					'std' 			=> 'center'
				),

				$xe_core->css_animation('hd_animation'),
				$xe_core->anim_duration('hd_duration'),
				$xe_core->anim_delay('hd_delay'),

				$xe_core->extra_class('hd_class'),
				$xe_core->uniq_class('hd_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Heading Style',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'hd_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Heading Style 1',  'xe-core'  ) => '1',
						__( 'Heading Style 2',  'xe-core'  ) => '2',
						__( 'Heading Style 3',  'xe-core'  ) => '3',
					),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Title Color', 'xe-core' ),
					'param_name' 	=> 'hd_title_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( '', 'xe-core' )
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Subtitle Color', 'xe-core' ),
					'param_name' 	=> 'hd_subtitle_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( '', 'xe-core' )
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Separator Color', 'xe-core' ),
					'param_name' 	=> 'hd_sep_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( '', 'xe-core' )
				),

				$xe_core->design_options('hd_css')

			)

		) );

	}

	public function heading_shortcode($atts, $content = null) {

		$atts = vc_map_get_attributes( 'heading', $atts );
		extract( $atts ); 

		global $xe_core;

		$xe_core->load_custom_css($hd_css);

		$hd_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $hd_css, ' ' ), $this->settings['base'], $atts );

		/* Title Color */
		$styles = !empty($hd_title_color) ? '.'.esc_attr($hd_uniq).' .heading { 
			color:' . esc_attr($hd_title_color) . ';
		}' : '';

		/* Subtitle Color */
		$styles .= !empty($hd_subtitle_color) ? '.'.esc_attr($hd_uniq).' .subheading { 
			color:' . esc_attr($hd_subtitle_color) . ';
		}' : '';

		/* Separator Color */
		$styles .= !empty($hd_sep_color) ? '.'.esc_attr($hd_uniq).' hr { 
			border-color:' . esc_attr($hd_sep_color) . ';
		}' : '';

		$hd_title = $xe_core->str_to_tags($hd_title);
	    $hd_subtitle = $xe_core->str_to_tags($hd_subtitle);

	    $args = array(
			'strong' => array(),
			'br' => array(),
		); 

		$anim = $xe_core->animation($hd_animation, $hd_duration, $hd_delay);
		$classes = $xe_core->classes( array($hd_class, 'text-'.$hd_align, $hd_uniq, $hd_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array($anim['attr'], $dynamic_css);
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $hd_title
	     * @var $hd_subtitle
	     * @var $hd_style
	     * @var $hd_align [< left, center or right >]
	     * @var $hd_tag [< from h1 to h6 >]
	     * @var $classes
	     * @var $attributes
	     */
	    
	    /**
	     * @var $output
	     */
		$output = '
		<div class="heading '.esc_attr($classes).'" '.$attributes.'>
			<'.esc_attr($hd_tag).'>'.wp_kses($hd_title, $args).'</'.esc_attr($hd_tag).'>
			<span>'.wp_kses($hd_subtitle, $args).'</span>
			<hr class="'.esc_attr($hd_align).'-block">
		</div>
	    ';

		return $output;

	}

}
new Xe_Core_Heading();