<?php 
/**
 * Testimonials element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Testimonials extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'testimonials_fields') );
		add_shortcode( 'testimonials', array($this, 'testimonials_shortcode') );

	}

	public function testimonials_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Testimonials', 'xe-core' ),
			'description' => __( 'Client testimonials', 'xe-core' ),
			'base' 		=> 'testimonials',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'checkbox',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Testimonials', 'xe-core'),
		            'description' 	=> __('Select the testimonials you want to display.', 'xe-core'),
		            'param_name' 	=> 'tm_id',
		            'value' 		=> $xe_core->cpt_array('xe-testimonials'),
		        ),

		        $xe_core->css_animation('tm_animation'),
				$xe_core->anim_duration('tm_duration'),
				$xe_core->anim_delay('tm_delay'),

		        $xe_core->extra_class('tm_class'),
				$xe_core->uniq_class('tm_uniq'),

				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Testimonials Style',  'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'tm_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Testimonials Style 1',  'xe-core'  ) => '1',
						__( 'Testimonials Style 2',  'xe-core'  ) => '2',
						__( 'Testimonials Style 3',  'xe-core'  ) => '3',
					),
					'std'			=> '1'
				),

				$xe_core->design_options('tm_css')

			)

		) );

	}

	public function testimonials_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'testimonials', $atts );
		extract( $atts );

		if (!empty($tm_id)) :

			global $xe_core;

			$tm_id = explode(",", $tm_id);
			$args = array(
				'post_type'	=> 'xe-testimonials',
				'post__in' 	=> $tm_id,
				'posts_per_page'=> -1
			);
			$query = new WP_Query($args);
			$output = '';
			$count = 0;

			$tm_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $tm_css, ' ' ), $this->settings['base'], $atts );

			/* Styles */
			$styles = '';

			$anim = $xe_core->animation($tm_animation, $tm_duration, $tm_delay);
			$classes = $xe_core->classes( array($tm_uniq, $tm_class, $tm_css, $anim['class']) );
			$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

			$attributes = array( $anim['attr'], $dynamic_css );
			$attributes = implode(' ', $attributes);

		    /**
		     * Following variables ready to use after this point.
		     *
		     * @var $count [< equal to 0 at this point >]
		     * @var $classes
		     * @var $attributes
		     */

			if ( $query->have_posts() ) :

				/**
			     * @var $output
			     */
				$output = '
				<div class="testi '.esc_attr($classes).'" '.$attributes.'> 
					<!-- TESTIMONIALS SLIDERS CAROUSEL -->
			        <div id="carousel-example-generic" class="carousel slide carousel-fade" data-ride="carousel">
							<div class="row">
								<div class="col-lg-8">
									<div class="carousel-inner" role="listbox">
				';

				while ( $query->have_posts() ) :
					$query->the_post();

					if ( function_exists('get_field') ) {
						$position = get_field('testimonial_position');
						$rating = get_field('testimonial_rate');
						$text = get_field('testimonial_text');
					} else {
						$position = $rating = $text = '';
					}

					$id = get_the_ID();
					$title = get_the_title();
					$thumbnail = get_the_post_thumbnail( null, 'xe-core-testimonial' );
					$active = ($count == 0) ? 'active' : '';

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $id
				     * @var $thumbnail [< Do not escape >]
				     * @var $title
				     * @var $position
				     * @var $rating
				     * @var $text
				     */

					/**
				     * @var $output
				     */
					$output .= '             
					<!-- SLIDER -->
					<div class="item '.esc_attr($active).'">
						<p>'.esc_html($text).'</p>
						<h5>'.esc_html($title).'</h5>
						<span>'.esc_html($position).'</span>
						<ul class="star">';
					$output .= ($rating >= 1) ? '<li><i class="fa fa-star"></i></li>' : '<li class="grey"><i class="fa fa-star"></i></li>';
					$output .= ($rating >= 2) ? '<li><i class="fa fa-star"></i></li>' : '<li class="grey"><i class="fa fa-star"></i></li>';
					$output .= ($rating >= 3) ? '<li><i class="fa fa-star"></i></li>' : '<li class="grey"><i class="fa fa-star"></i></li>';
					$output .= ($rating >= 4) ? '<li><i class="fa fa-star"></i></li>' : '<li class="grey"><i class="fa fa-star"></i></li>';
					$output .= ($rating == 5) ? '<li><i class="fa fa-star"></i></li>' : '<li class="grey"><i class="fa fa-star"></i></li>';
					$output .= '</ul>
					</div>
					';

					$count++;
					
				endwhile;

				/**
			     * @var $output
			     */
				$output .= '
				</div>
		        </div>

				<!-- SLIDER AVATARS -->
				<div class="col-lg-4">
					<ol class="carousel-indicators '.$anim['class'].'" '.$anim['attr'].'>';

				foreach ($tm_id as $count => $id) {

					$title = get_the_title($id);
					$thumbnail = get_the_post_thumbnail($id, 'xe-core-testimonial');
					$active = ($count == 0) ? 'active' : '';

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $id
				     * @var $thumbnail [< Escape with wp_kses_post >]
				     * @var $active
				     */

					/**
				     * @var $output
				     */
					$output .= '<li data-target="#carousel-example-generic" data-slide-to="'.esc_attr($count).'" class="'.esc_attr($active).'"> <span class="feeder-name animated flipInY">'.esc_attr($title).'</span> '.wp_kses_post($thumbnail).' </li>';

				}

				/**
			     * @var $output
			     */
				$output .= '
								</ol>
							</div>
						</div>
					</div>
				</div>
				';

				/* Restore original Post Data */
				wp_reset_postdata();

			endif;

			return $output;

		endif;

	}

}
new Xe_Core_Testimonials();