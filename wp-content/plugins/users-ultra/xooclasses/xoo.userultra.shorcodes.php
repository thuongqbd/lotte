<?php
class XooShortCode {

	function __construct() 
	{		
		add_action( 'init',   array(&$this,'xoousers_shortcodes'));	
		add_action( 'init', array(&$this,'respo_base_unautop') );	
	}
	
	/**
	* Add the shortcodes
	*/
	function xoousers_shortcodes() 
	{	
	
	    add_filter( 'the_content', 'shortcode_unautop');			
		add_shortcode( 'usersultra_login', array(&$this,'usersultra_login_function') );
		add_shortcode( 'usersultra_logout', array(&$this,'usersultra_logout_function') );
		add_shortcode( 'usersultra_registration', array(&$this,'usersultra_registration_function') );
		add_shortcode( 'usersultra_my_messages', array(&$this,'usersultra_mymessages_function') );
		add_shortcode( 'usersultra_my_account', array(&$this,'usersultra_my_account_function') );
		add_shortcode( 'usersultra_directory', array(&$this,'usersultra_directory_function') );
		add_shortcode( 'usersultra_directory_mini', array(&$this,'usersultra_directory_mini_function') );
		add_shortcode( 'usersultra_searchbox', array(&$this,'usersultra_searchbox') );				
		
		add_shortcode( 'usersultra_profile', array(&$this,'usersultra_profile_function') );
		
		//Media ShortCodes
		add_shortcode( 'usersultra_photo_top_rated', array(&$this,'usersultra_photo_top_rated') );
		
		add_shortcode( 'usersultra_users_featured', array(&$this,'usersultra_featured_users') );
		add_shortcode( 'usersultra_users_promote', array(&$this,'usersultra_promote_users') );
		add_shortcode( 'usersultra_photos_promote', array(&$this,'usersultra_promote_photos') );
		
		 
		add_shortcode( 'usersultra_users_top_rated', array(&$this,'usersultra_top_rated_users') );
		add_shortcode( 'usersultra_users_most_visited', array(&$this,'usersultra_most_visited_users') );
		add_shortcode( 'usersultra_users_latest', array(&$this,'usersultra_latest_users') );		
		add_shortcode( 'usersultra_photo_latest', array(&$this,'usersultra_latest_photos') );
		
		add_shortcode( 'usersultra_images_grid', array(&$this,'usersultra_photo_grid') );		
		add_shortcode( 'usersultra_protect_content', array(&$this,'funnction_protect_content') );		
		add_shortcode( 'usersultra_front_publisher', array(&$this,'funnction_front_publisher') );
		
		//
		add_shortcode( 'one_third_first', array(&$this,'respo_base_grid_4_first') );
		add_shortcode( 'one_third',  array(&$this,'respo_base_grid_4'));
		add_shortcode( 'one_third_last',  array(&$this,'respo_base_grid_4_last'));
	
		add_shortcode( 'two_thirds_first',   array(&$this,'respo_base_grid_8_first'));
		add_shortcode( 'two_thirds',  array(&$this,'respo_base_grid_8'));
		add_shortcode( 'two_thirds_last',  array(&$this,'respo_base_grid_8_last') );
	
		add_shortcode( 'one_half_first',  array(&$this,'respo_base_grid_6_first') );
		add_shortcode( 'one_half',  array(&$this,'respo_base_grid_6') );
		add_shortcode( 'one_half_last',  array(&$this,'respo_base_grid_6_last'));
	
		add_shortcode( 'one_fourth_first',   array(&$this,'respo_base_grid_3_first'));
		add_shortcode( 'one_fourth',   array(&$this,'respo_base_grid_3'));
		add_shortcode( 'one_fourth_last',  array(&$this,'respo_base_grid_3_last'));
	
		add_shortcode( 'three_fourths_first',   array(&$this,'respo_base_grid_9_first'));
		add_shortcode( 'three_fourths',  array(&$this,'respo_base_grid_9'));
		add_shortcode( 'three_fourths_last',  array(&$this,'respo_base_grid_9_last'));
	
		add_shortcode( 'one_sixth_first',  array(&$this,'respo_base_grid_2_first'));
		add_shortcode( 'one_sixth',  array(&$this,'respo_base_grid_2'));
		add_shortcode( 'one_sixth_last',   array(&$this,'respo_base_grid_2_last'));
	
		add_shortcode( 'five_sixth_first',   array(&$this,'respo_base_grid_10_first'));
		add_shortcode( 'five_sixth', array(&$this,'respo_base_grid_10'));
		add_shortcode( 'five_sixth_last', array(&$this,'respo_base_grid_10_last') );			
		add_shortcode( 'respo_pricing',  array(&$this,'respo_pricing_shortcode') );

		add_shortcode( 'usersultra_latest_video_photo', array(&$this,'get_latest_video_photo') );
		add_shortcode( 'usersultra_happy_moment_child', array(&$this,'happy_moment_child') );
		add_shortcode( 'usersultra_happy_spirit', array(&$this,'happy_spirit') );
		
		add_shortcode( 'usersultra_happy_moment_home_page', array(&$this,'happy_moment_home_page') );
		add_shortcode( 'usersultra_happy_spirit_home_page', array(&$this,'happy_spirit_home_page') );
		add_shortcode( 'usersultra_latest_member_home_page', array(&$this,'latest_member_home_page') );
		add_shortcode( 'usersultra_happy_members', array(&$this,'happy_members') );
		add_shortcode( 'usersultra_happy_members_profile', array(&$this,'happy_members_profile') );
		add_shortcode( 'usersultra_happy_members_others', array(&$this,'happy_members_others') );
	}
	
