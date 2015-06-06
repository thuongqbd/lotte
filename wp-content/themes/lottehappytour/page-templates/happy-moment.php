<?php
/**
 * Template Name: HAPPY MOMENT
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
get_header(); 
wp_enqueue_script( 'moment', get_template_directory_uri().'/js/moment.js');
wp_enqueue_style( 'moment', get_template_directory_uri().'/css/moment.css');
global $post;
?>
	<section id="primary" class="site-content">
		<div id="content" role="main">
		<div class="container moment <?= $post->post_name?> moment-detail">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-page-image">
					<?php the_post_thumbnail(); ?>
				</div><!-- .entry-page-image -->
			<?php endif; ?>
				<div class="title-home happy-diary-title">
						<table cellspacing="0" cellpadding="0">
							<tbody>
								<tr>
									<td class="first"><h2><?php the_title(); ?></h2></td>
									<td class="second"><img src="<?= get_template_directory_uri()?>/images/breadcrumb-arrow.png" alt=""></td>
									<td class="line-title">&nbsp;</td>
								</tr>
							</tbody>
						</table>
					</div>
				<div class="group">
				<?php the_content(); ?>
				</div>
		<?php endwhile; // end of the loop. ?>
				<?php if($post->post_parent):?>
				<div class="facebook-widget">
					<div id="fb-like-share">
						<div class="fb-like" data-href="<?php echo site_url().$_SERVER['REQUEST_URI']?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
					</div>					
					<div id="fb-comments">
						<div class="fb-comments" data-href="<?php echo site_url().$_SERVER['REQUEST_URI']?>" data-numposts="10" data-colorscheme="light"></div>
					</div>
				</div>
				<?php endif?>
		</div>
		</div>
	</section>

	
<?php get_sidebar( 'front' ); ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=456273237869405";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php get_footer(); ?>