<?php

// shortcode for Last Minute Deals
add_shortcode('happydiary_topReadingbyFBLikeOrCommentCount', 'happydiary_topReadingbyFBLikeOrCommentCount');

function happydiary_topReadingbyFBLikeOrCommentCount() {

	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,
		'meta_key' => 'fb_like_count',
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'fb_like_count fb_comment_count date',
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'fb_like_count',
				'value' => '0',
				'compare' => '>',
			),
			array(
				'key' => 'fb_comment_count',
				'value' => '0',
				'compare' => '>',
			)			
		),
	);

// The Query
	$query = new WP_Query($args);
//	var_dump($query);
// The Loop
	if ($query->have_posts()) {
		$ret = '<div class="container">';
	
			$ret .='<div class="title-home happy-diary-title">
						<div class="title">
							<h2>HAPPY DIARY</h2>
						</div>
						<span class="span"></span>
					</div>';
			$ret .= '<div class="group happy-diary">';

		$i = 1;
		$count = $query->found_posts;
		$ret_3=$ret_4='';
		while ($query->have_posts()) {
			$query->the_post();
			//do something
			if($i==1){
				$ret .= '<div class="hot">
							<div class="img">
								<div class="position-hot">
									<a href="'.  get_the_permalink().'" title='.  get_the_title().'>
										<span class="news-hot">'.  get_field('hightlight_text').'</span>
										<span class="icon-next"></span>
									</a>
								</div>'.
							get_the_post_thumbnail(get_the_ID(),array(215,240))
								
							.'</div>
							<div class="hot-description">
								<h3>'.  get_the_title().'</h3>
								<p>'.  get_the_excerpt().'</p>
							</div>
						</div>';
			}
			if($i==2){
				$ret .= '<div class="news-happy-diary">
							<h2><a href="'.  get_permalink().'">'.  get_the_title().'</a></h2>
							<div class="img">
								<p>'.  get_the_excerpt().'</p>
								<a href="'.  get_the_permalink().'" title='.  get_the_title().'>'.  get_the_post_thumbnail(get_the_ID(),array(485,323)).'</a>
							</div>
						</div>';
			}
			
			if($i==3){
				$ret_3 = '<div class="item-happy-diary">
							<div class="image-beauty">
								<p class="beauty"><span>'.  get_field('hightlight_text').'</span></p>
								<div class="img">
									<a href="'.  get_the_permalink().'" title='.  get_the_title().'>
										'.get_the_post_thumbnail(get_the_ID(),array(242,160)).'
									</a>
								</div>
							</div>
							<div class="louping">
								<h2>Louping</h2>
								<p>'.  get_the_excerpt().'</p>
								<p class="louping-bottom"></p>
							</div>
						</div>';
			}
			if($i==4){
				$ret_4 ='<div class="item-happy-diary">
							<div class="louping-group-1">
								'.get_the_post_thumbnail(get_the_ID(),array(352,210)).'
							</div>
							<div class="louping-next"></div>
						</div>';
			}			
			$i++;			
		}
		if($count >=3){			
			$ret .='<div class="happy-diary-group">';
			$ret .= $ret_3.$ret_4;
			$ret .= '</div>'; //end of $ret .='<div class="happy-diary-group">';
		}
		$ret .= '</div>'; //end of $ret .= '<div class="group happy-diary">';
		$ret .= '</div>'; // end of $ret = '<div class="container">'; 
	} else {
		// no posts found
		return;
	}

// Restore original Post Data
	wp_reset_postdata();


	return $ret;
}
