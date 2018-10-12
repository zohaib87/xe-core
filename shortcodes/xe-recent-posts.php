<?php 
/**
 * Recent Posts element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Recent_Posts extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'recent_posts_fields') );
		add_shortcode( 'recent_posts', array($this, 'recent_posts_shortcode') );

	}

	public function recent_posts_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Recent Posts', 'xe-core' ),
			'description' => __( 'Display recent posts', 'xe-core' ),
			'base' 		=> 'recent_posts',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

		        array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Number', 'xe-core' ),
					'description' 	=> __( 'Number of posts to display.', 'xe-core' ),
					'param_name' 	=> 'rp_number',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Order By', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'rp_orderby',
					'value' 		=> array(
						__( 'ID', 'xe-core' )  => 'ID',
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
					'param_name' 	=> 'rp_order',
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
					'param_name' 	=> 'rp_col',
					'value' 		=> array(
						__( '1 Column', 'xe-core' )  => '12',
						__( '2 Columns', 'xe-core' ) => '6',
						__( '3 Columns', 'xe-core' ) => '4',
						__( '4 Columns', 'xe-core' ) => '3',
					),
					'std'			=> '4'
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Pagination', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'rp_paging',
					'value' 		=> array(
						__( 'Disable', 'xe-core' )  => 'false',
						__( 'Enable', 'xe-core' ) => 'paging',
					),
					'std'			=> 'false'
				),

				$xe_core->css_animation('rp_animation'),
				$xe_core->anim_duration('rp_duration'),
				$xe_core->anim_delay('rp_delay'),

		        $xe_core->extra_class('rp_class'),
				$xe_core->uniq_class('rp_uniq'),

				$xe_core->design_options('rp_css')

			)

		) );

	}

	function recent_posts_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'recent_posts', $atts );
		extract( $atts );

		global $xe_core, $xe_opt;

		$rp_number = ( !empty($rp_number) ) ? $rp_number : -1;
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

		$args = array(
			'post_type'	=> 'post',
			'posts_per_page' => $rp_number,
			'orderby' 	=> $rp_orderby,
			'order' 	=> $rp_order,
			'post__not_in' => get_option('sticky_posts'),
			'paged' 	=> $paged
		);
		$query = new WP_Query($args);
		$output = '';

		$xe_core->load_custom_css($rp_css);

		$rp_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $rp_css, ' ' ), $this->settings['base'], $atts );

		/* Styles */
		$styles = '';

		$anim = $xe_core->animation($rp_animation, $rp_duration, $rp_delay);
		$classes = $xe_core->classes( array($rp_uniq, $rp_class, $rp_css, $anim['class'], 'blog') );
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
			$output .= '<div class="'.esc_attr($classes).'" '.$attributes.'>';
			
			ob_start();
			get_template_part( 'template-parts/start' );
			$output .= ob_get_contents();  
		    ob_end_clean();

			while ( $query->have_posts() ) :
				$query->the_post();

				/**
			     * Following variables ready to use after this point.
			     *
			     * @var $rp_col
			     */
			    $xe_opt->blog['columns'] = $rp_col;

				/**
				 * @var $output
				 */
				ob_start();
				get_template_part( 'template-parts/content' );
				$output .= ob_get_contents();  
			    ob_end_clean();
				
			endwhile;

			/**
			 * @var $output
			 */
			ob_start();
			get_template_part( 'template-parts/end' );
			$output .= ob_get_contents();  
		    ob_end_clean();

			$output .= '</div>';

			/**
			 * Paging Nav
			 */
			if ($rp_paging == 'paging') {
				$output .= $xe_core->paging_nav($query);
			}

			/* Restore original Post Data */
			wp_reset_postdata();

		endif;

		return $output;

	}

}
new Xe_Core_Recent_Posts();