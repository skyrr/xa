<?php
	wp_enqueue_script('jquery');
	wp_enqueue_script('js.cookie', get_template_directory_uri().'/resources/js/js.cookie-2.1.0.min.js', array(), NULL, TRUE);
	wp_enqueue_script('imperia-bootstrap', get_template_directory_uri().'/resources/libs/bootstrap/js/bootstrap.min.js', array('jquery'), NULL, TRUE);
	wp_enqueue_script('imperia-common', get_template_directory_uri().'/resources/js/common.js', array('jquery', 'js.cookie'), NULL, TRUE);
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ru"> <!--<![endif]-->

<head>
	<meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<title><?php wp_title(''); ?></title>
	<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/resources/img/favicon/favicon.png" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<?php wp_enqueue_style('imperia-bootstrap', get_template_directory_uri() . '/resources/libs/bootstrap/css/bootstrap.css'); ?>
	<?php wp_enqueue_style('imperia-fonts', get_template_directory_uri() . '/resources/css/fonts.css'); ?>
	<?php wp_enqueue_style('imperia-owl-carousel', get_template_directory_uri() . '/resources/css/owl.carousel.css'); ?>
	<?php wp_enqueue_style('imperia-main', get_template_directory_uri() . '/resources/css/main.css'); ?>
	<?php wp_enqueue_style('imperia-media', get_template_directory_uri() . '/resources/css/media.css'); ?>

	<?php wp_head(); ?>

	<!-- Google analytics -->
	<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-81044124-1', 'auto');
    ga('send', 'pageview');
	</script>
	<!-- (END) Google analytics -->
</head>

<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-MPTVCH"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-MPTVCH');</script>
<!-- End Google Tag Manager -->