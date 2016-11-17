<?php global $currency; ?>

<?php
	global $header_style;
	if ( ! isset($header_style) ) {
		$header_style = 2;
	}
?>

<div class="header-<?php echo $header_style; ?>">
	<div class="container">
		<div class="logo2 hidden-xs">
			<a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/logo2.png" alt=""></a>
		</div>
		<div class="nav_menu">
			<a href="#" class="response"><img src="<?php echo get_template_directory_uri(); ?>/resources/img/burger.png" alt=""></a>
			<div class="nav menu">
				<?php wp_nav_menu( array(
					'theme_location'  => 'header_menu',
					'container'       => false,
					'menu_class'      => 'menu-1',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu'
				) ); ?>
			</div>
		</div>
		<div class="head1_wr">

			<div class="s-cur-page">
                <?php echo $currency->getCurrencySelect(); ?>
			</div>

            <?php if ( function_exists('qtranxf_getSortedLanguages') && count(qtranxf_getSortedLanguages()) > 1 ): ?>
			<div class="lang-select">
				<?php the_widget('qTranslateXWidget', array('type' => 'dropdown', 'hide-title' => true, 'widget-css-off' => true) ); ?>
			</div>
			<?php endif; ?>

			<div class="back_call back_call1">
				<a class="call-1 popup_callback_open" id="openCallbackPopup"><?php _e('Обратный звонок', 'imperia'); ?></a>
				<?php get_template_part( 'popup-callback' ); ?>
				<div class="phone-1">
					<?php $telephone = get_field('telephones', 'option')[0]; ?>
					<a class="phone" href="tel:<?php echo $telephone['number']; ?>"><?php echo $telephone['number']; ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
