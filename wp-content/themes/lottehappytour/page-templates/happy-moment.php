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
global $post;
?>
<link href="<?= get_template_directory_uri()?>/css/moment.css" rel="stylesheet" type="text/css">
	<div class="container <?= $post->post_name?> moment-detail">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-page-image">
					<?php the_post_thumbnail(); ?>
				</div><!-- .entry-page-image -->
			<?php endif; ?>
				<div class="title-home">
					<div class="title">
						<h2><?php the_title(); ?></h2>
					</div>
					<span class="span"></span>
				</div>
				<div class="group">
				<?php the_content(); ?>
				</div>
		<?php endwhile; // end of the loop. ?>
	</div>
<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>