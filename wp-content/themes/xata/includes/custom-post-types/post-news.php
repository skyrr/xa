<?php
add_action('init', 'register_post_news');
function register_post_news() {
    $labels = array(
        'name' => __('Новости', 'imperia'),
        'singular_name' => __('Новость', 'imperia'),
        'add_new' => __('Добавить новость', 'imperia'),
        'add_new_item' => __('Добавить новую публикацию', 'imperia'),
        'edit_item' => __('Редактировать новость', 'imperia'),
        'new_item' => __('Новая публикация', 'imperia'),
        'view_item' => __('Посмотреть новость', 'imperia'),
        'search_items' => __('Найти новость', 'imperia'),
        'not_found' =>  __('Новостей не найдено', 'imperia'),
        'not_found_in_trash' => __('В корзине новостей не найдено', 'imperia'),
        'parent_item_colon' => '',
        'menu_name' => __('Новости', 'imperia')

    );
    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'query_var'             => true,
        'rewrite'               => array(
            'slug' => 'news',
            'with_front' => true
        ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'supports'              => array('title','editor','thumbnail'),
        'taxonomies'            => array(),
    );


    register_post_type('post-news', $args );
}