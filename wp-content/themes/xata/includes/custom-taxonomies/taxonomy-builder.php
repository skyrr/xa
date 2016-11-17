<?php
// Add art-post taxonomies
add_action( 'init', function() {
    // Add new taxonomy, NOT hierarchical (like tags)
    $labels = array(
        'name'                       => _x( 'Застройщики', 'taxonomy general name', 'imperia' ),
        'singular_name'              => _x( 'Застройщик', 'taxonomy singular name', 'imperia' ),
        'search_items'               => __( 'Поиск застройщиков', 'imperia' ),
        'popular_items'              => __( 'Популярные застройщики', 'imperia' ),
        'all_items'                  => __( 'Все застройщики', 'imperia' ),
        'parent_item'                => null,
        'parent_item_colon'          => null,
        'edit_item'                  => __( 'Редактировать застройщика', 'imperia' ),
        'update_item'                => __( 'Обновить застройщика', 'imperia' ),
        'add_new_item'               => __( 'Добавить нового застройщика', 'imperia' ),
        'new_item_name'              => __( 'Название новго застройщика', 'imperia' ),
        'separate_items_with_commas' => __( 'Разделяйте застройщиков зяпятыми', 'imperia' ),
        'add_or_remove_items'        => __( 'Добавить или удалить застройщиков', 'imperia' ),
        'choose_from_most_used'      => __( 'Выберите из найболее популярных застройщиков', 'imperia' ),
        'not_found'                  => __( 'Застройщиков не найдено.', 'imperia' ),
        'menu_name'                  => __( 'Застройщики', 'imperia' ),
    );

    $args = array(
        'hierarchical'          => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'builder' ),
    );

    register_taxonomy( 'builder', 'post-realty', $args );
});