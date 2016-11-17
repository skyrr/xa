<?php global $currency; ?>
<?php $search = new \Xata\Search(); ?>

<?php get_header(); ?>

<div class="header">
    <div class="container">
        <div class="left_head left_head_main">
            <a href="#" class="response"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/burger.png" alt=""></a>
            <div class="nav">
                <?php wp_nav_menu( array(
                    'theme_location'  => 'header_menu',
                    'container'       => false,
                    'menu_class'      => 'menu',
                    'echo'            => true,
                    'fallback_cb'     => 'wp_page_menu'
                ) ); ?>
            </div>
        </div>
        <div class="right_head">

            <div class="s-cur">
                <?php echo $currency->getCurrencySelect(); ?>
            </div>

            <?php if ( function_exists('qtranxf_getSortedLanguages') && count(qtranxf_getSortedLanguages()) > 1 ): ?>
            <div class="s-lng">
                <?php the_widget('qTranslateXWidget', array('type' => 'dropdown', 'hide-title' => true, 'widget-css-off' => true) ); ?>
            </div>
            <?php endif; ?>

            <div class="back_call">
                <a class="call popup_callback_open" id="openCallbackPopup"><?php _e('Обратный звонок', 'imperia'); ?></a>
                <?php get_template_part( 'popup-callback' ); ?>
                <?php $telephone = get_field('telephones', 'option')[0]; ?>
                <a class="phone" href="tel:<?php echo $telephone['number']; ?>"><?php echo $telephone['number']; ?></a>
            </div>
        </div>
        <div class="logo">
            <a href="#"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/logo.png" alt=""></a>
        </div>
    </div>

    <form action="<?php echo home_url('realty'); ?>" method="get">
        <div class="input-line">
            <div class="container">
                <div class="row selects">
                    <div class="col-sm-4">
                        <select class="s-select1" name="operation">
                            <option value="sell" <?php if($search->getOperation() == 'sell') echo 'selected'; ?>><?php _e('Купить', 'imperia'); ?></option>
                            <option value="rent" <?php if($search->getOperation() == 'rent') echo 'selected'; ?>><?php _e('Аренда', 'imperia'); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="s-select2" name="type">
                            <option value="apartment" <?php if($search->getType() == 'apartment') echo 'selected'; ?>><?php _e('Квартира', 'imperia'); ?></option>
                            <option value="commerce" <?php if($search->getType() == 'commerce') echo 'selected'; ?>><?php _e('Коммерция', 'imperia'); ?></option>
                            <option value="house" <?php if($search->getType() == 'house') echo 'selected'; ?>><?php _e('Дом', 'imperia'); ?></option>
                            <option value="territory" <?php if($search->getType() == 'territory') echo 'selected'; ?>><?php _e('Земельный участок', 'imperia'); ?></option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <?php echo $search->getRegionsSelect(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="search-line">
            <div class="container">
                <div class="row">

                    <div class="filters" id="filters" data-show="false">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="square"><?php _e('Площадь от', 'imperia'); ?></label>
                                        <input type="text" name="area_from" class="form-control" id="square" placeholder="0 м" value="<?php echo $search->getAreaFrom(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="floor"><?php _e('Этаж от', 'imperia'); ?></label>
                                        <input type="text" name="floor_from" class="form-control" id="floor" placeholder="0" value="<?php echo $search->getFloorFrom(); ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="area_to" class="form-control" id="to" placeholder="0 м" value="<?php echo $search->getAreaTo(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="floor_to" class="form-control" id="to" placeholder="0" value="<?php echo $search->getFloorTo(); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-1"></div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                            <div class="col-xs-7 col-sm-7 col-md-7">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="price"><?php _e('Цена от', 'imperia'); ?></label>
                                        <input type="text" name="price_from" class="form-control" id="price" placeholder="0 грн" value="<?php echo $search->getPriceFrom(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label class="nmb-rooms" for="rooms"><?php _e('Количество <br> комнат от', 'imperia'); ?></label>
                                        <input type="text" name="rooms_from" class="form-control" id="rooms" placeholder="0" value="<?php echo $search->getRoomsFrom(); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5 col-sm-5 col-md-5">
                                <div class="form-horizontal">
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="price_to" class="form-control" id="to" placeholder="0 грн" value="<?php echo $search->getPriceTo(); ?>">
                                    </div>
                                    <div class="form-group form_group_custom">
                                        <label for="to"><?php _e('до', 'imperia'); ?></label>
                                        <input type="text" name="rooms_to" class="form-control" id="to" placeholder="0" value="<?php echo $search->getRoomsTo(); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-2">
                            <div class="form-horizontal">
                                <div class="form-group form_group_custom currency">
                                    <?php echo $currency->getCurrencySelect('form-currency'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="toggle-filter">
                        Детальніше <span class="glyphicon glyphicon-chevron-down"></span>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
                        <a class="find form_submit"><?php _e('Искать', 'imperia'); ?></a>
                        <p class="x"> </p>
                        <a class="clean" href="<?php echo home_url('realty'); ?>"><?php _e('Очистить', 'imperia'); ?></a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<section>
    <div class="container">
        <div class="row">

            <?php get_sidebar(); ?>

            <div class="col-sm-8 col-md-9">
                <div class="section">

                    <?php $args = array(
                        'post_type' => 'post-realty',
                        'numberposts' => 3,
                        'meta_query' => array(
                            array(
                                'key'     => 'top_offer',
                                'value'   => 1,
                                'compare' => '='
                            ),
                            array(
                                'key'     => 'type',
                                'value'   => 'apartment',
                                'compare' => '='
                            ),
                        ),
                        'orderby' => 'rand',
                    );
                    $posts_array = get_posts( $args );

                    if ( count($posts_array) > 0 ): ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="top">
                                    <h2><?php _e('Топ-предложение квартиры', 'imperia'); ?></h2>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                    <div class="row">
                    <?php $args = array(
                        'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                        'combined_query' => array(
                            'args' => $search->getCombinedMetaQuery(),
                        ),
                    );

                    if ( ! $search->getSort() ) {
                        $args['orderby'] = 'date';
                        $args['order'] = 'DESC';
                    } else {
                        // Modify combined ordering:
                        add_filter( 'cq_orderby', function( $orderby ) {
                            return 'meta_value ASC';
                        });
                        // Modify sub fields:
                        add_filter( 'cq_sub_fields', function( $fields ) {
                            global $wpdb;
                            return $fields . ', CAST(' . $wpdb->postmeta . '.meta_value AS UNSIGNED) AS meta_value';
                        });
                    }

                    query_posts($args); ?>

                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php
                        $data = get_fields();
                        foreach ($data as &$value) {
                            if ( ! is_string($value) ) continue;
                            $value = trim($value);
                            $value = ( strlen($value) > 0 )? $value : FALSE;
                        }

                        switch ($data['operation']){
                            case 'rent':
                                $data['operation'] = __('Аренда', 'imperia');
                                break;
                            case 'sell':
                                $data['operation'] = __('Купить', 'imperia');
                                break;
                            default:
                                $data['operation'] = FALSE;
                        }

                        $data['region'] = get_the_terms( get_the_ID(), 'region' );
                        if ( $data['region'] ) {
                            $data['region'] = $data['region'][0]->name;
                        } else {
                            $data['region'] = FALSE;
                        };
                        ?>
                        <!-- Grid display -->
                        <div class="main__prod col-xs-12 col-md-4 display-style display-style-grid" <?php if ( isset($_COOKIE['display-style']) && $_COOKIE['display-style'] != 'grid' ) echo ' style="display: none;"'; ?> id="post-<?php the_ID(); ?>">
                            <div class="selling">
                                <h3><?php echo $data['operation']; ?></h3>
                                <a class="img-container" href="<?php the_permalink(); ?>">
                                    <img src="<?php echo $data['photos'][0]['sizes']['thumbnail']; ?>" alt="<?php echo $data['photos'][0]['alt']; ?>">
                                </a>
                                <div class="row">
                                    <div class="col-xs-12">
                                        <p><?php _e('Название улицы', 'imperia'); ?>:</p>
                                        <b class="street_name name"><?php the_title(); ?></b>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Район', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <b><?php echo $data['region']; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Этаж', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <b><?php echo $data['floor']; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Количетво комнат', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <b><?php echo $data['room_count']; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Площадь', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <b><?php echo $data['area']; ?> <?php _e('м', 'imperia'); ?><sup>2</sup></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Номер телефону', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <b><?php echo $data['phone_number']; ?></b>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl col-xs-12">
                                                <p><?php _e('Цена', 'imperia'); ?>:</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="dtl1 col-xs-12">
                                                <span><?php echo $currency->getUserPrice($data['price'], $data['currency']); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?php the_permalink(); ?>" class="detal"><?php _e('Подробнее', 'imperia'); ?></a>
                            </div>
                        </div>
                        <!-- List display -->
                        <div class="display-style display-style-list" <?php if ( ! isset($_COOKIE['display-style']) || $_COOKIE['display-style'] != 'list' ) echo ' style="display: none;"'; ?>>
                            <div class="row" id="post-<?php the_ID(); ?>">
                                <div class="col-xs-12">
                                    <div class="selling1">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <h3><?php echo $data['operation']; ?></h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-3">
                                                <a href="<?php the_permalink(); ?>"><img src="<?php echo $data['photos'][0]['sizes']['thumbnail']; ?>" alt="<?php echo $data['photos'][0]['alt']; ?>" width="270"></a>
                                            </div>
                                            <div class="col-xs-6">
                                                <div class="detal-adr">
                                                    <p><?php _e('Название улицы', 'imperia'); ?></p>
                                                    <h4><?php the_title(); ?></h4>
                                                    <div class="row">
                                                        <div class="col-xs-3">
                                                            <p><?php _e('Район', 'imperia'); ?>:</p>
                                                            <b><?php echo $data['region']; ?></b>
                                                        </div>
                                                        <div class="col-xs-5">
                                                            <p><?php _e('Количетво комнат', 'imperia'); ?>:</p>
                                                            <b><?php echo $data['room_count']; ?></b>
                                                        </div>
                                                        <div class="col-xs-4">
                                                            <p><?php _e('Площадь', 'imperia'); ?>:</p>
                                                            <b><?php echo $data['area']; ?> <?php _e('м', 'imperia'); ?><sup>2</sup></b>
                                                        </div>
                                                    </div>
                                                    <a href="<?php the_permalink(); ?>" class="detal1"><?php _e('Подробнее', 'imperia'); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-3">
                                                <p class="vertical-line"></p>
                                                <div class="price1">
                                                    <p><?php _e('Цена', 'imperia'); ?></p>
                                                    <span><?php echo number_format($data['price'], 0, ',', ' '); ?> <?php _e('грн', 'imperia'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="h1-line3"></p>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>

                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="pg-numbers">
                                <nav>
                                    <?php
                                    // Remove anchor from pagination
                                    add_filter( 'paginate_links', function($link){
                                        return str_replace ('#' . parse_url($link, PHP_URL_FRAGMENT), '', $link);
                                    });
//                                    var_dump(get_site_url());
                                    $GLOBALS['wp_rewrite']->pagination_base = 'realty/page';
                                    ?>

                                    <?php
                                    global $wp_query;
                                    $big = 999999999; // need an unlikely integer
                                    $pagination =  paginate_links( array(
                                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                                        'format' => '?paged=%#%',
                                        'current' => max( 1, get_query_var('paged') ),
                                        'total' => $wp_query->max_num_pages,
                                        'type' => 'array',
                                        'prev_text'    => '<span aria-hidden="true">← </span>' . __('Предыдущая', 'imperia'),
                                        'next_text'    => __('Следующая', 'imperia') . '<span aria-hidden="true"> →</span>',
                                    ) );
                                    ?>
                                    <ul class="pagination">
                                        <?php if ( is_array($pagination) ): ?>
                                            <?php foreach($pagination as $item): ?>
                                                <li><?php echo $item; ?></li>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <?php $args = array(
                        'post_type' => 'post-realty',
                        'numberposts' => 3,
                        'meta_query' => array(
                            array(
                                'key'     => 'top_offer',
                                'value'   => 1,
                                'compare' => '='
                            ),
                            array(
                                'key'     => 'type',
                                'value'   => 'commerce',
                                'compare' => '='
                            ),
                        ),
                        'orderby' => 'rand',
                    );
                    $posts_array = get_posts( $args );
                    if ( count($posts_array) > 0 ): ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="top">
                                    <h2><?php _e('Топ-предложение коммерческая недвижимость', 'imperia'); ?></h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ( $posts_array as $post ) : setup_postdata( $post ); ?>
                                <?php
                                $data = get_fields();
                                foreach ($data as &$value) {
                                    if ( ! is_string($value) ) continue;
                                    $value = trim($value);
                                    $value = ( strlen($value) > 0 )? $value : FALSE;
                                }

                                switch ($data['operation']){
                                    case 'rent':
                                        $data['operation'] = __('Аренда', 'imperia');
                                        break;
                                    case 'sell':
                                        $data['operation'] = __('Купить', 'imperia');
                                        break;
                                    default:
                                        $data['operation'] = FALSE;
                                }

                                $data['region'] = get_the_terms( get_the_ID(), 'region' );
                                if ( $data['region'] ) {
                                    $data['region'] = $data['region'][0]->name;
                                } else {
                                    $data['region'] = FALSE;};
                                ?>
                                <div class="main__prod col-xs-12 col-sm-12 col-md-4">
                                    <div class="selling">
                                        <h3><?php echo $data['operation']; ?></h3>
                                        <a class="img" href="<?php the_permalink(); ?>"><img src="<?php echo $data['photos'][0]['sizes']['thumbnail']; ?>" alt="<?php echo $data['photos'][0]['alt']; ?>"></a>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <p><?php _e('Название улицы', 'imperia'); ?></p>
                                                <b><?php the_title(); ?></b>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dtl">
                                                <p><?php _e('Район', 'imperia'); ?>:</p>
                                                <b><?php echo $data['region']; ?></b>
                                                <p><?php _e('Площадь', 'imperia'); ?>:</p>
                                                <b><?php echo $data['area']; ?> <?php _e('м', 'imperia'); ?><sup>2</sup></b>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="dtl1">
                                                <p><?php _e('Количетво комнат', 'imperia'); ?>:</p>
                                                <b><?php echo $data['room_count']; ?></b>
                                                <p><?php _e('Цена', 'imperia'); ?>:</p>
                                                <span><?php echo $currency->getUserPrice($data['price'], $data['currency']); ?></span>
                                            </div>
                                        </div>
                                        <a href="<?php the_permalink(); ?>" class="detal"><?php _e('Подробнее', 'imperia'); ?></a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php wp_reset_postdata(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="order">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <h1><?php _e('Хотите продать квартиру или недвижимость?', 'imperia'); ?></h1>
                <h2><?php _e('Свяжитесь с нами и мы поможем Вам', 'imperia'); ?></h2>
            </div>
        </div>
        <div class="row" id="index_callback">
            <div class="col-xs-12">
                <div class="complete" style="display: none;">
                    <?php _e('Заявка принята', 'imperia'); ?>
                </div>
                <form class="form-inline" role="form" method="POST" action="<?php echo get_template_directory_uri(); ?>/includes/callback/callback.php">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" id="exampleInputName1" placeholder="<?php _e('Ваше имя', 'imperia'); ?>">
                    </div>
                    <div class="form-group">
                        <input type="tel" name="telephone" class="form-control" id="exampleInputTel1" placeholder="<?php _e('Ваш телефон', 'imperia'); ?>">
                    </div>
                    <?php wp_nonce_field('callback_email_send'); ?>
                    <button type="submit" class="btn btn-default"><?php _e('Заказать звонок', 'imperia'); ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
