<?php
global $xoouserultra;

$module = "";
$act = "";
$gal_id = "";
$page_id = "";
$view = "";
$reply = "";
$post_id = "";


if (isset($_GET["module"])) {
	$module = $_GET["module"];
}
if (isset($_GET["act"])) {
	$act = $_GET["act"];
}
if (isset($_GET["gal_id"])) {
	$gal_id = $_GET["gal_id"];
}
if (isset($_GET["video_gal_id"])) {
	$video_gal_id = $_GET["video_gal_id"];
}
if (isset($_GET["page_id"])) {
	$page_id = $_GET["page_id"];
}
if (isset($_GET["view"])) {
	$view = $_GET["view"];
}
if (isset($_GET["reply"])) {
	$reply = $_GET["reply"];
}
if (isset($_GET["post_id"])) {
	$post_id = $_GET["post_id"];
}
$current_user = $xoouserultra->userpanel->get_user_info();
$user_id = $current_user->ID;
$user_email = $current_user->user_email;
$howmany = 5;
?>
<div class="usersultra-dahsboard-cont">
	<div class="usersultra-dahsboard-left"> 
		<div class="myavatar rounded">
			<div class="pic" id="uu-backend-avatar-section">
				<?php echo $xoouserultra->userpanel->get_user_pic($user_id, "", 'avatar', '', 'dynamic') ?>
            </div>
			<div class="btnupload">
				<a class="uultra-btn-upload-avatar" href="#" title="<?php echo _e("Update Profile Image", 'xoousers') ?>" id="uu-send-private-message" data-id="<?php echo $user_id ?>"><span><i class="fa fa-camera fa-2x"></i></span></a>
			</div>
			<div class="uu-upload-avatar-sect" id="uu-upload-avatar-box">           
				<?php echo $xoouserultra->userpanel->avatar_uploader() ?>         
            </div>
		</div>
		<ul class="main_menu">
			<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('dashboard'); ?></li>
			<?php if (!in_array("account", $modules)) { ?>  
				<?php if (!$xoouserultra->check_if_disabled_for_this_user($user_id, "account", $modules_custom_user, $modules_custom_user_id)) { ?> 
					<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('account'); ?></li>
				<?php } ?>
			<?php } ?>
					
			<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('profile'); ?></li>             

			<?php if (!in_array("messages", $modules)) { ?>        
				<?php if (!$xoouserultra->check_if_disabled_for_this_user($user_id, "messages", $modules_custom_user, $modules_custom_user_id)) { ?> 
					<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('messages'); ?></li>
				<?php } ?>
			<?php } ?>

			<?php if (!in_array("posts", $modules)) { ?>  
				<?php if (!$xoouserultra->check_if_disabled_for_this_user($user_id, "posts", $modules_custom_user, $modules_custom_user_id)) { ?> 
					<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('posts'); ?></li>
				<?php } ?>
			<?php } ?>

			<?php if (!in_array("photos", $modules)) { ?>  
				<?php if (!$xoouserultra->check_if_disabled_for_this_user($user_id, "photos", $modules_custom_user, $modules_custom_user_id)) { ?> 
					<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('photos'); ?></li> 
				<?php } ?>
			<?php } ?>

			<?php if (!in_array("videos", $modules)) { ?> 
				<?php if (!$xoouserultra->check_if_disabled_for_this_user($user_id, "videos", $modules_custom_user, $modules_custom_user_id)) { ?> 
					<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('videos'); ?></li>
				<?php } ?>
			<?php } ?>
					
			<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('settings'); ?></li>
			<li><?php echo $xoouserultra->userpanel->get_user_backend_menu('logout'); ?></li>

		</ul>
    </div>

	<div class="usersultra-dahsboard-center"> 
		<?php
		//dashboard
		if ($module == "dashboard" || $module == "") {
		?> 
			<h1> <?php _e('Hello', 'xoousers'); ?> <?php echo $current_user->display_name ?>. <?php _e('Welcome to your dashboard', 'xoousers'); ?></h1>     

			<?php if (!in_array("photos", $modules)) { ?>  
			<div class="expandable-panel xoousersultra-shadow-borers" id="cp-2">
				<div class="expandable-panel-heading">
					<h2><?php _e('My Latest Photos:', 'xoousers'); ?><span class="icon-close-open"></span></h2>
				</div>
				<div class="expandable-panel-content">
					<?php echo $xoouserultra->photogallery->show_latest_photos_private(10); ?>
				</div>                    
			</div>
			<?php } ?>   


		<?php } ?>

		<?php
		//my posts
		if ($module == "posts" && !in_array("posts", $modules)) {
		?>
			<?php if ($act == "") { ?> 
				<div class="commons-panel xoousersultra-shadow-borers" >
					<div class="commons-panel-heading">
						<h2> <?php _e('My Posts', 'xoousers'); ?> </h2>
					</div>
					<p class="paneldesc"><?php echo _e('Here you can manage your posts. ', 'xoousers') ?></p>
					<div class="commons-panel-content" >  
						<?php echo $xoouserultra->publisher->show_my_posts(); ?>
					</div>
				</div>
			<?php } ?>

			<?php if ($act == "add") { ?>                  
				<?php echo do_shortcode('[usersultra_front_publisher]'); ?>                   
			<?php } ?>

			<?php if ($act == "edit") { ?>                  
				<?php echo $xoouserultra->publisher->edit_post($post_id); ?>                   
			<?php } ?>
		<?php } ?>

		<?php
		//my photos
		if ($module == "photos" && !in_array("photos", $modules)) {
		?>
			<div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('My Galleries', 'xoousers'); ?> / </h2>
				</div>
				<div class="commons-panel-content">
					<p><?php _e('Here you can manage your galleries and photos.', 'xoousers'); ?></p>
					<a  id="add_gallery"  href="#"> <?php _e('Add Gallery', 'xoousers'); ?></a>
					<div class="gallery-list">
						<div class="add-new-gallery" id="new_gallery_div">
							<p>
								<?php _e('Name', 'xoousers'); ?>
	                            <br />
								<input type="text" class="xoouserultra-input" name="new_gallery_name" id="new_gallery_name" value=""> 
								<?php if($xoouserultra->is_admin):?>
									<?php _e('User', 'xoousers'); ?>
									<br />
									<?php wp_dropdown_users(array('id' => 'name','name'=>'new_gallery_user_id','id'=>'new_gallery_user_id','selected'=>get_current_user_id())); ?>
									<br />
								<?php endif;?>								
								<?php _e('Description', 'xoousers'); ?>
								<br />
	                            <textarea class="xoouserultra-input" name="new_gallery_desc" id="new_gallery_desc" ></textarea>
							</p>
							<div class="usersultra-btn-options-bar">
	                            <a class="buttonize" href="#" id="close_add_gallery"><?php _e('Cancel', 'xoousers'); ?></a>
	                            <a class="buttonize green"  href="#" id="new_gallery_add"><?php _e('Submit', 'xoousers'); ?></a>
							</div>
						</div>
						<ul id="usersultra-gallerylist">
							<?php _e('loading ...', 'xoousers'); ?>
						</ul>
					</div>
				</div>                    
			</div>
			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					var page_id_val = $('#page_id').val();
					$.post(ajaxurl, {
						action: 'reload_galleries', 'page_id': page_id_val
					}, function (response) {
						$("#usersultra-gallerylist").html(response);
					});
				});
				var gallery_delete_confirmation_message = '<?php echo _e('Delete this gallery?', 'xoousers') ?>';
			</script>

		<?php } ?>

		<input type="hidden" value="<?php echo $page_id ?>" name="page_id" id="page_id" />

		<?php
		//my photos
		if ($module == "photos-files" && !in_array("photos", $modules)) {
			//get selected gallery
			$current_gal = $xoouserultra->photogallery->get_gallery($gal_id)
			?>
			<div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('My Photos', 'xoousers'); ?> / <?php echo $current_gal->gallery_name ?></h2>
				</div>
				<div class="commons-panel-content">
					<p><?php _e('Here you can manage your photos.', 'xoousers'); ?></p>
					<a  id="add_new_files"  href="#"> <?php _e('Upload Files', 'xoousers'); ?></a>
					<div class="photo-list">                         
						<div class="res_sortable_container" id="resp_t_image_list">
							<?php $xoouserultra->photogallery->post_media_display($gal_id); ?>                       
						</div>
						<ul id="usersultra-photolist" class="usersultra-photolist-private">
							<?php _e('loading photos ...', 'xoousers'); ?>
						</ul>
					</div>
				</div>                    
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$.post(ajaxurl, {
						action: 'reload_photos', 'gal_id': '<?php echo $gal_id ?>'
					}, function (response) {
						$("#usersultra-photolist").html(response);
					});
				});
			</script>
		<?php } ?>

		<?php
		//profile
		if ($module == "profile" && !in_array("profile", $modules)) {
			?>
			<div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('My Profile', 'xoousers'); ?> </h2>
				</div>
				<div class="commons-panel-content">
					<?php echo $xoouserultra->userpanel->edit_profile_form(); ?>
				</div>
			</div>
		<?php } ?>

		<?php
		//my settings
		if ($module == "settings") {
		?>
			<div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('Settings', 'xoousers'); ?>  </h2>
				</div>
				<div class="commons-panel-content">
					<h2> <?php _e('Update Password', 'xoousers'); ?>  </h2>                     
					<form method="post" name="uultra-close-account" >
						<p><?php _e('Type your New Password', 'xoousers'); ?></p>
						<p><input type="password" name="p1" id="p1" /></p>

						<p><?php _e('Re-type your New Password', 'xoousers'); ?></p>
						<p><input type="password"  name="p2" id="p2" /></p>

						<p><input type="button" name="xoouserultra-backenedb-eset-password" id="xoouserultra-backenedb-eset-password" class="xoouserultra-button" value="<?php _e('CLICK HERE TO RESET PASSWORD', 'xoousers'); ?>" /></p>

						<p id="uultra-p-reset-msg"></p>
					</form>
					
					<h2> <?php _e('Update Email', 'xoousers'); ?>  </h2> 

					<form method="post" name="uultra-change-email" >
						<p><?php _e('Type your New Email', 'xoousers'); ?></p>
						<p><input type="text" name="email" id="email" value="<?php echo $user_email ?>" /></p>

						<p><input type="button" name="xoouserultra-backenedb-update-email" id="xoouserultra-backenedb-update-email" class="xoouserultra-button" value="<?php _e('CLICK HERE TO UPDATE YOUR EMAIL', 'xoousers'); ?>" /></p>

						<p id="uultra-p-changeemail-msg"></p>
					</form>
				</div>
			</div>
			<script type="text/javascript">
				var delete_account_confirmation_mesage = '<?php echo _e('Are you totally sure that you want to close your account. This action cannot be reverted?', 'xoousers') ?>';
			</script>
		<?php } ?>

		<?php
		//videos
		if ($module == "videos" && !in_array("videos", $modules)) {
		?>
	        <div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('My Video Galleries', 'xoousers'); ?> / </h2>
				</div>
				<div class="commons-panel-content">
					<p><?php _e('Here you can manage your galleries and videos.', 'xoousers'); ?></p>
					<a  id="add_video_gallery"  href="#"> <?php _e('Add Gallery', 'xoousers'); ?></a>
					<div class="video-gallery-list">
						<div class="add-new-video-gallery" id="new_video_gallery_div">
							<p>
								<?php _e('Name', 'xoousers'); ?>
								<br />
								<input type="text" class="xoouserultra-input" name="new_video_gallery_name" id="new_video_gallery_name" value=""> 
								<?php if($xoouserultra->is_admin):?>
									<?php _e('User', 'xoousers'); ?>
									<br />
									<?php wp_dropdown_users(array('id' => 'name','name'=>'new_video_user_id','id'=>'new_video_user_id','selected'=>get_current_user_id())); ?>
									<br />
								<?php endif;?>
								<?php _e('Description', 'xoousers'); ?>
								<br />
								<textarea class="xoouserultra-input" name="new_video_gallery_desc" id="new_video_gallery_desc" ></textarea>
							</p>

							<div class="usersultra-btn-options-bar">
								<a class="buttonize" href="#" id="close_add_video_gallery"><?php _e('Cancel', 'xoousers'); ?></a>
								<a class="buttonize green"  href="#" id="new_video_gallery_add"><?php _e('Submit', 'xoousers'); ?></a>

							</div>
						</div>
						<ul id="usersultra-video-gallerylist">
							<?php _e('loading video galleries ...', 'xoousers'); ?>
						</ul>
					</div>
				</div>                    
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					var page_id_val = $('#page_id').val();
					$.post(ajaxurl, {
						action: 'reload_video_galleries', 'page_id': page_id_val
					}, function (response) {
						$("#usersultra-video-gallerylist").html(response);
					});
				});
				var gallery_delete_confirmation_message = '<?php echo _e('Delete this gallery?', 'xoousers') ?>';
			</script>       

		<?php } ?>

		<?php
		//videos-files
		if ($module == "videos-files" && !in_array("videos-files", $modules)) {
			//get selected gallery
			$current_video_vgal = $xoouserultra->videogallery->get_video_gallery($video_gal_id)
			?>
			<div class="commons-panel xoousersultra-shadow-borers" >
				<div class="commons-panel-heading">
					<h2> <?php _e('My Videos', 'xoousers'); ?> </h2>
				</div>
				<div class="commons-panel-content">
					<p><?php _e('Here you can manage your videos.', 'xoousers'); ?></p>
					<a  id="add_new_video"  href="#"> <?php _e('Add Video', 'xoousers'); ?></a>
					<div class="add-new-video" id="new_video_div">
						<p>
							<?php _e('Name', 'xoousers'); ?>
							<br />
							<input type="text" class="xoouserultra-input" name="new_video_name" id="new_video_name" value=""> 
						</p>
						<p>
							<?php _e('Video ID', 'xoousers'); ?>
							<br />
							<input type="text" class="xoouserultra-input" name="new_video_unique_vid" id="new_video_unique_vid" value=""> 
						</p>
						<p>
							<?php _e('Description', 'xoousers'); ?>
							<br />
							<textarea name="new_video_desc" id="new_video_desc" class="xoouserultra-input"></textarea>
						</p>
						<div id="uploadContainer" style="margin-top: 10px;">
							<?php $xoouserultra->videogallery->post_media_display($video_gal_id, null, 'new_video_div'); ?> 
						</div>

						<input type="hidden" name="video_gal_id" id="new_video_gal_id" value="<?php echo $video_gal_id ?>"> 
						<input type="hidden" name="video_id" id="new_video_id" value="<?php echo $video_id ?>"> 
						<input type="hidden" name="video_image" id="new_video_image" value=""> 
						<input type="hidden" name="video_thumb" id="new_video_thumb" value="">
						<div class="usersultra-btn-options-bar">
							<a class="buttonize" href="#" id="close_add_video"><?php _e('Cancel', 'xoousers'); ?></a>
							<a class="buttonize green"  href="#" id="new_video_add_confirm"><?php _e('Submit', 'xoousers'); ?></a>
						</div>
					</div>
					<div class="video-list">     							                                     
						<ul id="usersultra-videolist" class="usersultra-video-private">
							<?php _e('please wait, loading videos ...', 'xoousers'); ?>
						</ul>
					</div>
				</div>                           
			</div>

			<script type="text/javascript">
				jQuery(document).ready(function ($) {
					$.post(ajaxurl, {
						action: 'reload_videos', 'video_gal_id': '<?php echo $video_gal_id ?>'
					}, function (response) {
						$("#usersultra-videolist").html(response);
					});
				});
				var video_delete_confirmation_message = '<?php echo _e('Delete this video?', 'xoousers') ?>';
				var video_empy_field_name = '<?php echo _e('Please input a name', 'xoousers') ?>';
				var video_empy_field_id = '<?php echo _e('Please input video ID', 'xoousers') ?>';
			</script>  
		<?php } ?>

    </div>
</div>