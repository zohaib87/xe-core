<?php 
/**
 * Tabs element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Tabs extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'tabs_fields') );
		add_shortcode( 'tabs', array($this, 'tabs_shortcode') );

	}

	public function tabs_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Tabs', 'xe-core' ),
			'description' => __( 'Tabbed content', 'xe-core' ),
			'base' 		=> 'tabs',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'checkbox',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Tabs', 'xe-core'),
		            'description' 	=> __('Select the tabs you want to display.', 'xe-core'),
		            'param_name' 	=> 'tab_id',
		            'value' 		=> $xe_core->cpt_array('xe-tabs'),
		        ),

		        $xe_core->css_animation('tab_animation'),
				$xe_core->anim_duration('tab_duration'),
				$xe_core->anim_delay('tab_delay'),

		        $xe_core->extra_class('tab_class'),
				$xe_core->uniq_class('tab_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Tabs Style', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'tab_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Tabs Style 1', 'xe-core' ) => '1',
						__( 'Tabs Style 2', 'xe-core' ) => '2',
					),
					'std'			=> '1'
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Tab Title Color', 'xe-core' ),
					'description' 	=> __( 'Choose color for tab title.', 'xe-core' ),
					'param_name' 	=> 'tab_title_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Tab Title Hover Color', 'xe-core' ),
					'description' 	=> __( 'Choose hover color for tab title.', 'xe-core' ),
					'param_name' 	=> 'tab_title_hover_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'colorpicker',
					'class' 		=> '',
					'heading' 		=> __( 'Active Tab Title Color', 'xe-core' ),
					'description' 	=> __( 'Choose title color for active tab .', 'xe-core' ),
					'param_name' 	=> 'tab_title_active_color',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> __( '', 'xe-core' ),
				),

				$xe_core->design_options('tab_css')

			)

		) );

	}

	public function tabs_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'tabs', $atts );
		extract( $atts );

		if (!empty($tab_id)) :

			global $xe_core;

			$ids = explode(",", $tab_id);
			$args = array(
				'post_type'	=> 'xe-tabs',
				'post__in' 	=> $ids,
				'posts_per_page'=> -1
			);
			$query = new WP_Query($args);
			$active = 'active';
			$output = '';

			$xe_core->load_custom_css($tab_css);

			$tab_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $tab_css, ' ' ), $this->settings['base'], $atts );

			/* Title color */
			$styles = !empty($tab_title_color) ? '.'.$tab_uniq.' > li > a { 
				color:' . $tab_title_color . ';
			}' : '';

			/* Title hover color */
			$styles .= !empty($tab_title_hover_color) ? '.'.$tab_uniq.' > li > a:hover { 
				color:' . $tab_title_hover_color . ';
			}' : '';

			/* Title active color */
			$styles .= !empty($tab_title_active_color) ? '.'.$tab_uniq.' > li > a:active { 
				color:' . $tab_title_active_color . ';
			}' : '';

			$anim = $xe_core->animation($tab_animation, $tab_duration, $tab_delay);
			$classes = $xe_core->classes( array($tab_uniq, $tab_class, $tab_css, $tab_uniq, $anim['class']) );
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

				/**
			     * @var $output
			     */
				$output = '
				<ul class="nav nav-tabs '.esc_attr($classes).'" '.$attributes.' role="tablist">
				';

				foreach ($ids as $id) {

					if ( function_exists('get_field') ) {
						$icon_selector = get_field('tab_icon', $id);
						
						if ($icon_selector == 'fontawesome') {
							$icon = get_field('tab_fontawesome', $id);
							$icon = !empty($icon) ? 'fa '.$icon : 'fa-cog';
						} elseif ($icon_selector == 'ionicons') {
							$icon = get_field('tab_ionicons', $id);
							$icon = !empty($icon) ? $icon : 'ion-ios-gear';
						}
					} else {
						$icon = 'fa-cog';
					}

					$title = get_the_title($id);

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $title
				     * @var $active [< Just 'active' string for tab class >]
				     * @var $id [< Post/tab id >]
				     * @var $icon [< Font icon class >]
				     */

					/**
					 * @var $output
					 */
			    	$output .= '
			    	<li role="presentation" class="'.esc_attr($active).'"> <a href="#'.esc_attr($id).'" aria-controls="'.esc_attr($id).'" role="tab" data-toggle="tab"> <i class="'.esc_attr($icon).'"></i>
					  <h5>'.esc_html($title).'</h5>
					  </a></li>
					';

					$active = '';

			    }

				$active = 'active';

				/**
				 * @var $output
				 */
			    $output .= '
			    </ul>
			    
			    <!-- TAB CONTENT -->
		        <div class="tab-inner">
					<div class="tab-content"> 
			    ';

				while ( $query->have_posts() ) :
					$query->the_post();

					$id = get_the_ID();
					$title = get_the_title();
					ob_start();
					the_content();
					$content = ob_get_clean();

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $id [< Current post/tab id >]
				     * @var $title
				     * @var $content [< Escape with wp_kses_post >]
				     */

					/**
					 * @var $output
					 */
					$output .= '	            
		            <!-- SETTING -->
		            <div role="tabpanel" class="tab-pane '.esc_attr($active).'" id="'.esc_attr($id).'">
						'.wp_kses_post($content).'
		            </div>
					';

					$active = '';
					
				endwhile;

				/**
				 * @var $output
				 */
				$output .= '
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
new Xe_Core_Tabs();