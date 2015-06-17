<?php
/**
 * The template for displaying Search Results pages
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
                <td class="first"><h2>Kết quả tìm kiếm</h2></td>
                <td class="second"><img src="<?php echo get_template_directory_uri(); ?>/images/breadcrumb-arrow.png" alt=""/></td>
                <td class="line-title">&nbsp;</td>

            </tr>
        </table>
    </div>
	<div class="group">
		<div class="happy-diary-detail">
			<div class="detail-content">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'lottehappytour' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
			</header>

			<?php lottehappytour_content_nav( 'nav-above' ); ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
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
			<?php endwhile; ?>

			<?php lottehappytour_content_nav( 'nav-below' ); ?>

		<?php else : ?>

			<article id="post-0" class="post no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'Nothing Found', 'lottehappytour' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'lottehappytour' ); ?></p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

		<?php endif; ?>
		
		</div><!-- #content -->
		<div class="detail-related">
			<?php get_sidebar(); ?>
		</div>
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>