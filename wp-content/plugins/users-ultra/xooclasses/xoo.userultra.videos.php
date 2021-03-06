<?php

class XooUserVideo {

	function __construct() {
		$this->ini_video_module();

		add_action('wp_enqueue_scripts', array($this, 'add_styles'));
		add_action('wp_ajax_add_new_video_gallery', array($this, 'add_new_video_gallery'));
		add_action('wp_ajax_add_new_video', array($this, 'add_new_video'));
		add_action('wp_ajax_reload_video_galleries', array($this, 'reload_video_galleries'));
		add_action('wp_ajax_reload_videos', array($this, 'reload_videos'));
		add_action('wp_ajax_video_image_upload', array($this, 'video_image_upload'));
//		add_action( 'wp_ajax_ajax_upload_avatar', array( $this, 'ajax_upload_avatar' ));
//		
		add_action('wp_ajax_delete_video', array($this, 'delete_video'));
		add_action('wp_ajax_delete_video_gallery', array($this, 'delete_video_gallery'));
//		add_action( 'wp_ajax_delete_video', array( $this, 'delete_video' ));
//		
//		
		add_action('wp_ajax_edit_video_gallery', array($this, 'edit_video_gallery'));
		add_action('wp_ajax_edit_video_gallery_confirm', array($this, 'edit_video_gallery_confirm'));
//		
		add_action('wp_ajax_edit_video', array($this, 'edit_video'));
		add_action('wp_ajax_edit_video_confirm', array($this, 'edit_video_confirm'));
//		add_action( 'wp_ajax_edit_video_confirm', array( $this, 'edit_video_confirm' ));	
//		add_action( 'wp_ajax_edit_video', array( $this, 'edit_video' ));	
		add_action('wp_ajax_set_as_main_video', array($this, 'set_as_main_video'));
		add_action('wp_ajax_sort_video_list', array($this, 'sort_video_list'));
		add_action('wp_ajax_sort_video_gallery_list', array($this, 'sort_video_gallery_list'));
		add_action('wp_ajax_nopriv_videos_of_gallery', array( $this, 'get_videos_of_gallery' ));
		add_action('wp_ajax_videos_of_gallery', array( $this, 'get_videos_of_gallery' ));
		
		add_action('wp_ajax_nopriv_moment_update_facebook', array( $this, 'update_facebook' ));
		add_action('wp_ajax_moment_update_facebook', array( $this, 'update_facebook' ));
//		 add_filter( 'query_vars',   array(&$this, 'userultra_uid_query_var') );
	}

	public function ini_video_module() {
		global $wpdb;

		// Create table
		$query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'usersultra_video_galleries (
				`gallery_id` bigint(20) NOT NULL auto_increment,
				`gallery_user_id` int(11) NOT NULL ,
				`gallery_name` varchar(60) NOT NULL,				
				`gallery_order` int(11) NOT NULL ,	
				`gallery_private` int(1) NOT NULL ,	
				`gallery_only_friends` int(1) NOT NULL ,				
				`gallery_desc` text NOT NULL,			
				PRIMARY KEY (`gallery_id`)
			) COLLATE utf8_general_ci;';

		$wpdb->query($query);

