<?php get_header(); ?>
<?php
    $data = get_fields();
        foreach ($data as &$value) {
        if ( ! is_string($value) ) continue;
        $value = trim($value);
        $value = ( strlen($value) > 0 )? $value : FALSE;
    }

    switch ($data['operation']){
        case 'rent':
            $data['operation_text'] = __('Аренда', 'imperia');
            break;
        case 'sell':
            $data['operation_text'] = __('Купить', 'imperia');
            break;
        default:
            $data['operation_text'] = FALSE;
    }

    switch ($data['type']){
        case 'apartment':
            $data['type_text'] = __('Квартиры', 'imperia');
            break;
        case 'commerce':
            $data['type_text'] = __('Коммерция', 'imperia');
            break;
        default:
            $data['type_text'] = FALSE;
    }

    $data['region'] = get_the_terms( get_the_ID(), 'region' );
    $data['region'] = ( $data['region'] ) ? $data['region'][0] : FALSE;
?>

<div class="body-2">
    <?php
        global $header_style;
        $header_style = 3;
        get_template_part( 'header-page' );
    ?>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
    <div class="search">
        <?php //get_template_part( 'search-catalog' ); ?>
<!--        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">-->
<!--            <a class="clean" href="--><?php //echo home_url('realty'); ?><!--">--><?php //_e('Очистить', 'imperia'); ?><!--</a>-->
        <!--        </div>-->
    </div>
        <div class="container">
            <section>
                <div class="row">
                    <div class="col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo home_url(); ?>"><?php _e('На главную', 'imperia'); ?></a></li>
                            <?php $href = home_url('realty?operation='.$data['operation']); ?>
                            <li><a href="<?php echo $href; ?>"><?php echo $data['operation_text']; ?></a></li>
                            <?php $href .= '&type='.$data['type']; ?>
                            <li><a href="<?php echo $href; ?>"><?php echo $data['type_text']; ?></a></li>
                            <?php $href .= '&region_id='.$data['region']->term_id; ?>
                            <li><a href="<?php echo $href; ?>"><?php echo $data['region']->name;; ?></a></li>
                            <li class="active"><?php the_title(); ?></li>
                        </ol>
                    </div>
                </div>
                <div class="row">

                <?php get_sidebar_single_post(); ?>

                <div class="col-xs-12 col-sm-8 col-md-9">
                    <div class="product">
                        <div class="product-h2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2><?php the_title(); ?></h2>
                                </div>
                            </div>
                        </div>

                        <div class="prdkt">
                            <div class="row">
                                <div class="col-xs-12">
                                    <h4><?php ; ?></h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-7">
                                    <div id="sync1" class="owl-carousel">
                                        <?php $i = 0; ?>
                                        <?php foreach($data['photos'] as $photo): ?>
                                            <div class="item">
                                                <img src="<?php echo $photo['sizes']['medium']; ?>" alt="<?php echo $photo['alt']; ?>">
                                            </div>
                                        <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div id="sync2" class="owl-carousel">
                                        <?php foreach($data['photos'] as $photo): ?>
                                            <div class="item">
                                                <img src="<?php echo $photo['sizes']['thumbnail']; ?>" alt="<?php echo $photo['alt']; ?>">
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-5">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <b><?php _e('Район', 'imperia'); ?>:</b>
                                                <p><?php echo $data['region']->name; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <b><?php _e('Этаж', 'imperia'); ?>:</b>
                                                <p><?php echo $data['floor']; ?></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <b><?php _e('Количетво комнат', 'imperia'); ?>:</b>
                                                <p><?php echo $data['room_count']; ?></p>
                                            </div>
                                        </div>
