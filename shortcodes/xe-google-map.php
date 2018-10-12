<?php 
/**
 * Google Map element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Google_Map extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'google_map_fields') );
		add_shortcode( 'google_map', array($this, 'google_map_shortcode') );

	}

	public function google_map_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Google Map', 'xe-core' ),
			'description' => __( 'Google map block with mark', 'xe-core' ),
			'base' 		=> 'google_map',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Title', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'gm_title',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' => 'attach_image',
					'class' => '',
					'heading' => __( 'Marker', 'xe-core' ),
					'description' => __( '', 'xe-core' ),
					'param_name' => 'gm_marker',
					'value' => '',
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Zoom', 'xe-core' ),
					'description' 	=> __( 'Enter map zoom value. e.g: 13', 'xe-core' ),
					'param_name' 	=> 'gm_zoom',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Latitude', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'gm_lat',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Longitude', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'gm_lang',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Height', 'xe-core' ),
					'description' 	=> __( 'Enter height of map in pixels. Do not add "px".', 'xe-core' ),
					'param_name' 	=> 'gm_height',
					'value' 		=> __( '', 'xe-core' ),
				),

				$xe_core->css_animation('gm_animation'),
				$xe_core->anim_duration('gm_duration'),
				$xe_core->anim_delay('gm_delay'),

		        $xe_core->extra_class('gm_class'),
				$xe_core->uniq_class('gm_uniq'),

				$xe_core->design_options('gm_css')

			),

		) );

	}

	public function google_map_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'google_map', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($gm_css);

		$gm_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $gm_css, ' ' ), $this->settings['base'], $atts );

		$styles = !empty($gm_height) ? ".".esc_attr($gm_uniq)." .map-wrapper {
			min-height: ".esc_attr($gm_height)."px;
		}" : '';

		$gm_marker = !empty($gm_marker) ? wp_get_attachment_url($gm_marker) : get_template_directory_uri() . '/img/marker.png';
		$gm_zoom = !empty($gm_zoom) ? $gm_zoom : '13';
		$gm_lat = !empty($gm_lat) ? $gm_lat : '-37.814199';
		$gm_lng = !empty($gm_lng) ? $gm_lng : '144.961560';

		$anim = $xe_core->animation($gm_animation, $gm_duration, $gm_delay);
		$classes = $xe_core->classes( array($gm_uniq, $gm_class, $gm_css, $anim['class']) );
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
		<div class="map-block '.esc_attr($classes).'" '.$attributes.'>
	        <div id="map-canvas" class="map-wrapper" data-lat="'.esc_attr($gm_lat).'" data-lng="'.esc_attr($gm_lang).'" data-zoom="'.esc_attr($gm_zoom).'" data-style="1" data-marker="'.esc_url($gm_marker).'"></div>
	        <div class="markers-wrapper addresses-block"> <a class="marker" data-rel="map-canvas" data-lat="'.esc_attr($gm_lat).'" data-lng="'.esc_attr($gm_lang).'" data-string="'.esc_attr($gm_title).'"></a> </div>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Google_Map();