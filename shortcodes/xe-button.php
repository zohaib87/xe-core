<?php 
/**
 * Button element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Button extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'button_fields') );
		add_shortcode( 'button', array($this, 'button_shortcode') );

	}

	public function button_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Button', 'xe-core' ),
			'description' => __( 'Eye catching button', 'xe-core' ),
			'base' 		=> 'button',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(
							
				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Button Text', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_text',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Button Link', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_link',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Button Align', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_align',
					'value' 		=> array(
						__( 'Left', 'xe-core' )  => 'text-left',
						__( 'Center', 'xe-core' )  => 'text-center',
						__( 'Right', 'xe-core' ) => 'pull-right',
					),
					'std'			=> 'text-left'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Button Size', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_size',
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
					'param_name' 	=> 'btn_target',
					'value' 		=> array(
						__( 'Default', 'xe-core' )  => '_self',
						__( 'Open in New Tab', 'xe-core' ) => '_blank',
					),
					'std'			=> '_self'
				),

				$xe_core->css_animation('btn_animation'),
				$xe_core->anim_duration('btn_duration'),
				$xe_core->anim_delay('btn_delay'),

				$xe_core->icon_selector('btn_icon_selector'),
				$xe_core->fontawesome('btn_fontawesome', 'btn_icon_selector'),
				$xe_core->ionicons('btn_ionicons', 'btn_icon_selector'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Icon Align', 'xe-core' ),
					'value' 		=> array(
						__( 'Left', 'xe-core' )	=> 'left',
						__( 'Right', 'xe-core' ) 	=> 'right',
					),
					'param_name' 	=> 'btn_icon_align',
					'description' 	=> __( '', 'xe-core' ),
					'std'			=> 'right'
				),

				$xe_core->extra_class('btn_class'),
				$xe_core->uniq_class('btn_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Hover Effects', 'xe-core' ),
					'value' 		=> array(
						__( 'None', 'xe-core' )	=> 'none',
						__( '2D Transitions', 'xe-core' )	=> 'btn_2d_transition',
						__( 'Background Transitions', 'xe-core' ) 	=> 'btn_bg_transition',
						__( 'Icons', 'xe-core' ) 	=> 'btn_icon',
						__( 'Border Transitions', 'xe-core' ) 	=> 'btn_border_transition',
						__( 'Shadow and Glow Transitions', 'xe-core' ) 	=> 'btn_sng_transition',
						__( 'Speech Bubbles', 'xe-core' ) 	=> 'btn_speech_bubble',
						__( 'Curls', 'xe-core' ) 	=> 'btn_curl',
					),
					'param_name' 	=> 'btn_hover_effect',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'std'			=> 'none'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( '2D Transitions', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_2d_transition',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Grow', 'xe-core' )  => 'hvr-grow',
						__( 'Shrink', 'xe-core' )  => 'hvr-shrink',
						__( 'Pulse', 'xe-core' ) => 'hvr-pulse',
						__( 'Pulse Grow', 'xe-core' ) => 'hvr-pulse-grow',
						__( 'Pulse Shrink', 'xe-core' ) => 'hvr-pulse-shrink',
						__( 'Push', 'xe-core' ) => 'hvr-push',
						__( 'Pop', 'xe-core' ) => 'hvr-pop',
						__( 'Bounce In', 'xe-core' ) => 'hvr-bounce-in',
						__( 'Bounce Out', 'xe-core' ) => 'hvr-bounce-out',
						__( 'Rotate', 'xe-core' ) => 'hvr-rotate',
						__( 'Grow Rotate', 'xe-core' ) => 'hvr-grow-rotate',
						__( 'Float', 'xe-core' ) => 'hvr-float',
						__( 'Sink', 'xe-core' ) => 'hvr-sink',
						__( 'Bob', 'xe-core' ) => 'hvr-bob',
						__( 'Hang', 'xe-core' ) => 'hvr-hang',
						__( 'Skew', 'xe-core' ) => 'hvr-skew',
						__( 'Skew Forward', 'xe-core' ) => 'hvr-skew-forward',
						__( 'Skew Backward', 'xe-core' ) => 'hvr-skew-backward',
						__( 'Wobble Horizontal', 'xe-core' ) => 'hvr-wobble-horizontal',
						__( 'Wobble Vertical', 'xe-core' ) => 'hvr-wobble-vertical',
						__( 'Wobble To Bottom Right', 'xe-core' ) => 'hvr-wobble-to-bottom-right',
						__( 'Wobble To Top Right', 'xe-core' ) => 'hvr-wobble-to-top-right',
						__( 'Wobble Top', 'xe-core' ) => 'hvr-wobble-top',
						__( 'Wobble Bottom', 'xe-core' ) => 'hvr-wobble-bottom',
						__( 'Wobble Skew', 'xe-core' ) => 'hvr-wobble-skew',
						__( 'Buzz', 'xe-core' ) => 'hvr-buzz',
						__( 'Buzz Out', 'xe-core' ) => 'hvr-buzz-out',
						__( 'Fordward', 'xe-core' ) => 'hvr-fordward',
						__( 'Backward', 'xe-core' ) => 'hvr-backward',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_2d_transition',
					),
					'std'			=> 'hvr-grow'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Background Transitions', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_bg_transition',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Fade', 'xe-core' )  => 'hvr-fade',
						__( 'Back Pulse', 'xe-core' )  => 'hvr-back-pulse',
						__( 'Sweep To Right', 'xe-core' )  => 'hvr-sweep-to-right',
						__( 'Sweep To Left', 'xe-core' )  => 'hvr-sweep-to-left',
						__( 'Sweep To Bottom', 'xe-core' )  => 'hvr-sweep-to-bottom',
						__( 'Sweep To Top', 'xe-core' )  => 'hvr-sweep-to-top',
						__( 'Bounce To Right', 'xe-core' )  => 'hvr-bounce-to-right',
						__( 'Bounce To Left', 'xe-core' )  => 'hvr-bounce-to-left',
						__( 'Bounce To Bottom', 'xe-core' )  => 'hvr-bounce-to-bottom',
						__( 'Bounce To Top', 'xe-core' )  => 'hvr-bounce-to-top',
						__( 'Radial Out', 'xe-core' )  => 'hvr-radial-out',
						__( 'Radial In', 'xe-core' )  => 'hvr-radial-in',
						__( 'Rectangle In', 'xe-core' )  => 'hvr-rectangle-in',
						__( 'Rectangle Out', 'xe-core' )  => 'hvr-rectangle-out',
						__( 'Shutter In Horizontal', 'xe-core' )  => 'hvr-shutter-in-horizontal',
						__( 'Shutter Out Horizontal', 'xe-core' )  => 'hvr-shutter-out-horizontal',
						__( 'Shutter In Vertical', 'xe-core' )  => 'hvr-shutter-in-vertical',
						__( 'Shutter Out Vertical', 'xe-core' )  => 'hvr-shutter-out-vertical',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_bg_transition',
					),
					'std'			=> 'hvr-fade'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Icons', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_icon',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Icon Back', 'xe-core' )  => 'hvr-icon-back',
						__( 'Icon Forward', 'xe-core' )  => 'hvr-icon-forward',
						__( 'Icon Down', 'xe-core' )  => 'hvr-icon-down',
						__( 'Icon Up', 'xe-core' )  => 'hvr-icon-up',
						__( 'Icon Spin', 'xe-core' )  => 'hvr-icon-spin',
						__( 'Icon Drop', 'xe-core' )  => 'hvr-icon-drop',
						__( 'Icon Fade', 'xe-core' )  => 'hvr-icon-fade',
						__( 'Icon Float Away', 'xe-core' )  => 'hvr-icon-float-away',
						__( 'Icon Sink Away', 'xe-core' )  => 'hvr-icon-sink-away',
						__( 'Icon Grow', 'xe-core' )  => 'hvr-icon-grow',
						__( 'Icon Shrink', 'xe-core' )  => 'hvr-icon-shrink',
						__( 'Icon Pulse', 'xe-core' )  => 'hvr-icon-pulse',
						__( 'Icon Pulse Grow', 'xe-core' )  => 'hvr-icon-pulse-grow',
						__( 'Icon Pulse Shrink', 'xe-core' )  => 'hvr-icon-pulse-shrink',
						__( 'Icon Push', 'xe-core' )  => 'hvr-icon-push',
						__( 'Icon Pop', 'xe-core' )  => 'hvr-icon-pop',
						__( 'Icon Bounce', 'xe-core' )  => 'hvr-icon-bounce',
						__( 'Icon Rotate', 'xe-core' )  => 'hvr-icon-rotate',
						__( 'Icon Grow Rotate', 'xe-core' )  => 'hvr-icon-grow-rotate',
						__( 'Icon Float', 'xe-core' )  => 'hvr-icon-float',
						__( 'Icon Sink', 'xe-core' )  => 'hvr-icon-sink',
						__( 'Icon Bob', 'xe-core' )  => 'hvr-icon-bob',
						__( 'Icon Hang', 'xe-core' )  => 'hvr-icon-hang',
						__( 'Icon Wobble Horizontal', 'xe-core' )  => 'hvr-icon-wobble-horizontal',
						__( 'Icon Wobble Vertical', 'xe-core' )  => 'hvr-icon-wobble-vertical',
						__( 'Icon Buzz', 'xe-core' )  => 'hvr-icon-buzz',
						__( 'Icon Buzz Out', 'xe-core' )  => 'hvr-icon-buzz-out',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_icon',
					),
					'std'			=> 'hvr-icon-back'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Icons', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_border_transition',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Border Fade', 'xe-core' )  => 'hvr-border-fade',
						__( 'Hollow', 'xe-core' )  => 'hvr-hollow',
						__( 'Trim', 'xe-core' )  => 'hvr-trim',
						__( 'Ripple Out', 'xe-core' )  => 'hvr-ripple-out',
						__( 'Ripple In', 'xe-core' )  => 'hvr-ripple-in',
						__( 'Outline Out', 'xe-core' )  => 'hvr-outline-out',
						__( 'Outline In', 'xe-core' )  => 'hvr-outline-in',
						__( 'Round Corner', 'xe-core' )  => 'hvr-round-corner',
						__( 'Underline From Left', 'xe-core' )  => 'hvr-underline-from-left',
						__( 'Underline From Right', 'xe-core' )  => 'hvr-underline-from-right',
						__( 'Reveal', 'xe-core' )  => 'hvr-reveal',
						__( 'Underline Reveal', 'xe-core' )  => 'hvr-underline-reveal',
						__( 'Overline Reveal', 'xe-core' )  => 'hvr-overline-reveal',
						__( 'Overline From Left', 'xe-core' )  => 'hvr-overline-from-left',
						__( 'Overline From Center', 'xe-core' )  => 'hvr-overline-from-center',
						__( 'Overline From Right', 'xe-core' )  => 'hvr-overline-from-right',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_border_transition',
					),
					'std'			=> 'hvr-border-fade'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Shadow and Glow Transitions', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_sng_transition',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Shadow', 'xe-core' )  => 'hvr-shadow',
						__( 'Grow Shadow', 'xe-core' )  => 'hvr-grow-shadow',
						__( 'Float Shadow', 'xe-core' )  => 'hvr-float-shadow',
						__( 'Glow', 'xe-core' )  => 'hvr-glow',
						__( 'Shadow Radial', 'xe-core' )  => 'hvr-shadow-radial',
						__( 'Box Shadow Outset', 'xe-core' )  => 'hvr-box-shadow-outset',
						__( 'Box Shadow Inset', 'xe-core' )  => 'hvr-box-shadow-inset',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_sng_transition',
					),
					'std'			=> 'hvr-shadow'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Speech Bubbles', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_speech_bubble',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Bubble Top', 'xe-core' )  => 'hvr-bubble-top',
						__( 'Bubble Right', 'xe-core' )  => 'hvr-bubble-right',
						__( 'Bubble Bottom', 'xe-core' )  => 'hvr-bubble-bottom',
						__( 'Bubble Left', 'xe-core' )  => 'hvr-bubble-left',
						__( 'Bubble Float Top', 'xe-core' )  => 'hvr-bubble-float-top',
						__( 'Bubble Float Right', 'xe-core' )  => 'hvr-bubble-float-right',
						__( 'Bubble Float Bottom', 'xe-core' )  => 'hvr-bubble-float-bottom',
						__( 'Bubble Float Left', 'xe-core' )  => 'hvr-bubble-float-left',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_speech_bubble',
					),
					'std'			=> 'hvr-bubble-top'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Curls', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_curl',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Curl Top Left', 'xe-core' )  => 'hvr-curl-top-left',
						__( 'Curl Top Right', 'xe-core' )  => 'hvr-curl-top-right',
						__( 'Curl Bottom Left', 'xe-core' )  => 'hvr-curl-bottom-left',
						__( 'Curl Bottom Right', 'xe-core' )  => 'hvr-curl-bottom-right',
					),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => 'btn_curl',
					),
					'std'			=> 'hvr-curl-top-left'
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Text Color', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_text_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Text Hover Color', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_text_hover_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Background Color', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_bg_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Background Hover Color', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_bg_hover_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => array('none', 'btn_2d_transition', 'btn_icon', 'btn_sng_transition', 'btn_speech_bubble', 'btn_curl'),
					),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Hover Effect Color', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'btn_hover_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
					'dependency' 	=> array(
						'element' => 'btn_hover_effect',
						'value'   => array('btn_bg_transition', 'btn_border_transition'),
					),
				),

				$xe_core->design_options('btn_css')

			),

		) );

	}

	public function button_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'button', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($btn_css);

		$btn_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $btn_css, ' ' ), $this->settings['base'], $atts );

		switch ($btn_hover_effect) {

			case 'none':
			$hover_effect = '';
			$property = '';
			break;

			case 'btn_2d_transition':
			$hover_effect = $btn_2d_transition;
			$property = '';
			break;

			case 'btn_bg_transition':
			$hover_effect = $btn_bg_transition;
			$property = 'background';
			break;

			case 'btn_icon':
			$hover_effect = $btn_icon;
			$property = '';
			break;

			case 'btn_border_transition':
			$hover_effect = $btn_border_transition;
			$property = 'box-shadow';
			break;

			case 'btn_sng_transition':
			$hover_effect = $btn_sng_transition;
			$property = '';
			break;

			case 'btn_speech_bubble':
			$hover_effect = $btn_speech_bubble;
			$property = '';
			break;

			case 'btn_curl':
			$hover_effect = $btn_curl;
			$property = '';
			break;

		}

		/* Text color */
		$styles = !empty($btn_text_color) ? '.'.esc_attr($btn_uniq).' { 
			color:' . esc_attr($btn_text_color) . ';
		}' : '';

		/* Text Hover color */
		$styles .= !empty($btn_text_hover_color) ? '.'.esc_attr($btn_uniq).':hover, .'.esc_attr($btn_uniq).':active  { 
			color:' . esc_attr($btn_text_hover_color) . ';
		}' : '';

		/* Background color */
		$styles .= !empty($btn_bg_color) ? '.'.esc_attr($btn_uniq).' { 
			background-color:' . esc_attr($btn_bg_color) . ';
		}' : '';

		if ($btn_hover_effect == 'btn_bg_transition' || $btn_hover_effect == 'btn_border_transition') {

			/* Hover Effect color */
			$styles .= (!empty($btn_hover_color) && !empty($property) ) ? '.'.esc_attr($btn_uniq).'.'.esc_attr($hover_effect).' { 
				'.esc_attr($property).':' . esc_attr($btn_hover_color) . ';
			}' : '';

		} else {

			/* Background Hover Color */
			$styles .= !empty($btn_bg_hover_color) ? '.'.esc_attr($btn_uniq).':hover, .'.esc_attr($btn_uniq).':active { 
				background-color:' . esc_attr($btn_bg_hover_color) . ';
			}' : '';

		}		

		if ( !empty($btn_fontawesome) || !empty($btn_ionicons) ) {

			$icon = $xe_core->icon_class($btn_icon_selector, $btn_fontawesome, $btn_ionicons);
			$icon_html = '<i class="'.esc_attr($icon . ' hvr-icon').'"></i>';

			if ($btn_icon_align == 'left') {
				$icon_left = $icon_html . ' ';
				$icon_right = '';
			} elseif ($btn_icon_align == 'right') {
				$icon_left = '';
				$icon_right = ' ' . $icon_html;
			}

		} else {

			$icon_left = $icon_right = '';

		}

		$anim = $xe_core->animation($btn_animation, $btn_duration, $btn_delay);
		$classes = $xe_core->classes( array($btn_uniq, $btn_class, $btn_size, $btn_align, $hover_effect, $btn_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */
	    
	    $output = ($btn_align == 'text-center') ? '<div class="text-center">' : '';
		$output .= '
		<a href="'.esc_url($btn_link).'" class="btn '.esc_attr($classes).'" target="'.esc_attr($btn_target).'" '.$attributes.'>'.$icon_left . esc_html($btn_text) . $icon_right.'</a>
		';
		$output .= ($btn_align == 'text-center') ? '</div>' : '';

		return $output;

	}

}
new Xe_Core_Button();