<?php 
/**
 * Image element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Image_Link extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'image_link_fields') );
		add_shortcode( 'image_link', array($this, 'image_link_shortcode') );

	}

	public function image_link_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Image', 'xe-core' ),
			'description' => __( 'Simple image with link', 'xe-core' ),
			'base' 		=> 'image_link',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
					'type' 			=> 'attach_image',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Image', 'xe-core' ),
					'param_name' 	=> 'il_id',
					'value' 		=> '',
					'description' 	=> __( '', 'xe-core' )
				),

				array(
					'type' 			=> 'textfield',
					'class' 		=> '',
					'heading' 		=> __( 'Width', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'il_width',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'class' 		=> '',
					'heading' 		=> __( 'Height', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'il_height',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Link', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'il_link',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Link Target', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'il_target',
					'value' 		=> array(
						__( 'Default', 'xe-core' )  => '_self',
						__( 'Open in New Tab', 'xe-core' ) => '_blank',
					),
					'std' 			=> '_self'
				),

				$xe_core->css_animation('il_animation'),
				$xe_core->anim_duration('il_duration'),
				$xe_core->anim_delay('il_delay'),

		        $xe_core->extra_class('il_class'),
				$xe_core->uniq_class('il_uniq'),

				$xe_core->design_options('il_css')

			),

		) );

	}

	public function image_link_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'image_link', $atts );
		extract( $atts );

		global $xe_core;

		$img_url = wp_get_attachment_url($il_id);
		$img_alt = get_post_meta($il_id, '_wp_attachment_image_alt', true);
		$width = !empty($width) ? 'width="'.esc_attr($il_width).'"' : '';
		$height = !empty($height) ? ' height="'.esc_attr($il_height).'"' : '';
		$size = $width . $height;
		
		$xe_core->load_custom_css($il_css);

		$il_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $il_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($il_animation, $il_duration, $il_delay);
		$classes = $xe_core->classes( array($il_uniq, $il_class, $il_css, $anim['class']) );
		$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

		$attributes = array( $anim['attr'], $dynamic_css );
		$attributes = implode(' ', $attributes);

	    /**
	     * Following variables ready to use after this point.
	     *
	     * @var $img_url [< Image url >]
	     * @var $img_alt [< Image alt >]
	     * @var $size [< Width and Height attributes combined >]
	     * @var $classes
	     * @var $attributes
	     */

		$output = '
		<div class="photofra '.esc_attr($classes).'" '.$attributes.'>
			<a href="'.esc_url($il_link).'">
				<img class="img-responsive" '.$size.' src="'.esc_url($img_url).'" alt="'.esc_attr($img_alt).'">
			</a>
		</div>
		';

		return $output;

	}

}
new Xe_Core_Image_Link();