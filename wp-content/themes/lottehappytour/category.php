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
                    <td class="second"><img src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow.png" alt=""/></td>
                    <td class="line-title">&nbsp;</td>

                </tr>
            </table>
        </div>
		
        <div class="category-happy-diary-slider">
            <div class="jcarousel-wrapper">
                <div class="jcarouselheader-category">
                    <ul>
                        <li class="item">
                            <p><a href="#">Mua thu la roi </a></p>
                            <img src="<?php echo get_template_directory_uri(); ?>/images/1.jpg" alt=""/>
                        </li>
                        <li class="item">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/2.jpg" alt=""/>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="category-dots-control">
                    <a href="#" class="pre jcarousel-control-prev-category" data-jcarouselcontrol="true"></a>
                    <a href="#" class="next jcarousel-control-next-category" data-jcarouselcontrol="true"></a>
            </div>
        </div>

		<?php 
		echo do_shortcode('[happydiary_TieuDiemAndNoiBat]');
		echo do_shortcode('[happydiary_topReadingbyFBLikeOrCommentCount]');
		?>
	</div>
<?php echo do_shortcode( '[happydiary_lastestNews]' );?>
	
<?php get_footer(); ?>
