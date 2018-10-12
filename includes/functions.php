<?php 
/**
 * Xe Core functions and definitions.
 *
 * @package Xe Core
 */

class Xe_Core_Functions {

	function __construct() {
	}

	/**
	 * Custom Page Navigation
	 */
	public function paging_nav($query) {

		// Don't print empty markup if there's only one page.
		if ( $query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 2,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="fa fa-long-arrow-left" aria-hidden="true"></i>' . esc_html__( ' Previous', 'xe-core' ),
			'next_text' => esc_html__( 'Next ', 'xe-core' ) . '<i class="fa fa-long-arrow-right" aria-hidden="true"></i>',
	        'type'      => 'list',
		) );

		if ( $links ) :

		$output = '<nav class="navigation paging-navigation" role="navigation">';
		$output .= '<h1 class="screen-reader-text">' . esc_html__( 'Posts navigation', 'xe-core' ) . '</h1>';
		$output .= $links;
		$output .= '</nav><!-- .navigation -->';

		return $output;
		
		endif;

	}

	/**
	 * Array of css animations.
	 */
	public function animation_array() {

		return array(
			__('None', 'xe-core') => 'none',
			__('bounce', 'xe-core') => 'bounce',
		    __('flash', 'xe-core') => 'flash',
		    __('pulse', 'xe-core') => 'pulse',
		    __('rubberBand', 'xe-core') => 'rubberBand',
		    __('shake', 'xe-core') => 'shake',
		    __('headShake', 'xe-core') => 'headShake',
		    __('swing', 'xe-core') => 'swing',
		    __('tada', 'xe-core') => 'tada',
		    __('wobble', 'xe-core') => 'wobble',
		    __('jello', 'xe-core') => 'jello',
		    __('bounceIn', 'xe-core') => 'bounceIn',
		    __('bounceInDown', 'xe-core') => 'bounceInDown',
		    __('bounceInLeft', 'xe-core') => 'bounceInLeft',
		    __('bounceInRight', 'xe-core') => 'bounceInRight',
		    __('bounceInUp', 'xe-core') => 'bounceInUp',
		    __('fadeIn', 'xe-core') => 'fadeIn',
		    __('fadeInDown', 'xe-core') => 'fadeInDown',
		    __('fadeInDownBig', 'xe-core') => 'fadeInDownBig',
		    __('fadeInLeft', 'xe-core') => 'fadeInLeft',
		    __('fadeInLeftBig', 'xe-core') => 'fadeInLeftBig',
		    __('fadeInRight', 'xe-core') => 'fadeInRight',
		    __('fadeInRightBig', 'xe-core') => 'fadeInRightBig',
		    __('fadeInUp', 'xe-core') => 'fadeInUp',
		    __('fadeInUpBig', 'xe-core') => 'fadeInUpBig',
		    __('flip', 'xe-core') => 'flip',
		    __('flipInX', 'xe-core') => 'flipInX',
		    __('flipInY', 'xe-core') => 'flipInY',
		    __('lightSpeedIn', 'xe-core') => 'lightSpeedIn',
		    __('rotateIn', 'xe-core') => 'rotateIn',
		    __('rotateInDownLeft', 'xe-core') => 'rotateInDownLeft',
		    __('rotateInDownRight', 'xe-core') => 'rotateInDownRight',
		    __('rotateInUpLeft', 'xe-core') => 'rotateInUpLeft',
		    __('rotateInUpRight', 'xe-core') => 'rotateInUpRight',
		    __('hinge', 'xe-core') => 'hinge',
		    __('rollIn', 'xe-core') => 'rollIn',
		    __('rollOut', 'xe-core') => 'rollOut',
		    __('zoomIn', 'xe-core') => 'zoomIn',
		    __('zoomInDown', 'xe-core') => 'zoomInDown',
		    __('zoomInLeft', 'xe-core') => 'zoomInLeft',
		    __('zoomInRight', 'xe-core') => 'zoomInRight',
		    __('zoomInUp', 'xe-core') => 'zoomInUp',
		    __('slideInDown', 'xe-core') => 'slideInDown',
		    __('slideInLeft', 'xe-core') => 'slideInLeft',
		    __('slideInRight', 'xe-core') => 'slideInRight',
		    __('slideInUp', 'xe-core') => 'slideInUp',
		);

	}

	/**
	 * Animation classes and attributes
	 */
	public function animation($animation, $duration, $delay) {

		$anim = array(
			'class' => '',
			'attr' 	=> ''
		);

		if ($animation != 'none') {
			$anim['class'] = 'wow '.$animation;
			$anim['attr'] = !empty($duration) ? 'data-wow-duration="'.esc_attr($duration).'"' : '';
			$anim['attr'] .= !empty($duration) ? ' data-wow-delay="'.esc_attr($delay).'"' : '';
		}

		return $anim;

	}

	/**
	 * Animation fields
	 */
	public function css_animation($param_name) {

		return array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'CSS Animation',  'xe-core' ),
			'description' 	=> __( '', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> $this->animation_array(),
			'std'			=> 'none'
		);

	}
	public function anim_duration($param_name) {

		return array(
			'type' 			=> 'textfield',
			'class' 		=> '',
			'heading' 		=> __( 'Animation Duration', 'xe-core' ),
			'description' 	=> __( 'Enter animation duration time in seconds. e.g: 0.5s', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> __( '', 'xe-core' ),
		);

	}
	public function anim_delay($param_name) {

		return array(
			'type' 			=> 'textfield',
			'class' 		=> '',
			'heading' 		=> __( 'Animation Delay', 'xe-core' ),
			'description' 	=> __( 'Enter animation delay time in seconds. e.g: 0.4s', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> __( '', 'xe-core' ),
		);
		
	}

	/**
	 * Icon fields
	 */
	public function icon_selector($param_name) {

		return array(
			'type' 			=> 'dropdown',
			'heading' 		=> __( 'Icon Library', 'xe-core' ),
			'value' 		=> array(
				__( 'Font Awesome', 'xe-core' )	=> 'fontawesome',
				__( 'Ionicons', 'xe-core' ) 	=> 'ionicons',
			),
			'param_name' 	=> $param_name,
			'description' 	=> __( '', 'xe-core' ),
			'std'			=> 'fontawesome'
		);

	}
	public function fontawesome($param_name, $element) {

		return array(
			'type' 			=> 'textfield',
			'class' 		=> '',
			'heading' 		=> __( 'Fontawesome', 'xe-core' ),
			'description' 	=> '<a href="'.esc_url( 'http://fontawesome.io/icons/' ).'" target="_blank">'.__( 'Click Here', 'xe-core' ).'</a>'.__( ' to choose icon and get its class name.', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> __( '', 'xe-core' ),
			'dependency' 	=> array(
				'element' => $element,
				'value' => 'fontawesome',
			),
		);

	}
	public function ionicons($param_name, $element) {

		return array(
			'type' 			=> 'textfield',
			'class' 		=> '',
			'heading' 		=> __( 'Ionicon', 'xe-core' ),
			'description' 	=> '<a href="'.esc_url( 'http://ionicons.com/' ).'" target="_blank">'.__( 'Click Here', 'xe-core' ).'</a>'.__( ' to choose icon and get its class name.', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> __( '', 'xe-core' ),
			'dependency' 	=> array(
				'element' => $element,
				'value'   => 'ionicons',
			),
		);

	}

	/**
	 * Icon class generator
	 */
	public function icon_class($icon_library, $fontawesome, $ionicons) {

		$icons = array(
			'fontawesome' 	=> $fontawesome,
			'ionicons' 		=> $ionicons,
		);

		if ($icon_library == 'fontawesome') {

			$icon = $icons['fontawesome'];
			$icon = !empty($icon) ? 'fa ' . $icon : 'fa fa-cog';

		} elseif ($icon_library == 'ionicons') {

			$icon = $icons['ionicons'];
			$icon = !empty($icon) ? $icon : 'ion-ios-gear';

		}

		return $icon;

	}

	/**
	 * Extra class
	 */
	public function extra_class($param_name) {

		return array(
			'type' 			=> 'textfield',
			'class' 		=> '',
			'heading' 		=> __( 'Extra Class', 'xe-core' ),
			'description' 	=> __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> __( '', 'xe-core' ),
		);

	}

	/**
	 * Unique class
	 */
	public function uniq_class($param_name) {

		return array(
			'type' 			=> 'textfield',
			'edit_field_class' => 'vc_col-xs-12 xe-hidden',
			'heading' 		=> __( 'Unique Class', 'xe-core' ),
			'description' 	=> __( 'Unique class name to target and style this element specifically. Please don\'t remove this class unless you know what you are doing.', 'xe-core' ),
			'param_name' 	=> $param_name,
			'value' 		=> uniqid('xe-'),
		);

	}

	/**
	 * Design options
	 */
	public function design_options($param_name) {

		return array(
            'type' 			=> 'css_editor',
            'heading' 		=> __( 'CSS', 'xe-core' ),
            'param_name' 	=> $param_name,
            'group' 		=> __( 'Design Options', 'xe-core' ),
        );

	}

	/**
	 * Adjusting spacing of classes
	 */
	public function classes( $classes = array() ) {

		$classes = implode(' ', $classes);
		$classes = trim( preg_replace('/\s+/', ' ', $classes) );

		return $classes;

	}

	/**
	 * Minifying styles 
	 */
	public function minify_css($css) {

		$css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
	    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
	    $css = str_replace(array('{ ', ' {'), '{', $css);
	    $css = str_replace(array('} ', ' }'), '}', $css);
	    $css = str_replace('; ', ';', $css);
	    $css = str_replace(': ', ':', $css);
	    $css = str_replace(', ', ',', $css);
	    $css = str_replace(array('> ', ' >'), '>', $css);
	    $css = str_replace(array('+ ', ' +'), '+', $css);
	    $css = str_replace(array('~ ', ' ~'), '~', $css);
	    $css = str_replace(';}', '}', $css);

	    return $css;

	}

	/**
	 * Get Custom Post Types ID and Title in array
	 */
	public function cpt_array($post_type) {

		$args = array(
			'post_type' => $post_type,
			'posts_per_page'=> -1
		);

		$value = array();								
		$query = new WP_Query( $args );

		if ( $query->have_posts() ) :

			$value = array();

			while ( $query->have_posts() ) :

				$query->the_post();

				$id = get_the_ID();
				$title = get_the_title();

				$value[$title] = $id;
				
			endwhile;

		endif;

		/* Restore original Post Data */
		wp_reset_postdata();

		return $value;

	}

	/**
	 * Get Custom Taxonomies in array
	 */
	public function cpt_tax_array($taxonomy) {

		$terms = get_terms( array(
		    'taxonomy' => $taxonomy,
		    'hide_empty' => true,
		) );
		$value = array();

		foreach ($terms as $key => $term) {

			$title = $term->name;
			$value[$title] = $term->term_id;
		
		}

		return $value;

	}

	/**
	 * Load custom CSS styles in loops etc.
	 */
    public function load_custom_css($css) {

		wp_enqueue_style( 'vc_shortcode-custom', plugin_dir_url(__DIR__) . 'assets/css/vc-custom.css' );
		wp_add_inline_style( 'vc_shortcode-custom', $css );

	}

	/**
	 * Get string in between.
	 */
	public function get_string_between($start, $end, $string) {

	    $string = ' ' . $string;
	    $ini = strpos($string, $start);
	    if ($ini == 0) return '';
	    $ini += strlen($start);
	    $len = strpos($string, $end, $ini) - $ini;
	    return substr($string, $ini, $len);

	}

	/**
	 * Replace string between.
	 */
	public function str_replace_between($str_start, $str_end, $replace, $string) {

		$pos = strpos($string, $str_start);
	    $start = $pos === false ? 0 : $pos + strlen($str_start);

	    $pos = strpos($string, $str_end, $start);
	    $end = $pos === false ? strlen($string) : $pos;

	    return substr_replace($string, $replace, $start, $end - $start);
	    
	}

	/**
	 * Pipes to strong and asterisk to br tags
	 */
	public function str_to_tags($string) {
		
		$string = preg_replace("/\|/", '<strong>', $string, 1);
		$string = preg_replace("/\|/", '</strong>', $string, 1);
		$string = str_replace("*", '<br>', $string);

		return $string;

	}

}
global $xe_core;
$xe_core = new Xe_Core_Functions();