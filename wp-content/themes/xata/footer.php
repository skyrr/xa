<footer>
    <div class="container">
        <div class="s-logo">
            <a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/small_logo.png" alt=""></a>
        </div>
        <?php wp_nav_menu( array(
            'theme_location'  => 'footer_menu',
            'container'       => false,
            'menu_class'      => 'f-menu',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu'
        ) ); ?>
        <div class="adr_tel_email">
            <div class="adr">
                <span><?php _e('Адрес', 'imperia'); ?>:</span>
                <p><?php the_field('address_city', 'option'); ?>, <br><?php the_field('address_street', 'option'); ?></p>
            </div>
            <?php $telephones = get_field('telephones', 'option'); ?>
            <?php if ( $telephones ): ?>
                <div class="tel">
                    <span><?php _e('Тел.', 'imperia'); ?>:</span>
                    <p>
                        <?php $i = 0;
                        foreach($telephones as $item) {
                            if ($i >= 2) break;
                            echo ($i > 0) ? '<br/>' . $item['number'] : $item['number'];
                            $i++;
                        } ?>
                    </p>
                </div>
            <?php endif; ?>
            <?php $email = get_field('emails', 'option')[0]; ?>
            <?php if ( $email ): ?>
                <div class="email">
                    <span>email:</span>
                    <a href="mailto:<?php echo $email['address']; ?>"><?php echo $email['address']; ?></a>
                </div>
            <?php endif; ?>
        </div>
        <ul class="soc-btn">
            <li><a href="<?php the_field('instagram_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/instagram.png" alt=""></a></li>
            <li><a href="<?php the_field('facebook_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/fb.png" alt=""></a></li>
            <li><a href="<?php the_field('vkontakte_link', 'option'); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/vk.png" alt=""></a></li>
            <br>
            <li class="powered_by">
                <a href="http://imrev.com.ua/" target="_blank">
                    <img src="<?php echo get_template_directory_uri(); ?>/resources/img/powered-by.png" alt="">
                </a>
            </li>
        </ul>
    </div>
</footer>

</body>
<?php wp_footer(); ?>
</html>