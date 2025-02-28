<?php

    /**
     * Function: Filters taxonomy
     * 
     * @package Darío Elizondo
     * 
     */

    add_action('init', 'deemamurad_taxonomy_filters');

    function deemamurad_taxonomy_filters() {
        $labels = array(
            'name'              => _x('Filters', 'taxonomy general name'),
            'singular_name'     => _x('Filter', 'taxonomy singular name'),
            'search_items'      => __('Search Filters'),
            'all_items'         => __('All Filters'),
            'parent_item'       => __('Parent Filter'),
            'parent_item_colon' => __('Parent Filter:'),
            'edit_item'         => __('Edit Filter'),
            'update_item'       => __('Update Filter'),
            'add_new_item'      => __('Add New Filter'),
            'new_item_name'     => __('New Filter Name'),
            'menu_name'         => __('Filters'),
        );
    
        $args = array(
            'hierarchical'      => true, // True so that it behaves like a category (with hierarchy)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'filter'),
        );
    
        register_taxonomy( 'filters', array('product'), $args );
    }

    // Remove the 'Filters' column from the list of products in the dashboard
    add_filter( 'manage_edit-product_columns', 'deemamurad_remove_filters_column', 10, 1 );
    function deemamurad_remove_filters_column( $columns ) {
        unset( $columns['taxonomy-filters'] );
        return $columns;
    }