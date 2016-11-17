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

                <div class="col-xs-12 col-sm-8 col-md-9">
                    <div class="news-detal">
                        <?php while ( have_posts() ) : the_post(); ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <h4><?php echo get_the_date('d.m.Y'); ?></h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <h1><?php the_title(); ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="h1-line"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo home_url(); ?>"><?php _e('На главную', 'imperia'); ?></a></li>
                                    <li><a href="<?php echo home_url(); ?>/news"><?php _e('Новости', 'imperia'); ?></a></li>
                                    <li class="active"><?php the_title(); ?></li>
                                </ol>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="news-photo">
                                    <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' )[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>" width="845">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <?php the_content(); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6">
                                <?php setPostViews( get_the_ID() ); ?>
                                <p class="views"><?php echo getPostViews( get_the_ID() ); ?> <?php _e('просмотров', 'imperia'); ?></p class="views">
                            </div>
                            <?php
                                $data = get_fields();
                                foreach ($data as &$value) {
                                    if ( ! is_string($value) ) continue;
                                    $value = trim($value);
                                    $value = ( strlen($value) > 0 )? $value : FALSE;
                                }
                            ?>
                            <?php if ( $data['source'] || $data['link_to_source'] ): ?>
                            <?php if ( $data['link_to_source'] && ! preg_match("/^https?:\/{2}/i", $data['link_to_source'])) {
                                    $data['link_to_source'] = 'http://'.$data['link_to_source'];
                            } ?>
                            <div class="col-xs-6">
                                <?php if ( ! $data['source'] && $data['link_to_source'] ): ?>
                                    <p class="source"><?php _e('Источник', 'imperia'); ?>: <a href="<?php echo $data['link_to_source']; ?>"><?php echo $data['link_to_source']; ?></a></p>
                                <?php elseif ( $data['source'] && ! $data['link_to_source'] ): ?>
                                    <p class="source"><?php _e('Источник', 'imperia'); ?>: <?php echo $data['source']; ?></p>
                                <?php else: ?>
                                    <p class="source"><?php _e('Источник', 'imperia'); ?>: <a href="<?php echo $data['link_to_source']; ?>"><?php echo $data['source']; ?></a></p>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="h1-line2"></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <ul class="soc-btn1">
                                    <li><p><?php _e('Поделится', 'imperia'); ?></p></li>
                                    <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/g+small.png" alt=""></a></li>
                                    <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/fb-small.png" alt=""></a></li>
                                    <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/vk-small.png" alt=""></a></li>
                                </ul>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php get_footer(); ?>