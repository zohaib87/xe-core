<?php 
/**
 * Small Icon element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Small_Icon extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'small_icon_fields') );
		add_shortcode( 'small_icon', array($this, 'small_icon_shortcode') );

	}

	public function small_icon_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Small Icon', 'xe-core' ),
			'description' => __( 'Small icon with title and content', 'xe-core' ),
			'base' 		=> 'small_icon',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(
							
				$xe_core->icon_selector('sm_selector'),
				$xe_core->fontawesome('sm_fontawesome', 'sm_selector'),
				$xe_core->ionicons('sm_ionicons', 'sm_selector'),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'sm_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textarea',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Content', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'sm_text',
					'value' 		=> __( '', 'xe-core' ),
				),

				$xe_core->css_animation('sm_animation'),
				$xe_core->anim_duration('sm_duration'),
				$xe_core->anim_delay('sm_delay'),

		        $xe_core->extra_class('sm_class'),
				$xe_core->uniq_class('sm_uniq'),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Icon Color', 'xe-core' ),
					'param_name' 	=> 'sm_icon_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( 'Choose color for icon.', 'xe-core' )
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Title Color', 'xe-core' ),
					'param_name' 	=> 'sm_title_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( 'Choose color for title.', 'xe-core' )
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Subtitle Color', 'xe-core' ),
					'param_name' 	=> 'sm_subtitle_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( 'Choose color for subtitle.', 'xe-core' )
				),

				$xe_core->design_options('sm_css')

			),

		) );

	}

	public function small_icon_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'small_icon', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($sm_css);

		$sm_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $sm_css, ' ' ), $this->settings['base'], $atts );

		/* Icon color */
		$styles = !empty($sm_icon_color) ? '.'.$sm_uniq.' i { 
			color:' . $sm_icon_color . ';
		}' : '';

		/* Title color */
		$styles .= !empty($sm_title_color) ? '.'.$sm_uniq.' h3 { 
			color:' . $sm_title_color . ';
		}' : '';

		/* Subtitle color */
		$styles .= !empty($sm_subtitle_color) ? '.'.$sm_uniq.' p { 
			color:' . $sm_subtitle_color . ';
		}' : '';

		$icon = $xe_core->icon_class($sm_selector, $sm_fontawesome, $sm_ionicons);
		$anim = $xe_core->animation($sm_animation, $sm_duration, $sm_delay);
		$classes = $xe_core->classes( array($sm_uniq, $sm_class, $sm_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $icon [< Icon class name >]
	     * @var $attributes
	     */
	    
	    /**
	     * @var $output
	     */
		$output = '
		<div class="contact-info '.esc_attr($classes).'" '.$attributes.'>
			<div class="row">
				<div class="col-xs-2">
					<div class="icon"> 
						<i class="'.esc_attr($icon).'"></i> 
					</div>
				</div>
				<div class="col-xs-10">
					<h6>'.esc_html($sm_title).'</h6>
					<p>'.wp_kses_post($sm_text).'</p>
				</div>
			</div>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Small_Icon();