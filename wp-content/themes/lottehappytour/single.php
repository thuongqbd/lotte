<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
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
				
						<?php while (have_posts()) : the_post(); 
							$style = "";
							if(!has_post_thumbnail()){
								$style = 'style="color:#000"';
							}								
						?>
							<!-- happy diary news -->

							<div class="detail-nature">
								<div class="detail-positon-nature">
									<h2 class="hightlight_text"><?php the_field('hightlight_text') ?></h2>									
									<h1 class="post-title" <?php echo $style; ?>><?php the_title(); ?></h1>
								</div>
								<?php if(has_post_thumbnail()):?>
									<?php the_post_thumbnail('full'); ?>
								<?php endif;?>
							</div>
							<div class="happy-diary-content">                                    
								<?php the_content(); ?>                                    
							</div>
							<!-- end happy diary news -->
							<?php // comments_template( '', false );    ?>

						<?php endwhile; // end of the loop.    ?>					
			</div>
			<div class="detail-related">
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>