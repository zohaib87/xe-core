<?php 
/**
 * Portfolio element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Portfolio extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'portfolio_fields') );
		add_shortcode( 'portfolio', array($this, 'portfolio_shortcode') );

	}

	public function portfolio_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Portfolio', 'xe-core' ),
			'description' => __( 'Display portfolio grid', 'xe-core' ),
			'base' 		=> 'portfolio',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'checkbox',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Categories', 'xe-core'),
		            'description' 	=> __('Select the categories you want to display.', 'xe-core'),
		            'param_name' 	=> 'pf_cat',
		            'value' 		=> $xe_core->cpt_tax_array('xe-portfolio-categories'),
		        ),

		        array(
					'type' 			=> 'textfield',
					'class' 		=> '',
					'heading' 		=> __( 'Number', 'xe-core' ),
					'description' 	=> __( 'Number of portfolios to display.', 'xe-core' ),
					'param_name' 	=> 'pf_number',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Order By', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'pf_orderby',
					'value' 		=> array(
						__( 'ID', 'xe-core' ) => 'ID',
						__( 'Title', 'xe-core' ) => 'title',
						__( 'Date', 'xe-core' ) => 'date',
						__( 'Modified', 'xe-core' ) => 'modified',
						__( 'Random', 'xe-core' ) => 'rand',
					),
					'std'			=> 'date'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Order Type', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'pf_order',
					'value' 		=> array(
						__( 'ASC', 'xe-core' )  => 'ASC',
						__( 'DESC', 'xe-core' ) => 'DESC',
					),
					'std'			=> 'ASC'
				),

				array(
					'type' 			=> 'dropdown',
					'admin_label' 	=> true,
					'heading' 		=> __( 'Columns', 'xe-core' ),
					'description' 	=> __( 'Select the desired column layout.', 'xe-core' ),
					'param_name' 	=> 'pf_col',
					'value' 		=> array(
						__( '3 Columns', 'xe-core' ) => '4',
						__( '4 Columns', 'xe-core' ) => '3',
					),
					'std'			=> '4'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Pagination', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'pf_paging',
					'value' 		=> array(
						__( 'Disable', 'xe-core' )  => 'false',
						__( 'Enable', 'xe-core' ) => 'paging',
					),
					'std'			=> 'false'
				),

				$xe_core->css_animation('pf_animation'),
				$xe_core->anim_duration('pf_duration'),
				$xe_core->anim_delay('pf_delay'),

		        $xe_core->extra_class('pf_class'),
				$xe_core->uniq_class('pf_uniq'),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Style', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'pf_style',
					'group' 		=> __( 'Styles', 'xe-core' ),
					'value' 		=> array(
						__( 'Portfolio Style 1', 'xe-core' )  => '1',
						__( 'Portfolio Style 2', 'xe-core' )  => '2',
						__( 'Portfolio Style 3', 'xe-core' )  => '3',
					),
					'std'			=> '1'
				),

				$xe_core->design_options('pf_css')

			)

		) );

	}

	public function portfolio_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'portfolio', $atts );
		extract( $atts );

		if (!empty($pf_cat)) :

			global $xe_core, $xe_opt;

			$pf_cat = explode(",", $pf_cat);
			$pf_number = ( !empty($pf_number) ) ? $pf_number : -1;
			$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

			$args = array(
				'post_type'	=> 'xe-portfolio',
				'posts_per_page' => $pf_number,
				'tax_query' => array(
					array(
						'taxonomy' => 'xe-portfolio-categories',
						'field'    => 'id',
						'terms'    => $pf_cat,
					),
				),
				'orderby' 	=> $pf_orderby,
				'order' 	=> $pf_order,
				'paged' 	=> $paged
			);
			$query = new WP_Query($args);
			$output = '';

			$xe_core->load_custom_css($pf_css);

			$pf_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $pf_css, ' ' ), $this->settings['base'], $atts );

			$styles = '';

			$anim = $xe_core->animation($pf_animation, $pf_duration, $pf_delay);
			$classes = $xe_core->classes( array($pf_uniq, $pf_class, $pf_css, $anim['class']) );
			$dynamic_css = !empty($styles) ? 'data-xe-css="'.$xe_core->minify_css($styles).'"' : '';

			$attributes = array( $anim['attr'], $dynamic_css );
			$attributes = implode(' ', $attributes);

		    /**
		     * Following variables ready to use after this point.
		     *
		     * @var $classes
		     * @var $attributes
		     */
		    $xe_opt->portfolio['vc'] = '';
		    $xe_opt->portfolio['classes'] = $classes;
			$xe_opt->portfolio['cat'] = $pf_cat;
			$xe_opt->portfolio['attributes'] = $attributes;
			$xe_opt->portfolio['style'] = $pf_style;

			if ( $query->have_posts() ) :

				/**
				 * @var $output
				 */
				ob_start();
				get_template_part( 'template-parts/start', 'portfolio-list' );
				$output .= ob_get_contents();  
			    ob_end_clean();

				while ( $query->have_posts() ) :
					$query->the_post();

					/**
				     * Following variables ready to use after this point.
				     *
				     * @var $pf_col
				     */
				    $xe_opt->portfolio['columns'] = $pf_col;

					/**
					 * @var $output
					 */
					ob_start();
					get_template_part( 'template-parts/content', 'portfolio-list' );
					$output .= ob_get_contents();  
				    ob_end_clean();
					
				endwhile;

				/**
				 * @var $output
				 */
				ob_start();
				get_template_part( 'template-parts/end', 'portfolio-list' );
				$output .= ob_get_contents();  
			    ob_end_clean();

				if ($pf_paging == 'paging') {
					$output .= $xe_core->paging_nav($query);
				}

				/* Restore original Post Data */
				wp_reset_postdata();

			endif;

			return $output;

		endif;

	}

}
new Xe_Core_Portfolio();