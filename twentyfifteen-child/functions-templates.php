<?php

// Hook into the 'init' action
add_action( 'init', 'post_type_template' );

// Register Template Post Type
function post_type_template() {
    $labels = array(
        'name'                => __( 'Templates' ),
        'singular_name'       => __( 'Template' ),
        'plural_name'         => __( 'Templates' ),
        'menu_name'           => __( 'Templates' ),
        'parent_item_colon'   => __( 'Template:' ),
        'all_items'           => __( 'All templates' ),
        'view_item'           => __( 'View template' ),
        'add_new_item'        => __( 'Add New template' ),
        'add_new'             => __( 'New template' ),
        'edit_item'           => __( 'Edit template' ),
        'update_item'         => __( 'Update template' ),
        'search_items'        => __( 'Search templates' ),
        'not_found'           => __( 'No template found' ),
        'not_found_in_trash'  => __( 'No template found in Trash' ),
    );

    $args = array(
        'labels'              => $labels,
        'label'               => __( 'Templates' ),
        'singular_label'      => __('Template'),
        'plural_label'        => __('Templates'),
        'description'         => __( 'to fill in meta-boxes and editor defaults' ),
        'supports'            => array( 'title', 'editor', 'thumbnail' ),
        'taxonomies'          => array('template_cat', 'post_tag'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        '_builtin'            => false,
        'capability_type'     => 'page',
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 15,
        'menu_icon'           => '',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'rewrite'             => false,
    );
    //'menu_icon'           => get_bloginfo('template_directory').'/functions/img/icon.png'
    if (function_exists('register_post_type')) {
      register_post_type( 'template', $args );
    }
}
