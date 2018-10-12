<?php 
/**
 * Class for adding custom post types.
 *
 * @package Xe Core
 */

class Xe_Core_CustomPostTypes {

    protected $xe_options,
    $portfolio_slug,
    $events_slug;

    function __construct() {

        $this->xe_options = get_option('xe_options');

        $this->portfolio_slug = ( isset($this->xe_options['portfolio_list_slug']) && !empty($this->xe_options['portfolio_list_slug']) ) ? $this->xe_options['portfolio_list_slug'] : 'portfolio';
        $this->events_slug = ( isset($this->xe_options['events_list_slug']) && !empty($this->xe_options['events_list_slug']) ) ? $this->xe_options['events_list_slug'] : 'events';

        add_action( 'init', array($this, 'custom_post_types') );
        register_activation_hook( __FILE__, array($this, 'rewrite_flush') );

    }

    protected function portfolio() {

        $labels = array(
            'name'               => 'Portfolio',
            'singular_name'      => 'Portfolio',
            'menu_name'          => 'Portfolio',
            'name_admin_bar'     => 'Portfolio',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Portfolio',
            'new_item'           => 'New Portfolio',
            'edit_item'          => 'Edit Portfolio',
            'view_item'          => 'View Portfolio',
            'all_items'          => 'All Portfolios',
            'search_items'       => 'Search Portfolios',
            'parent_item_colon'  => 'Parent Portfolios:',
            'not_found'          => 'No Portfolios found.',
            'not_found_in_trash' => 'No Portfolios found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-portfolio',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => $this->portfolio_slug ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array( 'title', 'editor', 'thumbnail', 'comments', 'revisions' ),
        );
        return register_post_type( 'xe-portfolio', $args );

    }

    protected function events() {

        $labels = array(
            'name'               => 'Events',
            'singular_name'      => 'Event',
            'menu_name'          => 'Events',
            'name_admin_bar'     => 'Event',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Event',
            'new_item'           => 'New Event',
            'edit_item'          => 'Edit Event',
            'view_item'          => 'View Event',
            'all_items'          => 'All Events',
            'search_items'       => 'Search Events',
            'parent_item_colon'  => 'Parent Events:',
            'not_found'          => 'No Events found.',
            'not_found_in_trash' => 'No Events found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-backup',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => $this->events_slug ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'supports'           => array( 'title', 'thumbnail', 'comments', 'revisions' ),
        );
        return register_post_type( 'xe-events', $args );

    }

