<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<?php // force Internet Explorer to use the latest rendering engine available ?>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<title><?php wp_title(''); ?></title>

		<?php // mobile meta (hooray!) ?>
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<?php // Icons and Favicons ?>
<link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/library/images/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="<?php echo get_template_directory_uri(); ?>/library/images/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/library/images/favicon-16x16.png">
<link href="https://fonts.googleapis.com/css?family=EB+Garamond|Merriweather+Sans:wght@300;700&display=swap" rel="stylesheet">
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/library/images/manifest.json">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" />
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">

		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

		<?php // wordpress head functions ?>
		<?php wp_head(); ?>
		<?php // end of wordpress head ?>

		<?php // drop Google Analytics Here ?>
		<?php // end analytics ?>

	</head>

	<body <?php body_class(); ?> >

		<div id="container">
			<header class="header" role="banner">

				<div id="inner-header" class="wrap cf">
					<div id="header-title-wrapper">
						<a id="header-logo" href="<?php echo home_url(); ?>"></a>
						
						<div id="desktop-title-wrapper">
						<div id="mobile-title-wrapper">
							<a id="header-mobile-logo" href="<?php echo home_url(); ?>"></a>
							<h1 id="header-text-mobile" ><a href="<?php echo home_url(); ?>" rel="nofollow"><div id="header-title-1">Story<br>Archival Project</a></h1>
							<h1 id="header-text-tablet" ><a href="<?php echo home_url(); ?>" rel="nofollow"><div id="header-title-1">Story Archival Project</a></h1>
							</div>
							<h3 id="subheader-text">10 years of live, unscripted stories</h3>
						</div>
					</div>
					<div id="header-button-wrapper">
						<div id="header-buttons">
							<a class="col1_3 header-button" data-fancybox data-src="#about-modal" href="#0">
								<h3>What is Secretly Y'all?</h3>
							</a>
							<a class="col1_3 header-button" data-fancybox data-src="#support-modal" href="#0">
								<h3>Support the Archive</h3>
							</a>
							<a class="col1_3 header-button" href="https://www.secretlyall.org/so-you-want-to-tell/" target="_blank">
								<h3>Want to Tell a Story?</h3>
							</a>	
						</div>
					</div>
				</div>
				<div id="hamburger-menu">
					<div id="hamburger-buttons-wrapper">
						<a class="col1_3 hamburger-menu-item" data-fancybox data-src="#about-modal" href="#0">
							<h2>What is Secretly Y'all?</h2>
						</a>						
						<a class="col1_3 hamburger-menu-item" data-fancybox data-src="#support-modal" href="#0">
							<h2>Support the Archive</h2>
						</a>						
						<a class="col1_3 hamburger-menu-item" href="https://www.secretlyall.org/so-you-want-to-tell/" target="_blank">
							<h2 >Want to Tell a Story?</h2>
						</a>
					</div>
				</div>
				<a id="hamburger-icon" href="#0" class="header-icon" onclick="openHamburger()"></a>

	
					</div>	
					<?php // if you'd like to use the site description you can un-comment it below ?>
					<?php // bloginfo('description'); ?>




				</div>

			</header>