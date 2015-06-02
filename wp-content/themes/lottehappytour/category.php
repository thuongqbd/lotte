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

get_header(); 
$cat = get_query_var('cat');
$cate = get_category($cat);
?>
<?php if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb('<p id="breadcrumbs">','</p>');
	} ?>	
	<div class="container">			

		<div class="title-home happy-diary-title">
			<table cellspacing="0" cellpadding="0">
				<tr>
					<td class="first"><h2><?php echo $cate->name;?></h2></td>
					<td class="second"></td>
					<td class="line-title">&nbsp;</td>
				</tr>
			</table>
		</div>

		<?php 
		echo do_shortcode('[happydiary_TieuDiemAndNoiBat]');
		echo do_shortcode('[happydiary_topReadingbyFBLikeOrCommentCount]');
		?>
	</div>
<?php echo do_shortcode( '[happydiary_lastestNews]' );?>
	
<?php get_footer(); ?>
