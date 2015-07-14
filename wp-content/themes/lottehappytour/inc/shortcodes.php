<?php
// shortcode for happydiary_topReadingbyFBLikeOrCommentCount
add_shortcode('happydiary_topReadingbyFBLikeOrCommentCount', 'happydiary_topReadingbyFBLikeOrCommentCount');
function happydiary_topReadingbyFBLikeOrCommentCount() {
	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '6',
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

// The Loop
	if ($query->have_posts()) {	
		
		$ret = '<div class="group happy-diary happy-diary-group-home " data-found_posts="'.$query->found_posts.'">';		
		$ret .='<div class="like-page-guu-3">';
		if(is_category('happy-diary')){
			$ret .='<h3>Tin đọc nhiều nhất</h3>';
		}
		$ret .='<ul>';
		while ($query->have_posts()) {
			$query->the_post();
			$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
			$ret .= '<li><a href="'.  get_the_permalink(get_the_ID()).'" title="'.  get_the_title(get_the_ID()).'">'
							.'<span><strong>'. get_the_title(get_the_ID()).'</strong></span>'
							.swe_wp_get_attachment_image($post_thumbnail_id,array(293,220),false)						
					. '</a></li>';						
		}		
		$ret .="</div></ul></div>";
	} else {
		// no posts found
		return;
	}
// Restore original Post Data
	wp_reset_postdata();

	return $ret;
}

// shortcode for happydiary_topReadingbyFBLikeOrCommentCount
add_shortcode('happydiary_topReadingbyFBLikeOrCommentCount_sp', 'happydiary_topReadingbyFBLikeOrCommentCount_sp');
function happydiary_topReadingbyFBLikeOrCommentCount_sp() {

	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
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
	
// The Loop
	if ($query->have_posts()) {
		
			$ret = '<div class="group" data-found_posts="'.$query->found_posts.'">
						<div class="slider-mobile">
							<div class="carousel-wrapper-header">
								<div class="jcarouselheader-mobile">
									<ul id="">
								';

		
		while ($query->have_posts()) {
			$query->the_post();
			
			//do something
				$ret .='				<li>
											<div class="mobile-item">
												<h2><a href="'.  get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></h2>
												<p>'.get_the_excerpt().'
												</p>
												'. get_the_post_thumbnail(get_the_ID(),array(738,554)).'
											</div>
										</li>';		
		}
			$ret .='				</ul>
								</div>
							</div>
						
							<div class="control-mobile-slider">
								<a href="#" class="pre jcarousel-control-prev-mobile"></a>
								<a href="#" class="next jcarousel-control-next-mobile"></a>
							</div>
						</div>
					</div>';
		
	} else {
		// no posts found
		return;
	}

// Restore original Post Data
	wp_reset_postdata();

	return $ret;
}

// shortcode for happydiary_lastestNews
add_shortcode('happydiary_lastestNews', 'happydiary_lastestNews');
function happydiary_lastestNews() {

	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date'	
	);

// The Query
	$query = new WP_Query($args);

// The Loop
	if ($query->have_posts()) {
		
		$ret = ' <div class="container">
                    <!-- lastest news -->
                    <div class="group happy-member latest-news-homepage">
                        <div class="content-happy-member">
                            <div class="happy-members-slider lastest-slider">
                                <div class="title-lastest-news" data-found_posts="'.$query->found_posts.'"><h2>Tin mới nhất</h2></div>
                                <div id="lastest-news">
                                    <div class="jcarousel-wrapper">
                                        <div class="jcarousel jcarousel3">
                                            <ul>';
								while ($query->have_posts()) {
									$query->the_post();
									$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
									//do something

									$ret .= ' <li class="item">
                                                    <div class="item-list">
														<a href="'.  get_permalink().'" title="'.  get_the_title().'">
                                                        '.  swe_wp_get_attachment_image($post_thumbnail_id, array(243,176))
														
														.'</a>
                                                        <p><a href="'.  get_permalink().'" title="'.  get_the_title().'">'.  get_the_title().'</a></p>
                                                    </div>
                                                </li>';
								}
								$ret .= '	</ul>
										</div>
                                    </div>
                                </div>

                                <div class="controll-lastest group-dots-control">
                                    <div class="news-controll-lastest">
                                        <a href="#" class="pre jcarousel-control-prev3">Cũ hơn</a>
                                        <a href="#" class="next jcarousel-control-next3">Mới hơn</a>
                                    </div>	
                                </div>
                            </div>
                        </div>

                    </div> 
                    <!--end lastest news  -->
                </div>'; 
	} else {
		// no posts found
		return;
	}

