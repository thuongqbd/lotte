<?php
/**
 * Template Name: Front Page Template
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<div class="container">
				<div class="title-home happy-diary-title">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td class="first"><h2>Phượt ký</h2></td>
							<td class="second"></td>
							<td class="line-title">&nbsp;</td>
						</tr>
					</table>
				<?php echo do_shortcode('[happydiary_topReadingbyFBLikeOrCommentCount]');?>
				
				<!-- slider happy diary news home page slider -->
				<div class="group">
					<div class="slider-mobile">
						<div class="carousel-wrapper-header">
							<div class="jcarouselheader-mobile">
								<ul id="slider-header">
									<li>
										<div class="mobile-item">
											<h2><a href="#">Mùa thu lành lặn</a></h2>
											<p>Phượt có nghĩa là cưỡi xe máy nhong nhong.
												Sai bét! Ngay cả khi đi tàu hoả, máy bay, xe đạp...
												hoặc đi bộ cũng gọi là phượt.
											</p>
											<img src="<?php echo get_template_directory_uri(); ?>/uploads/test.jpg" alt=""/>
										</div>
									</li>
									<li>
										<div class="mobile-item">
											<h2><a href="#">abc Mùa thu lành lặn</a></h2>
											<p>Phượt có nghĩa là cưỡi xe máy nhong nhong.
												Sai bét! Ngay cả khi đi tàu hoả, máy bay, xe đạp...
												hoặc đi bộ cũng gọi là phượt.
											</p>
											<img src="<?php echo get_template_directory_uri(); ?>/uploads/test.jpg" alt=""/>
										</div>
									</li>

								</ul>
							</div>
						</div>
						
						<div class="control-mobile-slider">
							<a href="#" class="pre jcarousel-control-prev-mobile"></a>
							<a href="#" class="next jcarousel-control-next-mobile"></a>
						</div>
					</div>
				</div>
				<!-- end slider happy diary news home page slider -->
				
				
			</div>
			<?php echo do_shortcode('[usersultra_happy_moment_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_happy_spirit_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_latest_member_home_page]');?>
			<?php echo do_shortcode('[happydiary_lastestNews]');?>
	
<?php // get_sidebar( 'front' ); ?>
<?php get_footer(); ?>