<!--                                        --><?php //var_dump($wp_query)?>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <b><?php _e('Площадь', 'imperia'); ?>:</b>
                                                <p><?php echo $data['area']; ?> <?php _e('м', 'imperia'); ?><sup>2</sup></p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <b><?php _e('Телефони', 'imperia'); ?>:</b>
                                                <p><?php echo $data['phone_number']; ?> </p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <p><?php echo $data['phone_number_2']; ?> </p>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="rajon">
                                                <p><?php echo $data['phone_number_3']; ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="dtl col-xs-12">
                                                    <p><?php _e('Дата оголошення', 'imperia'); ?>:</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="dtl1 col-xs-12">
                                                    <b><?php echo the_time('d.m.Y'); ?></b>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="g-line"></p>
                                    <div class="price">
                                        <p><?php echo $currency->getUserPrice($data['price'], $data['currency']); ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="desc">
                                        <?php the_content(); ?>
                                    </div>
                                    <a href="#" class="request popup_watchback_open" id="openWatchbackPopup"><?php _e('Заявка на осмотр', 'imperia'); ?></a>
                                    <!-- Modal -->
                                    <div class="modal fade" id="popup_watchback" role="dialog">
                                        <div class="modal-dialog modal_dialog_custom">
                                            <!-- Modal content-->
                                            <div class="modal-content modal_custom">
                                                <div class="modal-header modal_header_custom">
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                    <div class="product-h">
                                                        <h2 class="modal-title"><?php _e('Заявка на осмотр', 'imperia'); ?></h2>
                                                        <h2 class="modal-title after-submit" style="display: none"><?php _e('Заявка принята', 'imperia'); ?></h2>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-2 col-sm-offset-5 modal_border"></div>
                                                </div>
                                                <form class="form-horizontal" role="form" method="POST" action="<?php echo get_template_directory_uri(); ?>/includes/callback/callback.php">
                                                    <div class="modal-body modal_body_custom">
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="text" name="name" class="form-control form_control_custom" id="name" placeholder="<?php _e('Ваше имя', 'imperia'); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-12">
                                                                <input type="tel" name="telephone" class="form-control form_control_custom" id="phone" placeholder="<?php _e('Ваш телефон', 'imperia'); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="text-success text-left col-sm-12">* послуга безкоштовна</div>
                                                    </div>
                                                    <input type="hidden" name="realty_id" value="<?php the_ID(); ?>" />
                                                    <?php wp_nonce_field('callback_email_send'); ?>
                                                    <div class="modal-footer btn_reg_padding">
                                                        <div class="col-sm-12 text-center">
                                                            <button type="submit" class="find"><?php _e('Заказать звонок', 'imperia'); ?></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end Modal-->
                                    <p class="g-line2"></p>
									<div class="share">
                                        <p><?php _e('Поделится', 'imperia'); ?></p>
										<script type="text/javascript">(function() {
  if (window.pluso)if (typeof window.pluso.start == "function") return;
  if (window.ifpluso==undefined) { window.ifpluso = 1;
    var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
    s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
    var h=d[g]('body')[0];
    h.appendChild(s);
  }})();</script>
<div class="pluso" data-background="transparent" data-options="medium,round,line,horizontal,nocounter,theme=05" data-services="vkontakte,facebook"></div>
									</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="maps">
                                    <div class="panel-group1" role="tablist">
                                        <div class="panel1">
                                            <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                                                <h4 class="panel-title1">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                                                        <?php _e('Карта', 'imperia'); ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <p class="g-line3"></p>
                                            <div id="collapseListGroup1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="height: 0px;">

                                                <?php if( !empty($data['map']) ): ?>
                                                <div class="realty-acf-map">
                                                    <div class="marker" data-lat="<?php echo $data['map']['lat']; ?>" data-lng="<?php echo $data['map']['lng']; ?>"></div>
                                                </div>
                                                <?php endif; ?>

                                                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyD_vkZyyT2wkW2T8Z1bPl9gygsIG6_QDNU"></script>
                                                <script type="text/javascript">
                                                    (function($) {

                                                        function new_map( $el ) {
                                                            var $markers = $el.find('.marker');

                                                            var args = {
                                                                zoom		: 17,
                                                                center		: new google.maps.LatLng(0, 0),
                                                                mapTypeId	: google.maps.MapTypeId.ROADMAP
                                                            };

                                                            var map = new google.maps.Map( $el[0], args);

                                                            map.markers = [];

                                                            $markers.each(function(){
                                                                add_marker( $(this), map );
                                                            });

                                                            center_map( map, args.zoom );

                                                            return map;
                                                        }


                                                        function add_marker( $marker, map ) {
                                                            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

                                                            var marker = new google.maps.Marker({
                                                                position	: latlng,
                                                                map			: map
                                                            });

                                                            map.markers.push( marker );

                                                            if( $marker.html() )
                                                            {
                                                                var infowindow = new google.maps.InfoWindow({
                                                                    content		: $marker.html()
                                                                });

                                                                google.maps.event.addListener(marker, 'click', function() {
                                                                    infowindow.open( map, marker );
                                                                });
                                                            }
                                                        }


                                                        function center_map( map, zoom ) {
                                                            var bounds = new google.maps.LatLngBounds();

                                                            $.each( map.markers, function( i, marker ){
                                                                var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
                                                                bounds.extend( latlng );
                                                            });

                                                            if( map.markers.length == 1 )
                                                            {
                                                                map.setCenter( bounds.getCenter() );
                                                                if ( zoom === undefined ) zoom = 17;
                                                                map.setZoom( zoom );
                                                            }
                                                            else
                                                            {
                                                                map.fitBounds( bounds );
                                                            }

                                                        }


                                                        var map = null;

                                                        $(document).ready(function(){
                                                            $('.realty-acf-map').each(function(){
                                                                map = new_map( $(this) );
                                                            });
                                                        });

                                                    })(jQuery);
                                                </script>

                                            </div>
                                        </div>
                                    </div>
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
