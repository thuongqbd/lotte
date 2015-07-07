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
<?php
if (function_exists('yoast_breadcrumb')) {
	yoast_breadcrumb('<p id="breadcrumbs">', '</p>');
}
?>
<div class="container">
    
    <div class="title-home happy-diary-title">
        <table cellspacing="0" cellpadding="0">
            <tr>
                <td class="first"><h2><?php
							$cat = get_the_category();
							echo $cat[0]->name;
							?></h2></td>
                <td class="second"><img src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow.png" alt=""/></td>
                <td class="line-title">&nbsp;</td>

            </tr>
        </table>
    </div>
	<div class="group">
		<div class="happy-diary-detail">
			<div class="detail-content">
				<?php
				while (have_posts()) : the_post();
					?>
					<!-- happy diary news -->

					<div class="detail-nature clearfix">
						<div class="detail-positon-nature">
																
							<h1 class="post-title" ><?php the_title(); ?></h1>
							<div class="meta" <time datetime="<?php echo get_the_date('H:s:i d/m/Y'); ?>" 
													data-view_count="<?php the_field('view_count') ?>"
													data-fb_like_count="<?php the_field('fb_like_count') ?>"
													data-fb_share_count="<?php the_field('fb_share_count') ?>"
													data-fb_comment_count="<?php the_field('fb_comment_count') ?>">
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
					<div class="other-post">
						<h3>Bài viết khác</h3>
						<?php $args = array(
							'posts_per_page'   => 5,
							'offset'           => 0,
							'category'         => '',
							'category_name'    => '',
							'orderby'          => 'date',
							'order'            => 'DESC',
							'include'          => '',
							'exclude'          => $post->ID,
							'meta_key'         => '',
							'meta_value'       => '',
							'post_type'        => 'post',
							'post_mime_type'   => '',
							'post_parent'      => '',
							'author'	   => '',
							'post_status'      => 'publish',
							'suppress_filters' => true 
						);
						$posts_array = get_posts( $args ); 
						$myposts = get_posts( $args );
						if($myposts):
							?>
						<ul>
						<?php
						foreach ( $myposts as $post ) : setup_postdata( $post ); ?>
							<li>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><span><?php the_date('d.m.Y');?></span> - <?php the_title(); ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
						<?php
						endif;
						wp_reset_postdata();?>
						
						
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

<?php get_footer(); ?>