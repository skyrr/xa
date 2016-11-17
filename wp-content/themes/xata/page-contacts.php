<?php get_header(); ?>

<div class="body-1">

    <?php
        global $header_style;
        $header_style = 1;
        get_template_part( 'header-page' );
    ?>

    <div class="container">
        <div class="panel-group" role="tablist">
            <div class="panel1">
                <div class="panel-heading" role="tab" id="collapseListGroupHeading1">
                    <h4 class="panel-title">
                        <a class="collapsed" data-toggle="collapse" href="#collapseListGroup1" aria-expanded="false" aria-controls="collapseListGroup1">
                            <?php _e('Подбор недвижимости', 'imperia'); ?>
                        </a>
                    </h4>
                </div>
                <div id="collapseListGroup1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="collapseListGroupHeading1" aria-expanded="false" style="height: 0px;">
                    <?php get_template_part( 'search-page' ); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="contacts">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php the_title(); ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4">
                    <div class="line"></div>
                    <div class="adress">
                        <span><?php _e('Адрес', 'imperia'); ?>:</span>
                        <p>
                            <?php $country = trim(get_field('address_country', 'option')); ?>
                            <?php if ( strlen($country) > 0 ): ?>
                                <?php echo $country; ?><br>
                            <?php endif; ?>

                            <?php $city = trim(get_field('address_city', 'option')); ?>
                            <?php if ( strlen($city) > 0 ): ?>
                                <?php echo $city; ?><br>
                            <?php endif; ?>

                            <?php $street = trim(get_field('address_street', 'option')); ?>
                            <?php if ( strlen($street) > 0 ): ?>
                                <?php echo $street; ?><br>
                            <?php endif; ?>

                            <?php $office = trim(get_field('address_office', 'option')); ?>
                            <?php if ( strlen($office) > 0 ): ?>
                                <?php _e('Офис', 'imperia'); ?> <?php echo $office; ?>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="line"></div>
                    <div class="telephone">
                        <span><?php _e('Тел.', 'imperia'); ?>:</span>
                        <p>
                            <?php $telephones = get_field('telephones', 'option'); ?>
                            <?php $i = 0;
                            foreach($telephones as $item) {
                                echo ($i > 0) ? '<br/>' . $item['number'] : $item['number'];
                                $i++;
                            } ?>
                        </p>
                    </div>
                    <div class="mail">
                        <span>Email:</span>
                        <p>
                            <?php $emails = get_field('emails', 'option'); ?>
                            <?php $i = 0;
                            foreach($emails as $item) {
                                echo ($i > 0) ? '<br/>' . '<a href="mailto:'. $item['address'] .'">' . $item['address'] . '</a>' : '<a href="mailto:'. $item['address'] .'">' . $item['address'] . '</a>';
                                $i++;
                            } ?>

                        </p>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4">
                    <div class="line"></div>
                    <div class="social">
                        <span><?php _e('Соц.', 'imperia'); ?>:</span>
                        <ul class="soc-button">
                            <li><a href="<?php the_field('instagram_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/instagram.png" alt=""></a></li>
                            <li><a href="<?php the_field('facebook_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/fb.png" alt=""></a></li>
                            <li><a href="<?php the_field('vkontakte_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/vk.png" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
<?php wp_footer(); ?>
</html>