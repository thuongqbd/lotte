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

	
			<div class="container">
				<div class="title-home happy-diary-title">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<td class="first"><h2>Phượt ký</h2></td>
							<td class="second"><img src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow.png" alt=""/></td>
							<td class="line-title">&nbsp;</td>
                        
						</tr>
					</table>
				</div>
				<?php echo do_shortcode('[happydiary_tinmoinhat]');?>
				
				<!-- slider happy diary news home page slider -->				
				
				<!-- end slider happy diary news home page slider -->							
			</div>
			<?php echo do_shortcode('[usersultra_happy_moment_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_happy_spirit_home_page video_page_id="24" photo_page_id="28"]');?>
			<?php echo do_shortcode('[usersultra_latest_member_home_page]');?>
			<?php echo do_shortcode('[happydiary_tintieudiem]');?>
			
<?php // get_sidebar( 'front' ); ?>
<?php get_footer(); ?>