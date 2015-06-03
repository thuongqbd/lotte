<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
global $post;
get_header();
?>
<?php
if (function_exists('yoast_breadcrumb')) {
	yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
}
?>
<div class="container">
	<div class="title-home happy-diary-title">
		<table cellspacing="0" cellpadding="0">
			<tbody><tr>
					<td class="first"><h2><?php
							$cat = get_the_category();
							echo $cat[0]->name;
							?></h2></td>
					<td class="second"></td>
					<td class="line-title">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="group">
		<div class="happy-diary-detail">
			<div class="detail-content">

				<?php
				while (have_posts()) : the_post();
					$style = "";
					if (!has_post_thumbnail()) {
						$style = 'style="color:#000"';
					}
					?>
					<!-- happy diary news -->

					<div class="detail-nature clearfix">
						<div class="detail-positon-nature">
							<h2 class="hightlight_text"><?php the_field('hightlight_text') ?></h2>									
							<h1 data-view-count="<?php the_field('view_count') ?>" class="post-title" <?php echo $style; ?>><?php the_title(); ?></h1>
							<div class="meta" <time datetime="<?php echo get_the_date('H:s:i d/m/Y'); ?>">
								<span class="time">
									<?php echo get_the_date('H:s:i'); ?>
								</span><span class="date">
									<?php echo get_the_date('d/m/Y'); ?>
								</span>
							</div>
							
						</div>								
					</div>
					<div class="happy-diary-content clearfix">
						<?php // if (has_post_thumbnail()): ?>
							<?php // the_post_thumbnail('full'); ?>
						<?php // endif; ?>
						<?php the_content(); ?>                                    
					</div>
					<!-- end happy diary news -->
					<?php // comments_template( '', false );     ?>

				<?php endwhile; // end of the loop.    ?>					
				<?php if (is_active_sidebar('sidebar-4')) : ?>		
					<?php dynamic_sidebar('sidebar-4'); ?>
				<?php endif; ?>
			</div>
			<div class="detail-related">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<?php
if ($_SERVER['SERVER_NAME'] == 'happytourlotteria.vn') {
	// PRODUCTION	
	update_field('view_count', get_field('view_count') + 1, $post->ID);
	$link = get_permalink($post->ID);

	$fql = "SELECT url, normalized_url, share_count, like_count, comment_count, ";
	$fql .= "total_count, commentsbox_count, comments_fbid, click_count FROM ";
	$fql .= "link_stat WHERE url = '$link'";

	$apifql = "https://api.facebook.com/method/fql.query?format=json&query=" . urlencode($fql);
	$response = file_get_contents($apifql);
	$json_data = json_decode($response);
	if (!empty($json_data)) {
		$fb_share_count = $json_data[0]->share_count;
		$fb_like_count = $json_data[0]->like_count;
		$fb_comment_count = $json_data[0]->comment_count;
		update_field('fb_like_count', $fb_like_count, $post->ID);
		update_field('fb_share_count', $fb_share_count, $post->ID);
		update_field('fb_comment_count', $fb_comment_count, $post->ID);
	}
}
?>
<?php get_footer(); ?>