// Restore original Post Data
	wp_reset_postdata();
	return $ret;
}

// shortcode for happydiary_tindocnhieunhat
add_shortcode('happydiary_TieuDiemAndNoiBat', 'happydiary_TieuDiemAndNoiBat');
function happydiary_TieuDiemAndNoiBat() {
	
	
	$ret = '<div class="group">
				<div class="happy-diary-block">';
	
	// WP_Query arguments
//	$args = array(
//		'post_status' => 'publish',
//		'category_name' => 'happy-diary',
//		'pagination' => false,		
//		'posts_per_page' => '6',
//		'order' => 'DESC',
//		'orderby' => 'date',
//		'meta_key'=> 'diary_type',
//		'meta_value'=> 'tieudiem',
//		'date_query' => array(
//			array(
//				'column' => 'post_date_gmt',
//				'before' => '1 week ago',
//			),
//		),
		
//	);

// The Query
//	$query = new WP_Query($args);
	
// The Loop
//	if ($check1 = $query->have_posts()) {		
//		
//		$ret .='	<div class="tieudiem like-page-guu-3" data-found_posts="'.$query->found_posts.'">';
//		$ret .='	<h3>Tin tiêu điểm</h3> ';
//		$ret .=			'<ul>';
//		while ($query->have_posts()) {
//			$query->the_post();		
//			$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
//						
//			$ret .= '		<li>
//								<a href="'.  get_permalink().'" title="'.  get_the_title() .'">'
//									.'<span><strong>'.get_the_title().'</strong></span>'
//									.swe_wp_get_attachment_image($post_thumbnail_id,array(293,220),false)
//								.'</a>									
//							</li>
//							';
//		}
//			$ret .='	</ul>
//					</div><!-- end of tieudiem -->
//				';					
//	} else {
//		// no posts found
////		return;
//	}

// Restore original Post Data
//	wp_reset_postdata();
	// WP_Query arguments
	$args2 = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_key'=> 'diary_type',
		'meta_value'=> 'noibat',
		
	);
/*----------------------------------------------------------------------------*/
// The Query
	$query2 = new WP_Query($args2);
	
// The Loop
	if ($check2 = $query2->have_posts()) {				
		
		$ret .='		<div class="noibat like-page-guu-4" data-found_posts="'.$query2->found_posts.'">
						<h3>Tin nổi bật</h3>
						<ul>
							
								';
		
		while ($query2->have_posts()) {
			$query2->the_post();		
			$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
			$ret .= '	<li>
							<a href="'.  get_permalink($query2->post->ID).'" title="'.  get_the_title($query2->post->ID) .'">'
									.swe_wp_get_attachment_image($post_thumbnail_id,array(293,220),false)
									.'<span>'.get_the_title($query2->post->ID).'</span>'.'</a>

						</li>
						';
		}
				
			$ret .='			
							
						</ul>
					</div><!-- end of feature noibat -->
				';					
	} else {
		// no posts found
		//return;
	}
	$ret .= '</div></div>';
// Restore original Post Data
	wp_reset_postdata();	
	return $ret;
	
}

//happydiary_NoiBat_SP
add_shortcode('happydiary_NoiBat_SP', 'happydiary_NoiBat_SP');
function happydiary_NoiBat_SP(){
	
	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '4',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_key'=> 'diary_type',
		'meta_value'=> 'noibat',
		
	);
/*----------------------------------------------------------------------------*/
// The Query
	$query = new WP_Query($args);
	$ret = "";
// The Loop
	if ($query->have_posts()) {				
		$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
		$ret .='<div class="category-happy-diary-slider" data-found_posts="'.$query->found_posts.'">
					<div class="jcarousel-wrapper">
						<div class="jcarouselheader-category">
							<ul>';
		
		while ($query->have_posts()) {
			$query->the_post();		
			//do something
			
				$ret .='			
								<li class="item">
									<p><a href="'.  get_permalink().'" title="'.  get_the_title() .'">'.  get_the_title().'</a></p>
									<a href="'.  get_permalink().'" title="'.  get_the_title() .'">'.get_the_post_thumbnail(get_the_ID(),array(738,554)).'</a>
								</li>';
			
		}			
			$ret .='		</ul>
						</div>
					</div>
					<div class="category-dots-control">
						<a href="#" class="pre jcarousel-control-prev-category" data-jcarouselcontrol="true"></a>
						<a href="#" class="next jcarousel-control-next-category" data-jcarouselcontrol="true"></a>
					</div>
				</div>';				
	} else {
		// no posts found
		//return;
	}

