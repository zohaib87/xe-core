<?php 
/**
 * Member element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Member extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'member_fields') );
		add_shortcode( 'member', array($this, 'member_shortcode') );

	}

	public function member_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Member', 'xe-core' ),
			'description' => __( 'Display member with info', 'xe-core' ),
			'base' 		=> 'member',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'dropdown',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Member', 'xe-core'),
		            'description' 	=> __('Select the member you want to display.', 'xe-core'),
		            'param_name' 	=> 'mb_id',
		            'value' 		=> $xe_core->cpt_array('xe-members'),
		        ),

		        $xe_core->css_animation('mb_animation'),
				$xe_core->anim_duration('mb_duration'),
				$xe_core->anim_delay('mb_delay'),

		        $xe_core->extra_class('mb_class'),
				$xe_core->uniq_class('mb_uniq'),

				$xe_core->design_options('mb_css')

			)

		) );

	}

	public function member_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'member', $atts );
		extract( $atts );

		if (!empty($mb_id)) :

			global $xe_core;

			$args = array(
				'p' 		=> $mb_id,
				'post_type'	=> 'xe-members',
			);
			$query = new WP_Query($args);
			$output = '';

			$xe_core->load_custom_css($mb_css);

			$mb_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $mb_css, ' ' ), $this->settings['base'], $atts );

			/* Styles */
			$styles = '';

			$anim = $xe_core->animation($mb_animation, $mb_duration, $mb_delay);
			$classes = $xe_core->classes( array($mb_uniq, $mb_class, $mb_css, $anim['class']) );
			$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

			$attributes = array( $anim['attr'], $dynamic_css );
			$attributes = implode(' ', $attributes);

		    /**
		     * Following variables ready to use after this point.
		     *
		     * @var $classes
		     * @var $attributes
		     */

			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) :
					$query->the_post();

					if ( function_exists('get_field') ) {
						$position = get_field('member_position');
						$email = get_field('member_email');
						$about = get_field('member_about');
						$facebook = get_field('member_facebook');
						$twitter = get_field('member_twitter');
						$google_plus = get_field('member_google_plus');
						$github = get_field('member_github');
						$behance = get_field('member_behance');
						$dribbble = get_field('member_dribbble');
						$pinterest = get_field('member_pinterest');
						$instagram = get_field('member_instagram');
						$linkedin = get_field('member_linkedin');
						$thumblr = get_field('member_thumblr');
						$youtube = get_field('member_youtube');
						$vimeo = get_field('member_vimeo');
					} else {
						$position = $email = $about = $facebook = $twitter = $google_plus = $github = $behance = $dribbble = $pinterest = $instagram = $linkedin = $thumblr = $youtube = $vimeo = '';
					}

					$title = get_the_title();
					$thumbnail = get_the_post_thumbnail( null, 'xe-core-member', array('class' => 'img-responsive') );

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $title
				     * @var $thumbnail [< Escape with wp_kses_post >]
				     * @var $position 
				     * @var $email
				     * @var $about [< Escape with wp_kses_post >]
				     * @var $facebook, $twitter, $google_plus, $github, $behance, $dribbble, $pinterest, $instagram, $linkedin, $thumblr, $youtube, $vimeo
				     */

					$output .= '
					<div class="team '.esc_attr($classes).'" '.$attributes.'>
						<div class="team-member"> 
							<!-- IMAGE --> 
							'.wp_kses_post($thumbnail).' 
							<!-- TEAM HOVER -->
							<div class="team-over">
								<h4>'.esc_html($title).'</h4>
								<span>'.esc_html($position).'</span>
								<p>'.esc_html($about).'</p>
								<!-- SOCIAL ICON -->
								<ul class="social_icons">
					';

					$output .= !empty($facebook) ? '<li class="facebook"> <a href="'.esc_url($facebook).'"><i class="fa fa-facebook"></i> </a></li>' : '';
					$output .= !empty($twitter) ? '<li class="twitter"> <a href="'.esc_url($twitter).'"><i class="fa fa-twitter"></i> </a></li>' : '';
					$output .= !empty($google_plus) ? '<li class="googleplus"> <a href="'.esc_url($google_plus).'"><i class="fa fa-google-plus"></i> </a></li>' : '';
					$output .= !empty($github) ? '<li class="github"> <a href="'.esc_url($github).'"><i class="fa fa-github"></i> </a></li>' : '';
					$output .= !empty($behance) ? '<li class="behance"> <a href="'.esc_url($behance).'"><i class="fa fa-behance"></i> </a></li>' : '';
					$output .= !empty($dribbble) ? '<li class="dribbble"> <a href="'.esc_url($dribbble).'"><i class="fa fa-dribbble"></i> </a></li>' : '';
					$output .= !empty($pinterest) ? '<li class="pinterest-p"> <a href="'.esc_url($pinterest).'"><i class="fa fa-pinterest"></i> </a></li>' : '';
					$output .= !empty($instagram) ? '<li class="instagram"> <a href="'.esc_url($instagram).'"><i class="fa fa-instagram"></i> </a></li>' : '';
					$output .= !empty($linkedin) ? '<li class="linkedin"> <a href="'.esc_url($linkedin).'"><i class="fa fa-linkedin"></i> </a></li>' : '';
					$output .= !empty($thumblr) ? '<li class="thumblr"> <a href="'.esc_url($thumblr).'"><i class="fa fa-thumblr"></i> </a></li>' : '';
					$output .= !empty($youtube) ? '<li class="youtube"> <a href="'.esc_url($youtube).'"><i class="fa fa-youtube"></i> </a></li>' : '';
					$output .= !empty($vimeo) ? '<li class="vimeo"> <a href="'.esc_url($vimeo).'"><i class="fa fa-vimeo"></i> </a></li>' : '';

					$output .= '
								</ul>
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
new Xe_Core_Member();