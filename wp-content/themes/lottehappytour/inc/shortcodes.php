<?php

// shortcode for happydiary_topReadingbyFBLikeOrCommentCount
add_shortcode('happydiary_topReadingbyFBLikeOrCommentCount', 'happydiary_topReadingbyFBLikeOrCommentCount');

function happydiary_topReadingbyFBLikeOrCommentCount() {

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
			$post_thumbnail_id = get_post_thumbnail_id(get_the_ID() );
			//do something
			if($i==1){
				$ret .= '<div class="hot">
							<div class="img">
								<div class="position-hot">
									<a href="'.  get_the_permalink().'" title='.  get_the_title().'>
										<span class="news-hot">'.  get_field('hightlight_text').'</span>
										<span class="icon-next"></span>
									</a>
								</div>
								<a href="'.  get_the_permalink().'" title='.  get_the_title().'>'.
								swe_wp_get_attachment_image($post_thumbnail_id,array(215,'240c'))															
								.'</a>
							</div>
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
								<a href="'.  get_the_permalink().'" title='.  get_the_title().'>'.  swe_wp_get_attachment_image($post_thumbnail_id,array(485,323)).'</a>
							</div>
						</div>';
			}
			
			if($i==3){
				$ret_3 = '<div class="item-happy-diary">
							<div class="image-beauty">
								<p class="beauty"><span>'.  get_field('hightlight_text').'</span></p>
								<div class="img">
									<a href="'.  get_the_permalink().'" title='.  get_the_title().'>
										'.swe_wp_get_attachment_image($post_thumbnail_id,array(242,'160c')).'
									</a>
								</div>
							</div>
							<div class="louping">
								<h2>'.  get_the_title().'</h2>
								<p>'.  get_the_excerpt().'</p>
								<p class="louping-bottom"></p>
							</div>
						</div>';
			}
			if($i==4){
				$ret_4 ='<div class="item-happy-diary">
							<div class="louping-group-1">
								<a href="'.  get_the_permalink().'" title='.  get_the_title().'>
									'.swe_wp_get_attachment_image($post_thumbnail_id,array(352,'210c')).'
								</a>
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
// shortcode for happydiary_lastestNews
add_shortcode('happymembers_homepage', 'happymembers_homepage');

function happymembers_homepage() {

	$ret = '<div class="container">
                    <!-- happy members --> 
                    <div class="group happy-member">
                        <div class="content-happy-member">
                            <div class="happy-members-slider">
                                <div class="jcarousel-wrapper">
                                    <div class="jcarousel jcarousel2">
                                        <ul>
                                            <li class="item">
                                                <div class="item-list">
                                                    <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                    <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                     <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                     <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                     <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                     <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>
                                            <li class="item">
                                                <div class="item-list">
                                                     <img src="'.get_template_directory_uri().'/images/uploads/slider.jpg" alt=""/>
                                                    <p>Naivebambi</p>
                                                </div>
                                            </li>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="title-happy-members">
                                <h2>Happy members</h2>
                                <div class="group-dots-control">
                                    <a href="#" class="next jcarousel-control-prev2"></a>
                                    <a href="#" class="pre jcarousel-control-next2"></a>	`
                                </div>
                            </div>
                        </div>


                    </div> 
                    <!-- end happy members  -->
                </div>';

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
                    <div class="group happy-member">
                        <div class="content-happy-member">
                            <div class="happy-members-slider lastest-slider">
                                <div class="title-lastest-news"><h2>Lastest news</h2></div>
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
                                                        '.  swe_wp_get_attachment_image($post_thumbnail_id, array(258,158))
														
														.'</a>
                                                        <p><a href="'.  get_permalink().'" title="'.  get_the_title().'">'.  get_the_title().'</a> <span class="date">'.  get_the_date().'</span></p>
                                                    </div>
                                                </li>';
								}
								$ret .= '	</ul>
										</div>
                                    </div>
                                </div>

                                <div class="controll-lastest group-dots-control">
                                    <div class="news-controll-lastest">
                                        <a href="#" class="pre jcarousel-control-prev3">Previous</a>
                                        <a href="#" class="next jcarousel-control-next3">Next</a>
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