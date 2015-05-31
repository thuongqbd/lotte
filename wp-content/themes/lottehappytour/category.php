<?php
/**
 * The template for displaying Category pages
 *
 * Used to display archive-type pages for posts in a category.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */

get_header(); ?>
<?php if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	} ?>
	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<div class="container">
				<div class="title-home happy-diary-title">
					<div class="title">
						<h2>HAPPY DIARY</h2></div>
						<span class="span"></span>	
				</div>
				<?php 
				echo do_shortcode('[happydiary_TieuDiemAndNoiBat]');
				echo do_shortcode('[happydiary_topReadingbyFBLikeOrCommentCount]');
				?>
			</div>
		<?php echo do_shortcode( '[happydiary_lastestNews]' );?>

		</div><!-- #content -->
	</section><!-- #primary -->
	
<?php get_footer(); ?>
