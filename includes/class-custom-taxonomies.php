<?php 
/**
 * Class for adding custom taxonomies.
 *
 * @package Xe Core
 */

class Xe_Core_CustomTaxonomies {

	protected $xe_options,
    $portfolio_category_slug,
    $event_category_slug;

    function __construct() {

    	$this->xe_options = get_option('xe_options');

    	$this->portfolio_category_slug = ( isset($this->xe_options['portfolio_list_category_slug']) && !empty($this->xe_options['portfolio_list_category_slug']) ) ? $this->xe_options['portfolio_list_category_slug'] : 'portfolio-category';
    	$this->events_category_slug = ( isset($this->xe_options['events_list_category_slug']) && !empty($this->xe_options['events_list_category_slug']) ) ? $this->xe_options['events_list_category_slug'] : 'events-category';

    	add_action( 'init', array($this, 'register_taxonomies'), 0 );

    }

    protected function portfolio_categories() {
	
	    $labels = array(
	        'name'              => 'Categories',
	        'singular_name'     => 'Category',
	        'search_items'      => 'Search Categories',
	        'all_items'         => 'All Categories',
	        'parent_item'       => 'Parent Category',
	        'parent_item_colon' => 'Parent Category:',
	        'edit_item'         => 'Edit Category',
	        'update_item'       => 'Update Category',
	        'add_new_item'      => 'Add New Category',
	        'new_item_name'     => 'New Category Name',
	        'menu_name'         => 'Categories',
	    );

	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => $this->portfolio_category_slug ),
	    );

	    return $args;

	}

	protected function event_categories() {
	
	    $labels = array(
	        'name'              => 'Categories',
	        'singular_name'     => 'Category',
	        'search_items'      => 'Search Categories',
	        'all_items'         => 'All Categories',
	        'parent_item'       => 'Parent Category',
	        'parent_item_colon' => 'Parent Category:',
	        'edit_item'         => 'Edit Category',
	        'update_item'       => 'Update Category',
	        'add_new_item'      => 'Add New Category',
	        'new_item_name'     => 'New Category Name',
	        'menu_name'         => 'Categories',
	    );

	    $args = array(
	        'hierarchical'      => true,
	        'labels'            => $labels,
	        'show_ui'           => true,
	        'show_admin_column' => true,
	        'query_var'         => true,
	        'rewrite'           => array( 'slug' => $this->events_category_slug ),
	    );

	    return $args;

	}

	public function register_taxonomies() {
 
		register_taxonomy( 'xe-portfolio-categories', array('xe-portfolio'), $this->portfolio_categories() );
		register_taxonomy( 'xe-event-categories', array('xe-events'), $this->event_categories() );

	}

}
new Xe_Core_CustomTaxonomies();