<?php
namespace Xata;

class Search {

    private $data;

    function __construct() {
        $this->data = $_GET;
    }


    // Retrieve the regions in select html
    public function getRegionsSelect() {
        $args = array(
            'show_option_all'    => __('Все районы', 'imperia'),
            'show_option_none'   => '',
            'option_none_value'  => '-1',
            'orderby'            => 'name',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => '',
            'echo'               => 0,
            'selected'           => $this->data['region_id'],
            'hierarchical'       => 1,
            'name'               => 'region_id',
            'id'                 => '',
            'class'              => 's-select3',
            'depth'              => 0,
            'tab_index'          => 0,
            'taxonomy'           => 'region',
            'hide_if_empty'      => false,
            'value_field'	     => 'term_id',
        );
        return wp_dropdown_categories($args);

    }





    public function getOperation() {
        return ( $this->_validate($this->data['operation']) )? $this->data['operation'] : FALSE;
    }

    public function getType() {
        return ( $this->_validate($this->data['type']) )? $this->data['type'] : FALSE;
    }

    public function getRegion() {
        return ( $this->_validate($this->data['region_id']) )? $this->data['region_id'] : FALSE;
    }

    public function getPostId() {
        return ( $this->_validate($this->data['post_id']) )? $this->data['post_id'] : FALSE;
    }

    public function getPhone() {
        return ( $this->_validate($this->data['phone_number']) )? $this->data['phone_number'] : FALSE;
    }

    public function getPhone2() {
        return ( $this->_validate($this->data['phone_number_2']) )? $this->data['phone_number_2'] : FALSE;
    }

    public function getPhone3() {
        return ( $this->_validate($this->data['phone_number_3']) )? $this->data['phone_number_3'] : FALSE;
    }

    public function getPhoneOwner1() {
        return ( $this->_validate($this->data['phone_number_owner_1']) )? $this->data['phone_number_owner_1'] : FALSE;
    }

    public function getPhoneOwner2() {
        return ( $this->_validate($this->data['phone_number_owner_2']) )? $this->data['phone_number_owner_2'] : FALSE;
    }

    public function getPhoneOwner3() {
        return ( $this->_validate($this->data['phone_number_owner_3']) )? $this->data['phone_number_owner_3'] : FALSE;
    }

    public function getAreaFrom() {
        return ( $this->_validate($this->data['area_from'], array('positive')) )? $this->data['area_from'] : $this->getFieldLimit('area', 'min');
    }

    public function getAreaTo() {
        return ( $this->_validate($this->data['area_to'], array('positive')) )? $this->data['area_to'] : $this->getFieldLimit('area', 'max');
    }

    public function getFloorFrom() {
        return ( $this->_validate($this->data['floor_from']) )? $this->data['floor_from'] : $this->getFieldLimit('floor', 'min');
    }

    public function getFloorTo() {
        return ( $this->_validate($this->data['floor_to']) )? $this->data['floor_to'] : $this->getFieldLimit('floor', 'max');
    }

    public function getPriceFrom() {
        return ( $this->_validate($this->data['price_from'], array('positive')) )? $this->data['price_from'] : $this->getCurrencyFieldLimit('price', 'min');
    }

    public function getPriceTo() {
        return ( $this->_validate($this->data['price_to'], array('positive')) )? $this->data['price_to'] : $this->getCurrencyFieldLimit('price', 'max');
    }

    public function getRoomsFrom() {
        return ( $this->_validate($this->data['rooms_from'], array('positive')) )? $this->data['rooms_from'] : $this->getFieldLimit('room_count', 'min');
    }

    public function getRoomsTo() {
        return ( $this->_validate($this->data['rooms_to'], array('positive')) )? $this->data['rooms_to'] : $this->getFieldLimit('room_count', 'max');
    }

    public function getBuilding() {
        return ( isset($this->data['building']) )? $this->data['building'] : array();
    }

    public function getSort() {
        return ( isset($this->data['sort']) )? $this->data['sort'] : FALSE;
    }



    private function _validate(&$value, $limits = array()) {
        if ( ! isset($value) ) return FALSE;
        if ( strlen(trim($value)) < 1 ) return FALSE;

        if ( in_array('positive', $limits) ) {
            if ( $value < 0 ) return FALSE;
        }

        return TRUE;
    }

    private function getFieldLimit($meta_key = FALSE, $limit = 'max') {
        if ( ! $meta_key ) return FALSE;
        if ( $limit == 'max' && $limit == 'min' ) return FALSE;
        global $wpdb;
        $query = $wpdb->prepare( "SELECT ".$limit."(cast(meta_value as unsigned)) FROM wp_postmeta WHERE meta_key = %s", $meta_key );
        $result = $wpdb->get_var($query);
        return $result;
    }

    private function getCurrencyFieldLimit($meta_key = FALSE, $limit = 'max') {
        if ( ! $meta_key ) return FALSE;
        if ( $limit == 'max' && $limit == 'min' ) return FALSE;
        global $wpdb;
        global $currency;
        $userCurrency = $currency->getUserCurrency();
        $result = 0;
        foreach ( $currency->getCurrencyList() as $item) {
            $query = $wpdb->prepare(" SELECT ".$limit."(cast(meta_value as unsigned)) FROM wp_postmeta WHERE `meta_key` = %s AND `post_id` IN (
	          SELECT `post_id` FROM `wp_postmeta` WHERE `meta_key` = 'currency' AND `meta_value` = %s
            )", $meta_key, $item['code']);
            $value = $wpdb->get_var($query);
            $value = $currency->convert($value, $item['code'], $userCurrency['code']);

            if ( $limit == 'max') {
                if ($value > $result) $result = ceil($value);
            }
            if ($limit == 'min') {
                if ($value < $result || $result == 0) $result = floor($value);
            }
        }
        return $result;
    }



