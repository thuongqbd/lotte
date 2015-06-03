<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php wp_title('|', true, 'right'); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>
		<?php if($_SERVER['SERVER_NAME']=='happytourlotteria.vn') {
			// PRODUCTION	
			include_once("inc/analyticstracking.php") ;
			} ?>
		<div class="main-menu-mobile"></div>
		<div class="mobile-menu">
			<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</div>
		
		
		<div id="page" class="hfeed site">
			<div class="main">
				<div class="container">
					<!-- header -->
					<header class="header">
						<a class="drop-down-menu">	
						</a>
						<div class="carousel-wrapper-header">
							<div class="jcarouselheader">
								<ul id="slider-header">
									<?php
									$headers = get_uploaded_header_images();
									shuffle($headers);
									foreach ($headers as $header) {
										?>
										<li><a href="#"><img src="<?php echo $header['url']; ?>" alt=""/></a></li>
										<?php
									}
									?>

								</ul>
							</div>
						</div>
						<p class="jcarousel-pagination-header"></p>
						<div class="user_menu">
							<div class="container">
								<ul>
								<?php  if ( is_user_logged_in() ) {									
									?>
									<li class="logout">
										<a href="<?php echo home_url()?>/wp-login.php?action=logout">Thoát</a>
									</li>
									<?php
								}else{
									$sign_up = get_page_by_path('registration');
									$login = get_page_by_path('login');
									?>
									<li class="login">
										<a href="<?php echo get_permalink($login->ID)?>" title="<?php echo $login->post_title;?>">
											<?php echo $login->post_title;?>
										</a>
									</li>
									<li class="sign-up">
										<a href="<?php echo get_permalink($sign_up->ID)?>" title="<?php echo $sign_up->post_title;?>">
											<?php echo $sign_up->post_title;?>
										</a>
									</li>
									
									<?php
								}  ?>
								</ul>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function () {
								$('.jcarouselheader').jcarouselAutoscroll({
									autostart: true,
									interval: 5000,
									target: '+=1',
								}).jcarousel({
									wrap: 'circular'
								});
							});
						</script>
					</header>

					<!-- end header -->
				</div>
				<div class="container">
					<div class="menutop">
						<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
					</div>
				</div>
				<div class="content-page">
					
