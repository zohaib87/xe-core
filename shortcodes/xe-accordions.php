<?php 
/**
 * Accordions element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Accordions extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'accordions_fields') );
		add_shortcode( 'accordions', array($this, 'accordions_shortcode') );
		
	}

	public function accordions_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Accordions', 'xe-core' ),
			'description' => __( 'Collapsible content panels', 'xe-core' ),
			'base' 		=> 'accordions',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'dropdown',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Accordions', 'xe-core'),
		            'description' 	=> __('Select the accordions you want to display.', 'xe-core'),
		            'param_name' 	=> 'ad_id',
		            'value' 		=> $xe_core->cpt_array('xe-accordions'),
		        ),

		        $xe_core->css_animation('ad_animation'),
				$xe_core->anim_duration('ad_duration'),
				$xe_core->anim_delay('ad_delay'),

		        $xe_core->extra_class('ad_class'),
				$xe_core->uniq_class('ad_uniq'),

				$xe_core->design_options('ad_css')

			)

		) );

	}

	public function accordions_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'accordions', $atts );
		extract( $atts );

		if (!empty($ad_id)) :

			global $xe_core;

			$xe_core->load_custom_css($ad_css);

			$ad_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $ad_css, ' ' ), $this->settings['base'], $atts );
			
			$anim = $xe_core->animation($ad_animation, $ad_duration, $ad_delay);
			$classes = $xe_core->classes( array($ad_class, $ad_css, $anim['class']) );

			$attributes = array( $anim['attr'] );
			$attributes = implode(' ', $attributes);

		    /**
		     * Following variables ready to use after this point.
		     *
		     * @var $classes
		     * @var $attributes
		     */

			$args = array(
				'p' 		=> $ad_id,
				'post_type'	=> 'xe-accordions',
			);
			$query = new WP_Query($args);
			$output = '';

			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) :
					$query->the_post();

					if ( function_exists('get_field') ) {
						$accordions = get_field('accordion_repeater');
					} else {
						$accordions = '';
					}

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $accordions [< array of 'title' and 'content' >]
				     * @var $classes
				     * @var $attributes
				     */

					$output .= '';
					
				endwhile;

				/* Restore original Post Data */
				wp_reset_postdata();

			endif;

			return $output;

		endif;

	}

}
new Xe_Core_Accordions();