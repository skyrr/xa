<?php
namespace Xata;

/**
 * Class Currency
 *
 * Its necessary to create class object in functions.php (for cookies, admin fields)
 *
 * CURRENCY_OPTION_FIELD Sub fields should be: code, symbol, currency
 *
 * @package Xata
 */
class Currency {

    const CURRENCY_OPTION_FIELD = 'currencies';
    const CURRENCY_GET_PARAM = 'currency';
    const PRODUCT_POST_TYPE = 'post-realty';
    const PRODUCT_CURRENCY_FIELD = 'currency';

    private $currencies = array();
    private $userCurrency;

    function __construct() {
        $this->addSelectValues();

        $this->currencies = get_field(self::CURRENCY_OPTION_FIELD, 'option');
        $this->userCurrency = $this->currencies[1]['code'];

        // Get user currency
        if ( isset($_GET[self::CURRENCY_GET_PARAM]) ) {
            $this->setUserCurrency($_GET[self::CURRENCY_GET_PARAM]);
        } else if ( isset($_COOKIE[self::CURRENCY_GET_PARAM]) && $this->isCurrencyExist($_COOKIE[self::CURRENCY_GET_PARAM]) ) {
            $this->userCurrency = $_COOKIE[self::CURRENCY_GET_PARAM];
        }

    }


    public function getCurrencySelect($cssClass = false) {
        $result = false;
        $cssClass = ( $cssClass !== false && strlen($cssClass) > 0 ) ? 'class="' . $cssClass . '"' : '';
        if ( ! empty($this->currencies) && count($this->currencies) > 1 ) {
            $result .= '<select ' . $cssClass . ' onchange="document.location=value">';
            foreach ($this->currencies as $item) {
                $selected = ($item['code'] == $this->userCurrency) ? ' selected' : '';
                $result .= '<option value="' . $this->getActionUrl($item['code']) . '"' . $selected . '>' . $item['symbol'] . '</option>';
            }
            $result .= '</select>';
        } else {
            return false;
        }
        return $result;
    }



    public function setUserCurrency($code) {
        if ( $this->isCurrencyExist($code) ) {
            $this->userCurrency = $code;
            if ( ! headers_sent() ) {
                setcookie (self::CURRENCY_GET_PARAM, $code, 0, '/');
            }
        }
    }


    public function getUserCurrency() {
        return $this->getCurrencyByCode($this->userCurrency);
    }


    public function getCurrencyByCode($code) {
        foreach($this->currencies as $currency) {
            if ( in_array($code, $currency) ) {
                return $currency;
            }
        }
        return false;
    }


    public function getCurrencyList() {
        return $this->currencies;
    }


    public function isCurrencyExist($code) {
        foreach($this->currencies as $currency) {
            if ( in_array($code, $currency) ) {
                return true;
            }
        }
        return false;
    }


    public function convert($amount, $currencyFrom, $currencyTo) {
        if ($this->currencies[0]['code'] == $currencyFrom) {
            $currencyTo = $this->getCurrencyByCode($currencyTo);
            return $amount / $currencyTo['currency'];
        } else {
            $currencyFrom = $this->getCurrencyByCode($currencyFrom);
            $currencyTo = $this->getCurrencyByCode($currencyTo);
            return $amount * ($currencyFrom['currency'] / $currencyTo['currency']);
        }
    }




    public function getUserPrice($amount, $currency) {
        if ( empty($currency) ) {
            $currency = $this->currencies[0]['code'];
        } else {
            if ( ! $this->isCurrencyExist($currency) ) {
                return __('Цена уточняется', 'imperia');
            };
        }
        $currencyTo = $this->getUserCurrency();
        $converted = $this->convert($amount, $currency, $currencyTo['code']);
        return number_format($converted, 0, ',', ' ') . ' ' . $currencyTo['symbol'];
    }






    /**
     * Return action url for currency select
     * @param $code string
     *
     * @return string
     */
    private function getActionUrl($code) {
        $url = $this->getCurrentUrl();
        list($urlpart, $qspart) = array_pad(explode('?', $url), 2, '');
        parse_str($qspart, $qsvars);

        $currentCurrency = $this->getUserCurrency();
        if ( isset($_GET['price_from']) ) {
            $qsvars['price_from'] = floor($this->convert($_GET['price_from'], $currentCurrency['code'], $code));
            if ($qsvars['price_from'] == 0) {
                $qsvars['price_from'] = "";
            }
//            $qsvars['price_from'] = 1;
        } else $qsvars['price_from'] = "";
        if ( isset($_GET['price_to']) ) {
            $qsvars['price_to'] = ceil($this->convert($_GET['price_to'], $currentCurrency['code'], $code));
            if ($qsvars['price_to'] == 0) {
                $qsvars['price_to'] = "";
            }
//            $qsvars['price_to'] = 2;
        } else $qsvars['price_to'] = "";
        $qsvars[self::CURRENCY_GET_PARAM] = $code;

        $newqs = http_build_query($qsvars);
        return $urlpart . '?' . $newqs;
    }


    /**
     * Returns current page url
     * @return string
     */
    private function getCurrentUrl() {
        return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }




    /**
     *  Init values for product currency select
     */
    private function addSelectValues() {
        if ( $this->isPostAddPage(self::PRODUCT_POST_TYPE) || $this->isPostEditPage(self::PRODUCT_POST_TYPE) ) {
            add_filter('acf/load_field/name=' . self::PRODUCT_CURRENCY_FIELD, function($field) {
                $field['choices'] = array();
                foreach ($this->currencies as $currency) {
                    $field['choices'][trim($currency['code'])] = $currency['symbol'];
                }
                return $field;
            });
        }
    }



    private function isPostAddPage($post_type = 'post') {
        global $pagenow;
        return ( is_admin() && $pagenow == 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == $post_type ) ? true : false;
    }


    private function isPostEditPage($post_type = 'post') {
        global $pagenow;
        return ( is_admin() && $pagenow == 'post.php' && isset($_GET['post']) && get_post_type($_GET['post']) == $post_type ) ? true : false;
    }


}