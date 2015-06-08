<?php
/**
 * Template Name: HAPPY MEMBERS
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
global $post;
?>
<?php
if (function_exists('yoast_breadcrumb')) {
	yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
}
?>
<link href="<?= get_template_directory_uri()?>/css/moment.css" rel="stylesheet" type="text/css">
	<section id="primary" class="site-content">
		<div id="content" role="main">
			<div class="container member">
			<?php while ( have_posts() ) : the_post(); ?>
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
					<div class="member-container">
					<?php the_content(); ?>
					</div>
			<?php endwhile; // end of the loop. ?>
			</div>
		</div>
	</section>
<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>