<?php
    $search = new \Xata\Search();

    // Generate search title
    function change_wp_title( $title, $sep ) {
        $title = '';
        if ( $_GET['operation'] == 'sell' ) {
            $title = __('Продажа недвижимости', 'imperia');
            if ( $_GET['type'] == 'apartment') {
                $title = __('Продажа квартир', 'imperia');
            } else if ( $_GET['type'] == 'commerce') {
                $title = __('Продажа коммерции', 'imperia');
            }
        } else if ( $_GET['operation'] == 'rent' ) {
            $title = __('Аренда недвижимости', 'imperia');
            if ( $_GET['type'] == 'apartment') {
                $title = __('Аренда квартир', 'imperia');
            } else if ( $_GET['type'] == 'commerce') {
                $title = __('Аренда коммерции', 'imperia');
            }
        }

        if ( isset( $_GET['region'] ) ) {
            $title .= ' ' . get_term( $_GET['region'], 'region' )->name;
        }
        /*
        // Add the blog name
        $title .= get_bloginfo( 'name', 'display' );
        // Add the blog description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title .= " $sep $site_description";
        }
        // Add a page number if necessary:
        global $page, $paged;
        if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
            $title .= " $sep " . sprintf( __( 'Page %s', '_s' ), max( $paged, $page ) );
        }*/
        return $title;
    }

    add_filter( 'wp_title', 'change_wp_title', 10, 2 );
?>

<?php get_header(); ?>

