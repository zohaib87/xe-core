<?php 
/**
 * Pricing Table element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Table extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'table_fields') );
		add_shortcode( 'table', array($this, 'table_shortcode') );

	}

	public function table_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Pricing Table', 'xe-core' ),
			'description' => __( 'Display pricing table', 'xe-core' ),
			'base' 		=> 'table',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'dropdown',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Pricing Table', 'xe-core'),
		            'description' 	=> __('Select the table you want to display.', 'xe-core'),
		            'param_name' 	=> 'tb_id',
		            'value' 		=> $xe_core->cpt_array('xe-pricing-tables'),
		        ),

		        array(
		            'type' 			=> 'dropdown',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Featured', 'xe-core'),
		            'description' 	=> __('', 'xe-core'),
		            'param_name' 	=> 'tb_featured',
		            'value' 		=> array(
		            	__( 'Enable', 'xe-core' )  => '1',
						__( 'Disable', 'xe-core' ) => '0',
		            ),
		            'std'			=> '0'
		        ),

		        $xe_core->css_animation('tb_animation'),
				$xe_core->anim_duration('tb_duration'),
				$xe_core->anim_delay('tb_delay'),

		        $xe_core->extra_class('tb_class'),
				$xe_core->uniq_class('tb_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Pricing Table Style', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'sb_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Pricing Table Style 1', 'xe-core' )  => '1',
						__( 'Pricing Table Style 2', 'xe-core' ) => '2',
					),
				),

				$xe_core->design_options('tb_css')

			)

		) );

	}

	public function table_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'table', $atts );
		extract( $atts );

		if (!empty($tb_id)) :

			global $xe_core;

			$args = array(
				'p' 		=> $tb_id,
				'post_type'	=> 'xe-pricing-tables',
			);
			$query = new WP_Query($args);
			$output = '';

			$xe_core->load_custom_css($tb_css);

			$tb_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $tb_css, ' ' ), $this->settings['base'], $atts );

			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) :
					$query->the_post();

					if ( function_exists('get_field') ) {
						$subtitle = get_field('table_subtitle');
						$icon_selector = get_field('table_icon');
						$icon_fontawesome = get_field('table_fontawesome');
						$icon_ionicons = get_field('table_ionicons');
						$icon_size = get_field('table_icon_size');
						$currency = get_field('table_currency');
						$price = get_field('table_price');
						$billed = get_field('table_billed');
						$button_text = get_field('table_button_text');
						$button_link = get_field('table_button_link');
						$button_target = get_field('table_button_target');
						$features = get_field('table_features');
					} else {
						$subtitle = $icon_selector = $icon_fontawesome = $icon_ionicons = $icon_size = $currency = $price = $billed = $button_text = $button_link = $button_target = $features = '';
					}

					$title = get_the_title();
					$icon = $xe_core->icon_class($icon_selector, $icon_fontawesome, $icon_ionicons);

					/* Styles */
					$styles = '';

					$anim = $xe_core->animation($tb_animation, $tb_duration, $tb_delay);			
					$classes = $xe_core->classes( array($tb_uniq, $tb_class, $tb_css, $anim['class']) );
					$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

					$attributes = array( $anim['attr'], $dynamic_css );
					$attributes = implode(' ', $attributes);

					$ft_count = 1;

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $classes
				     * @var $attributes
				     * @var $title 
				     * @var $subtitle 
				     * @var $icon [< Font icon class >]
				     * @var $icon_image
				     * @var $icon_size
				     * @var $currency
				     * @var $price
				     * @var $billed
				     * @var $button_text
				     * @var $button_link
				     * @var $button_target
				     * @var $tb_featured [< Returns true or false >]
				     * @var $features [< Repeater of 'feature' text field >]
				     */

					$output .= '
					<div class="pricing '.esc_attr($classes).'" '.$attributes.'>
						<div class="pricing-table">
							<h6>'.esc_html($title).'</h6>
							<div class="price-head font-montserrat"> 
								<span class="curency">'.esc_html($currency).'</span>'.esc_html($price).'<span class="month">'.esc_html($billed).'</span> 
							</div>
							<div class="p-details">
					';

					if ($features) :
						foreach ($features as $feature) {
							if ($ft_count == 2) {
								$ft_class = ' class="grey-bg"';
								$ft_count = 1;
							} else {
								$ft_class = '';
								$ft_count++;
							}
						 	$output .= '<p'.$ft_class.'>'.esc_html($feature['feature']).'</p>';
						}
					endif;

					$output .= '<a href="'.esc_url($button_link).'" class="btn" target="'.esc_attr($button_target).'">'.esc_html($button_text).'<i class="fa fa-long-arrow-right"></i></a>
							</div>
						</div>
					</div>
					';
					
				endwhile;

				/* Restore original Post Data */
				wp_reset_postdata();

			endif;

			return $output;

		endif;

	}

}
new Xe_Core_Table();