    protected function testimonials() {

        $labels = array(
            'name'               => 'Testimonials',
            'singular_name'      => 'Testimonial',
            'menu_name'          => 'Testimonials',
            'name_admin_bar'     => 'Testimonial',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Testimonial',
            'new_item'           => 'New Testimonial',
            'edit_item'          => 'Edit Testimonial',
            'view_item'          => 'View Testimonial',
            'all_items'          => 'All Testimonials',
            'search_items'       => 'Search Testimonials',
            'parent_item_colon'  => 'Parent Testimonials:',
            'not_found'          => 'No Testimonials found.',
            'not_found_in_trash' => 'No Testimonials found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-editor-quote',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-testimonials' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title', 'thumbnail' )
        );
        return register_post_type( 'xe-testimonials', $args );

    }

    protected function pricing_tables() {

        $labels = array(
            'name'               => 'Pricing Tables',
            'singular_name'      => 'Pricing Table',
            'menu_name'          => 'Pricing Tables',
            'name_admin_bar'     => 'Pricing Table',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Pricing Table',
            'new_item'           => 'New Pricing Table',
            'edit_item'          => 'Edit Pricing Table',
            'view_item'          => 'View Pricing Table',
            'all_items'          => 'All Pricing Tables',
            'search_items'       => 'Search Pricing Tables',
            'parent_item_colon'  => 'Parent Pricing Tables:',
            'not_found'          => 'No Pricing Tables found.',
            'not_found_in_trash' => 'No Pricing Tables found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-tag',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-pricing-tables' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title' )
        );
        return register_post_type( 'xe-pricing-tables', $args );

    }

    protected function members() {

        $labels = array(
            'name'               => 'Members',
            'singular_name'      => 'Member',
            'menu_name'          => 'Members',
            'name_admin_bar'     => 'Member',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Member',
            'new_item'           => 'New Member',
            'edit_item'          => 'Edit Member',
            'view_item'          => 'View Member',
            'all_items'          => 'All Members',
            'search_items'       => 'Search Members',
            'parent_item_colon'  => 'Parent Members:',
            'not_found'          => 'No Members found.',
            'not_found_in_trash' => 'No Members found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-id',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-members' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title', 'thumbnail' )
        );
        return register_post_type( 'xe-members', $args );

    }

    protected function faqs() {

        $labels = array(
            'name'               => 'FAQs',
            'singular_name'      => 'FAQ',
            'menu_name'          => 'FAQs',
            'name_admin_bar'     => 'FAQ',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New FAQ',
            'new_item'           => 'New FAQ',
            'edit_item'          => 'Edit FAQ',
            'view_item'          => 'View FAQ',
            'all_items'          => 'All FAQs',
            'search_items'       => 'Search FAQs',
            'parent_item_colon'  => 'Parent FAQs:',
            'not_found'          => 'No FAQs found.',
            'not_found_in_trash' => 'No FAQs found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-editor-help',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-faq' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title' )
        );
        return register_post_type( 'xe-faq', $args );

    }

    protected function tabs() {

        $labels = array(
            'name'               => 'Tabs',
            'singular_name'      => 'Tab',
            'menu_name'          => 'Tabs',
            'name_admin_bar'     => 'Tab',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Tab',
            'new_item'           => 'New Tab',
            'edit_item'          => 'Edit Tab',
            'view_item'          => 'View Tab',
            'all_items'          => 'All Tabs',
            'search_items'       => 'Search Tabs',
            'parent_item_colon'  => 'Parent Tabs:',
            'not_found'          => 'No Tabs found.',
            'not_found_in_trash' => 'No Tabs found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-category',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-tabs' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title', 'editor' )
        );
        return register_post_type( 'xe-tabs', $args );

    }

    protected function accordions() {

        $labels = array(
            'name'               => 'Accordions',
            'singular_name'      => 'Accordion',
            'menu_name'          => 'Accordions',
            'name_admin_bar'     => 'Accordion',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Accordion',
            'new_item'           => 'New Accordion',
            'edit_item'          => 'Edit Accordion',
            'view_item'          => 'View Accordion',
            'all_items'          => 'All Accordions',
            'search_items'       => 'Search Accordions',
            'parent_item_colon'  => 'Parent Accordions:',
            'not_found'          => 'No Accordions found.',
            'not_found_in_trash' => 'No Accordions found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-editor-justify',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-accordions' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'exclude_from_search' => true,
            'supports'           => array( 'title' )
        );
        return register_post_type( 'xe-accordions', $args );

    }

    protected function mega_menus() {

        $labels = array(
            'name'               => 'Mega Menu',
            'singular_name'      => 'Mega Menu',
            'menu_name'          => 'Mega Menus',
            'name_admin_bar'     => 'Mega Menu',
            'add_new'            => 'Add New',
            'add_new_item'       => 'Add New Mega Menu',
            'new_item'           => 'New Mega Menu',
            'edit_item'          => 'Edit Mega Menu',
            'view_item'          => 'View Mega Menu',
            'all_items'          => 'All Mega Menus', 
            'search_items'       => 'Search Mega Menus',
            'parent_item_colon'  => 'Parent Mega Menus:',
            'not_found'          => 'No Mega Menus found.',
            'not_found_in_trash' => 'No Mega Menus found in Trash.',
        );
        
        $args = array(
            'labels'             => $labels,
            'public'             => false,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'menu_icon'          => 'dashicons-welcome-widgets-menus',
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'xe-mega-menus' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            // 'show_in_menu'       => 'themes.php', // to display in submenu
            // 'menu_position'      => 5,
            'supports'           => array( 'title', 'editor', 'revisions' ),
        );
        return register_post_type( 'xe-mega-menus', $args );

    }

    public function custom_post_types() {

        if ( class_exists('acf') ) {

            $this->portfolio();
            $this->events();

        }

        if ( class_exists('acf') && class_exists('Vc_Manager') ) {  
            
            $this->testimonials();
            $this->pricing_tables();  
            $this->members();
            $this->faqs();
            $this->tabs();
            $this->accordions();
            $this->mega_menus();

        }

    }

    public function rewrite_flush() {

        $this->custom_post_types();
        flush_rewrite_rules();

    }

}
new Xe_Core_CustomPostTypes();