<div class="body-2">

    <?php
        global $header_style;
        $header_style = 3;
        get_template_part( 'header-page' );
    ?>

    <div class="search">
        <?php get_template_part( 'search-catalog' ); ?>
    </div>
    <section>
        <div class="container">
            <div class="row">

                <?php get_sidebar(); ?>

                <div class="col-xs-12 col-md-9 text-right" >
                    <div class="sort">
                        <ul>
                            <li><a href="#" class="change-display-style sort-1<?php if ( ! isset($_COOKIE['display-style']) || $_COOKIE['display-style'] == 'grid' ) echo ' active'; ?>" data-style="grid"></a></li>
                            <li><a href="#" class="change-display-style sort-2<?php if ( isset($_COOKIE['display-style']) && $_COOKIE['display-style'] == 'list' ) echo ' active'; ?>" data-style="list"></a></li>
                        </ul>
                    </div>
                    <div class="sort-select">
                        <script>
                            var href_sort = window.location.href.replace(/&sort=[a-z0-9\-_]+/i,'');
                            console.log(href_sort);
                        </script>
                        <label for="sorting"><?php _e('Сортировка', 'imperia'); ?>:</label>
                        <select id="ThemeSelect" class="sorting" onchange="window.location = href_sort + this.value; saveTheme(this.value);">
                            <option value="" <?php if( $search->getSort() ) echo 'selected'; ?>><?php _e('по дате', 'imperia'); ?></option>
                            <option value="&sort=price" <?php if( $search->getSort() == 'price' ) echo 'selected'; ?>><?php _e('по цене', 'imperia'); ?></option>
                            <option value="&sort=area" <?php if( $search->getSort() == 'area' ) echo 'selected'; ?>><?php _e('по размеру', 'imperia'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 col-md-9">
                    <div class="search-result">
<!--                        <div class="col-xs-12 col-md-7">-->
<!--                            <h1>--><?php //_e('Результаты поиска', 'imperia'); ?><!--</h1>-->
<!--                        </div>-->

                        <div class="row">
                            <div class="col-xs-12">
                                <p class="h1-line"></p>
                            </div>
                        </div>
<!--                        <div class="row">-->
<!--                            <div class="col-xs-12">-->
<!--                                <ol class="breadcrumb">-->
<!--                                    <li><a href="--><?php //echo home_url(); ?><!--">--><?php //_e('На главную', 'imperia'); ?><!--</a></li>-->
<!--                                    --><?php //$breadcrumbs = $search->getBreadcrumbs(); ?>
<!--                                    --><?php //$last_item = ( count($breadcrumbs) > 0 )? array_pop($breadcrumbs) : array( 'name' => __('Вся недвижимость', 'imperia') ); ?>
<!--                                    --><?php //foreach($breadcrumbs as $item): ?>
<!--                                        <li><a href="--><?php //echo $item['href']; ?><!--">--><?php //echo $item['name']; ?><!--</a></li>-->
<!--                                    --><?php //endforeach; ?>
<!--                                    <li class="active">--><?php //echo $last_item['name'] ?><!--</li>-->
<!--                                </ol>-->
<!--                            </div>-->
<!--                        </div>-->
                        <div class="row">

                            <?php $args = array(
                                'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1,
                                'combined_query' => array(
                                    'args' => $search->getCombinedMetaQuery(),
                                ),
                            );

                            if ( ! $search->getSort() ) {
                                $args['orderby'] = 'modified';
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
                            <div class="main__prod col-xs-12 col-md-4 display-style display-style-grid hidden-xs hidden-sm" <?php if ( isset($_COOKIE['display-style']) && $_COOKIE['display-style'] != 'grid' ) echo ' style="display: none;"'; ?> id="post-<?php the_ID(); ?>">
                                <div class="selling">
                                    <h3><?php ; ?></h3>
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
                                                    <p><?php _e('Дата', 'imperia'); ?>:</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="dtl1 col-xs-12">
                                                    <b><?php echo the_modified_date('d.m.Y'); ?></b>
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
<!--                            <div class="display-style display-style-list">-->
<!--                                <div class="row" id="post---><?php //the_ID(); ?><!--">-->
                                <div class="main__prod col-xs-12 col-md-4 display-style display-style-grid hidden-md hidden-lg">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="item-title">
                                                <strong><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></strong>
                                            </div>
                                        </div>
                                        <div class="col-xs-5 col-md-5 img-middle">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo $data['photos'][0]['sizes']['thumbnail']; ?>" alt="<?php echo $data['photos'][0]['alt']; ?>">
                                            </a>
                                        </div>
                                        <div class="col-xs-7 col-md-7 no-left">
                                            <table class="selling-info">
                                                <tbody class="dl-horizontal dl-horizontal-xs selling">
                                                <?php if ($data['region']) {
                                                    ?><tr><td><?php _e('Район', 'imperia'); ?>:</td><td><?php echo $data['region']; ?></td></tr>
                                                <?php }
                                                ?>
                                                <?php if ($data['room_count']) {
                                                    ?><tr><td><?php _e('Кімнат', 'imperia'); ?>:</td><td><?php echo $data['room_count']; ?></td></tr>
                                                <?php }
                                                ?>
                                                <?php if ($data['area']) {
                                                    ?><tr><td><?php _e('Площадь', 'imperia'); ?>:</td><td><?php echo $data['area']; ?> <?php _e('м', 'imperia'); ?><sup>2</sup></td></tr>
                                                <?php }
                                                ?>
                                                <?php if ($data['price']) {
                                                    ?><tr><td><?php _e('Цена', 'imperia'); ?>:</td><td><span><?php echo $currency->getUserPrice($data['price'], $data['currency']); ?></span></td></tr>
                                                <?php }
                                                ?>


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row item-info-inline">
                                        <div class="col-xs-5 text-muted">
                                            <span>
                                                <i class="glyphicon glyphicon-calendar"></i> <?php echo the_modified_date('d.m.Y'); ?>
                                            </span>
                                        </div>
                                        <div class="col-xs-7 no-left">
                                            <span>
                                                <?php if (!$data['phone_number']) {
                                                } else {
                                                    echo "<i class=\"glyphicon glyphicon-phone-alt\"></i> ".$data['phone_number'];
//                                                    _e('тел.: ', 'imperia');
                                                }; ?>
                                            </span>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>