	/**
	* Don't auto-p wrap shortcodes that stand alone
	*/
	function respo_base_unautop() 
	{
		add_filter( 'the_content',  'shortcode_unautop');
	}
	
	public function  usersultra_login_function ($atts)
	{
		global $xoouserultra;
		
		if (isset($_GET['resskey'])&& $_GET['resskey']!="") 
		{
			//users is trying to reset passowrd			
			return $xoouserultra->password_reset( $_GET['resskey'] );		
			
		
		}else{
				
			if (!is_user_logged_in()) 
			{
				return $xoouserultra->login( $atts );
				
			} else {
				
				
				if($xoouserultra->get_option('uultra_auto_redirect_loggedin_user') == 'yes')
				{
					$xoouserultra->login->auto_redirection_on_login();
				
				}else{					
				
					return $xoouserultra->show_minified_profile( $atts );	
				
				}					
				
			}
		
		}
	
	}
	
	//logout
	public function  usersultra_logout_function ($atts)
	{
		global $xoouserultra;
				
		if (is_user_logged_in()) 
		{
			return $xoouserultra->custom_logout_page( $atts );				
			
		}
	
	}
	
	//Protect Content
	public function funnction_protect_content( $atts, $content = null ) 
	{
		global $xoouserultra;
		return $xoouserultra->userpanel->show_protected_content( $atts, $content );	
	}
	
	//Protect Content
	public function usersultra_searchbox( $atts ) 
	{
		global $xoouserultra;
		return $xoouserultra->userpanel->uultra_search_form( $atts );	
	}
	
	
	
	//Front Publisher
	public function  funnction_front_publisher ($atts)
	{
		global $xoouserultra;		
			
		//display publisher
		
		if (is_user_logged_in()) 
		{
			return $xoouserultra->show_front_publisher( $atts );		
			
		}	
	
	}
	
