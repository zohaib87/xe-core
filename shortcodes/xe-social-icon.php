<?php 
/**
 * Social Icon element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Social_Icon extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'social_icon_fields') );
		add_shortcode( 'social_icon', array($this, 'social_icon_shortcode') );

	}

	public function social_icon_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Social Icon', 'xe-core' ),
			'description' => __( 'Social icon with title and followers', 'xe-core' ),
			'base' 		=> 'social_icon',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(
							
				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Icon',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_icon',
					'value' 		=> array(
						__( 'Default',  'xe-core'  ) 	=> '',
						__( 'Facebook',  'xe-core'  ) 	=> 'facebook',
						__( 'Twitter',  'xe-core'  ) 	=> 'twitter',
						__( 'Google Plus',  'xe-core' ) => 'google-plus',
						__( 'Gituhb',  'xe-core'  ) 	=> 'github',
						__( 'Behance',  'xe-core'  ) 	=> 'behance',
						__( 'Dribbble',  'xe-core'  ) 	=> 'dribbble',
						__( 'Pinterest',  'xe-core'  ) 	=> 'pinterest',
						__( 'Instagram',  'xe-core'  ) 	=> 'instagram',
						__( 'Linkedin',  'xe-core'  ) 	=> 'linkedin',
						__( 'Thumblr',  'xe-core'  ) 	=> 'Thumblr',
						__( 'Youtube',  'xe-core'  ) 	=> 'youtube',
						__( 'Vimeo',  'xe-core'  ) 		=> 'vimeo',
					),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Followers', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_likes',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'class' 		=> '',
					'heading' 		=> __( 'Link', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_link',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Link Target',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_target',
					'value' 		=> array(
						__( 'Default',  'xe-core'  ) => '_self',
						__( 'Open In New Window',  'xe-core'  ) => '_blank',
					),
					'std'			=> '_self'
				),

				$xe_core->css_animation('si_animation'),
				$xe_core->anim_duration('si_duration'),
				$xe_core->anim_delay('si_delay'),

		        $xe_core->extra_class('si_class'),
				$xe_core->uniq_class('si_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Style', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'si_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Social Icon Style 1', 'xe-core' )  => '1',
						__( 'Social Icon Style 2', 'xe-core' )  => '2',
						__( 'Social Icon Style 3', 'xe-core' )  => '3',
					),
					'std'			=> '1'
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Title Color', 'xe-core' ),
					'param_name' 	=> 'si_title_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( 'Choose color for icon title.', 'xe-core' )
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Subtitle Color', 'xe-core' ),
					'param_name' 	=> 'si_subtitle_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> '', 
					'description' 	=> __( 'Choose color for icon subtitle.', 'xe-core' )
				),

				$xe_core->design_options('si_css')

			),

		) );

	}

	public function social_icon_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'social_icon', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($si_css);

		$si_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $si_css, ' ' ), $this->settings['base'], $atts );

		/* Title Color */
		$styles = !empty($si_title_color) ? '.'.$si_uniq.' { 
			color:' . $si_title_color . ';
		}' : '';

		/* Subtitle Color */
		$styles .= !empty($si_subtitle_color) ? '.'.$si_uniq.' { 
			color:' . $si_subtitle_color . ';
		}' : '';

		$anim = $xe_core->animation($si_animation, $si_duration, $si_delay);
		$classes = $xe_core->classes( array($si_uniq, $si_class, $si_uniq, $si_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
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
		<div class="social-panel social_icons '.esc_attr($classes).'" '.$attributes.'>
			<div class="'.esc_attr($si_icon).'"> 
				<a href="'.esc_url($si_link).'" target="'.esc_attr($si_target).'">
					<i class="fa fa-'.esc_attr($si_icon).'"></i> 
				</a>
				<h4>'.esc_html($si_likes).'</h4>
				<p>'.esc_html($si_title).'</p>
			</div>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Social_Icon();