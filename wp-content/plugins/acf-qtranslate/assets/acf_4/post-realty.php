<?php
add_action('init', 'register_post_realty');
function register_post_realty() {
    $labels = array(
        'name' => __('Недвижимость', 'imperia'),
        'singular_name' => __('Обьект', 'imperia'),
        'add_new' => __('Добавить обьект', 'imperia'),
        'add_new_item' => __('Добавить новый обьект', 'imperia'),
        'edit_item' => __('Редактировать обьект', 'imperia'),
        'new_item' => __('Новый обьект', 'imperia'),
        'view_item' => __('Посмотреть обьект', 'imperia'),
        'search_items' => __('Найти обьект', 'imperia'),
        'not_found' =>  __('Обьектов не найдено', 'imperia'),
        'not_found_in_trash' => __('В корзине обьектов не найдено', 'imperia'),
        'parent_item_colon' => '',
        'menu_name' => __('Недвижимость', 'imperia')

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
            'slug' => 'realty',
            'with_front' => true
        ),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'supports'              => array('title','editor','thumbnail'),
        'taxonomies'            => array(),
    );


    register_post_type('post-realty', $args );
}






// Admin filters
require_once get_template_directory().'/includes/knopix/AdminFilters.php';
$adminFilters = new \knopix\AdminFilters('post-realty');

// Filter by operation
$values = array(
    '' => __('Операция', 'imperia'),
    'rent' => __('Аренда', 'imperia'),
    'sell' => __('Купить', 'imperia'),
);
$adminFilters->addSelect('operation', $values);

// Filter by type
$values = array(
    '' => __('Тип', 'imperia'),
    'apartment' => __('Квартира', 'imperia'),
    'commerce' => __('Коммерция', 'imperia'),
    'house' => __('Дом', 'imperia'),
    'territory' => __('Земельный участок', 'imperia'),
);
$adminFilters->addSelect('type', $values);

// Filter by current user
$adminFilters->addCurrentUser(__('Только мои обьекты: ', 'imperia'));

// Filter by top offer
$adminFilters->addCheckbox('top_offer', __('Только топ предложения: ', 'imperia'));

// Filter by rooms
$adminFilters->addBetweenNumeric('room_count', __('Количество комнат: ', 'imperia'), 'от', 'до', 1);

// Filter by area
$adminFilters->addBetweenNumeric('area', __('Площадь: ', 'imperia'), 'от', 'до', 2);

// Filter by price
$adminFilters->addBetweenNumeric('floor', __('Этаж: ', 'imperia'), 'от', 'до', 2);

// Filter by builder
$adminFilters->addTaxonomySelect('builder');



// Photo column
$adminFilters->addColumnImage('photos', __('Фото', 'imperia'), 'cb');


// Operation column
$values = array(
    'rent' => __('Аренда', 'imperia'),
    'sell' => __('Купить', 'imperia'),
);
$adminFilters->addColumn('operation', __('Операция', 'imperia'), 'title', $values);

// Type column
$values = array(
    'apartment' => __('Квартира', 'imperia'),
    'commerce' => __('Коммерция', 'imperia'),
    'house' => __('Дом', 'imperia'),
    'territory' => __('Земельный участок', 'imperia'),
);
$adminFilters->addColumn('type', __('Тип', 'imperia'), 'operation', $values);

// Top offer column
$values = array(
    '0' => '',
    '1' => __('Топ предложение', 'imperia'),
);
$adminFilters->addColumn('top_offer', __('Топ предложение', 'imperia'), 'type', $values);