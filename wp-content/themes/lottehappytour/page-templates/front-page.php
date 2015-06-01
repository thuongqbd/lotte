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
							<td class="first"><h2>HAPPY DIARY</h2></td>
							<td class="second"></td>
							<td class="line-title">&nbsp;</td>
						</tr>
					</table>
				</div>
				<?php echo do_shortcode('[happydiary_topReadingbyFBLikeOrCommentCount]');?>
			</div>
			<?php echo do_shortcode('[usersultra_happy_moment_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_happy_spirit_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_latest_member_home_page]');?>
			<?php echo do_shortcode('[happydiary_lastestNews]');?>
		</div>
	</section>
<?php // get_sidebar( 'front' ); ?>
<?php get_footer(); ?>