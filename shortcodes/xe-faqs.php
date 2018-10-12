<?php 
/**
 * FAQs element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Faqs extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'faqs_fields') );
		add_shortcode( 'faqs', array($this, 'faqs_shortcode') );

	}

	public function faqs_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'FAQs', 'xe-core' ),
			'description' => __( 'Frequently Asked Questions', 'xe-core' ),
			'base' 		=> 'faqs',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'dropdown',
		            'heading' 		=> __('FAQs', 'xe-core'),
		            'description' 	=> __('Select the faqs you want to display.', 'xe-core'),
		            'param_name' 	=> 'faq_id',
		            'value' 		=> $xe_core->cpt_array('xe-faqs'),
		        ),

		        $xe_core->css_animation('faq_animation'),
				$xe_core->anim_duration('faq_duration'),
				$xe_core->anim_delay('faq_delay'),

		        $xe_core->extra_class('faq_class'),
				$xe_core->uniq_class('faq_uniq'),

				$xe_core->design_options('faq_css')

			)

		) );

	}

	public function faqs_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'faqs', $atts );
		extract( $atts );

		if (!empty($faq_id)) :

			global $xe_core;

			$xe_core->load_custom_css($faq_css);

			$faq_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $faq_css, ' ' ), $this->settings['base'], $atts );

			/* Styles */
			$styles = '';

			$anim = $xe_core->animation($faq_animation, $faq_duration, $faq_delay);
			$classes = $xe_core->classes( array($faq_uniq, $faq_class, $faq_css, $anim['class']) );
			$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

			$attributes = array( $anim['attr'], $dynamic_css );
			$attributes = implode(' ', $attributes);

		    /**
		     * Following variables ready to use after this point.
		     *
		     * @var $classes
		     * @var $attributes
		     */

			$faq_id = explode(",", $faq_id);
			$args = array(
				'p' 		=> $faq_id,
				'post_type'	=> 'xe-faqs',
			);
			$query = new WP_Query($args);
			$output = '';

			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) :
					$query->the_post();

					if ( function_exists('get_field') ) {
						$faqs = get_field('faq_repeater');
					} else {
						$faqs = null;
					}

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $faqs [< array of title and content >]
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
new Xe_Core_Faqs();