		// Create table videos
		$query = 'CREATE TABLE IF NOT EXISTS ' . $wpdb->prefix . 'usersultra_videos (
				`video_id` bigint(20) NOT NULL auto_increment,
				`video_user_id` bigint(20) NOT NULL ,				
				`video_name` varchar(200) NOT NULL,
				`video_type` varchar(50) NOT NULL,
				`video_preview` varchar(255) DEFAULT NULL,
				`video_unique_vid` varchar(50) NOT NULL,
				`video_order` int(11) NOT NULL,						
				PRIMARY KEY (`video_id`)
			) COLLATE utf8_general_ci;';

		$wpdb->query($query);
	}

	public function userultra_uid_query_var($query_vars) {
		$query_vars[] = 'uu_photokeyword';
		$query_vars[] = 'searchphoto';
		return $query_vars;
	}

	function add_styles() {

		wp_enqueue_script('jquery-ui-sortable');
	}

	/* Add New Video */

	public function add_new_video() {
		global $wpdb;

		$user_id = get_current_user_id();
		$video_name = sanitize_text_field($_POST['video_name']);
		$video_id = sanitize_text_field($_POST['video_id']);
		$video_desc = sanitize_text_field($_POST['video_desc']);
		$video_gal_id = $_POST['video_gal_id'];
		$video_image = $_POST['video_image'];
		$video_thumb = $_POST['video_thumb'];
		if (is_user_logged_in() && isset($user_id) && isset($video_name)) {
			
			$gall = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . $video_gal_id . ' LIMIT 1');
			if(count($gall)){
				if($video_image == null){
					$result = $this->downloadYoutubeThumb($video_id, $gall[0]->gallery_user_id);
					$video_image = $result["image"];
					$video_thumb = $result["thumb"];

				}
				$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_gal_id` = "' . $video_gal_id . '" AND `video_main` = 1');
	
				$new_message = array(
					'video_id' => NULL,
					'video_user_id' => $gall[0]->gallery_user_id,
					'video_gal_id' => $video_gal_id,
					'video_name' => $video_name,
					'video_unique_vid' => $video_id,
					'video_type' => 'youtube',
					'video_image' => $video_image,
					'video_thumb' => $video_thumb,
					'video_desc' => $video_desc,
					'video_main' => count($videos)>0?0:1,
					'create_at' => time(),
					'update_at' => time(),
				);

				// insert into database
				if ($wpdb->insert($wpdb->prefix . 'usersultra_videos', $new_message, array('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%d','%d','%d'))) {				
				}
			}			
			echo $this->post_media_display($video_gal_id, null, 'new_video_div');
		} //end user loged in
		die();
	}

	/* Add New Gallery */

	public function add_new_video_gallery() {
		global $wpdb,$xoouserultra;

		$user_id = $xoouserultra->is_admin && isset( $_POST['user_id'])? $_POST['user_id']: get_current_user_id();
		$gall_name = sanitize_text_field($_POST['gall_name']);
		$gall_description = sanitize_text_field($_POST['gall_desc']);

		if (is_user_logged_in() && isset($user_id) && isset($gall_name)) {
			$new_message = array(
				'gallery_id' => NULL,
				'gallery_user_id' => $user_id,
				'gallery_name' => $gall_name,
				'gallery_desc' => $gall_description,
				'create_at' => time(),
				'update_at' => time(),
			);
			// insert into database
			if ($wpdb->insert($wpdb->prefix . 'usersultra_video_galleries', $new_message, array('%d', '%s', '%s', '%s','%d','%d'))) {
				
			}
		} //end user loged in
	}

	public function get_pages($photo_count, $page, $list_perpage) {

		//calculates pages
		//$photo_count = $user_count_query->get_results();

		$total_pages = ceil($photo_count / $list_perpage);


		$big = 999999999; // need an unlikely integer
		$arr = paginate_links(array(
			'base' => @add_query_arg('ultra-page', '%#%'),
			'total' => $total_pages,
			'current' => $page,
			'show_all' => false,
			'end_size' => 1,
			'mid_size' => 2,
			'prev_next' => true,
			'prev_text' => __('Previous', 'xoousers'),
			'next_text' => __('Next', 'xoousers'),
			'type' => 'plain',
		));
		return $arr;
	}

	/* Reload Galleries - Users Dashboard */

	public function reload_video_galleries() {
		global $wpdb, $xoouserultra;


		$html = "";
		$user_id = get_current_user_id();
		if (is_user_logged_in() && isset($user_id)) {
			if($xoouserultra->is_admin){
				$galleries = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries ORDER BY `gallery_order` ASC');
//				$galleries = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries g LEFT JOIN ' . $wpdb->prefix . 'usersultra_videos v ON g.gallery_id = v.video_gal_id ORDER BY g.gallery_order ASC');
			}else{
				$galleries = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_user_id` = "' . $user_id . '" ORDER BY `gallery_order` ASC');
//				$galleries = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries g LEFT JOIN ' . $wpdb->prefix . 'usersultra_videos v ON g.gallery_id = v.video_gal_id WHERE g.`gallery_user_id` = "' . $user_id . '" ORDER BY g.gallery_order ASC');
			}
			if (empty($galleries)) {
				$html.= '<p>' . __('You have no galleries yet.', 'xoousers') . '</p>';
			} else {
				$n = count($galleries);
				$num_unread = 0;
				$time = time();
				foreach ($galleries as $gall) {
					//get main picture
					$thumb = $this->get_gallery_thumb($gall->gallery_id);
					//get amount of pictures
					$amount_pictures = $this->get_total_video_of_gal($gall->gallery_id);
					
					$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_gal_id` = "' . $gall->gallery_id . '" ORDER BY `video_order` ASC');
					$listVideo = '';
					foreach ($videos as $video) {
						$listVideo .= "<a class='fancybox.iframe fancybox_".$time."' href='//www.youtube.com/embed/".$video->video_unique_vid."?autohide=1&modestbranding=1&showinfo=0' data-fancybox-group='video-gallery-".$gall->gallery_id."' title='".str_replace('"',"'",$video->video_name)."'>".$video->video_name."</a>";
					}
					if($listVideo){
						$listVideo .='<script>jQuery(document).ready(function($){$(".fancybox_'.$time.'").fancybox()})</script>';
					}
					$user = '';
					if($xoouserultra->is_admin){
						$user .='<label><i class="fa fa-user fa-2x"></i>'.$xoouserultra->userpanel->get_display_name($gall->gallery_user_id ).'</label>';
					}

					echo "<li class='xoousersultra-shadow-borers' id='" . $gall->gallery_id . "'>
					
					<div class='pe_icons_gal'>
					<a href='#resp_del_video_gallery' data-id='" . $gall->gallery_id . "' class='delete' id='" . $gall->gallery_id . "' alt='delete' title='" . __('delete', 'xoousers') . "'></a>
					
					<a href='#resp_edit_video_gallery' data-id='" . $gall->gallery_id . "' class='edit' id='" . $gall->gallery_id . "' alt='edit' title='" . __('edit', 'xoousers') . "'></a>
					<a href='#resp_play_video_gallery' data-id='" . $gall->gallery_id . "' class='play' id='" . $gall->gallery_id . "' alt='play' title='" . __('play', 'xoousers') . "'></a>	
					</div>	
					
					<div class='usersultra-photo-name'>
					
						<a href='" . $xoouserultra->userpanel->get_internal_links('videos-files', 'video_gal_id', $gall->gallery_id) . "' >" . $gall->gallery_name . " </a>
					
					</div>
				
					<a href='" . $xoouserultra->userpanel->get_internal_links('videos-files', 'video_gal_id', $gall->gallery_id) . "' class=''  ><img src='" . $thumb . "' /> </a>
					
					
					
					<p class='usersultra-amount_pictures'>" . $amount_pictures . " " . __('Video(s)', 'xoousers') . "</p>
					
					<p>" . $gall->gallery_desc . "</p>
					".$user."
					<div class='uultra-video-gallery-edit white_content add-new-video-gallery' id='video-gallery-edit-div-" . $gall->gallery_id . "'>
					</div>
					<div style='display:none' class=' list-video-" . $gall->gallery_id . "' id='list-video-" . $gall->gallery_id . "'>".$listVideo."</div>
					</li>";
				}
			}


			die($html);
		} //end user loged in
	}

	/* Reload Videos */

	public function reload_videos() {
		global $wpdb, $xoouserultra;

		$user_id = get_current_user_id();
		$video_gal_id = $_POST["video_gal_id"];
		$html = "";

		$user_id = get_current_user_id();

		if (is_user_logged_in() && isset($user_id)) {
			$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_gal_id` = "' . $video_gal_id . '" ORDER BY `video_order` ASC');
			
			if (empty($videos)) {
				$html.= '<p>' . __('You have no videos yet.', 'xoousers') . '</p>';
			} else {
				$n = count($videos);
				$num_unread = 0;
				$time = time();
				foreach ($videos as $video) {
					$thumb = $this->get_video_thumb($video_gal_id, $video->video_id);
					$main = "";
					if ($video->video_main == 1) {
						$main = "<div class='pe_main_video'>" . __('MAIN VIDEO', 'xoousers') . "</div>";
					}

					$html .= "<li class='xoousersultra-shadow-borers' id='" . $video->video_id . "'>
					
					<div class='pe_icons_gal'>
					<a href='#resp_del_video' data-id='" . $video->video_gal_id . "' class='delete' id='" . $video->video_id . "' alt='delete' title='" . __('delete', 'xoousers') . "'></a><a href='#resp_set_main_video' data-id='" . $video->video_gal_id . "' class='' id='" . $video->video_id . "'></a><a href='#resp_edit_video' data-id='" . $video->video_gal_id . "' class='edit' id='" . $video->video_id . "' alt='edit' title='" . __('edit', 'xoousers') . "'></a>
					</div>" . $main;


					$html .= '<div class="embed-container">';

					if ($thumb) {
						$html .= "<a class='fancybox.iframe fancybox_".$time."' href='//www.youtube.com/embed/".$video->video_unique_vid."?autohide=1&modestbranding=1&showinfo=0' data-fancybox-group='video-gallery' title='".str_replace('"',"'",$video->video_name)."'><img src='$thumb' alt='".str_replace('"',"'",$video->video_name)."'/></a>";
					} else {
						switch ($video->video_type): case "youtube":

								$html .= '<iframe width="99%" src="//www.youtube.com/embed/' . $video->video_unique_vid . '?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

								break;

							case "vimeo":

								$html .= '<iframe src="http://player.vimeo.com/video/' . $video->video_unique_vid . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="99%"  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

							case "embed":

								$html .= stripslashes($video->video_unique_vid);

						endswitch;
					}

					$html .= "</div> ";

					$html .= "<div><p>" . $video->video_name . "</p></div>";

					$html .= "<div class='uultra-video-edit white_content' id='video-edit-div-" . $video->video_id . "'> ";

					$html .= "</li>";					
				}
				$html .= '<script>jQuery(document).ready(function($){$(".fancybox_'.$time.'").fancybox()})</script>';
			}

			echo $html;			
		} //end user loged in
		die();
	}

	/* Reload Videos */

	public function reload_videos_public($user_id) {
		global $wpdb, $xoouserultra;


		$html = "";


		if (isset($user_id)) {
			$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_user_id` = "' . $user_id . '" ORDER BY `video_order` ASC');


			if (empty($videos)) {
				$html.= '<p>' . __('The user has not added videos yet.', 'xoousers') . '</p>';
			} else {
				$n = count($videos);
				$num_unread = 0;
				foreach ($videos as $video) {

					$html .= "<li class='xoousersultra-shadow-borers' id='" . $video->video_id . "'>
					
					<div class='pe_icons_gal'>
					<a href='#resp_del_gallery' data-id='" . $video->video_id . "' class='delete' id='" . $video->video_id . "' alt='delete' title='" . __('delete', 'xoousers') . "'></a>
					</div>";


					$html .= '<div class="embed-container">';

					switch ($video->video_type): case "youtube":

							$html .= '<iframe width="100%" height="100%" src="//www.youtube.com/embed/' . $video->video_unique_vid . '?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

							$html .= "<p class='social_v'><i class='fa fa-youtube-square fa-3x'></i></p> ";

							break;

						case "vimeo":

							$html .= '<iframe src="http://player.vimeo.com/video/' . $video->video_unique_vid . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" width="100%"  frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';

							$html .= "<p class='social_v'><i class='fa fa-vimeo-square fa-3x'></i></p> ";

						case "embed":

							$html .= stripslashes($video->video_unique_vid);

					endswitch;




					$html .= "</div> ";

					$html .= "<div><p>" . $video->video_name . "</p></div>";

					$html .= "</li>";
				}
			}
		} //end user loged in

		echo $html;
	}

	/* Reload Galleries */

	public function reload_galleries_public($user_id, $gallery_type = null) {
		global $wpdb, $xoouserultra;

		$html = "";

		if (isset($user_id)) {
			$galleries = $wpdb->get_results('SELECT `gallery_id`, `gallery_user_id`, `gallery_name`, `gallery_desc`  FROM ' . $wpdb->prefix . 'usersultra_galleries WHERE `gallery_user_id` = "' . $user_id . '" ORDER BY `gallery_order` ASC');


			if (empty($galleries)) {
				$html.= '<p>' . __('You have no galleries yet.', 'xoousers') . '</p>';
			} else {
				$n = count($galleries);
				$num_unread = 0;
				foreach ($galleries as $gall) {
					//get main picture
					$thumb = $this->get_main_picture_public($gall->gallery_id);

					//get amount of pictures
					$amount_pictures = $this->get_total_pictures_of_gal($gall->gallery_id);


					echo "<li class='xoousersultra-shadow-borers' id='" . $gall->gallery_id . "'>
					
										
					<div class='usersultra-photo-name'>
					
						<a href='" . $xoouserultra->userpanel->public_profile_get_album_link($gall->gallery_id, $user_id) . "' >" . $gall->gallery_name . " </a>
					
					</div>
				
					<a href='" . $xoouserultra->userpanel->public_profile_get_album_link($gall->gallery_id, $user_id) . "' class=''  ><img src='" . $thumb . "' class='rounded' /> </a>
					
					
					
					<p class='usersultra-amount_pictures'>" . $amount_pictures . " " . __('Picture(s)', 'xoousers') . "</p>
					
					<p class='galdesc'>" . $gall->gallery_desc . "</p>
					</li>";
				}
			}

			return $html;
		} //end user loged in
	}

	function sort_video_list() {
		global $wpdb;

		$order = explode(',', $_POST['order']);
		$counter = 0;
		foreach ($order as $item_id) {

			$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET video_order = '$counter' WHERE  `video_id` = '$item_id' ";
			$wpdb->query($query);

			$counter++;
		}
		die(1);
	}

	function sort_video_gallery_list() {
		global $wpdb;
		$order = explode(',', $_POST['order']);
		$counter = 0;
		foreach ($order as $item_id) {

			$query = "UPDATE " . $wpdb->prefix . "usersultra_video_galleries SET gallery_order = '$counter' WHERE  `gallery_id` = '$item_id' ";
			$wpdb->query($query);

			$counter++;
		}
		die(1);
	}

	public function get_total_video_of_gal($gal_id) {
		global $wpdb, $xoouserultra;

		$total = 0;


		$photos = $wpdb->get_results('SELECT count(*) as total  FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_gal_id` = "' . $gal_id . '" ');



		foreach ($photos as $photo) {
			$total = $photo->total;
			//print_r($photo);
		}


		return $total;
	}

	public function get_video_gallery($video_gal_id) {
		global $wpdb, $xoouserultra;


		$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . (int) $video_gal_id . ' ');


		foreach ($videos as $video) {
			return $video;
		}
	}

	public function get_gallery_public($gal_id, $user_id) {
		global $wpdb, $xoouserultra;


		$photos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_galleries WHERE `gallery_id` = ' . $gal_id . '  AND  `gallery_user_id` = ' . $user_id . '  ');


		foreach ($photos as $photo) {
			return $photo;
		}
	}

	public function get_video_thumb($video_gal_id, $video_id) {
		global $wpdb, $xoouserultra;

		require_once(ABSPATH . 'wp-includes/link-template.php');
		$site_url = site_url() . "/";
		$current_gal = $this->get_video_gallery($video_gal_id);
		$user_id = $current_gal->gallery_user_id;
		$upload_folder = $xoouserultra->get_option('media_uploading_folder');

		$path_pics = ABSPATH . $upload_folder . "/" . $user_id . "/";

		$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '" AND  g.gallery_id = "'.$video_gal_id.'" LIMIT 1');
		$thumb = xoousers_url . "templates/" . xoousers_template . "/img/no-photo.png";
		if (!empty($videos)) {
			foreach ($videos as $video) {
				//get gallery			
				$path_pics = ABSPATH . $upload_folder . "/" . $video->gallery_user_id . "/";
				if (!is_dir($path_pics . $video->video_thumb) && file_exists($path_pics . $video->video_thumb)){
					return $site_url . $upload_folder . "/" . $video->gallery_user_id . "/" . $video->video_thumb;
				}else{
					$result = $this->downloadYoutubeThumb( $video->video_unique_vid, $video->gallery_user_id);
					$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `video_image` = '".$result["image"]."', `video_thumb`='".$result["thumb"]."'  WHERE  `video_id` = '$video->video_id' ";
					$wpdb->query($query);
					return $result["thumb"]?$site_url . $upload_folder . "/" . $video->gallery_user_id . "/" . $result["thumb"]:$thumb;
				}
			}
		}
		return $thumb;
	}

	public function get_gallery_thumb($gal_id) {
		global $wpdb, $xoouserultra;

		require_once(ABSPATH . 'wp-includes/link-template.php');
		$site_url = site_url() . "/";
		$upload_folder = $xoouserultra->get_option('media_uploading_folder');

		$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_gal_id` = "' . $gal_id . '" AND v.`video_main` = 1 AND  g.gallery_id = "'.$gal_id.'" LIMIT 1');
		
		if (empty($videos)) {
			$thumb = xoousers_url . "templates/" . xoousers_template . "/img/no-photo.png";
		} else {
			foreach ($videos as $video) {
				//get gallery			
				$path_pics = ABSPATH . $upload_folder . "/" . $video->gallery_user_id . "/";
				if (file_exists($path_pics . $video->video_thumb)){
					return $site_url . $upload_folder . "/" . $video->gallery_user_id . "/" . $video->video_thumb;
				}else{
					$result = $this->downloadYoutubeThumb( $video->video_unique_vid, $video->gallery_user_id);
					$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `video_image` = '".$result["image"]."', `video_thumb`='".$result["thumb"]."'  WHERE  `video_id` = '$video->video_id' ";
					$wpdb->query($query);
					return $site_url . $upload_folder . "/" . $video->gallery_user_id . "/" . $result["thumb"];
				}
			}
		}
		return $thumb;
	}

	public function edit_video_gallery() {
		global $wpdb, $xoouserultra;

		$user_id = get_current_user_id();
		$gal_id = $_POST["gal_id"];

		if ($gal_id != "") {
			if($xoouserultra->is_admin)
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . $gal_id . ' LIMIT 1');
			else
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . $gal_id . ' AND `gallery_user_id` = ' . $user_id . ' LIMIT 1');

			$html = "";
			foreach ($res as $gal) {
				$pulic = "";
				$registered = "";
				$friends = "";
				$select_users = "";
				if($xoouserultra->is_admin){
					$select_users = "<p>" . __('User', 'xoousers') . "</p><p>".wp_dropdown_users(array('id' => 'name','echo'=>false,'class'=>'xoouserultra-input','id'=>'uultra_video_gall_user_id_edit_'.$gal->gallery_id,'selected'=>$gal->gallery_user_id)).'</p>';
				}
				if ($gal->gallery_private == 0) {
					$pulic = "selected='selected'";
				}
				if ($gal->gallery_private == 1) {
					$registered = "selected='selected'";
				}
				if ($gal->gallery_private == 2) {
					$friends = "selected='selected'";
				}

				$html .="<p>" . __('Name', 'xoousers') . "</p>";

				$html .="<p><input type='text' value='" . $gal->gallery_name . "' class='xoouserultra-input' id='uultra_video_gall_name_edit_" . $gal->gallery_id . "'></p>";

				$html .= $select_users."<p>" . __('Description', 'xoousers') . "</p>";
				$html .="<p><textarea class='xoouserultra-input' id='uultra_video_gall_desc_edit_" . $gal->gallery_id . "'>" . $gal->gallery_desc . "</textarea></p>";


//				$html .="<p>" . __('Visibility', 'xoousers') . "</p>";
//				$html .="<p><select class='xoouserultra-input' id='uultra_video_gall_visibility_edit_" . $gal->gallery_id . "'>				
//				 <option value='0' " . $pulic . " >Public</option>
//  <option value='1' " . $registered . ">Only Registered</option>
//  <option value='2' " . $friends . ">Only Friends</option>
//  
//  </select>
//				
//				</p>";

				$html .="<div class='usersultra-btn-options-bar'><a class='buttonize btn-video-gallery-close-conf' href='#' data-id= " . $gal->gallery_id . ">" . __('Close', 'xoousers') . "</a> <a class='buttonize green btn-video-gallery-conf' data-id= " . $gal->gallery_id . " href='#'>" . __('Save', 'xoousers') . "</a></div>";
			}
		}

		echo $html;
		die();
	}

	public function edit_video_gallery_confirm() {
		global $wpdb, $xoouserultra;

		require_once(ABSPATH . 'wp-includes/formatting.php');


		$user_id = $xoouserultra->is_admin && isset($_POST["gal_user_id"])?$_POST["gal_user_id"]:get_current_user_id();
		$gal_id = $_POST["gal_id"];

		$gal_name = sanitize_text_field($_POST["gal_name"]);
		$gal_desc = sanitize_text_field($_POST["gal_desc"]);
		
		//$gal_name = $_POST["gal_name"];
		//$gal_desc = $_POST["gal_desc"];
//		$gal_visibility = $_POST["gal_visibility"];
		$update_at = time();


		if ($gal_id != "") {
			if($xoouserultra->is_admin){
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . $gal_id . ' LIMIT 1');
				if(count($res) >0 && $res[0]->gallery_user_id != $user_id){
					$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE g.`gallery_id` = "' . $gal_id . '"');
					$path_pics = ABSPATH.$xoouserultra->get_option('media_uploading_folder');
					if(!is_dir($path_pics."/".$user_id))
						$this->CreateDir ($path_pics."/".$user_id);
					
					foreach ($videos as $video) {
						$update_at = time();
//						$query = "UPDATE " . $wpdb->prefix ."usersultra_photos SET `update_at` = '$update_at' WHERE  `photo_id` = '$photo->photo_id' AND gallery_id = '$gal_id'";
						$pathBig = $path_pics."/".$video->gallery_user_id."/".$video->video_image;					
						$pathSmall=$path_pics."/".$video->gallery_user_id."/".$video->video_thumb;	
						
						$pathBigNew = $path_pics."/".$user_id."/".$video->video_image;					
						$pathSmallNew=$path_pics."/".$user_id."/".$video->video_thumb;	
						
						@rename($pathBig, $pathBigNew);
						@rename($pathSmall, $pathSmallNew);
					}
				}
			}
			$query = "UPDATE " . $wpdb->prefix . "usersultra_video_galleries SET `gallery_name` = '$gal_name', `gallery_desc` = '$gal_desc' ,`gallery_user_id` = '$user_id', `update_at`='$update_at'  WHERE  `gallery_id` = '$gal_id' ";
			$wpdb->query($query);
			
			$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `video_user_id` = '$user_id', `update_at`='$update_at'  WHERE  `video_gal_id` = '$gal_id' ";
			$wpdb->query($query);
		}

		die();
	}

	public function edit_video_confirm() {
		global $wpdb, $xoouserultra;

		require_once(ABSPATH . 'wp-includes/formatting.php');


		

		$video_id = $_POST["video_id"];

		$video_name = sanitize_text_field($_POST["video_name"]);
		$video_unique_id = sanitize_text_field($_POST["video_unique_id"]);
		$video_desc = sanitize_text_field($_POST["video_desc"]);
		$video_image = $_POST["video_image"];
		$video_thumb = $_POST["video_thumb"];
		$gal_id = $_POST["video_gal_id"];
		$update_at = time();
		if ($video_id != "") {
			if($xoouserultra->is_admin){
				$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `video_name` = '$video_name', `video_unique_vid` = '$video_unique_id'  , `video_desc` = '$video_desc' , `video_image` = '$video_image' , `video_thumb` = '$video_thumb' , `update_at`='$update_at' WHERE  `video_id` = '$video_id' ";
				$wpdb->query($query);

				$query = "UPDATE " . $wpdb->prefix . "usersultra_video_galleries SET `update_at`='$update_at'  WHERE  `gallery_id` = '$gal_id'";
				$wpdb->query($query);
			}else{
				$user_id = get_current_user_id();
				$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `video_name` = '$video_name', `video_unique_vid` = '$video_unique_id'  , `video_desc` = '$video_desc' , `video_image` = '$video_image' , `video_thumb` = '$video_thumb' , `update_at`='$update_at' WHERE  `video_id` = '$video_id' ";
				$wpdb->query($query);

				$query = "UPDATE " . $wpdb->prefix . "usersultra_video_galleries SET `update_at`='$update_at'  WHERE  `gallery_id` = '$gal_id' AND `gallery_user_id` = '$user_id' ";
				$wpdb->query($query);
			}
			
		}

		die();
	}

	public function edit_video() {
		global $wpdb, $xoouserultra;

		$user_id = get_current_user_id();
		$video_gal_id = $_POST['video_gal_id'];
		$video_id = $_POST["video_id"];

		if ($video_id != "") {
			if($xoouserultra->is_admin)
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '" LIMIT 1');
			else
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '"  AND g.`gallery_user_id` = "'.$user_id.'" LIMIT 1');

			
			$html = "";
			foreach ($res as $video) {
				$pulic = "";
				$registered = "";
				$friends = "";

				if ($video->video_type == 'youtube') {
					$youtube = "selected='selected'";
				}
				if ($video->video_type == 'vimeo') {
					$vimeo = "selected='selected'";
				}

				$html .="<p>" . __('Name', 'xoousers') . "</p>";

				$html .="<p><input type='text' value='" .$video->video_name. "' class='xoouserultra-input' id='uultra_video_name_edit_" . $video->video_id . "'></p>";

				$html .="<p>" . __('Video ID', 'xoousers') . "</p>";
				$html .="<p><input type='text' value='" . $video->video_unique_vid . "' class='xoouserultra-input' id='uultra_video_id_edit_" . $video->video_id . "'></p>";

				$html .="<p>".__( 'Description', 'xoousers' )."</p>";				
				$html .="<p><textarea class='xoouserultra-input' id='uultra_video_desc_edit_".$video->video_id."'>".$video->video_desc."</textarea></p>";
				
//				$html .="<p>" . __('Type', 'xoousers') . "</p>";
//				$html .="<p><select class='xoouserultra-input' id='uultra_video_type_edit_" . $video->video_id . "'>				
//				 
//  <option value='youtube' " . $youtube . ">Youtube</option>
//  <option value='vimeo' " . $vimeo . ">Vimeo</option>
//  
//  </select>
//				
//				</p>";

				$html .= $this->post_media_display($video_gal_id, $video_id, 'video-edit-div-' . $video_id,true);
				$html .= "<input type='hidden' name='video_image' id='new_video_image' value='" . $video->video_image . "'><input type='hidden' name='video_thumb' id='new_video_thumb' value='" . $video->video_thumb . "'>";
				$html .="<div class='usersultra-btn-options-bar'><a class='buttonize btn-video-close-conf' href='' data-id= " . $video->video_id . ">" . __('Close', 'xoousers') . "</a> <a  class='buttonize green btn-video-edit-conf' data-id= " . $video_gal_id . " id= " . $video->video_id . " href=''>" . __('Save', 'xoousers') . "</a></div>";
			}
		}

		echo $html;
		die();
	}

	public function delete_video_gallery() {
		global $wpdb, $xoouserultra;

		$gal_id = $_POST["gal_id"];
		$user_id = get_current_user_id();
		//get video

		if ($gal_id != "") {
			if($xoouserultra->is_admin){
				$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE g.`gallery_id` = "' . $gal_id . '"');			
				//delete gallery from db
				$query = "DELETE FROM " . $wpdb->prefix . "usersultra_video_galleries WHERE  `gallery_id` = '$gal_id' ";
				$wpdb->query($query);
			}else{
				$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE g.`gallery_id` = "' . $gal_id . '"  AND g.`gallery_user_id` = "'.$user_id.'"');			
				//delete gallery from db
				$query = "DELETE FROM " . $wpdb->prefix . "usersultra_video_galleries WHERE  `gallery_id` = '$gal_id' AND gallery_user_id = '$user_id'";
				$wpdb->query($query);
			}
			foreach ($videos as $video) {
				$this->delete_video_files($video,$video->gallery_user_id);
			}	
			//delete video from db
			$query = "DELETE FROM " . $wpdb->prefix . "usersultra_videos WHERE  `video_gal_id` = '$gal_id' ";
			$wpdb->query($query);
		}
	}

	public function delete_video() {
		global $wpdb, $xoouserultra;

		$user_id = get_current_user_id();
		$video_id = $_POST["video_id"];

		//get photo
		if ($video_id != "") {
//			$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_id` = ' . $video_id . ' AND video_user_id = ' . $user_id . '');
			if($xoouserultra->is_admin){
				$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '" LIMIT 1');
				
			}else{
				$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '"  AND g.`gallery_user_id` = "'.$user_id.'" LIMIT 1');
			}
			foreach ($videos as $video) {
				$this->delete_video_files($video,$video->gallery_user_id);
			}
			//delete  from db
			$query = "DELETE FROM " . $wpdb->prefix . "usersultra_videos WHERE  `video_id` = '$video_id' ";
			$wpdb->query($query);
		}
	}

	public function delete_video_files($video,$o_id) {
		global $wpdb, $xoouserultra;
		$path_pics = ABSPATH . $xoouserultra->get_option('media_uploading_folder');

		$pathBig = $path_pics . "/" . $o_id . "/" . $video->video_image;
		$pathSmall = $path_pics . "/" . $o_id . "/" . $video->video_thumb;

		//delete	

		if (file_exists($pathBig)) {
			unlink($pathBig);
		}

		if (file_exists($pathSmall)) {
			unlink($pathSmall);
		}
	}

	public function set_as_main_video() {
		global $wpdb, $xoouserultra;

		$video_id = $_POST["video_id"];
		$gal_id = $_POST["gal_id"];
		//set all to 0

		$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET video_main = '0' WHERE  `video_gal_id` = '$gal_id' ";
		$wpdb->query($query);

		//set to main
		$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET video_main = '1' WHERE  `video_id` = '$video_id' AND  `video_gal_id` = '$gal_id' ";
		$wpdb->query($query);

		die();
	}

	public function get_photos_of_gal_public($gal_id, $display_photo_rating, $gallery_type = null) {
		global $wpdb, $xoouserultra;

		require_once(ABSPATH . 'wp-includes/link-template.php');

		$html = "";

		$site_url = site_url() . "/";


		$current_gal = $this->get_gallery($gal_id);
		$user_id = $current_gal->gallery_user_id;

		$upload_folder = $xoouserultra->get_option('media_uploading_folder');

		if (isset($gal_id)) {
			$photos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_photos WHERE `photo_gal_id` = "' . $gal_id . '" ORDER BY `photo_order` ASC');



			if (empty($photos)) {
				$html.= '<p>' . __('You have no photos in this gallery yet.', 'xoousers') . '</p>';
			} else {
				$n = count($photos);
				$num_unread = 0;
				foreach ($photos as $photo) {
					//get thumbnail

					$thumb = $site_url . $upload_folder . "/" . $user_id . "/" . $photo->photo_thumb;
					$large = $site_url . $upload_folder . "/" . $user_id . "/" . $photo->photo_large;

					$html.= "<li id='" . $photo->photo_id . "' >";



					if ($gallery_type == "lightbox") {

						$html .="<a href='" . $large . "' class='' data-lightbox='example-1' data-title='" . $photo->photo_desc . "'><img src='" . $thumb . "' class='rounded'/> </a>";
					} else {

						$html .="<a href='" . $xoouserultra->userpanel->public_profile_get_photo_link($photo->photo_id, $user_id) . "' class='' ><img src='" . $thumb . "' class='rounded'/> </a>";
					}

					if ($display_photo_rating == "yes") {

						$html.= "<div class='ratebox'>";
						$html.= $xoouserultra->rating->get_rating($photo->photo_id, "photo_id");
						$html.= "</div>";
					}


					$html.= "</li>";
				}
			}

			return $html;
		} //end user loged in
	}

	function setFileType($filename) {

		$fileTypes['swf'] = 'application/x-shockwave-flash';
		$fileTypes['pdf'] = 'application/pdf';
		$fileTypes['exe'] = 'application/octet-stream';
		$fileTypes['zip'] = 'application/zip';
		$fileTypes['doc'] = 'application/msword';
		$fileTypes['xls'] = 'application/vnd.ms-excel';
		$fileTypes['ppt'] = 'application/vnd.ms-powerpoint';
		$fileTypes['gif'] = 'image/gif';
		$fileTypes['png'] = 'image/png';
		$fileTypes['jpeg'] = 'image/jpg';
		$fileTypes['jpg'] = 'image/jpg';
		$fileTypes['rar'] = 'application/rar';

		$fileTypes['ra'] = 'audio/x-pn-realaudio';
		$fileTypes['ram'] = 'audio/x-pn-realaudio';
		$fileTypes['ogg'] = 'audio/x-pn-realaudio';

		$fileTypes['wav'] = 'video/x-msvideo';
		$fileTypes['wmv'] = 'video/x-msvideo';
		$fileTypes['avi'] = 'video/x-msvideo';
		$fileTypes['asf'] = 'video/x-msvideo';
		$fileTypes['divx'] = 'video/x-msvideo';

		$fileTypes['mp3'] = 'audio/mpeg';
		$fileTypes['mp4'] = 'audio/mpeg';
		$fileTypes['mpeg'] = 'video/mpeg';
		$fileTypes['mpg'] = 'video/mpeg';
		$fileTypes['mpe'] = 'video/mpeg';
		$fileTypes['mov'] = 'video/quicktime';
		$fileTypes['swf'] = 'video/quicktime';
		$fileTypes['3gp'] = 'video/quicktime';
		$fileTypes['m4a'] = 'video/quicktime';
		$fileTypes['aac'] = 'video/quicktime';
		$fileTypes['m3u'] = 'video/quicktime';

		$ext = strtolower(end(explode('.', $filename)));
		return $fileTypes[$ext];
	}

	public function post_media_display($gal_id, $video_id = null, $container,$return=false) {
		global $wpdb, $xoouserultra;

		$template_dir = get_template_directory_uri();
		$id = $video_id ? '_' . $video_id : '';
		$image = xoousers_url . "templates/" . xoousers_template . "/img/no-photo.png";
		if ($video_id) {
			$image = $this->get_video_thumb($gal_id, $video_id);
//			$current_gal = $this->get_video_gallery($gal_id);
//			$site_url = site_url() . "/";
//			$user_id = $current_gal->gallery_user_id;
////			$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_id` = ' . $video_id . ' AND `video_user_id` = ' . $user_id . ' ');
//			if($xoouserultra->is_admin){
//				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '"');				
//			}else{
//				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $video_id . '"  AND g.`gallery_user_id` = "'.$user_id.'"');			
//			}
//
//			$path_pics = ABSPATH . $xoouserultra->get_option('media_uploading_folder');
//			$path_pics = $path_pics . "/" . $user_id . "/";
//
//			$upload_folder = $xoouserultra->get_option('media_uploading_folder');
//
//			foreach ($res as $video) {
//				if (file_exists($path_pics . $video->video_thumb))
//					$image = $site_url . $upload_folder . "/" . $user_id . "/" . $video->video_thumb;
//			}
		}
		$plupload_init = array(
			'runtimes' => 'html5,silverlight,flash,html4',
			'browse_button' => 'pickfiles' . $id,
			'container' => 'plupload-upload-ui' . $id,
//				'drop_element'        => 'drag-drop-area',
			'file_data_name' => 'async-upload',
			'multiple_queues' => true,
			'multi_selection' => false,
			'max_file_size' => wp_max_upload_size() . 'b',
			//'max_file_size'       => get_option('drag-drop-filesize').'b',
			'url' => admin_url('admin-ajax.php'),
			'flash_swf_url' => includes_url('js/plupload/plupload.flash.swf'),
			'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
			'filters' => array(array('title' => __('Allowed Files', 'xoousers'), 'extensions' => "jpg,png,gif,bmp,jpeg")),
			'multipart' => true,
			'urlstream_upload' => true,
			// Additional parameters:
			'multipart_params' => array(
				'_ajax_nonce' => wp_create_nonce('video_preview_upload'),
				'action' => 'video_image_upload', // The AJAX action name
				'gal_id' => $gal_id,
				'video_id' => $video_id
			),
		);

//		$site_url = site_url() . "/";
//		$upload_folder = $xoouserultra->get_option('media_uploading_folder');
//		$user_id = get_current_user_id();
//		$path = $site_url . $upload_folder . "/" . $user_id . "/";
		// Apply filters to initiate plupload:
		$plupload_init = apply_filters('plupload_init', $plupload_init);
		
		ob_start();
		?>
		<!-- Uploader section -->
		<?php _e('Thumb', 'xoousers'); ?>
		<div id="uploaderSection" style="position: relative;">
			<div id="plupload-upload-ui<?php echo $id ?>" class="hide-if-no-js">
				<a id="pickfiles<?php echo $id ?>" href="javascript:;">
					<img src="<?php echo $image; ?>" />
				</a>
			</div>                              			
		</div> 
		<script type="text/javascript">

			jQuery(document).ready(function ($) {

				// Create uploader and pass configuration:
				var uploader<?php echo $id ?> = new plupload.Uploader(<?php echo json_encode($plupload_init); ?>);

				// Init ////////////////////////////////////////////////////
				uploader<?php echo $id ?>.init();

				// Selected Files //////////////////////////////////////////
				uploader<?php echo $id ?>.bind('FilesAdded', function (up, files) {
					jQuery.each(files, function (i, file) {
						jQuery('#symposium_filelist<?php echo $id ?>').append('<div class="addedFile" id="' + file.id + '">' + file.name + '</div>');
					});
					up.refresh();
					uploader<?php echo $id ?>.start();
				});

				// A new file was uploaded:
				uploader<?php echo $id ?>.bind('FileUploaded', function (up, file, response) {

					console.log(up, file, response);
					result = JSON.parse(response.response);
					$('#<?php echo $container ?> #new_video_image').val(result.image);
					$('#<?php echo $container ?> #new_video_thumb').val(result.thumb);
					$('#<?php echo $container ?> #pickfiles<?php echo $id ?> img').attr('src',result.path + result.thumb);

				});

				// Error Alert /////////////////////////////////////////////
				uploader<?php echo $id ?>.bind('Error', function (up, err) {
					alert("Error: " + err.code + ", Message: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");
					up.refresh();
				});
			});


		</script>
		<?php
		$content = ob_get_clean();
		if($return)
			return $content;
		
		echo $content;
	}

	public function CreateDir($root) {

		if (is_dir($root)) {

			$retorno = "0";
		} else {

			$oldumask = umask(0);
			$valrRet = mkdir($root, 0777);
			umask($oldumask);


			$retorno = "1";
		}
	}

	public function createthumb($imagen, $newImage, $toWidth, $toHeight, $extorig) {

		$ext = strtolower($extorig);
		switch ($ext) {
			case 'png' : $img = imagecreatefrompng($imagen);
				break;
			case 'jpg' : $img = imagecreatefromjpeg($imagen);
				break;
			case 'jpeg' : $img = imagecreatefromjpeg($imagen);
				break;
			case 'gif' : $img = imagecreatefromgif($imagen);
				break;
		}


		$width = imagesx($img);
		$height = imagesy($img);



		$xscale = $width / $toWidth;
		$yscale = $height / $toHeight;

		// Recalculate new size with default ratio
		if ($yscale > $xscale) {
			$new_w = round($width * (1 / $yscale));
			$new_h = round($height * (1 / $yscale));
		} else {
			$new_w = round($width * (1 / $xscale));
			$new_h = round($height * (1 / $xscale));
		}



		if ($width < $toWidth) {

			$new_w = $width;

			//}else {					
			//$new_w = $current_w;			
		}

		if ($height < $toHeight) {

			$new_h = $height;

			//}else {					
			//$new_h = $current_h;			
		}




		$dst_img = imagecreatetruecolor($new_w, $new_h);

		/* fix PNG transparency issues */
		imagefill($dst_img, 0, 0, IMG_COLOR_TRANSPARENT);
		imagesavealpha($dst_img, true);
		imagealphablending($dst_img, true);
		imagecopyresampled($dst_img, $img, 0, 0, 0, 0, $new_w, $new_h, imagesx($img), imagesy($img));



		switch ($ext) {
			case 'png' : $img = imagepng($dst_img, "$newImage", 9);
				break;
			case 'jpg' : $img = imagejpeg($dst_img, "$newImage", 100);
				break;
			case 'jpeg' : $img = imagejpeg($dst_img, "$newImage", 100);
				break;
			case 'gif' : $img = imagegif($dst_img, "$newImage");
				break;
		}

		imagedestroy($dst_img);



		return true;
	}

	// File upload handler:
	function video_image_upload() {
		global $xoouserultra;
		global $wpdb;

		// Check referer, die if no ajax:
		check_ajax_referer('video_preview_upload');

		/// Upload file using Wordpress functions:
		$file = $_FILES['async-upload'];
//		var_dump($file);die;

		$original_max_width = $xoouserultra->get_option('media_photo_large_width');
		$original_max_height = $xoouserultra->get_option('media_photo_large_height');


		$thumb_max_width = $xoouserultra->get_option('media_photo_thumb_width');
		$thumb_max_height = $xoouserultra->get_option('media_photo_thumb_height');


		$mini_max_width = $xoouserultra->get_option('media_photo_mini_width');
		$mini_max_height = $xoouserultra->get_option('media_photo_mini_height');

		

		$gal_id = $_POST['gal_id'];
		$video_id = $_POST['video_id'];
		$info = pathinfo($file['name']);
		$real_name = $file['name'];
		$ext = $info['extension'];
		$ext = strtolower($ext);
		
		$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries WHERE `gallery_id` = ' . $gal_id . ' LIMIT 1');
		if(count($res)){
			
			$o_id = $res[0]->gallery_user_id;
			$rand = $this->genRandomString();

			$rand_name = $rand . "_" . session_id() . "_" . time();
			$upload_folder = $xoouserultra->get_option('media_uploading_folder');
			$path_pics = ABSPATH . $upload_folder;


			if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
				if ($o_id != '') {
					if (!is_dir($path_pics . "/" . $o_id . "")) {
						$this->CreateDir($path_pics . "/" . $o_id);
					}

					$pathBig = $path_pics . "/" . $o_id . "/" . $rand_name . "." . $ext;
					$pathSmall = $path_pics . "/" . $o_id . "/" . "thumb_" . $rand_name . "." . $ext;

					if (copy($file['tmp_name'], $pathBig)) {
						//check auto-rotation						
						if ($xoouserultra->get_option('uultra_rotation_fixer') == 'yes') {
							$this->orient_image($pathBig);
						}

						//check max width

						list( $source_width, $source_height, $source_type ) = getimagesize($pathBig);

						if ($source_width > $original_max_width) {
							//resize
							if ($this->createthumb($pathBig, $pathBig, $original_max_width, $original_max_height, $ext)) {
								$old = umask(0);
								chmod($pathBig, 0777);
								umask($old);
							}
						}

						//thumb

						if ($this->createthumb($pathBig, $pathSmall, $thumb_max_width, $thumb_max_height, $ext)) {

							$old = umask(0);
							chmod($pathSmall, 0777);
							umask($old);
						}

						$pic1 = $rand_name . "." . $ext;
						$pic2 = "thumb_" . $rand_name . "." . $ext;
						
						$site_url = site_url() . "/";						
						$path = $site_url . $upload_folder . "/" . $o_id . "/";		
						echo json_encode(array("image" => $pic1, "thumb" => $pic2,"path"=>$path));

	//						$order = 1;
	//						
	//						//check if there is main picture
	//						
	//						$photos = $wpdb->get_results( 'SELECT *  FROM ' . $wpdb->prefix . 'usersultra_photos WHERE `photo_gal_id` = "' . $gal_id . '" AND `photo_main` = 1 ' );
	//						
	//						$ismain = 0;
	//						if ( empty( $photos ) )
	//			            {
	//							$ismain = 1;
	//						}
	//						
	//						//update database
	//						$query = "INSERT INTO " . $wpdb->prefix ."usersultra_photos (`photo_gal_id`,`photo_name`, `photo_large`, `photo_thumb` ,`photo_mini` ,`photo_order`, `photo_main`) VALUES ('$gal_id','$real_name','$pic1','$pic2', '$pic3','$order', '$ismain')";						
	//						$wpdb->query( $query );
					}
				}
			} // image type
		}
		
		exit;
	}

	public function orient_image($file_path) {
		if (!function_exists('exif_read_data')) {
			return false;
		}
		$exif = @exif_read_data($file_path);
		if ($exif === false) {
			return false;
		}
		$orientation = intval(@$exif['Orientation']);
		if (!in_array($orientation, array(3, 6, 8))) {
			return false;
		}
		$image = @imagecreatefromjpeg($file_path);

		switch ($orientation) {
			case 3:
				$image = @imagerotate($image, 180, 0);
				break;
			case 6:
				$image = @imagerotate($image, 270, 0);
				break;
			case 8:
				$image = @imagerotate($image, 90, 0);
				break;
			default:
				return false;
		}
		$success = imagejpeg($image, $file_path);

		// Free up memory (imagedestroy does not delete files):
		@imagedestroy($image);
		return $success;
	}

	public function genRandomString() {
		$length = 5;
		$characters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWZYZ";

		$real_string_legnth = strlen($characters);
		$string = "ID";

		for ($p = 0; $p < $length; $p++) {
			$string .= $characters[mt_rand(0, $real_string_legnth - 1)];
		}

		return strtolower($string);
	}

	public function downloadYoutubeThumb($id,$o_id = null) {
		global $xoouserultra;
		$result = array("image" => null, "thumb" => null);
		$o_id = $o_id==null?get_current_user_id():$o_id;
		$url = "http://img.youtube.com/vi/$id/0.jpg";
		try {
			@$file = fopen ($url, "rb");
		} catch (Exception $exc) {
			return $result;
		}

		if ($o_id != '' && $file){
			$original_max_width = $xoouserultra->get_option('media_photo_large_width');
			$original_max_height = $xoouserultra->get_option('media_photo_large_height');
			$thumb_max_width = $xoouserultra->get_option('media_photo_thumb_width');
			$thumb_max_height = $xoouserultra->get_option('media_photo_thumb_height');

			
			$rand = $this->genRandomString();
			$rand_name = $rand . "_" . session_id() . "_" . time();
			$path_pics = ABSPATH . $xoouserultra->get_option('media_uploading_folder');
			if (!is_dir($path_pics . "/" . $o_id . "")) {
				$this->CreateDir($path_pics . "/" . $o_id);
			}
			$pathBig = $path_pics . "/" . $o_id . "/" . $rand_name . ".jpg";
			$pathSmall = $path_pics . "/" . $o_id . "/" . "thumb_" . $rand_name . ".jpg";
			
			$bigFile = fopen ($pathBig, "wb");
			
			if ($bigFile){
				while(!feof($file)) {
					fwrite($bigFile, fread($file, 1024 * 8 ), 1024 * 8 );
				}
				if ($file) {
					fclose($file);
				}

				if ($bigFile) {
					fclose($bigFile);
				}
				
				//check auto-rotation						
				if ($xoouserultra->get_option('uultra_rotation_fixer') == 'yes') {
					$this->orient_image($pathBig);
				}

				//check max width

				list( $source_width, $source_height, $source_type ) = getimagesize($pathBig);

				if ($source_width > $original_max_width) {
					//resize
					if ($this->createthumb($pathBig, $pathBig, $original_max_width, $original_max_height, 'jpg')) {
						$old = umask(0);
						chmod($pathBig, 0777);
						umask($old);
					}
				}

				//thumb

				if ($this->createthumb($pathBig, $pathSmall, $thumb_max_width, $thumb_max_height, 'jpg')) {

					$old = umask(0);
					chmod($pathSmall, 0777);
					umask($old);
				}

				$result["image"] = $rand_name . ".jpg";
				$result["thumb"] = "thumb_" . $rand_name . ".jpg";				
			}		
		}
		return $result;
		
	}

	public function get_latest_video($atts) {
		global $wpdb, $xoouserultra;
//		$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos ORDER BY `create_at` DESC LIMIT 1 ');
		$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id ORDER BY v.`create_at` DESC LIMIT 1 ');
		if(count($res)>0){
			$video = $res[0];
			$site_url = site_url()."/";
			$upload_folder =  $xoouserultra->get_option('media_uploading_folder'); 
			$user_id =$video->gallery_user_id;
			$video->video_image = $site_url.$upload_folder."/".$user_id."/".$video->video_image;
			$video->video_thumb = $site_url.$upload_folder."/".$user_id."/".$video->video_thumb;
			return $video;
		}
		return null;
	}
	
	public function happy_moment_child($atts) {
		global $wpdb;
		$result = array('listGallery'=>null,'listVideoOfFirst'=>null);
		$listGallery = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_video_galleries g LEFT JOIN ' . $wpdb->prefix . 'usersultra_videos v ON g.gallery_id = v.video_gal_id WHERE v.video_main = 1 GROUP BY g.gallery_id ORDER BY g.`create_at` DESC');
		if(count($listGallery) >0){
			$firstGallery = $listGallery[0];
			if(isset($_GET['gallery'])){
				foreach ($listGallery as $key => $gallery) {
					if($gallery->gallery_id == $_GET['gallery']){
						$firstGallery = $gallery;
					}
				}
			}else{
				$url = get_permalink(get_the_ID()).'?gallery='.$firstGallery->video_gal_id.'&video='.$firstGallery->video_id;
				wp_redirect($url);
			}						
			$listVideoOfFirst = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON g.gallery_id = v.video_gal_id  WHERE v.`video_gal_id` = '.$firstGallery->gallery_id.' ORDER BY v.`video_order`');
			
			$result = array('listGallery'=>$listGallery,'listVideoOfFirst'=>$listVideoOfFirst);
		}
		
		return $result;
	}
	
	public function get_videos_of_gallery() {
		global $wpdb, $xoouserultra;

		$video_gal_id = $_POST["video_gal_id"];
		$data = array();

		$videos = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON g.gallery_id = v.video_gal_id  WHERE v.`video_gal_id` = '.$video_gal_id.' ORDER BY v.`video_order`');	
		if (empty($videos)) {
			echo null;
		} else {
			$tmp = array();
			$firstVideo = null;
			foreach ($videos as $video) {
				$thumb = $this->get_video_thumb($video_gal_id, $video->video_id);
				$tmp["src"] = $thumb;
				$tmp["id"] = $video->video_id;
				$tmp["title"] = $video->video_name;
				$tmp["desc"] = $video->video_desc;
				$tmp["gal_id"] = $video->gallery_id;
				$tmp["video_id"] = $video->video_id;
				$tmp["video_unique_vid"] = $video->video_unique_vid;
				$tmp["create_at"] = date("m.d.y",$video->create_at);
				if(!$firstVideo)
					$firstVideo = $video;
				
				$data["items"][] = $tmp;
			}
			$contentFirstVideo = '
				<div class="video-warp" >
					<iframe width="100%" height="100%" src="//www.youtube.com/embed/'.$firstVideo->video_unique_vid.'?autohide=1&modestbranding=1&showinfo=0" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
				</div>
				<div class="video-bar"></div>
				<div class="video-des">
					<h3>'.  $firstVideo->video_name.'</h3>
					<p class="desc">'.$firstVideo->video_desc.'</p>
				</div>';
			$data['firstVideo'] = $contentFirstVideo;
			echo json_encode($data);
		}		
		die();		
	}
	
	public function happy_moment_home_page($atts) {
		global $wpdb, $xoouserultra;
//		$listVideos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON g.gallery_id = v.video_gal_id WHERE v.video_main = 1 ORDER BY v.`create_at` DESC');
		$listVideos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON g.gallery_id = v.video_gal_id ORDER BY v.`create_at` DESC');
		if(count($listVideos) >0){
			$result = array('firstVideo'=>$listVideos[0],'listVideos'=>$listVideos);
		}
		
		return $result;
	}
	
	public function get_all_videos_of_user($id) {
		global $wpdb;
//		$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos WHERE `video_user_id` = "' . $id . '" ORDER BY `create_at` DESC, `video_main` DESC');
		$videos = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE g.`gallery_user_id` = "' . $id . '" ORDER BY v.`create_at` DESC, v.`video_main` DESC');			
		return $videos;
	}
	
	public function update_facebook() {
		if ($_SERVER['SERVER_NAME'] == 'happytourlotteria.vn') {
			// PRODUCTION	
			global $wpdb;
			if(isset($_POST['gallery_id']) && isset($_POST['video_id'])){
				$res = $wpdb->get_results('SELECT *  FROM ' . $wpdb->prefix . 'usersultra_videos v LEFT JOIN ' . $wpdb->prefix . 'usersultra_video_galleries g ON v.video_gal_id = g.gallery_id WHERE v.`video_id` = "' . $_POST['video_id'] . '" AND g.gallery_id ="'.$_POST['gallery_id'].'"  LIMIT 1');
				if(isset($res[0])){
					$link = get_permalink(53).'?gallery='.$_POST['gallery_id'].'&video='.$_POST['video_id'];

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
						$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `share_count` = '$fb_share_count', `like_count` = '$fb_like_count' ,`comment_count` = '$fb_comment_count'  , `view_count` = '".($res[0]->view_count+1)."'  WHERE  `video_id` = '".$_POST['video_id']."' ";
						$wpdb->query($query);
					}else{
						$query = "UPDATE " . $wpdb->prefix . "usersultra_videos SET `view_count` = '".($res[0]->view_count+1)."'  WHERE  `video_id` = '".$_POST['video_id']."' ";
						$wpdb->query($query);
					}
					
				}
			}
		}
	}
}

$key = "videogallery";
$this->{$key} = new XooUserVideo();