// Restore original Post Data
	wp_reset_postdata();
	return $ret;
}

//happydiary_detail_otherpost
add_shortcode('happydiary_detail_otherpost', 'happydiary_detail_otherpost');
function happydiary_detail_otherpost(){
	global $post;
	$re = '
		<div class="other-post">
			<h3>Tin khác</h3>';
	$args = array(
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
	 
	$myposts = get_posts( $args );
	if($myposts):
		$re .='<ul>';
	foreach ( $myposts as $post ) : setup_postdata( $post ); 
		$re .='<li><a href="'.get_the_permalink($post->ID).'" title="'.get_the_title($post->ID).'"><span>'. get_the_date('d.m.Y', $post->ID).'</span> - '.get_the_title($post->ID).'</a></li>';		
	endforeach;
	$re .='</ul>';
	
	endif;
	wp_reset_postdata();

	$re .='</div>';
	return $re;
}

// shortcode for happydiary_tinmoinhat
add_shortcode('happydiary_tinmoinhat', 'happydiary_tinmoinhat');
function happydiary_tinmoinhat() {
	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '6',		
	);

// The Query
	$query = new WP_Query($args);

// The Loop
	if ($query->have_posts()) {	
		
		$ret = '<div class="group happy-diary happy-diary-group-home " data-found_posts="'.$query->found_posts.'">';		
		$ret .='<div class="like-page-guu-3">';
		if(is_category('happy-diary')){
			$ret .='<h3>Tin mới nhất</h3>';
		}
		$ret .='<ul>';
		while ($query->have_posts()) {
			$query->the_post();
			$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
			$ret .= '<li><a href="'.  get_the_permalink(get_the_ID()).'" title="'.  get_the_title(get_the_ID()).'">'
							.'<span><strong>'. get_the_title(get_the_ID()).'</strong></span>'
							.swe_wp_get_attachment_image($post_thumbnail_id,array(293,220),false)						
					. '</a></li>';						
		}		
		$ret .="</div></ul></div>";
	} else {
		// no posts found
		return;
	}
// Restore original Post Data
	wp_reset_postdata();

	return $ret;
}

// shortcode for happydiary_tintieudiem
add_shortcode('happydiary_tintieudiem', 'happydiary_tintieudiem');
function happydiary_tintieudiem() {

	// WP_Query arguments
	$args = array(
		'post_status' => 'publish',
		'category_name' => 'happy-diary',
		'pagination' => false,		
		'posts_per_page' => '15',
		'order' => 'DESC',
		'orderby' => 'date',
		'meta_key'=> 'diary_type',
		'meta_value'=> 'tieudiem',
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

// The Loop
	if ($query->have_posts()) {
		
		$ret = ' <div class="container">
                    <!-- lastest news -->
                    <div class="group happy-member latest-news-homepage">
                        <div class="content-happy-member">
                            <div class="happy-members-slider lastest-slider">
                                <div class="title-lastest-news" data-found_posts="'.$query->found_posts.'"><h2>Tin tiêu điểm</h2></div>
                                <div id="lastest-news">
                                    <div class="jcarousel-wrapper">
                                        <div class="jcarousel jcarousel3">
                                            <ul>';
								while ($query->have_posts()) {
									$query->the_post();
									$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
									//do something

									$ret .= ' <li class="item">
                                                    <div class="item-list">
														<a href="'.  get_permalink().'" title="'.  get_the_title().'">
                                                        '.  swe_wp_get_attachment_image($post_thumbnail_id, array(243,176))
														
														.'</a>
                                                        <p><a href="'.  get_permalink().'" title="'.  get_the_title().'">'.  get_the_title().'</a></p>
                                                    </div>
                                                </li>';
								}
								$ret .= '	</ul>
										</div>
                                    </div>
                                </div>

                                <div class="controll-lastest group-dots-control">
                                    <div class="news-controll-lastest">
                                        <a href="#" class="pre jcarousel-control-prev3">Cũ hơn</a>
                                        <a href="#" class="next jcarousel-control-next3">Mới hơn</a>
                                    </div>	
                                </div>
                            </div>
                        </div>

                    </div> 
                    <!--end lastest news  -->
                </div>'; 
	} else {
		// no posts found
		return;
	}

// Restore original Post Data
	wp_reset_postdata();
	return $ret;
}