<?php 
/**
 * Gallery element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Image_Gallery extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'image_gallery_fields') );
		add_shortcode( 'image_gallery', array($this, 'image_gallery_shortcode') );

	}

	public function image_gallery_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Gallery', 'xe-core' ),
			'description' => __( 'Responsive image gallery', 'xe-core' ),
			'base' 		=> 'image_gallery',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'attach_images',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Images', 'xe-core' ),
					'param_name' 	=> 'ig_images',
					'value' 		=> '',
					'description' 	=> __( '', 'xe-core' )
				),

				$xe_core->css_animation('ig_animation'),
				$xe_core->anim_duration('ig_duration'),
				$xe_core->anim_delay('ig_delay'),

		        $xe_core->extra_class('ig_class'),
				$xe_core->uniq_class('ig_uniq'),

				$xe_core->design_options('ig_css')

			),

		) );

	}

	public function image_gallery_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'image_gallery', $atts );
		extract( $atts );

		global $xe_core;

		$xe_core->load_custom_css($ig_css);

		$ig_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $ig_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($ig_animation, $ig_duration, $ig_delay);
		$classes = $xe_core->classes( array($ig_uniq, $ig_class, $ig_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $classes
	     * @var $attributes
	     */
	    
	    $ig_images = explode(",", $ig_images);

		$output = ' 
		<section class="photography '.esc_attr($classes).'" '.$attributes.'>
			<div class="container-fluid">
				<ul class="row">
		';

		foreach ($ig_images as $ig_image) {

			$image_url = wp_get_attachment_url($ig_image);
			$image_alt = get_post_meta( $ig_image, '_wp_attachment_image_alt', true);

			/**
		     * Following variables ready to use after this point.
		     *
		     * @var $image_url
		     * @var $image_alt
		     */
			
			$output .= '
			<li> 
				<img src="'.esc_url($image_url).'" alt="'.esc_attr($image_alt).'"> 
				<a href="'.esc_url($image_url).'" data-lighter> 
					<i class="lnr lnr-frame-expand"></i> 
				</a> 
			</li>
			';

		}

		$output .= '
				</ul>
			</div>
	    </section>
		';

		return $output;

	}

}
new Xe_Core_Image_Gallery();