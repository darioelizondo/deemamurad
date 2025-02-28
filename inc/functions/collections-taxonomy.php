<?php

    /**
     * Function: Collection taxonomy
     * 
     * @package Darío Elizondo
     * 
     */

    add_action('init', 'deemamurad_taxonomy_collections');

    function deemamurad_taxonomy_collections() {
        $labels = array(
            'name'              => _x('Collections', 'taxonomy general name'),
            'singular_name'     => _x('Collection', 'taxonomy singular name'),
            'search_items'      => __('Search Collections'),
            'all_items'         => __('All Collections'),
            'parent_item'       => __('Parent Collection'),
            'parent_item_colon' => __('Parent Collection:'),
            'edit_item'         => __('Edit Collection'),
            'update_item'       => __('Update Collection'),
            'add_new_item'      => __('Add New Collection'),
            'new_item_name'     => __('New Collection Name'),
            'menu_name'         => __('Collections'),
        );

        $args = array(
            'hierarchical'      => true, // True so that it behaves like a category (with hierarchy)
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'collection'),
        );

        register_taxonomy( 'collections', array('product'), $args );
    }

    // Remove the 'Collections' column from the list of products in the dashboard
    add_filter( 'manage_edit-product_columns', 'deemamurad_remove_collections_column', 10, 1 );
    function deemamurad_remove_collections_column( $columns ) {
        unset( $columns['taxonomy-collections'] );
        return $columns;
    }