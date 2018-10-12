<?php 
/**
 * Posts Categories element for Visual Composer.
 *
 * @package Xe Core
 */

class Xe_Core_Posts_Categories extends WPBakeryShortCode {

	function __construct() {

		add_action( 'vc_before_init', array($this, 'posts_categories_fields') );
		add_shortcode( 'posts_categories', array($this, 'posts_categories_shortcode') );

	}

	public function posts_categories_fields() {

		global $xe_core;

		vc_map( array(

			'name' 		=> __( 'Posts Categories', 'xe-core' ),
			'description' => __( 'Display posts by categories', 'xe-core' ),
			'base' 		=> 'posts_categories',
			'class' 	=> '',
			'category' 	=> __( 'Custom' , 'xe-core'),
			'params' 	=> array(

				array(
		            'type' 			=> 'checkbox',
		            'admin_label' 	=> true,
		            'heading' 		=> __('Categories', 'xe-core'),
		            'description' 	=> __('Select the categories you want to display.', 'xe-core'),
		            'param_name' 	=> 'pc_cat',
		            'value' 		=> $xe_core->cpt_tax_array('category'),
		        ),

		        array(
					'type' 			=> 'textfield',
					'admin_label' 	=> true,
					'class' 		=> '',
					'heading' 		=> __( 'Number', 'xe-core' ),
					'description' 	=> __( 'Number of posts to display.', 'xe-core' ),
					'param_name' 	=> 'pc_number',
					'value' 		=> __( '', 'xe-core' ),
				),

				array(
					'type' 			=> 'dropdown',
					'heading' 		=> __( 'Order By', 'xe-core' ),
					'description' 	=> __( '', 'xe-core' ),
					'param_name' 	=> 'pc_orderby',
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
					'param_name' 	=> 'pc_order',
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
					'param_name' 	=> 'pc_col',
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
					'param_name' 	=> 'pc_paging',
					'value' 		=> array(
						__( 'Disable', 'xe-core' )  => 'false',
						__( 'Enable', 'xe-core' ) => 'paging',
					),
					'std'			=> 'false'
				),

				$xe_core->css_animation('pc_animation'),
				$xe_core->anim_duration('pc_duration'),
				$xe_core->anim_delay('pc_delay'),

		        $xe_core->extra_class('pc_class'),
				$xe_core->uniq_class('pc_uniq'),

				$xe_core->design_options('pc_css')

			)

		) );

	}

	function posts_categories_shortcode($atts, $content = null) { 

		$atts = vc_map_get_attributes( 'posts_categories', $atts );
		extract( $atts );

		global $xe_core, $xe_opt;

		$pc_cat = explode(",", $pc_cat);
		$pc_number = !empty($pc_number) ? $pc_number : -1;
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;

		$args = array(
			'post_type'	=> 'post',
			'posts_per_page' => $pc_number,
			'tax_query' => array(
				array(
					'taxonomy' => 'category',
					'field'    => 'id',
					'terms'    => $pc_cat,
				),
			),
			'orderby' 	=> $pc_orderby,
			'order' 	=> $pc_order,
			'post__not_in' => get_option('sticky_posts'),
			'paged' 	=> $paged
		);
		$query = new WP_Query($args);
		$output = '';

		$xe_core->load_custom_css($pc_css);

		$pc_css = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $pc_css, ' ' ), $this->settings['base'], $atts );

		$anim = $xe_core->animation($pc_animation, $pc_duration, $pc_delay);
		$classes = $xe_core->classes( array($pc_uniq, $pc_class, $pc_css, $anim['class'], 'blog') );

		$attributes = array( $anim['attr'] );
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
			$output .= '<div class="'.esc_attr($classes).'"'.$attributes.'>';
			
			ob_start();
			get_template_part( 'template-parts/start' );
			$output .= ob_get_contents();  
		    ob_end_clean();

			while ( $query->have_posts() ) :
				$query->the_post();

				/**
			     * Following variables ready to use after this point.
			     *
			     * @var $pc_col
			     */
			    $xe_opt->blog['columns'] = $pc_col;

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
			if ($pc_paging == 'paging') {
				$output .= $xe_core->paging_nav($query);
			}

			/* Restore original Post Data */
			wp_reset_postdata();

		endif;

		return $output;

	}

}
new Xe_Core_Posts_Categories();