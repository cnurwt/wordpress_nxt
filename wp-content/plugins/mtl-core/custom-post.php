<?php
/**
 * Custom Post
 */

function services_register() {
    $labels = array(
        'name' => _x('Services', 'post type general name'),
        'singular_name' => _x('Services Item', 'post type singular name'),
        'add_new' => _x('Add New', 'services item'),
        'add_new_item' => __('Add New Services Item'),
        'edit_item' => __('Edit Services Item'),
        'new_item' => __('New Services Item'),
        'view_item' => __('View Services Item'),
        'search_items' => __('Search Services Items'),
        'not_found' =>  __('Nothing found'),
        'not_found_in_trash' => __('Nothing found in Trash'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'menu_position' => 8,
        'supports' => array('title','editor', 'author','excerpt','thumbnail','comments')
    ); 
    register_post_type( 'services' , $args );
}
add_action('init', 'services_register');

function create_services_taxonomies() {
    $labels = array(
        'name'              => _x( 'Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Categories' ),
        'all_items'         => __( 'All Categories' ),
        'parent_item'       => __( 'Parent Category' ),
        'parent_item_colon' => __( 'Parent Category:' ),
        'edit_item'         => __( 'Edit Category' ),
        'update_item'       => __( 'Update Category' ),
        'add_new_item'      => __( 'Add New Category' ),
        'new_item_name'     => __( 'New Category Name' ),
        'menu_name'         => __( 'Categories' ),
    );

    $args = array(
        'hierarchical'      => true, // Set this to 'false' for non-hierarchical taxonomy (like tags)
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'categories' ),
    );

    register_taxonomy( 'services_categories', array( 'services' ), $args );
}
add_action( 'init', 'create_services_taxonomies', 0 );
