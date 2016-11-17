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
                    <div class="news">
                        <div class="col-xs-7">
                            <h1><?php single_term_title(); ?></h1>
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
                                    <li class="active"><?php _e('Новости', 'imperia'); ?></li>
                                </ol>
                            </div>
                        </div>

                        <?php $args = array(
                            'post_type' => 'post-news',
                            'publish' => true,
                            'paged' => get_query_var('paged'),
                        );

                        query_posts($args); ?>

                        <?php while ( have_posts() ) : the_post(); ?>
                            <div class="row" id="post-<?php the_ID(); ?>">
                                <div class="col-xs-12">
                                    <div class="news1">
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-12 col-md-4">
                                                <img src="<?php echo wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' )[0]; ?>" alt="<?php echo get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true); ?>">
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-8">
                                                <div class="nws1">
                                                    <h4><?php echo get_the_date('d.m.Y'); ?></h4>
                                                    <h2><?php the_title(); ?></h2>
                                                    <p><?php echo strip_tags( get_the_excerpt() ); ?></p>
                                                    <a href="<?php the_permalink(); ?>"><?php _e('Читать подробнее', 'imperia'); ?> →</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="pg-numbers">
                                    <nav>
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