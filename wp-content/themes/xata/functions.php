<?php
// Number of allowed revisions
function revisions_to_keep( $revisions ) {
    return 0;
}
add_filter( 'wp_revisions_to_keep', 'revisions_to_keep' );



// Disable admin bar
show_admin_bar( false );


// Add languages
add_action('after_setup_theme', 'add_languages');
function add_languages() {
    load_theme_textdomain('imperia', get_template_directory() . '/languages');
}


// Add thumbnail support
add_theme_support( 'post-thumbnails' );



// Replace default more sumbol
function new_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


// Change excerpt length (words)
function custom_excerpt_length( $length ) {
    return 25;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );



// Register menus
register_nav_menus( array(
    'header_menu' => 'Header menu',
    'footer_menu' => 'Footer menu',
) );
// Add active class to current active item
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);
function special_nav_class ($classes, $item) {
    if (in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}


// Remove posts menu
function edit_admin_menus() {
    remove_menu_page('edit.php');
}
add_action( 'admin_menu', 'edit_admin_menus' );



// Posts views counter
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}

function imperia_load_scripts_styles()
{
    wp_enqueue_script(
        'owl-carousel',
        get_template_directory_uri() . '/resources/js/owl.carousel.js',
        array('jquery',)
    );
}
add_action('wp_enqueue_scripts', 'imperia_load_scripts_styles');


// Add post-realty
require_once 'includes/custom-post-types/post-realty.php';

// Add post-realty regions
require_once 'includes/custom-taxonomies/taxonomy-region.php';

// Add post-realty builders
require_once 'includes/custom-taxonomies/taxonomy-builder.php';

// Add post-news
require_once 'includes/custom-post-types/post-news.php';

// Add Search class
require_once 'includes/xata/Search.php';

// Add Currency class
require_once 'includes/xata/Currency.php';
global $currency; // available everywhere, prevents objects cloning
$currency = new \Xata\Currency(); // Init here is necessary for correct work (cookies update, admin fields)

// Add wp combine query
require_once 'includes/wp-combine-queries/combined-query.php';


//Hide Defualt Roles
add_filter('editable_roles', function($roles) {
    if (isset($roles['subscriber'])) {
        unset($roles['subscriber']);
    }
    if (isset($roles['contributor'])) {
        unset($roles['contributor']);
    }
    if (isset($roles['author'])) {
        unset($roles['author']);
    }
    /*if (isset($roles['editor'])) {
        unset($roles['editor']);
    }*/
    return $roles;
});

// Check if ACF available
include_once(ABSPATH.'wp-admin/includes/plugin.php');
if ( ! function_exists('is_plugin_active') || ! is_plugin_active('advanced-custom-fields/acf.php') ) {
    add_action('admin_notices', function() {
        $class = 'notice notice-warning';
        $acf_url = get_admin_url(NULL, '/plugin-install.php?tab=plugin-information&plugin=advanced-custom-fields');
        $message = 'Theme <b>xata</b>: <a href="'.$acf_url.'">Advanced Custom Fields</a> plugin is required. Please install and/or activate it.';
        printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
    });
    // return;
}