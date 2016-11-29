<div class="col-xs-12 col-sm-4 col-md-3">
    <div class="col-xs-6 col-sm-3 col-md-3 col-lg-12">
        <a class="find form_submit"  onclick="goBack()"><?php _e('Повернутись', 'imperia'); ?></a>
    </div>
    <div class="left-nav">
        <div class="row">
            <h3><?php _e('Квартиры', 'imperia'); ?></h3>
            <ul>
                <li><a href="<?php echo home_url('realty?operation=sell&type=apartment'); ?>"><?php _e('Купить', 'imperia'); ?></a></li>
                <li><a href="<?php echo home_url('realty?operation=rent&type=apartment'); ?>"><?php _e('Аренда', 'imperia'); ?></a></li>
            </ul>
            <h3><?php _e('Коммерческая<br>недвижимость', 'imperia'); ?></h3>
            <ul>
                <li><a href="<?php echo home_url('realty?operation=sell&type=commerce'); ?>"><?php _e('Купить', 'imperia'); ?></a></li>
                <li><a href="<?php echo home_url('realty?operation=rent&type=commerce'); ?>"><?php _e('Аренда', 'imperia'); ?></a></li>
            </ul>
        </div>
        <div class="row hidden-xs">
            <h3><?php _e('Контакты', 'imperia'); ?></h3>
            <a class="back-call popup_callback_open" id="openCallbackPopup_2"><?php _e('Обратный звонок', 'imperia'); ?></a>
            <p class="b-line"> </p>
        </div>
        <div class="row hidden-xs">
            <h3><?php _e('Новости', 'imperia'); ?></h3>
            <?php $args = array(
                'post_type' => 'post-news',
                'numberposts' => 1,
                'category' => 'news'
            );
            $posts_array = get_posts( $args );
            foreach ( $posts_array as $post ) : setup_postdata( $post ); ?>
                <img class="news-image" src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' )[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                <h4><?php echo get_the_date('d.m.Y'); ?></h4>
                <b><?php the_title(); ?></b>
                <span><?php echo strip_tags( get_the_excerpt() ); ?></span>
                <a class="more" href="<?php the_permalink(); ?>"><?php _e('Читать подробнее', 'imperia'); ?> →</a>
            <?php endforeach; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</div>