	public function  usersultra_photo_top_rated ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_top_rated_photos( $atts );			
		
	}
	
	public function  usersultra_latest_photos ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_latest_photos( $atts );			
		
	}
	
	public function  usersultra_photo_grid ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_photo_grid( $atts );			
		
	}
	
	public function  usersultra_featured_users ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_featured_users($atts );
		
	}
	
	public function  usersultra_promote_users ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_promoted_users($atts );
		
	}
	
	public function  usersultra_promote_photos ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_promoted_photos($atts );
		
	}
	
	public function  usersultra_latest_users ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_latest_users($atts );
			
		
	}
	
	
	
	public function  usersultra_top_rated_users ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_top_rated_users($atts );
			
		
	}
	
	public function  usersultra_most_visited_users ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_most_visited_users($atts );
			
		
	}
	
	
	public function  usersultra_profile_function ($atts)
	{
		global $xoouserultra;
		
		if (!is_user_logged_in() &&  $xoouserultra->get_option( 'guests_can_view' )==0) 
		{
			return $xoouserultra->login( $atts );
			
		}else{
			
			return $xoouserultra->show_pulic_profile( $atts );
		}
		
		
	}	
	public function  usersultra_registration_function ($atts)
	{
		global $xoouserultra;
		
		if (!is_user_logged_in()) 
		{
			return $xoouserultra->show_registration_form( $atts );
			
		} else {
			
			//display mini profile					
			if($xoouserultra->get_option('uultra_auto_redirect_loggedin_user_registration') == 'yes')
			{
				$xoouserultra->login->auto_redirection_on_login();
				
			}else{					
				
				return $xoouserultra->show_minified_profile( $atts );
				
			}			
			
			
		}
			
		
	}
	
	public function  usersultra_directory_function ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_users_directory( $atts );
			
		
	}
	
	public function  usersultra_directory_mini_function ($atts)
	{
		global $xoouserultra;
		return $xoouserultra->show_users_directory_mini( $atts );
			
	}
	
	

	public function  usersultra_mymessages_function ($atts)
	{
		global $xoouserultra;
		
		if (!is_user_logged_in()) 
		{
			return $xoouserultra->login( $atts );
			
		}else{
			
			return $xoouserultra->show_usersultra_inbox( $atts );
		}
		
		
			
		
	}
	
	public function  usersultra_my_account_function ($atts)
	{
		global $xoouserultra;	
			
		
		if (!is_user_logged_in()) 
		{				
			
			return $xoouserultra->login( $atts );
				
		}else{							
				
			return $xoouserultra->show_usersultra_my_account( $atts );
		}
		
	}
	
	
	   /**
	 * Pricing Table
	 * @since 1.1
	 *
	 */
	 
	 function respo_pricing_shortcode( $atts, $content = null  ) 
	 {
		 global $xoouserultra;

		extract( shortcode_atts( array(
			'color' => 'black',
			'position' => '',
			'featured' => 'no',
			'plan_id' => '',
			'per' => 'month',
			'button_url' => '',
			'button_text' => __('Sign up','xoousers'),
			'button_color' => 'green',
			'button_target' => 'self',
			'button_rel' => 'nofollow',
			'class' => '',
		), $atts ) );
		//set variables
		$featured_pricing = ( $featured == 'yes' ) ? 'featured' : NULL;
		
		//get package
		$package = $xoouserultra->paypal->get_package($plan_id);
		
		$amount = $package->package_amount;
		$p_name = $package->package_name;
		$package_id = $package->package_id;
		
		//customization
		$customization = $package->package_customization;
		$customization = unserialize($customization);
		  
		if(is_array($customization))
		{
			  $p_price_color = $customization["p_price_color"];
			  $p_price_bg_color = $customization["p_price_bg_color"];
			  
			  $p_signup_color = $customization["p_signup_color"];
			  $p_signup_bg_color = $customization["p_signup_bg_color"];
			  
			  //customization string 			  
			  $custom_s = 'style="background-color:'.$p_price_bg_color.' !important; color:'.$p_price_color.' !important"';
			  
			  $custom_signup_color = 'style="color:'.$p_signup_color.' !important"';			  
			  $custom_signup_bg_color= 'style="background-color:'.$p_signup_bg_color.' !important; border-color:'.$p_signup_bg_color.' !important; "';
			
		}
		
		//get currency
		$currency_symbol =  $xoouserultra->get_option('paid_membership_symbol');
		
		//generate url		
		$package_url = $xoouserultra->paypal->get_package_url();
		$button_url = $package_url."?plan_id=".$plan_id;			
		
		//custom text for free packages		
		$free_text =  $xoouserultra->get_option('membership_display_zero');
		$amount_text = $currency_symbol. $amount;
		
		if($free_text!="" &&  $amount==0)
		{
			$amount_text =$free_text ;
		
		}	

		//start content
		$pricing_content ='';
		$pricing_content .= '<div class="respo-sc-pricing-table ' . $class . '" >';
		$pricing_content .= '<div class="respo-sc-pricing ' . $featured_pricing . ' respo-sc-column-' . $position . ' ' . $class . '">';
			$pricing_content .= '<div class="respo-sc-pricing-header '. $color .'" '. $custom_s.'>';
				$pricing_content .= '<h5 '. $custom_s.'>' .$p_name . '</h5>';
				$pricing_content .= '<div class="respo-sc-pricing-cost" '. $custom_s.'>' .$amount_text . '</div><div class="respo-sc-pricing-per">' . $per . '</div>';
			$pricing_content .= '</div>';
			$pricing_content .= '<div class="respo-sc-pricing-content">';
				$pricing_content .= '' . $content . '';
			$pricing_content .= '</div>';
			if( $button_url ) {
				$pricing_content .= '<div class="respo-sc-pricing-button"><a href="' . $button_url . '" class="respo-sc-button ' . $button_color . '" target="_' . $button_target . '" rel="' . $button_rel . '" '.$custom_signup_bg_color.'><span class="respo-sc-button-inner" '.$custom_signup_color.'>' . $button_text . '</span></a></div>';
			}
		$pricing_content .= '</div>';
		$pricing_content .= '</div><div class="respo-sc-clear-floats"></div>';
		
		return $pricing_content;
	}
	
	/**
    * Columns Shortcodes
   */

	function respo_base_grid_4_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_4 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_4( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_4">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_4_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_4 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	function respo_base_grid_8_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_8 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_8( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_8">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_8_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_8 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	function respo_base_grid_6_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_6 alpha">'. do_shortcode($content).'</div>';
	}
	
	function respo_base_grid_6( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_6">'. do_shortcode($content).'</div>';
	}
	
	function respo_base_grid_6_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_6 omega">'. do_shortcode($content) .'</div><div class="clear"></div>';
	}
	
	function respo_base_grid_3_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_3 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_3( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_3">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_3_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_3 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	function respo_base_grid_9_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_9 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_9( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_9">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_9_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_9 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	function respo_base_grid_2_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_2 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_2( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_2">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_2_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_2 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	function respo_base_grid_10_first( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_10 alpha">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_10( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_10">' . do_shortcode($content) . '</div>';
	}
	
	function respo_base_grid_10_last( $atts, $content = null ) {
	   return '<div class="respo-sc-grid_10 omega">' . do_shortcode($content) . '</div><div class="clear"></div>';
	}
	
	public function  get_latest_video_photo ($atts)
	{
		global $xoouserultra;
		
		$video_link = $photo_link= '#';
		if(isset($atts['video_page_id']))
			$video_link = isset($atts['video_page_id'])?get_page_link($atts['video_page_id']):'#';

		if(isset($atts['photo_page_id']))
			$photo_link = isset($atts['photo_page_id'])?get_page_link($atts['photo_page_id']):'#';
		
		$result = $xoouserultra->get_latest_video_photo( $atts );
		$contentVideo ='';
		$contentPhoto = '';
		if(!empty($result['video'])){
			$video = $result['video'];
			$thumb = $video->video_image;
			$contentVideo = '
			<a href="'.$video_link.'">
				<div class="video" style="background-image:url('.$thumb.')">
					<div class="icon">VIDEOS</div>
				</div>
			</a>';
		}
		if(!empty($result['photo'])){
			$photo = $result['photo'];
			$thumb = $photo->photo_large;
			$contentPhoto = '
			<a href="'.$photo_link.'">
				<div class="picture">
					<div class="image" style="background-image:url('.$thumb.')"></div>
					<div class="icon">PICTURE</div>
				</div>
			</a>';
		}
		$content = '<div class="container-promo">'.$contentVideo.$contentPhoto.'</div>';
		return $content;			
		
	}
	public function happy_moment_child($atts) {
		global $xoouserultra;
		$site_url = site_url()."/";
		$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
		
		wp_enqueue_script( 'moment', get_template_directory_uri().'/js/moment.js');
		wp_enqueue_style( 'moment', get_template_directory_uri().'/css/moment.css');
		$result = $xoouserultra->happy_moment_child( $atts );
		if($result['listGallery'] && $result['listVideoOfFirst']){
			$contentGallery = '';			
			foreach ($result['listGallery'] as $gallery) {
				$user_id =$gallery->gallery_user_id;
				$gallery->video_thumb = $site_url.$upload_folder."/".$user_id."/".$gallery->video_thumb;
				$contentGallery .='
					<li data-gal_id="'.$gallery->gallery_id.'">
						<div class="content">
							<div class="no-photo"><img src="'.$gallery->video_thumb.'" width="236px" height="151px" alt="'.$gallery->gallery_name.'"></div>
							<div class="title-album">'.$gallery->gallery_name.'</div>
							<div class="time">'.date("m.d.y",$gallery->create_at).'</div>
							<div class="icon-video"></div>
						</div>
					</li>';
			}			
			$contentListGallery = '
			<div class="container-slide-album">
				<div class="wraper">
					<div class="myjcarousel" data-jcarousel="true">
						<ul style="left: 0px; top: 0px;">'.$contentGallery.'</ul>
					</div>
					<p class="photo-title">
						Album
					</p>
					<a href="#" class="myjcarousel-control-prev inactive" data-jcarouselcontrol="true"></a>
					<a href="#" class="myjcarousel-control-next" data-jcarouselcontrol="true"></a>
				</div>
			</div>';

			$contentVideo = '';
			$mainVideo = null;
			foreach ($result['listVideoOfFirst'] as $video) {
				$video->video_thumb = $site_url.$upload_folder."/".$user_id."/".$video->video_thumb;
				if(!$mainVideo)	$mainVideo = $video;
				$contentVideo .= '
				<li data-vid="'.$video->video_unique_vid.'" data-title="'.$video->video_name.'" data-date="'.date("m.d.y",$video->create_at).'">
					<a href="javascript:void(0)" class="content">
						<img src="'.$video->video_thumb.'" width="240px" height="152px" alt="">
						<div class="icon-video"></div>
					</a>
				</li>';
			}
			$listVideo = '
			<div class="container-slide-video">
				<div class="myjcarousel" data-jcarousel="true">
					<ul style="left: 0px; top: 0px;">'.$contentVideo.'</ul>
				</div>
				<a href="#" class="myjcarousel-control-prev inactive" data-jcarouselcontrol="true"></a>
				<a href="#" class="myjcarousel-control-next" data-jcarouselcontrol="true"></a>
			</div>';
			}
		$contentMainVideo = '
		<div class="container-video">
			<div class="video-warp" style="height:610px">
				<iframe width="100%" height="610px" src="http://www.youtube.com/embed/'.$mainVideo->video_unique_vid.'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				<!--<div class="icon">VIDEOS</div>-->
				<!--<div class="icon-album">ALBUM</div>-->
			</div>
			<div class="video-bar"></div>
			<div class="video-des">
				<h3>'.$mainVideo->video_name.' |</h3>
				<span class="time">'.date("m.d.y",$mainVideo->create_at).'</span>
			</div>
		</div>';
		return $contentMainVideo.$listVideo.$contentListGallery;
	}
	
	public function happy_spirit($atts) {
		global $xoouserultra;
		$site_url = site_url()."/";
		$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
		
		wp_enqueue_script( 'moment', get_template_directory_uri().'/js/spirit.js');
		wp_enqueue_style( 'moment', get_template_directory_uri().'/css/moment.css');
		$result = $xoouserultra->happy_spirit( $atts );
		if($result['listGallery'] && $result['listPhotoOfFirst']){
			$contentGallery = '';			
			foreach ($result['listGallery'] as $gallery) {
				$user_id =$gallery->gallery_user_id;
				$gallery->photo_thumb = $site_url.$upload_folder."/".$user_id."/".$gallery->photo_thumb;
				$contentGallery .='
					<li data-gal_id="'.$gallery->gallery_id.'">
						<div class="content">
							<div class="no-photo"><img src="'.$gallery->photo_thumb.'" width="236px" height="151px" alt="'.$gallery->gallery_name.'"></div>
							<div class="title-album">'.$gallery->gallery_name.'</div>
							<div class="time">'.date("m.d.y",$gallery->create_at).'</div>
						</div>
					</li>';
			}			
			$contentListGallery = '
			<div class="container-slide-album">
				<div class="wraper">
					<div class="myjcarousel" data-jcarousel="true">
						<ul style="left: 0px; top: 0px;">'.$contentGallery.'</ul>
					</div>
					<p class="photo-title">
						Album
					</p>
					<a href="#" class="myjcarousel-control-prev inactive" data-jcarouselcontrol="true"></a>
					<a href="#" class="myjcarousel-control-next" data-jcarouselcontrol="true"></a>
				</div>
			</div>';

			$contentPhoto = '';
			$mainPhoto = null;
			foreach ($result['listPhotoOfFirst'] as $photo) {
				$photo->photo_thumb = $site_url.$upload_folder."/".$user_id."/".$photo->photo_thumb;
				$photo->photo_large = $site_url.$upload_folder."/".$user_id."/".$photo->photo_large;
				if(!$mainPhoto)	$mainPhoto = $photo;
				$contentPhoto .= '
				<li data-large="'.$photo->photo_large.'" data-title="'.$photo->photo_name.'" data-date="'.date("m.d.y",$photo->create_at).'">
					<a href="javascript:void(0)" class="content">
						<img src="'.$photo->photo_thumb.'" width="240px" height="152px" alt="">
						<div class="icon-photo"></div>
					</a>
				</li>';
			}
			$listPhoto = '
			<div class="container-slide-video">
				<div class="myjcarousel" data-jcarousel="true">
					<ul style="left: 0px; top: 0px;">'.$contentPhoto.'</ul>
				</div>
				<a href="#" class="myjcarousel-control-prev inactive" data-jcarouselcontrol="true"></a>
				<a href="#" class="myjcarousel-control-next" data-jcarouselcontrol="true"></a>
			</div>';
			}
		$contentMainPhoto = '
		<div class="container-video">
			<div class="video-warp" style="height:610px">
				<img src="'.$mainPhoto->photo_large.'" alt="'.$mainPhoto->photo_name.'">
			</div>
			<div class="video-bar"></div>
			<div class="video-des">
				<h3>'.$mainPhoto->photo_name.' |</h3>
				<span class="time">'.date("m.d.y",$mainPhoto->create_at).'</span>
			</div>
		</div>';
		return $contentMainPhoto.$listPhoto.$contentListGallery;
	}
	
	public function happy_moment_home_page($atts) {
		global $xoouserultra;
		$video_link = $photo_link= '#';
		if(isset($atts['video_page_id']))
			$video_link = isset($atts['video_page_id'])?get_page_link($atts['video_page_id']):'#';

		if(isset($atts['photo_page_id']))
			$photo_link = isset($atts['photo_page_id'])?get_page_link($atts['photo_page_id']):'#';
		
		wp_enqueue_script( 'appjs', get_template_directory_uri().'/js/app.js');
		$site_url = site_url()."/";
		$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
		$result = $xoouserultra->happy_moment_home_page( $atts );
		$firstVideo = $result['firstVideo'];
		$listVideos = '';
		foreach ($result['listVideos'] as $video) {
			$name = strlen($video->video_name)>40?substr($video->video_name, 0,40).'...':$video->video_name;
			$listVideos .= '
				<li class="item" data-vid="'.$video->video_unique_vid.'" data-name="'.$video->video_name.'" data-date="'.date("M,d,Y",$video->create_at).'">
					<a href="#">
						<div class="list-postion">
							<h3>'.$name.'</h3>
							<!--<p>demo demo demo</p>--!>
						</div>
						<img src="'.$site_url.$upload_folder."/".$video->gallery_user_id."/".$video->video_thumb.'" alt="'.$video->video_name.'">
					</a>
				</li>';
		}
		$content = '
			<div class="container">
				<div class="title-home happy-moment">
					<div class="title">
						<h2>HAPPY MOMENT</h2>
					</div>
					<span class="span"></span>
				</div>
				<div class="group happy-moment-wp">
					<div class="happy-moment-clip">
						<div class="moment-postion">
							<div class="icon-moment"></div>
							<div class="videos clip">
								<h2><a href="'.$video_link.'">Videos</a></h2>
							</div>
							<div class="videos picture">
								<h2><a href="'.$photo_link.'">Picture</a></h2>
							</div>
						</div>
						<iframe width="100%" height="450px" src="http://www.youtube.com/embed/'.$firstVideo->video_unique_vid.'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
					</div>
					<div class="happy-moment-slider">
						<div class="jcarousel-wrapper">
							<div class="jcarousel jcarousel1" data-jcarousel="true">
								<ul style="left: 0px; top: -318px;">
									'.$listVideos.'
								</ul>
							</div>
						</div>
						<div class="group-dots">
							<a href="#" class="next jcarousel-control-prev1" data-jcarouselcontrol="true"></a>
							<a href="#" class="pre jcarousel-control-next1" data-jcarouselcontrol="true"></a>	`
						</div>
					</div>
				</div>
				<div class="group happy-moment-wp-title">
					<div class="clip-title">
						<h2>'.$firstVideo->video_name.'<span>'.date("M,d,Y",$firstVideo->create_at).'</span></h2>
					</div>
				</div>
			</div>';
		
		return $content;
	}
	
	public function happy_spirit_home_page($atts) {
		global $xoouserultra;
		$video_link = $photo_link= '#';
		if(isset($atts['video_page_id']))
			$video_link = isset($atts['video_page_id'])?get_page_link($atts['video_page_id']):'#';

		if(isset($atts['photo_page_id']))
			$photo_link = isset($atts['photo_page_id'])?get_page_link($atts['photo_page_id']):'#';
		
		wp_enqueue_script( 'appjs', get_template_directory_uri().'/js/app.js');
		$site_url = site_url()."/";
		$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
		$result = $xoouserultra->happy_spirit_home_page( $atts );
		$firstPhoto = $result['firstPhoto'];
		$listPhotos = '';
		foreach ($result['listPhotos'] as $photo) {
			$name = strlen($photo->photo_name)>40?substr($photo->photo_name, 0,40).'...':$photo->photo_name;
			$listPhotos .= '
				<li class="item" data-large="'.$site_url.$upload_folder."/".$photo->gallery_user_id."/".$photo->photo_large.'" data-name="'.$photo->photo_name.'" data-date="'.date("M,d,Y",$photo->create_at).'">
					<a href="#">
						<div class="list-postion">
							<h3>'.$name.'</h3>
							<!--<p>demo demo demo</p>--!>
						</div>
						<img src="'.$site_url.$upload_folder."/".$photo->gallery_user_id."/".$photo->photo_thumb.'" alt="'.$photo->video_name.'">
					</a>
				</li>';
		}
		$content = '
			<div class="container">
				<div class="title-home happy-moment">
					<div class="title">
						<h2>HAPPY SPRIRIT</h2>
					</div>
					<span class="span"></span>
				</div>
				<div class="group happy-moment-wp spirit">
					<div class="happy-moment-clip">
						<div class="moment-postion">
							<div class="icon-moment"></div>
							<div class="videos clip">
								<h2><a href="'.$video_link.'">Videos</a></h2>
							</div>
							<div class="videos picture">
								<h2><a href="'.$photo_link.'">Picture</a></h2>
							</div>
						</div>
						<img id="main_photo" src="'.$site_url.$upload_folder."/".$firstPhoto->gallery_user_id."/".$firstPhoto->photo_large.'" alt="'.$firstPhoto->photo_name.'">
					</div>
					<div class="happy-moment-slider">
						<div class="jcarousel-wrapper">
							<div class="jcarousel jcarousel1" data-jcarousel="true">
								<ul style="left: 0px; top: -318px;">
									'.$listPhotos.'
								</ul>
							</div>
						</div>
						<div class="group-dots">
							<a href="#" class="next jcarousel-control-prev1" data-jcarouselcontrol="true"></a>
							<a href="#" class="pre jcarousel-control-next1" data-jcarouselcontrol="true"></a>	`
						</div>
					</div>
				</div>
				<div class="group happy-moment-wp-title">
					<div class="clip-title">
						<h2>'.$firstPhoto->photo_name.'<span>'.date("M,d,Y",$firstPhoto->create_at).'</span></h2>
					</div>
				</div>
			</div>';
		
		return $content;
	}
	
	public function latest_member_home_page($atts) {
		global $xoouserultra;
		$atts = array(
		
			'template' => 'latest_member_home_page', //this is the template file's name
			'container_width' => '100%', // this is the main container dimension
			'item_width' => '10%', // this is the width of each item or user in the directory
			'item_height' => 'auto', // auto height
			'list_per_page' => 99999, // how many items per page
			'pic_type' => 'avatar', // display either avatar or main picture of the user
			'pic_boder_type' => 'none', // rounded
			'pic_size_type' => 'fixed', // dynamic or fixed			
			'pic_size' => 100, // size in pixels of the user's picture
			'optional_fields_to_display' => '', // size in pixels of the user's picture
			'display_social' => 'yes', // display social
			'display_country_flag' => 'name', // display flag, no,yes,only, both. Only won't display name
			'display_total_found' => 'yes', // display total found
			'display_total_found_text' =>__('Users', 'xoousers'), // display total found	
			
				
			'list_order' => 'DESC', // asc or desc ordering
			'exclude' => '', // exclude from searching
		);
		return $xoouserultra->show_users_directory_mini( $atts );
	}
	
	public function happy_members($atts) {
		global $xoouserultra;
		$atts = array(
		
			'template' => 'members_list', //this is the template file's name
			'container_width' => '100%', // this is the main container dimension
			'item_width' => '10%', // this is the width of each item or user in the directory
			'item_height' => 'auto', // auto height
			'list_per_page' => 99999, // how many items per page
			'pic_type' => 'avatar', // display either avatar or main picture of the user
			'pic_boder_type' => 'none', // rounded
			'pic_size_type' => 'fixed', // dynamic or fixed			
			'pic_size' => 100, // size in pixels of the user's picture
			'optional_fields_to_display' => '', // size in pixels of the user's picture
			'display_social' => 'yes', // display social
			'display_country_flag' => 'name', // display flag, no,yes,only, both. Only won't display name
			'display_total_found' => 'yes', // display total found
			'display_total_found_text' =>__('Users', 'xoousers'), // display total found	
			
				
			'list_order' => 'DESC', // asc or desc ordering
			'exclude' => '', // exclude from searching
		);
		return $xoouserultra->show_users_directory_mini( $atts );
	}
	
	public function  happy_members_profile ($atts)
	{
		global $xoouserultra;
		wp_enqueue_script( 'memberjs', get_template_directory_uri().'/js/member.js');
		wp_enqueue_style( 'membercss', get_template_directory_uri().'/css/member.css');
		return $xoouserultra->happy_members_profile( $atts );
				
	}
	
	public function happy_members_others() {
		global $xoouserultra;
		$atts = array(
		
			'template' => 'members_list', //this is the template file's name
			'container_width' => '100%', // this is the main container dimension
			'item_width' => '10%', // this is the width of each item or user in the directory
			'item_height' => 'auto', // auto height
			'list_per_page' => 99999, // how many items per page
			'pic_type' => 'avatar', // display either avatar or main picture of the user
			'pic_boder_type' => 'none', // rounded
			'pic_size_type' => 'fixed', // dynamic or fixed			
			'pic_size' => 100, // size in pixels of the user's picture
			'optional_fields_to_display' => '', // size in pixels of the user's picture
			'display_social' => 'yes', // display social
			'display_country_flag' => 'name', // display flag, no,yes,only, both. Only won't display name
			'display_total_found' => 'yes', // display total found
			'display_total_found_text' =>__('Users', 'xoousers'), // display total found	
			
				
			'list_order' => 'DESC', // asc or desc ordering
			'exclude' => '', // exclude from searching
		);
		return $xoouserultra->happy_members_others( $atts );
	}
}
$key = "shortcode";
$this->{$key} = new XooShortCode();