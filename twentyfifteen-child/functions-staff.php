<?php

// Hook into the 'init' action
add_action( 'init', 'post_type_staff' );

// Register Staff Post Type
function post_type_staff() {
    $labels = array(
        'name'                => __( 'Staff' ),
        'singular_name'       => __( 'Staff' ),
        'menu_name'           => __( 'Staff' ),
        'parent_item_colon'   => __( 'Staff:' ),
        'all_items'           => __( 'All staff' ),
        'view_item'           => __( 'View staff' ),
        'add_new_item'        => __( 'Add New staff' ),
        'add_new'             => __( 'New staff' ),
        'edit_item'           => __( 'Edit staff' ),
        'update_item'         => __( 'Update staff' ),
        'search_items'        => __( 'Search staff' ),
        'not_found'           => __( 'No staff found' ),
        'not_found_in_trash'  => __( 'No staff found in Trash' ),
    );

    $args = array(
        'labels'              => $labels,
        'label'               => __( 'Staff' ),
        'singular_label'      => __('Staff'),
        'description'         => __( 'The guys and Beth' ),
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'          => array('staff_cat', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        '_builtin'            => false,
        'capability_type'     => 'post',
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 10,
        'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => false,
    );
    //'menu_icon'           => get_bloginfo('template_directory').'/functions/img/icon.png'
    if (function_exists('register_post_type')) {
      register_post_type( 'staff', $args );
    }
}

//add_action('init', 'rockable_create_post_types');
//function rockable_create_post_types(){
//$labels = array(
//'name' => __( 'Portfolio' ),
//'singular_name' => __( 'Portfolio' )
//);
//$args = array(
//'labels' => $labels,
//'label' => __('Portfolio'),
//'singular_label' => __('Portfolio'),
//'public' => true,
//'show_ui' => true,
//'_builtin' => false,
//'capability_type' => 'post',
//'hierarchical' => false,
//'rewrite' => false,
//'supports' => array('title','editor','excerpt','revisions','thumbnail'),
//'taxonomies' => array('portfolio_cat', 'post_tag'),
//'menu_icon' => get_bloginfo('template_directory').'/functions/img/icon.png'
//);
//if (function_exists('register_post_type')) {
//register_post_type('portfolio', $args);
//echo "------------------------------------------------registered portfolio";
//}
//}
//add_action('init', 'rockable_taxonomies', 0);
//function rockable_taxonomies(){
//$labels = array(
//'name' => _x('Portfolio Categories', 'taxonomy general name', 'rockable'),
//'singular_name' => _x('Portfolio Category', 'taxonomy singular name', 'rockable'),
//'search_items' => __('Search Portfolio', 'rockable'),
//'all_items' => __('All Portfolio Categories', 'rockable'),
//'parent_item' => __('Parent Portfolio Category', 'rockable'),
//'parent_item_colon' => __('Parent Portfolio Category:', 'rockable'),
//'edit_item' => __('Edit Portfolio Category', 'rockable'),
//'update_item' => __('Update Portfolio Category', 'rockable'),
//'add_new_item' => __('Add New Portfolio Category', 'rockable'),
//'new_item_name' => __('New Portfolio Category Name', 'rockable')
//);

//register_taxonomy('portfolio_cat', array('portfolio'),
//array(
//'hierarchical' => true,
//'labels' => $labels,
//'show_ui' => true,
//'query_var' => true,
//'rewrite' => array('slug' => 'portfolio_categories')
//));
//}

//// Register Taxonomy: Event
//function event_init() {
  //register_taxonomy(
    //'event',
    //'post',
    //array(
      //'hierarchical' => true,
      //'label' => __( 'Event' ),
      //'rewrite' => array( 'slug' => 'event' ),
      //'capabilities' => array (
        //'manage_terms' => 'manage_options', //by default only admin
        //'edit_terms' => 'manage_options',
        //'delete_terms' => 'manage_options',
        //'assign_terms' => 'manage_options',
        //// 'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
      //)
    //)
  //);
//}
//add_action( 'init', 'event_init' );
