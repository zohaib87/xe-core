<?php 
/**
 * Countdown element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Countdown extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'countdown_fields') );
		add_shortcode( 'countdown', array($this, 'countdown_shortcode') );

	}

	public function countdown_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Countdown', 'xe-core' ),
			'description' => __( 'A countdown to zero', 'xe-core' ),
			'base' 		=> 'countdown',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Date', 'xe-core' ),
					'description' 	=> __( 'Enter end date and time for countdown in this format: Sep 5, 2018 15:37:25', 'xe-core' ),
					'param_name' 	=> 'cd_date',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Countdown Align', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'cd_align',
					'value' 		=> array(
						__( 'Left', 'xe-core' )  => 'left',
						__( 'Center', 'xe-core' )  => 'center',
						__( 'Right', 'xe-core' ) => 'right',
					),
					'std'			=> 'left'
				),

				$xe_core->css_animation('cd_animation'),
				$xe_core->anim_duration('cd_duration'),
				$xe_core->anim_delay('cd_delay'),

		        $xe_core->extra_class('cd_class'),
				$xe_core->uniq_class('cd_uniq'),

				$xe_core->design_options('cd_css')

			)

		) );

	}

	public function countdown_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'countdown', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($cd_css);

		$cd_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $cd_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($cd_animation, $cd_duration, $cd_delay);
		$classes = $xe_core->classes( array($cd_uniq, $cd_class, $cd_css, 'text-'.$cd_align, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

		wp_enqueue_script( 'countdown', plugin_dir_url(__DIR__) . 'assets/js/countdown.js', array('jquery'), '20151215', true );
		wp_localize_script( 'countdown', 'cd', array(

		    'date' 		=> esc_attr($cd_date),

		) );

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */

		$output = '
		<div class="countdown-container-white mt-0 mb-0 '.esc_attr($classes).'" '.$attributes.'>
			<ul class="countdown">
				<li> <span class="days"></span>
					<p>days</p>
				</li>
				<li> <span class="hours"></span>
					<p>hours</p>
				</li>
				<li> <span class="minutes"></span>
					<p>minutes</p>
				</li>
				<li> <span class="seconds"></span>
					<p>seconds</p>
				</li>
			</ul>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Countdown();