<?php

namespace knopix;


class AdminFilters
{
    function __construct($postType = 'post')
    {
        $this->postType = $postType;
    }

    private $postType;


    /**
     * @param string $taxonomy
     * @param int $priority
     *
     * @return bool
     */
    public function addTaxonomySelect($taxonomy, $priority = 20) {
        if ( ! $this->checkPostType() ) return FALSE;
        if ( ! isset($taxonomy) ) return FALSE;
        add_action('init', function() use ($taxonomy) {
            // Get values
            $taxonomyObj = get_taxonomy($taxonomy);
            $values = array( '' => $taxonomyObj->labels->singular_name );
            $terms = get_terms( array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => false,
            ) );
            foreach ($terms as $term) {
                $values[$term->slug] = $term->name;
            }
            if ( count($values) <= 1 ) return FALSE;

            // Add select
            add_action('restrict_manage_posts', function() use ($taxonomy, $values) {
                $selectedVal = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : FALSE;
                $options = '';
                foreach ($values as $value => $text) {
                    $selected = ($value == $selectedVal) ? ' selected="selected"' : '';
                    $options .= '<option value="' . $value . '"' . $selected . '>' . $text . '</option>';
                }
                echo '<select name="'. $taxonomy .'">'.$options.'</select>';
            });
        }, 20); // It`s necessary to init after taxonomy init
    }




    public function addBetweenNumeric($meta_key, $label = '', $placeholderFrom = '', $placeholderTo = '', $size = 3) {
        if ( ! $this->checkPostType() ) return FALSE;
        if ( ! isset($meta_key) ) return FALSE;

        add_action('restrict_manage_posts', function() use ($meta_key, $label, $placeholderFrom, $placeholderTo, $size) {
            $valueFrom = ( ! empty($_GET[$meta_key][0]) ) ? $_GET[$meta_key][0] : $this->getFieldLimit($meta_key, 'min');
            $valueTo = ( ! empty($_GET[$meta_key][1]) ) ? $_GET[$meta_key][1] : $this->getFieldLimit($meta_key, 'max');
            echo '<span style="white-space: nowrap"><label style="margin-right: 10px;">'.$label.'
                <input type="text" placeholder="'.$placeholderFrom.'" size="'.$size.'" name="'. $meta_key .'[]" value="'.$valueFrom.'"/>
                -
                <input type="text" placeholder="'.$placeholderTo.'" size="'.$size.'" name="'. $meta_key .'[]" value="'.$valueTo.'"/>
            </label></span>';
        });

        $this->addFilter($meta_key, 'BETWEEN', 'NUMERIC');
    }



    /**
     * @string $slug
     * @array(value => text) $values
     * @return bool
     */
    public function addSelect($meta_key, $values) {
        if ( ! $this->checkPostType() ) return FALSE;
        if ( ! isset($meta_key) ) return FALSE;
        if ( ! is_array($values) ) return FALSE;

        add_action('restrict_manage_posts', function() use ($meta_key, $values) {
            $selectedVal = isset($_GET[$meta_key]) ? $_GET[$meta_key] : FALSE;

            $options = '';
            foreach ($values as $value => $text) {
                $selected = ($value == $selectedVal) ? ' selected="selected"' : '';
                $options .= '<option value="' . $value . '"' . $selected . '>' . $text . '</option>';
            }

            echo '<select name="'. $meta_key .'">'.$options.'</select>';
        });

        $this->addFilter($meta_key);
    }


    /**
     * @string $slug
     * @string $text
     * @return bool
     */
    public function addCheckbox($meta_key, $text) {
        if ( ! $this->checkPostType() ) return FALSE;
        if ( ! isset($meta_key) ) return FALSE;

        add_action('restrict_manage_posts', function() use ($meta_key, $text) {
            $checked = ( isset($_GET[$meta_key]) ) ? ' checked=checked' : '';
            echo '<label style="margin-right: 10px;">'.$text.'<input type="checkbox" name="'. $meta_key .'" value="1"'.$checked.'/></label>';
        });

        $this->addFilter($meta_key);
    }


    /**
     * @param $text
     * @return bool
     */
    public function addCurrentUser($text) {
        if ( ! $this->checkPostType() ) return FALSE;

        add_action('restrict_manage_posts', function() use ($text) {
            $currentUserId = get_current_user_id();
            $checked = ( isset($_GET['author']) && $_GET['author'] == $currentUserId ) ? ' checked=checked' : '';
            echo '<label style="margin-right: 10px;">'.$text.'<input type="checkbox" name="author" value="'. $currentUserId .'"'.$checked.'/></label>';
        });
    }




    private function checkPostType() {
        $pagePostType = ( isset($_GET['post_type']) ) ? $_GET['post_type'] : 'post';
        return ( $this->postType == $pagePostType ) ? TRUE : FALSE;
    }


    private function getFieldLimit($meta_key = FALSE, $limit = 'max') {
        if ( ! $meta_key ) return FALSE;
        if ( $limit == 'max' && $limit == 'min' ) return FALSE;
        global $wpdb;
        $query = $wpdb->prepare( "SELECT ".$limit."(cast(meta_value as unsigned)) FROM wp_postmeta WHERE meta_key = %s", $meta_key );
        $result = $wpdb->get_var($query);
        return $result;
    }


    private function addFilter($meta_key, $compare = '=', $type = 'CHAR') {
        global $pagenow;
        if ( ! is_admin() && $pagenow != 'edit.php') return FALSE;
        if ( ! isset($_GET[$meta_key]) || $_GET[$meta_key] == '') return FALSE;

        add_filter('parse_query', function($query) use ($meta_key, $compare, $type) {
            $query->query_vars['meta_query'][] = array(
                'key'     => $meta_key,
                'value'   => $_GET[$meta_key],
                'compare' => $compare,
                'type'    => $type
            );
        });
    }








    // Colunms
    public function addColumn($meta_key, $text, $after = FALSE, $values = FALSE) {
        $this->registerColumn($meta_key, $text, $after);

        add_action('manage_'.$this->postType.'_posts_custom_column', function($column, $post_id) use ($meta_key, $values) {
            if ( $column == $meta_key ) {
                $meta_value = get_post_meta($post_id, $meta_key, true);
                echo ( isset($values[$meta_value]) ) ? $values[$meta_value] : $meta_value;
            }
        }, 10, 2);
    }


    public function addColumnSortable($meta_key, $text, $after = FALSE, $values = FALSE) {
        $this->addColumn($meta_key, $text, $after, $values);

        add_filter( 'manage_edit-'.$this->postType.'_sortable_columns', function($columns) use ($meta_key) {
            $columns[$meta_key] = $meta_key;
            return $columns;
        });

        add_action( 'pre_get_posts', function( $query ) use ($meta_key) {
            if( ! is_admin() ) return;

            $orderby = $query->get('orderby');

            if ($orderby == $meta_key) {
                $query->set('meta_key', $meta_key);
                $query->set('orderby', 'meta_value_num');
            }
        });
    }


    public function addColumnImage($meta_key, $text, $after = FALSE) {
        $this->registerColumn($meta_key, $text, $after);

        add_action('manage_'.$this->postType.'_posts_custom_column', function($column, $post_id) use ($meta_key) {
            if ( $column == $meta_key ) {
                $meta_value = get_post_meta($post_id, $meta_key, true);
                if ( is_array($meta_value) ) {
                    $meta_value = array_shift($meta_value);
                }
                $thumbnail = wp_get_attachment_image_src($meta_value, 'thumbnail');
                echo '<img style="max-width: 100%; max-height: 100px;" src="' . $thumbnail[0] . '" />';
            }
        }, 10, 2);
    }


    private function registerColumn($meta_key, $text, $after = FALSE) {
        if ( ! $this->checkPostType() ) return FALSE;
        if ( ! isset($meta_key) || ! isset($text) ) return FALSE;
        add_filter('manage_'.$this->postType.'_posts_columns', function($columns) use ($meta_key, $text, $after) {
            $isInserted = FALSE;
            $newColumns = array();
            foreach ($columns as $key => $value) {
                $newColumns[$key] = $value;
                if ( $key == $after ) {
                    $newColumns[$meta_key] = $text;
                    $isInserted = TRUE;
                }
            }
            if ( ! $isInserted ) $newColumns[$meta_key] = $text;
            return $newColumns;
        });
    }



}