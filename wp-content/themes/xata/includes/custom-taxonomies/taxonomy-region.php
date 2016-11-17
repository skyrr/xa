<?php
// Add art-post taxonomies
add_action( 'init', 'register_region_taxonomy');
function register_region_taxonomy() {
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name'              => __('Районы', 'imperia'),
        'singular_name'     => __('Район', 'imperia'),
        'search_items'      => __('Найти район', 'imperia'),
        'all_items'         => __('Все районы', 'imperia'),
        'parent_item'       => __('Родительский район', 'imperia'),
        'parent_item_colon' => __('Родительский район:', 'imperia'),
        'edit_item'         => __('Редактировать район', 'imperia'),
        'update_item'       => __('Обновить район', 'imperia'),
        'add_new_item'      => __('Добавить новый район', 'imperia'),
        'new_item_name'     => __('Новое имя района', 'imperia'),
        'menu_name'         => __('Районы', 'imperia'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'region' ),
    );

    register_taxonomy( 'region', 'post-realty', $args );

    // Add new taxonomy, NOT hierarchical (like tags)
    /*$labels = array(
        'name'                       => _x( 'Artists', 'taxonomy general name' ),
        'singular_name'              => _x( 'Artist', 'taxonomy singular name' ),
        'search_items'               => __( 'Search Artists' ),
        'popular_items'              => __( 'Popular Artists' ),
        'all_items'                  => __( 'All Artists' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Edit Artist' ),
        'update_item'                => __( 'Update Artist' ),
        'add_new_item'               => __( 'Add New Artist' ),
        'new_item_name'              => __( 'New Artist Name' ),
        'separate_items_with_commas' => __( 'Separate artist with commas' ),
        'add_or_remove_items'        => __( 'Add or remove artists' ),
        'choose_from_most_used'      => __( 'Choose from the most used artists' ),
        'not_found'                  => __( 'No artists found.' ),
        'menu_name'                  => __( 'Artists' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'artist' ),
    );

    register_taxonomy( 'artist', array( 'post' ), $args );*/
}