    public function getCombinedMetaQuery() {
        $result = array();
        global $currency;
        foreach ($currency->getCurrencyList() as $item) {
            $result[] = $this->getCurencyMetaQuery($item['code']);
        }
        return $result;
    }



    public function getCurencyMetaQuery($currencyCode) {
        global $currency;
        $userCurrency = $currency->getUserCurrency();

        $result = array(
            'post_type' => 'post-realty',
            'publish' => true,
            'posts_per_page' => 999999999, // need an unlikely integer
        );

        if ( $this->getOperation() ) {
            $result['meta_query'][] = array(
                'key'     => 'operation',
                'value'   => $this->getOperation(),
                'compare' => '='
            );
        }
        if ( $this->getType() ) {
            $result['meta_query'][]  = array(
                'key'     => 'type',
                'value'   => $this->getType(),
                'compare' => '='
            );
        }
        if ( $this->getRegion() ) {
            $result['meta_query'][]  = array(
                'taxonomy' => 'region',
                'field'    => 'tax_id',
                'terms'    => $this->getRegion()
            );
        }

        if ( $this->getPhone() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number',
                'value'   => $this->getPhone(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }
        if ( $this->getPostId() ) {
            $result['meta_query'][] = array(
                'key'     => 'post_id',
                'value'   => $this->getPostId(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }

        if ( $this->getPhone2() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number_2',
                'value'   => $this->getPhone2(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }

        if ( $this->getPhone3() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number_3',
                'value'   => $this->getPhone3(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }
        if ( $this->getPhoneOwner1() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number_owner_1',
                'value'   => $this->getPhone(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }

        if ( $this->getPhoneOwner2() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number_owner_2',
                'value'   => $this->getPhone2(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }

        if ( $this->getPhoneOwner3() ) {
            $result['meta_query'][] = array(
                'key'     => 'phone_number_owner_3',
                'value'   => $this->getPhone3(),
                'type'    => 'numeric',
                'compare' => '='
            );
        }

        $result['meta_query'][]  = array(
            'key'     => 'area',
            'value'   => array( $this->getAreaFrom(), $this->getAreaTo() ),
            'type'    => 'numeric',
            'compare' => 'BETWEEN'
        );
        $result['meta_query'][]  = array(
            'key'     => 'floor',
            'value'   => array( $this->getFloorFrom(), $this->getFloorTo() ),
            'type'    => 'numeric',
            'compare' => 'BETWEEN'
        );
        $result['meta_query'][] = array(
            'key'     => 'room_count',
            'value'   => array( $this->getRoomsFrom(), $this->getRoomsTo() ),
            'type'    => 'numeric',
            'compare' => 'BETWEEN'
        );

        $result['meta_query'][] = array(
            'key'     => 'currency',
            'value'   => $currencyCode,
            'compare' => '='
        );

        $priceFrom = $currency->convert( $this->getPriceFrom(), $userCurrency['code'], $currencyCode );
        $priceTo   = $currency->convert( $this->getPriceTo(), $userCurrency['code'], $currencyCode );
        $result['meta_query'][] = array(
            'key'     => 'price',
            'value'   => array( $priceFrom, $priceTo ),
            'type'    => 'numeric',
            'compare' => 'BETWEEN'
        );

        // Sub query for buildings
        $building = array();
        foreach ( $this->getBuilding() as $item ) {
            $building[] = array(
                'key'     => 'building_type',
                'value'   => $item,
                'compare' => '=',
            );
        }
        if ( count( $building ) > 0 ) {
            $building['relation'] = 'OR';
            $result['meta_query'][] = $building;
        }//

        $result['meta_query']['relation'] = 'AND';

        $result['tax_query'] = $this->getTaxQuery();

        // Add sort
        if ( ! $this->getSort() ) {
            $result['orderby'] = 'date';
            $result['order'] = 'DESC';
        } else {
            $result['meta_key'] = $this->getSort();
            $result['orderby']  = 'meta_value_num';
            $result['order']    = 'ASC';
        }

        return $result;
    }




    public function getTaxQuery() {
        $result = array();

        if ( $this->getRegion() ) {
            $result[] = array(
                'taxonomy' => 'region',
                'field' => 'tax_id',
                'terms' => $this->getRegion()
            );
        }

        if ( count($result) > 0 ) {
            $result['relation'] = 'AND';
            return $result;
        } else {
            return FALSE;
        }
    }





    public function getBreadcrumbs() {
        $result = array();

        $separator = '?';
        $href = 'realty';

        if ( $this->getOperation() == 'sell' ) {
            $href .= $separator.'operation=sell';
            $separator = '&';
            $result[] = array(
                'name' => __('Купить', 'imperia'),
                'href' => home_url($href),
            );
        } else if ( $this->getOperation() == 'rent' ) {
            $href .= $separator.'operation=rent';
            $separator = '&';
            $result[] = array(
                'name' => __('Аренда', 'imperia'),
                'href' => home_url($href),
            );
        }

        if ( $this->getType() == 'apartment' ) {
            $href .= $separator.'type=apartment';
            $separator = '&';
            $result[] = array(
                'name' => __('Квартиры', 'imperia'),
                'href' => home_url($href),
            );
        } else if ( $this->getType() == 'commerce' ) {
            $href .= $separator.'type=commerce';
            $separator = '&';
            $result[] = array(
                'name' => __('Коммерция', 'imperia'),
                'href' => home_url($href),
            );
        }

        if ( $this->getRegion() ) {
            $href .= $separator.'region_id='.$this->data['region_id'];
            $separator = '&';
            $result[] = array(
                'name' => get_term( $this->data['region_id'], 'region' )->name,
                'href' => home_url($href),
            );
        }

        return $result;

    }



}